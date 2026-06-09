<?php

namespace App\Exports;

use App\Models\Registration;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegistrationExport implements
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
        return Registration::where('event_period_id', $this->eventPeriodId)
            ->with(['wilayah', 'lingkungan', 'paymentTier'])
            ->orderBy('registration_number')
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
            'Wilayah',
            'Lingkungan',
            'Alamat',
            'Nama Orang Tua',
            'No. WA Orang Tua',
            'Daftar Lewat',
            'Ukuran Kaos',
            'Alergi',
            'Catatan',
            'Tier Pembayaran',
            'Nominal (Rp)',
            'Donasi (Rp)',
            'Status Pembayaran',
            'Status Pendaftaran',
            'Tgl Daftar',
        ];
    }

    public function map($row): array
    {
        return [
            $row->registration_number,
            $row->child_full_name,
            $row->nickname,
            $row->gender === 'F' ? 'Perempuan' : 'Laki-laki',
            $row->birth_date?->format('d/m/Y'),
            'Kelas ' . $row->grade,
            $row->wilayah?->name ?? '-',
            $row->lingkungan?->name ?? '-',
            $row->address,
            $row->parent_name,
            $row->parent_whatsapp,
            $row->registration_source,
            $row->tshirt_size,
            $row->allergies ?? '-',
            $row->notes ?? '-',
            $row->paymentTier?->name ?? '-',
            $row->payment_amount,
            $row->donation_amount ?? 0,
            $row->payment_status,
            $row->status,
            $row->created_at?->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Bold header row
            1 => [
                'font'      => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill'      => [
                    'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3F4F6'],
                ],
            ],
        ];
    }
}
