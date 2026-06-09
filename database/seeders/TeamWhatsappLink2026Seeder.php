<?php

namespace Database\Seeders;

use App\Models\EventPeriod;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamWhatsappLink2026Seeder extends Seeder
{
    public function run(): void
    {
        $period = EventPeriod::where('year', '2026')->firstOrFail();

        $links = [
            // ── St. Carlo Acutis (Kelas Kecil, 1–10) ──────────────────────────
            'Carlo Acutis' => [
                1  => 'https://chat.whatsapp.com/HQD4onSx2Wi1W80PKycoT2?mode=gi_t',
                2  => 'https://chat.whatsapp.com/EEL3r4ynGqk6rKzXw55NVR?mode=gi_t',
                3  => 'https://chat.whatsapp.com/KR3lHPFESiAA1pLdFMZhbR?mode=gi_t',
                4  => 'https://chat.whatsapp.com/CfGYWdQPmrGBx8J7SBJH6Z?mode=gi_t',
                5  => 'https://chat.whatsapp.com/DOGbdKlbsBGIZqQQ57toqU?mode=gi_t',
                6  => 'https://chat.whatsapp.com/D1U8deDVb6p7wGZQSPDsx5?mode=gi_t',
                7  => 'https://chat.whatsapp.com/H7C6AmXnhR4Efnkl0IjdFO?mode=gi_t',
                8  => 'https://chat.whatsapp.com/E5KnNy6naPRBeWYiH1csf4?mode=gi_t',
                9  => 'https://chat.whatsapp.com/JEWf61YSiKFJ29X9rwxJ5S?mode=gi_t',
                10 => 'https://chat.whatsapp.com/GR7VZEemJar3IlDGPx5Xle?mode=gi_t',
            ],

            // ── St. Bernadette Soubirous (Kelas Tengah, 1–14) ─────────────────
            'Bernadette' => [
                1  => 'https://chat.whatsapp.com/CZKx6p68TOJ8CRWdNHpEsb?mode=gi_t',
                2  => 'https://chat.whatsapp.com/HEcpSeOutWe5691Ubg53fd?mode=gi_t',
                3  => 'https://chat.whatsapp.com/IHNyIFUGmqk2LkOXVlRW5L?mode=gi_t',
                4  => 'https://chat.whatsapp.com/E875EMk2X73175YDFPgvUb?mode=gi_t',
                5  => 'https://chat.whatsapp.com/EeSBtf2Opa71YNz2s3Eq43?mode=gi_t',
                6  => 'https://chat.whatsapp.com/KKtbIHB4ZinEYAWOIjq2Yf?mode=gi_t',
                7  => 'https://chat.whatsapp.com/Bxrxuw7KXMxDP5bTm0GkXQ?mode=gi_t',
                8  => 'https://chat.whatsapp.com/LBJHY4TXtGgKOjyemsWsBF?mode=gi_t',
                9  => 'https://chat.whatsapp.com/ItET9jA6TIcKscEDeZGLQm?mode=gi_t',
                10 => 'https://chat.whatsapp.com/DD74rzqibdWBEhQkkjDkms?mode=gi_t',
                11 => 'https://chat.whatsapp.com/DNDNnkGRh61Fibs4nLxAbs?mode=gi_t',
                12 => 'https://chat.whatsapp.com/ECUAZhyczIs2mJ3i1XDdwH?mode=gi_t',
                13 => 'https://chat.whatsapp.com/Kym90ZmMBAQ1ne2HPPNmEg?mode=gi_t',
                14 => 'https://chat.whatsapp.com/LcFrSPiX3ANHsJJVOa8Ncl?mode=gi_t',
            ],

            // ── St. Vincentius A Paulo (Kelas Besar, 1–14) ────────────────────
            'Vincentius' => [
                1  => 'https://chat.whatsapp.com/GDWqPKeLhwX4JELY5SQQtk?mode=gi_t',
                2  => 'https://chat.whatsapp.com/FGKz1mASxvy2xLJHlGbyKM?mode=gi_t',
                3  => 'https://chat.whatsapp.com/KIzKsTkVdpV24LI8DFzqEe?mode=gi_t',
                4  => 'https://chat.whatsapp.com/G7Robb5QKm0I86BA2gBkBg?mode=gi_t',
                5  => 'https://chat.whatsapp.com/JUERh6xfXGmJfHA7fvTjUD?mode=gi_t',
                6  => 'https://chat.whatsapp.com/Ei0qoP7kM6H9tiuo6bDpwA?mode=gi_t',
                7  => 'https://chat.whatsapp.com/Cp1ix2CIrPq9cwkgyEcasK?mode=gi_t',
                8  => 'https://chat.whatsapp.com/KQIbDp6fenI30WN0Zmch1C?mode=gi_t',
                9  => 'https://chat.whatsapp.com/Fnt8vjlIyzP1GQ0AECS5ej?mode=gi_t',
                10 => 'https://chat.whatsapp.com/I2IMQnDLIE97bzLeyMpeiT?mode=gi_t',
                11 => 'https://chat.whatsapp.com/HCJa9YttjfgKLuGaeEDThD?mode=gi_t',
                12 => 'https://chat.whatsapp.com/HB9QXn9ZVRzG9qRHr2xj7V?mode=gi_t',
                13 => 'https://chat.whatsapp.com/CRmCbmbDkBC0TFRYKn8DQf?mode=gi_t',
                14 => 'https://chat.whatsapp.com/KQNDRvK8LiM6AUmUw3BYAr?mode=gi_t',
            ],
        ];

        $updated = 0;

        foreach ($links as $saintKeyword => $teamLinks) {
            foreach ($teamLinks as $number => $link) {
                $rows = Team::where('event_period_id', $period->id)
                    ->where('number', $number)
                    ->whereHas('eventClass', fn ($q) => $q->where('saint_name', 'like', "%{$saintKeyword}%"))
                    ->update(['whatsapp_group_link' => $link]);

                $updated += $rows;
            }
        }

        $this->command->info("✅ TeamWhatsappLink2026Seeder: {$updated} teams updated.");
    }
}
