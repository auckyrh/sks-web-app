<?php

namespace App\Services;

use App\Models\EventPeriod;
use App\Models\Participant;
use App\Models\Team;
use App\Models\TeamAssignmentConstraint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * TeamAssignmentService
 *
 * Distributes participants into teams for a given event period.
 *
 * ┌──────────────────────────────────────────────────────────────────────┐
 * │  ALGORITHM OVERVIEW                                                  │
 * │                                                                      │
 * │  Phase A — Fixed-team constraints                                    │
 * │    Participants pinned to a specific team (e.g. special-needs child  │
 * │    whose companion needs to sit at the back of the last team).       │
 * │                                                                      │
 * │  Phase B — Same-team constraints                                     │
 * │    Groups of participants that must be in the same team (e.g. sibling│
 * │    or parent request). Placed in the first team with enough space.   │
 * │                                                                      │
 * │  Phase C — Balanced distribution                                     │
 * │    Remaining participants distributed using a greedy "fill lowest"   │
 * │    approach after sorting by gender interleave → wilayah spread      │
 * │    → grade. Lower-numbered teams receive more members when the total │
 * │    does not divide evenly.                                           │
 * │                                                                      │
 * │  Re-running resets ALL team assignments for the period first.        │
 * │                                                                      │
 * │  ADDING CONSTRAINTS FOR A NEW YEAR                                   │
 * │    1. Generate teams for the new EventPeriod.                        │
 * │    2. Create a new seeder (e.g. TeamAssignmentConstraint2027Seeder)  │
 * │       following the pattern in TeamAssignmentConstraint2026Seeder.   │
 * │    3. Run the seeder, then use the "Generate Otomatis" button in     │
 * │       Admin → Distribusi Kelompok. No code changes needed here.     │
 * └──────────────────────────────────────────────────────────────────────┘
 */
