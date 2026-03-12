<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wilayah;
use App\Models\Lingkungan;

class WilayahLingkunganSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'St. Agustinus' => [
                'St. Gregorius', 'St. Vincentius', 'St. Teresa Kalkuta',
                'St. Yudas Tadeus', 'St. Padre Pio', 'St. Lukas', 'St. Matius',
            ],
            'St. Anna' => [
                'St. Angela', 'St. Petrus', 'St. Fransiskus Xaverius',
            ],
            'St. Fransiskus Asisi' => [
                'St. Ignatius de Loyola', 'St. Yohanes Pemandi',
            ],
            'St. Joachim' => [
                'St. Aloysius Gonzaga', 'St. Antonius', 'St. Brigitta', 'St. John Paul II',
            ],
            'St. Maria' => [
                'St. Agatha', 'St. Gabrielle', 'St. Bernadette', 'St. Theresia',
            ],
            'St. Paulus' => [
                'St. Alexander', 'St. Benediktus', 'St. Dominikus Savio',
                'St. Filipus', 'St. Catharina', 'St. Ursula',
            ],
            'St. Petrus' => [
                'St. Andreas', 'St. Yohanes', 'St. Natanael',
            ],
            'St. Thomas More' => [
                'St. Fidelis', 'St. Hendrikus', 'St. Gabriel',
            ],
            'St. Timotius' => [
                'St. Basilius Agung', 'St. Silas', 'St. Kristoforus',
                'St. Titus', 'St. Genoveva',
            ],
            'St. Yohanes Rasul' => [
                'St. Patricia', 'St. Raphael', 'St. Michael',
                'St. Regina', 'St. Monika',
            ],
            'St. Yoseph' => [
                'St. Valentinus', 'St. Immanuel', 'St. Immaculata',
                'St. Fransiska', 'St. Marcellinus', 'St. Elisabeth',
            ],
        ];

        foreach ($data as $wilayahName => $lingkunganList) {
            $wilayah = Wilayah::create(['name' => $wilayahName]);

            foreach ($lingkunganList as $lingkunganName) {
                Lingkungan::create([
                    'wilayah_id' => $wilayah->id,
                    'name' => $lingkunganName,
                ]);
            }
        }

        $this->command->info('✅ 11 wilayah dan 48 lingkungan berhasil di-seed!');
    }
}
