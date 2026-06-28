<?php

namespace App\Exports;

use App\Models\EvaluationDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EvaluationExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles
{
    public function __construct(
        private readonly ?int $eventPeriodId
    ) {}

    public function collection(): Collection
    {
        return EvaluationDetail::with(['evaluation.eventPeriod', 'evaluation.eventClass', 'division'])
            ->whereHas('evaluation', fn ($q) => $q->where('event_period_id', $this->eventPeriodId))
            ->orderBy('evaluation_id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tipe Responden',
            'Kelas',
            'Nama Responden',
            'No. HP',
            'Divisi Tujuan',
            'Evaluasi / Kritik',
            'Saran',
            'Kesan & Pesan',
            'Waktu Submit',
        ];
    }

    private int $rowNumber = 0;

    public function map($detail): array
    {
        $eval = $detail->evaluation;

        return [
            ++$this->rowNumber,
            $eval->respondent_type === 'orang_tua' ? 'Orang Tua' : 'Panitia',
            $eval->eventClass?->saint_name ?? '—',
            $eval->respondent_name ?? 'Anonim',
            $eval->respondent_phone ?? '—',
            $detail->division->name,
            $detail->feedback,
            $detail->suggestions,
            $eval->impressions ?? '—',
            $eval->submitted_at->format('d M Y, H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D97706'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