class TeamAssignmentService
{
    /**
     * Run the full team assignment for the given event period.
     *
     * @return array{assigned: int, skipped: int, warnings: string[]}
     */
    public function run(EventPeriod $period): array
    {
        return DB::transaction(function () use ($period) {
            $stats = ['assigned' => 0, 'skipped' => 0, 'warnings' => []];

            // Reset all existing assignments for this period
            Participant::where('event_period_id', $period->id)
                ->update(['team_id' => null]);

            // Load all participants with their registration (needed for
            // registration_number matching and wilayah balancing)
            $allParticipants = Participant::where('event_period_id', $period->id)
                ->with('registration')
                ->get();

            if ($allParticipants->isEmpty()) {
                $stats['warnings'][] = 'Belum ada data peserta untuk periode ini.';
                return $stats;
            }

            // Load teams grouped by event_class_id, ordered by number ascending
            // (lower number = higher capacity target)
            $teamsByClass = Team::where('event_period_id', $period->id)
                ->orderBy('number')
                ->get()
                ->groupBy('event_class_id');

            if ($teamsByClass->isEmpty()) {
                $stats['warnings'][] = 'Belum ada tim untuk periode ini.';
                return $stats;
            }

            // Load constraints for this period
            $constraints = TeamAssignmentConstraint::where('event_period_id', $period->id)->get();

            // ── Phase A: Fixed-team constraints ──────────────────────────────
            // Pin specific participants to a specific team before anything else.
            $fixedConstraints = $constraints->where('type', 'fixed_team');
            foreach ($fixedConstraints as $constraint) {
                if (! $constraint->fixed_team_id) {
                    $stats['warnings'][] = "Constraint fixed_team ID {$constraint->id} tidak memiliki fixed_team_id — dilewati.";
                    continue;
                }

                $regNums = $this->toArray($constraint->registration_numbers);
                $matched = $allParticipants->filter(
                    fn ($p) => in_array($p->registration?->registration_number, $regNums)
                );

                if ($matched->isEmpty()) {
                    $stats['warnings'][] = "Constraint fixed_team ID {$constraint->id}: tidak ada peserta ditemukan untuk " . implode(', ', $regNums);
                    continue;
                }

                foreach ($matched as $participant) {
                    $participant->team_id = $constraint->fixed_team_id;
                    $participant->save();
                    $stats['assigned']++;
                }
            }

            // ── Phase B + C: Per-class distribution ──────────────────────────
            $distinctClassIds = $allParticipants->pluck('event_class_id')->unique()->filter();

            foreach ($distinctClassIds as $classId) {
                $teams = $teamsByClass->get($classId);

                if (! $teams || $teams->isEmpty()) {
                    $unassigned = $allParticipants->where('event_class_id', $classId)->count();
                    $stats['skipped']      += $unassigned;
                    $stats['warnings'][]    = "Kelas ID {$classId}: tidak ada tim — {$unassigned} peserta dilewati.";
                    continue;
                }

                $classParticipants = $allParticipants->where('event_class_id', $classId);
                $total             = $classParticipants->count();
                $teamCount         = $teams->count();

                // Calculate target size per team.
                // Lower-numbered teams (lower index) get the extra member.
                // e.g. 98 participants / 10 teams → teams[0..7] get 10, teams[8..9] get 9
                $base  = intdiv($total, $teamCount);
                $extra = $total % $teamCount;

                $targets = [];   // team->id => target headcount
                $fills   = [];   // team->id => current assigned count

                foreach ($teams->values() as $i => $team) {
                    $targets[$team->id] = $base + ($i < $extra ? 1 : 0);
                    $fills[$team->id]   = 0;
                }

                // Account for Phase-A participants already assigned to a team in this class
                foreach ($classParticipants->whereNotNull('team_id') as $pinned) {
                    if (isset($fills[$pinned->team_id])) {
                        $fills[$pinned->team_id]++;
                    }
                }

                // ── Phase B: Same-team constraints ───────────────────────────
                $sameConstraints = $constraints->where('type', 'same_team');
                foreach ($sameConstraints as $constraint) {
                    $regNums = $this->toArray($constraint->registration_numbers);

                    // Only process participants that belong to THIS class and are unassigned
                    $matched = $classParticipants->filter(
                        fn ($p) => is_null($p->team_id)
                            && in_array($p->registration?->registration_number, $regNums)
                    );

                    if ($matched->isEmpty()) {
                        continue; // constraint doesn't apply to this class — skip
                    }

                    $groupSize  = $matched->count();
                    $targetTeam = null;

                    // Collect all teams that can fit the whole group, then pick randomly
                    $eligible = [];
                    foreach ($teams as $team) {
                        $space = $targets[$team->id] - $fills[$team->id];
                        if ($space >= $groupSize) {
                            $eligible[] = $team;
                        }
                    }

                    if (! empty($eligible)) {
                        $targetTeam = $eligible[array_rand($eligible)];
                    }

                    // Fallback: team with the most space (may slightly exceed target)
                    if (! $targetTeam) {
                        $best = null;
                        foreach ($teams as $team) {
                            if (! $best || ($fills[$team->id] < $fills[$best->id])) {
                                $best = $team;
                            }
                        }
                        $targetTeam = $best;
                        $stats['warnings'][] = "Constraint same_team ID {$constraint->id}: tidak ada tim dengan cukup ruang — ditempatkan di tim dengan ruang terbanyak.";
                    }

                    foreach ($matched as $participant) {
                        $participant->team_id = $targetTeam->id;
                        $participant->save();
                        $fills[$targetTeam->id]++;
                        $stats['assigned']++;
                    }
                }

                // ── Phase C: Distribute remaining ────────────────────────────
                $remaining = $classParticipants->filter(fn ($p) => is_null($p->team_id));
                $sorted    = $this->sortForDistribution($remaining);

                // Track gender fills per team for gender-balanced distribution
                $genderFills = [];
                foreach ($teams as $team) {
                    $genderFills[$team->id] = ['F' => 0, 'M' => 0];
                }
                // Seed from Phase-A/B assignments already in this class
                foreach ($classParticipants->whereNotNull('team_id') as $pinned) {
                    if (isset($genderFills[$pinned->team_id])) {
                        $g = $pinned->gender === 'F' ? 'F' : 'M';
                        $genderFills[$pinned->team_id][$g]++;
                    }
                }

                foreach ($sorted as $participant) {
                    $gender     = $participant->gender === 'F' ? 'F' : 'M';
                    $targetTeam = $this->pickTeam($teams, $targets, $fills, $genderFills, $gender);

                    $participant->team_id = $targetTeam->id;
                    $participant->save();
                    $fills[$targetTeam->id]++;
                    $genderFills[$targetTeam->id][$gender]++;
                    $stats['assigned']++;
                }
            }

            return $stats;
        });
    }

