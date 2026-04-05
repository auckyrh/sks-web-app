<?php

namespace Database\Seeders;

use App\Models\EventPeriod;
use Illuminate\Database\Seeder;

class EventPeriodSeeder extends Seeder
{
    public function run(): void
    {
        $periods = [
            // 2008–2020: Jun 26–28 each year
            ['year' => 2008, 'theme' => 'Yesus = Kasih'],
            ['year' => 2009, 'theme' => 'Kamulah Sesamaku'],
            ['year' => 2010, 'theme' => 'Yesus Sahabatku'],
            ['year' => 2011, 'theme' => 'Aku Jagoan Kristus'],
            ['year' => 2012, 'theme' => 'Jesus Loves Me'],
            ['year' => 2013, 'theme' => 'Jesus Love Factory'],
            ['year' => 2014, 'theme' => '1000 Anak Misioner - The Mission of Love'],
            ['year' => 2015, 'theme' => '-'],
            ['year' => 2016, 'theme' => 'Hello Jesus'],
            ['year' => 2017, 'theme' => 'Here I Am Jesus'],
            ['year' => 2018, 'theme' => 'Warrior of Christ'],
            ['year' => 2019, 'theme' => 'Aku Katolik Aku Indonesia'],
            ['year' => 2020, 'theme' => 'Jesus is My Saviour'],

            // Specific records
            ['year' => 2021, 'theme' => 'Back to My Saviour', 'start' => '2021-06-24', 'end' => '2021-06-26'],
            ['year' => 2022, 'theme' => 'Unite with Jesus',   'start' => '2022-06-28', 'end' => '2022-06-30'],
            ['year' => 2023, 'theme' => 'Jesus is My Anchor', 'start' => '2023-06-20', 'end' => '2023-06-22', 'event_logo' => 'event-logos/LOGO-SKS-2023.jpeg'],
            ['year' => 2024, 'theme' => '-'],
            ['year' => 2025, 'theme' => 'Messenger of Joy & Love','start' => '2025-06-24', 'end' => '2025-06-26' , 'event_logo' => 'event-logos/LOGO-SKS-2025.png'],
            ['year' => 2026, 'theme' => 'Yeeess Lord!','start' => '2026-06-24', 'end' => '2026-06-26', 'event_logo' => 'event-logos/LOGO-SKS-2026.png'],
        ];

        $count = 0;

        foreach ($periods as $data) {
            $year       = $data['year'];
            $event_logo = $data['event_logo'] ?? null;
            $startDate  = $data['start'] ?? "{$year}-06-26";
            $endDate    = $data['end']   ?? "{$year}-06-28";
            $isActive   = $year === 2026;

            EventPeriod::firstOrCreate(
                ['year' => $year],
                [
                    'theme'                 => $data['theme'],
                    'event_logo'            => $event_logo,
                    'is_active'             => $isActive,
                    'event_start_date'      => $startDate,
                    'event_end_date'        => $endDate,
                    'registration_open_at'  => "{$year}-04-01 00:00:00",
                    'registration_close_at' => "{$year}-05-31 23:59:59",
                    'max_participants'      => 350,
                ]
            );

            $count++;
        }

        $this->command->info("✅ {$count} event period berhasil di-seed!");
    }
}
