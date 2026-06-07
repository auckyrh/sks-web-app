<?php

namespace Database\Seeders;

use App\Models\EventPeriod;
use App\Models\Team;
use App\Models\TeamAssignmentConstraint;
use Illuminate\Database\Seeder;

/**
 * SKS 2026 — Special team assignment constraints.
 *
 * Run AFTER teams have been generated for this period.
 * To add constraints for future years, create a new seeder
 * (e.g. TeamAssignmentConstraint2027Seeder) following the same pattern.
 *
 * Constraint types:
 *   same_team  → listed participants must be placed in the same team (any team)
 *   fixed_team → listed participants must be placed in a specific team (fixed_team_id)
 */
class TeamAssignmentConstraint2026Seeder extends Seeder
{
    public function run(): void
    {
        $period = EventPeriod::where('year', '2026')->firstOrFail();

        // Find Carlo Acutis team #10 dynamically (Kelas Besar, number = 10)
        $carloAcutis10 = Team::where('event_period_id', $period->id)
            ->where('number', 10)
            ->whereHas('eventClass', fn ($q) => $q->where('saint_name', 'like', '%Carlo Acutis%'))
            ->first();

        $constraints = [
            // ── same_team constraints ──────────────────────────────────────────

            [
                'type'                 => 'same_team',
                'registration_numbers' => ['SKS-2026-0280', 'SKS-2026-0281'],
                'fixed_team_id'        => null,
                'notes'                => 'Jane Airene & Carren Purnomo — permintaan orang tua agar satu kelompok (Kelas Besar).',
            ],
            [
                'type'                 => 'same_team',
                'registration_numbers' => ['SKS-2026-0080', 'SKS-2026-0288'],
                'fixed_team_id'        => null,
                'notes'                => 'Yovela Valentine Octora & Kim Reina Pontoh — permintaan orang tua agar satu kelompok (Kelas Kecil).',
            ],
            [
                'type'                 => 'same_team',
                'registration_numbers' => ['SKS-2026-0311', 'SKS-2026-0265'],
                'fixed_team_id'        => null,
                'notes'                => 'Vanessa Irish Soewignyo & Elysia Angelin Laij — permintaan orang tua agar satu kelompok (Kelas Kecil).',
            ],
            [
                'type'                 => 'same_team',
                'registration_numbers' => ['SKS-2026-0034', 'SKS-2026-0004'],
                'fixed_team_id'        => null,
                'notes'                => 'Celine Yang & Fabiola Aerilyn Bellvania — permintaan orang tua agar satu kelompok (Kelas Besar).',
            ],

            // ── fixed_team constraint ──────────────────────────────────────────

            [
                'type'                 => 'fixed_team',
                'registration_numbers' => ['SKS-2026-0292'],
                'fixed_team_id'        => $carloAcutis10?->id,
                'notes'                => 'Rafael Andi Sutanto — ada suster pendamping. Ditempatkan di St. Carlo Acutis 10 (nomor terbesar) agar suster dapat duduk di barisan paling belakang/samping tanpa mengganggu acara.',
            ],
        ];

        foreach ($constraints as $data) {
            TeamAssignmentConstraint::firstOrCreate(
                [
                    'event_period_id'      => $period->id,
                    'type'                 => $data['type'],
                    'registration_numbers' => json_encode($data['registration_numbers']),
                ],
                [
                    'fixed_team_id' => $data['fixed_team_id'],
                    'notes'         => $data['notes'],
                ]
            );
        }

        $this->command->info('✅ TeamAssignmentConstraint2026Seeder: ' . count($constraints) . ' constraints seeded.');

        if (! $carloAcutis10) {
            $this->command->warn('⚠️  Carlo Acutis team #10 not found — fixed_team_id for Rafael is NULL. Run after teams are generated.');
        }
    }
}
