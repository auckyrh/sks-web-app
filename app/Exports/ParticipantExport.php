<?php

namespace App\Exports;

use App\Models\Participant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParticipantExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles
{
    public function __construct(
        private readonly int $eventPeriodId
    ) {}

    public function collection(): Collection
    {
        return Participant::where('event_period_id', $this->eventPeriodId)
            ->with([
                'registration',
                'eventClass',
                'team',
                'registration.wilayah',
                'registration.lingkungan',
            ])
            ->orderBy('team_id')
            ->orderBy('child_full_name')
            ->get();
    }

    private static array $months = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
    ];

    private function formatDate(?\Carbon\Carbon $date): string
    {
        if (! $date) return '-';
        return $date->day . ' ' . self::$months[$date->month] . ' ' . $date->year;
    }

    public function headings(): array
    {
        return [
            'No. Pendaftaran',
            'Nama Lengkap',
            'Nama Panggilan',
            'JK',
            'Tanggal Lahir',
            'Kelas',
            'Level',
            'Nama Tim',
            'Nama Orang Tua',
            'No. WA Orang Tua',
            'Ukuran Kaos',
            'Alergi',
            'Catatan',
            'Wilayah',
            'Lingkungan',
            'Link Grup WA Tim',
        ];
    }

    public function map($row): array
    {
        return [
            $row->registration?->registration_number ?? '-',
            $row->child_full_name,
            $row->nickname,
            $row->gender === 'F' ? 'P' : 'L',
            $this->formatDate($row->birth_date),
            'Kelas ' . $row->grade,
            ucfirst($row->eventClass?->level ?? '-'),
            $row->team?->name ?? '-',
            $row->parent_name,
            $row->parent_whatsapp,
            $row->tshirt_size,
            $row->allergies ?? '-',
            $row->notes ?? '-',
            $row->registration?->wilayah?->name ?? '-',
            $row->registration?->lingkungan?->name ?? '-',
            $row->team?->whatsapp_group_link ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill'      => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3F4F6'],
                ],
            ],
        ];
    }
}
