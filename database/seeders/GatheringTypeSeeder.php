<?php

namespace Database\Seeders;

use App\Models\GatheringType;
use Illuminate\Database\Seeder;

class GatheringTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['slug' => 'gathering',      'label' => 'Gathering Panitia',   'color' => 'primary', 'order' => 1],
            ['slug' => 'rekoleksi',      'label' => 'Rekoleksi',           'color' => 'violet',  'order' => 2],
            ['slug' => 'pertemuan_ortu', 'label' => 'Pertemuan Orang Tua', 'color' => 'sky',     'order' => 3],
            ['slug' => 'gladi_kotor',    'label' => 'Gladi Kotor',         'color' => 'orange',  'order' => 4],
            ['slug' => 'gladi_bersih',   'label' => 'Gladi Bersih',        'color' => 'teal',    'order' => 5],
            ['slug' => 'pembubaran',     'label' => 'Pembubaran Panitia',  'color' => 'rose',    'order' => 6],
        ];

        foreach ($types as $type) {
            GatheringType::firstOrCreate(['slug' => $type['slug']], $type);
        }

        $count = count($types);
        $this->command->info("✅ {$count} tipe gathering berhasil di-seed!");
    }
}