    /**
     * Pick the best team to assign the next participant to.
     *
     * Priority:
     *   1. Most remaining total capacity (team not full)
     *   2. Fewest of this gender already assigned (gender balance)
     *   3. Tie-break by lower team number
     *
     * Lower-numbered teams fill first, naturally receiving more members
     * when the total doesn't divide evenly.
     *
     * @param  array<int, array{F: int, M: int}>  $genderFills  fills per team per gender
     * @param  string                              $gender       'F' or 'M'
     */
    private function pickTeam(
        Collection $teams,
        array $targets,
        array $fills,
        array $genderFills = [],
        string $gender = ''
    ): Team {
        $best      = null;
        $bestScore = PHP_INT_MAX;

        foreach ($teams as $team) {
            $remaining = ($targets[$team->id] ?? 0) - ($fills[$team->id] ?? 0);

            if ($remaining <= 0) {
                continue; // this team is full
            }

            $genderCount = ($gender !== '' && isset($genderFills[$team->id]))
                ? ($genderFills[$team->id][$gender] ?? 0)
                : 0;

            // Lower score = preferred:
            //   total fills (primary) → gender fills (secondary) → team number (tiebreak)
            $score = ($fills[$team->id] * 1_000_000)
                   + ($genderCount     *       1_000)
                   + $team->number;

            if ($score < $bestScore) {
                $bestScore = $score;
                $best      = $team;
            }
        }

        // Fallback when all teams are at capacity (rounding edge case)
        if (! $best) {
            foreach ($teams as $team) {
                if (! $best || $fills[$team->id] < $fills[$best->id]) {
                    $best = $team;
                }
            }
        }

        return $best;
    }

    /**
     * Normalise registration_numbers to a plain PHP array.
     *
     * The seeder previously passed json_encode()'d strings into firstOrCreate(),
     * which caused Eloquent's array cast to double-encode the value. This guard
     * handles both correctly-cast arrays and the legacy double-encoded strings.
     */
    private function toArray(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        // First decode — may still return a string if double-encoded
        $decoded = json_decode((string) $value, true);

        if (is_array($decoded)) {
            return $decoded;
        }

        // Second decode for double-encoded values
        $decoded2 = json_decode((string) $decoded, true);

        return is_array($decoded2) ? $decoded2 : [];
    }

    /**
     * Sort participants for distribution.
     *
     * Primary sort: wilayah → grade (ensures wilayah/grade spread).
     * Tertiary: random tiebreaker so participants with equal wilayah+grade
     * are shuffled differently on every run, producing varied results.
     * Gender balancing is handled dynamically in Phase C via pickTeam().
     */
    private function sortForDistribution(Collection $participants): Collection
    {
        return $participants
            ->sortBy(function (Participant $p): string {
                // Wilayah: non-null sorted numerically; null goes last (99999)
                $wilayahKey = str_pad((string) ($p->registration?->wilayah_id ?? 99999), 6, '0', STR_PAD_LEFT);
                // Grade
                $gradeKey   = str_pad((string) ($p->grade ?? 0), 2, '0', STR_PAD_LEFT);
                // Random tiebreaker — ensures a different ordering each run
                $randKey    = str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT);

                return "{$wilayahKey}_{$gradeKey}_{$randKey}";
            })
            ->values();
    }
}
