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

    public function headings(): array
    {
        return [
            'No. Pendaftaran',
            'Nama Lengkap',
            'Nama Panggilan',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Kelas',
            'Kelas Kelompok',
            'No. Tim',
            'Nama Tim',
            'Link Grup WA Tim',
            'Wilayah',
            'Lingkungan',
            'Nama Orang Tua',
            'No. WA Orang Tua',
            'Ukuran Kaos',
            'Alergi',
            'Catatan',
        ];
    }

    public function map($row): array
    {
        return [
            $row->registration?->registration_number ?? '-',
            $row->child_full_name,
            $row->nickname,
            $row->gender === 'F' ? 'Perempuan' : 'Laki-laki',
            $row->birth_date?->format('d/m/Y'),
            'Kelas ' . $row->grade,
            $row->eventClass?->name ?? '-',
            $row->team?->number ?? '-',
            $row->team?->name ?? '-',
            $row->team?->whatsapp_group_link ?? '-',
            $row->registration?->wilayah?->name ?? '-',
            $row->registration?->lingkungan?->name ?? '-',
            $row->parent_name,
            $row->parent_whatsapp,
            $row->tshirt_size,
            $row->allergies ?? '-',
            $row->notes ?? '-',
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
