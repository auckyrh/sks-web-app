<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\Registration;
use App\Models\TshirtSize;
use Illuminate\Database\Seeder;

class TshirtSizeBackfillSeeder extends Seeder
{
    /**
     * Backfill tshirt_size_id on existing registrations and participants
     * by matching the stored string code + event_period_id.
     *
     * Safe to run multiple times — skips rows that already have tshirt_size_id set.
     */
    public function run(): void
    {
        // Build a lookup map: [event_period_id][code] => tshirt_size_id
        $lookup = TshirtSize::all()->groupBy('event_period_id')->map(
            fn ($sizes) => $sizes->keyBy('code')->map(fn ($s) => $s->id)
        );

        // Backfill registrations
        $regUpdated = 0;
        Registration::withTrashed()
            ->whereNull('tshirt_size_id')
            ->whereNotNull('tshirt_size')
            ->each(function (Registration $reg) use ($lookup, &$regUpdated) {
                $id = $lookup[$reg->event_period_id][$reg->tshirt_size] ?? null;
                if ($id) {
                    $reg->updateQuietly(['tshirt_size_id' => $id]);
                    $regUpdated++;
                }
            });

        // Backfill participants
        $partUpdated = 0;
        Participant::withTrashed()
            ->whereNull('tshirt_size_id')
            ->whereNotNull('tshirt_size')
            ->each(function (Participant $participant) use ($lookup, &$partUpdated) {
                $id = $lookup[$participant->event_period_id][$participant->tshirt_size] ?? null;
                if ($id) {
                    $participant->updateQuietly(['tshirt_size_id' => $id]);
                    $partUpdated++;
                }
            });

        $this->command->info("Backfill complete — Registrations: {$regUpdated}, Participants: {$partUpdated}");
    }
}
