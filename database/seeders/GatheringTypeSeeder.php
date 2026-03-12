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
            ['slug' => 'rekoleksi',      'label' => 'Rekoleksi',           'color' => 'warning', 'order' => 2],
            ['slug' => 'pertemuan_ortu', 'label' => 'Pertemuan Orang Tua', 'color' => 'gray',  'order' => 3],
            ['slug' => 'gladi_kotor',    'label' => 'Gladi Kotor',         'color' => 'success', 'order' => 4],
            ['slug' => 'gladi_bersih',   'label' => 'Gladi Bersih',        'color' => 'info',    'order' => 5],
            ['slug' => 'pembubaran',     'label' => 'Pembubaran Panitia',  'color' => 'danger',  'order' => 6],
        ];

        foreach ($types as $type) {
            GatheringType::firstOrCreate(['slug' => $type['slug']], $type);
        }
    }
}
