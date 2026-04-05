<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            // Upper access
            ['name' => 'Romo',                      'access_level' => 'upper'],
            ['name' => 'Frater',                     'access_level' => 'upper'],
            ['name' => 'Ketua',                      'access_level' => 'upper'],
            ['name' => 'Wakil',                      'access_level' => 'upper'],
            ['name' => 'Sekretaris',                 'access_level' => 'upper'],
            ['name' => 'Bendahara',                  'access_level' => 'upper'],
            ['name' => 'IT',                         'access_level' => 'upper'],
            ['name' => 'Dana',                       'access_level' => 'upper'],
            ['name' => 'Pendaftaran',                'access_level' => 'upper'],
            ['name' => 'Acara',                      'access_level' => 'upper'],
            ['name' => 'Materi',                     'access_level' => 'upper'],

            // Lower access
            ['name' => 'Design',                     'access_level' => 'lower'],
            ['name' => 'Choir',                      'access_level' => 'lower'],
            ['name' => 'MC',                         'access_level' => 'lower'],
            ['name' => 'Pendamping',                 'access_level' => 'lower'],
            ['name' => 'Penjaga Pos',                'access_level' => 'lower'],
            ['name' => 'Band & Singer',              'access_level' => 'lower'],
            ['name' => 'Publikasi & Dokumentasi',    'access_level' => 'lower'],
            ['name' => 'Multimedia',                 'access_level' => 'lower'],
            ['name' => 'Liturgi & Doa',              'access_level' => 'lower'],
            ['name' => 'Konsumsi',                   'access_level' => 'lower'],
            ['name' => 'Kesehatan',                  'access_level' => 'lower'],
            ['name' => 'Perlengkapan',               'access_level' => 'lower'],
            ['name' => 'Keamanan & Kebersihan',      'access_level' => 'lower'],
        ];

        foreach ($divisions as $division) {
            Division::updateOrCreate(
                ['name' => $division['name']],   // find by
                $division                          // create or update with
            );
        }

        $count = count($divisions);
        $this->command->info("✅ {$count} divisi berhasil di-seed!");
    }
}