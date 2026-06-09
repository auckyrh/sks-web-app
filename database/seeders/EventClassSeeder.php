<?php

namespace Database\Seeders;

use App\Models\EventClass;
use App\Models\EventPeriod;
use Illuminate\Database\Seeder;

class EventClassSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            2025 => [
                ['level' => 'kecil',  'saint_name' => 'St. Yohanes Pembaptis', 'grade_min' => 1, 'grade_max' => 2],
                ['level' => 'tengah', 'saint_name' => 'St. Elisabeth',          'grade_min' => 3, 'grade_max' => 4],
                ['level' => 'besar',  'saint_name' => 'St. Zakharia',           'grade_min' => 5, 'grade_max' => 6],
            ],
            2026 => [
                ['level' => 'kecil',  'saint_name' => 'St. Vincentius A Paulo',        'grade_min' => 1, 'grade_max' => 2],
                ['level' => 'tengah', 'saint_name' => 'St. Bernadette Soubirus', 'grade_min' => 3, 'grade_max' => 4],
                ['level' => 'besar',  'saint_name' => 'St. Carlo Acutis',  'grade_min' => 5, 'grade_max' => 6],
            ],
        ];

        foreach ($data as $year => $classes) {
            $period = EventPeriod::where('year', $year)->first();

            if (! $period) {
                $this->command->warn("⚠️ Event period {$year} tidak ditemukan, dilewati.");
                continue;
            }

            foreach ($classes as $class) {
                EventClass::firstOrCreate(
                    ['event_period_id' => $period->id, 'level' => $class['level']],
                    $class
                );
            }

            $count = count($classes);
            $this->command->info("✅ {$count} event class ({$year}) berhasil di-seed!");
        }
    }
}
