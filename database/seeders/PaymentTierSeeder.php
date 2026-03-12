<?php

namespace Database\Seeders;

use App\Models\EventPeriod;
use App\Models\PaymentTier;
use Illuminate\Database\Seeder;

class PaymentTierSeeder extends Seeder
{
    public function run(): void
    {
        $count = 0;

        // 2008–2014: single Regular tier
        foreach (range(2008, 2014) as $year) {
            $period = EventPeriod::where('year', $year)->first();
            if (! $period) continue;

            PaymentTier::firstOrCreate(
                ['event_period_id' => $period->id, 'name' => 'Regular'],
                [
                    'amount'     => 300000,
                    'valid_from' => "{$year}-04-01",
                    'valid_until'=> "{$year}-05-31",
                ]
            );
            $count++;
        }

        // 2016–2021: Early Bird + Regular
        foreach (range(2016, 2021) as $year) {
            $period = EventPeriod::where('year', $year)->first();
            if (! $period) continue;

            PaymentTier::firstOrCreate(
                ['event_period_id' => $period->id, 'name' => 'Early Bird'],
                [
                    'amount'     => 300000,
                    'valid_from' => "{$year}-04-01",
                    'valid_until'=> "{$year}-04-30",
                ]
            );

            PaymentTier::firstOrCreate(
                ['event_period_id' => $period->id, 'name' => 'Regular'],
                [
                    'amount'     => 350000,
                    'valid_from' => "{$year}-05-01",
                    'valid_until'=> "{$year}-05-31",
                ]
            );
            $count += 2;
        }

        // 2022–2026 (excluding 2024): Early Bird + Regular
        foreach (array_diff(range(2022, 2026), [2024]) as $year) {
            $period = EventPeriod::where('year', $year)->first();
            if (! $period) continue;

            PaymentTier::firstOrCreate(
                ['event_period_id' => $period->id, 'name' => 'Early Bird'],
                [
                    'amount'     => 350000,
                    'valid_from' => "{$year}-04-01",
                    'valid_until'=> "{$year}-04-30",
                ]
            );

            PaymentTier::firstOrCreate(
                ['event_period_id' => $period->id, 'name' => 'Regular'],
                [
                    'amount'     => 400000,
                    'valid_from' => "{$year}-05-01",
                    'valid_until'=> "{$year}-05-31",
                ]
            );
            $count += 2;
        }

        $this->command->info("✅ {$count} payment tier berhasil di-seed!");
    }
}
