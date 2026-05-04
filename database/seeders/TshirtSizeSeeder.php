<?php

namespace Database\Seeders;

use App\Models\EventPeriod;
use App\Models\TshirtSize;
use Illuminate\Database\Seeder;

class TshirtSizeSeeder extends Seeder
{
    public function run(): void
    {
        $period = EventPeriod::where('year', 2026)->firstOrFail();

        $sizes = [
            // Kids sizes — from SKS 2026 Size Chart PDF
            ['code' => 'S',    'label' => 'S (Kids)',  'category' => 'kids',  'panjang' => 39, 'lebar' => 30, 'sort_order' => 1,  'is_active' => true],
            ['code' => 'M',    'label' => 'M (Kids)',  'category' => 'kids',  'panjang' => 43, 'lebar' => 32, 'sort_order' => 2,  'is_active' => true],
            ['code' => 'L',    'label' => 'L (Kids)',  'category' => 'kids',  'panjang' => 46, 'lebar' => 35, 'sort_order' => 3,  'is_active' => true],
            ['code' => 'XL',   'label' => 'XL (Kids)', 'category' => 'kids', 'panjang' => 50, 'lebar' => 37, 'sort_order' => 4,  'is_active' => true],
            ['code' => '2XL',  'label' => '2XL (Kids)','category' => 'kids', 'panjang' => 53, 'lebar' => 39, 'sort_order' => 5,  'is_active' => true],
            ['code' => '3XL',  'label' => '3XL (Kids)','category' => 'kids', 'panjang' => 57, 'lebar' => 42, 'sort_order' => 6,  'is_active' => true],
            ['code' => '4XL',  'label' => '4XL (Kids)','category' => 'kids', 'panjang' => 61, 'lebar' => 44, 'sort_order' => 7,  'is_active' => true],
            ['code' => '5XL',  'label' => '5XL (Kids)','category' => 'kids', 'panjang' => 65, 'lebar' => 45, 'sort_order' => 8,  'is_active' => true],

            // Adult sizes — from SKS 2026 Size Chart PDF (Adult/Unisex)
            ['code' => 'S-Dewasa',   'label' => 'S Dewasa',   'category' => 'adult', 'panjang' => 64, 'lebar' => 45, 'sort_order' => 9,  'is_active' => true],
            ['code' => 'M-Dewasa',   'label' => 'M Dewasa',   'category' => 'adult', 'panjang' => 66, 'lebar' => 47, 'sort_order' => 10, 'is_active' => true],
            ['code' => 'L-Dewasa',   'label' => 'L Dewasa',   'category' => 'adult', 'panjang' => 68, 'lebar' => 49, 'sort_order' => 11, 'is_active' => true],
            ['code' => 'XL-Dewasa',  'label' => 'XL Dewasa',  'category' => 'adult', 'panjang' => 70, 'lebar' => 51, 'sort_order' => 12, 'is_active' => true],
            ['code' => '2XL-Dewasa', 'label' => '2XL Dewasa', 'category' => 'adult', 'panjang' => 72, 'lebar' => 55, 'sort_order' => 13, 'is_active' => true],
            ['code' => '3XL-Dewasa', 'label' => '3XL Dewasa', 'category' => 'adult', 'panjang' => 74, 'lebar' => 59, 'sort_order' => 14, 'is_active' => true],
            ['code' => '4XL-Dewasa', 'label' => '4XL Dewasa', 'category' => 'adult', 'panjang' => 76, 'lebar' => 63, 'sort_order' => 15, 'is_active' => true],
            ['code' => '5XL-Dewasa', 'label' => '5XL Dewasa', 'category' => 'adult', 'panjang' => 78, 'lebar' => 67, 'sort_order' => 16, 'is_active' => true],
        ];

        foreach ($sizes as $size) {
            TshirtSize::updateOrCreate(
                ['event_period_id' => $period->id, 'code' => $size['code']],
                array_merge($size, ['event_period_id' => $period->id])
            );
        }

        $this->command->info('TshirtSize seeded for period ' . $period->year . ' (' . count($sizes) . ' sizes).');
    }
}
