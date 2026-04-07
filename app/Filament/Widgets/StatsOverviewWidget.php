<?php

namespace App\Filament\Widgets;

use App\Models\EventPeriod;
use App\Models\Registration;
use App\Models\Participant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $period = EventPeriod::where('is_active', true)->first();

        if (! $period) {
            return [
                Stat::make('Tidak ada periode aktif', '—')
                    ->description('Aktifkan satu periode event terlebih dahulu')
                    ->color('gray'),
            ];
        }

        $registrations = Registration::where('event_period_id', $period->id);

        $total        = (clone $registrations)->count();
        $pending      = (clone $registrations)->where('payment_status', 'pending')->count();
        $verified     = (clone $registrations)->where('payment_status', 'verified')->count();
        $rejected     = (clone $registrations)->where('payment_status', 'rejected')->count();
        $confirmed    = (clone $registrations)->where('status', 'confirmed')->count();
        $participants = Participant::where('event_period_id', $period->id)->count();
        $totalPayment  = (clone $registrations)->where('payment_status', 'verified')->sum('payment_amount');
        $totalDonation = (clone $registrations)->where('payment_status', 'verified')->sum('donation_amount');

        $last7 = Registration::where('event_period_id', $period->id)
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        return [
            Stat::make('Total Pendaftaran', $total)
                ->description($period->max_participants
                    ? 'Maksimum ' . number_format($period->max_participants, 0, ',', '.') . ' pendaftar'
                    : 'Semua pendaftaran periode aktif'
                )
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->chart($last7)
                ->color('primary'),

            Stat::make('Menunggu Verifikasi', $pending)
                ->description('Pembayaran belum diproses')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pending > 0 ? 'warning' : 'success'),

            Stat::make('Pembayaran Terverifikasi', $verified)
                ->description('Bukti pembayaran valid')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Pembayaran Ditolak', $rejected)
                ->description('Perlu tindak lanjut')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color($rejected > 0 ? 'danger' : 'gray'),

            Stat::make('Peserta Dikonfirmasi', $confirmed)
                ->description($participants . ' peserta terdaftar di sistem')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Total Pembayaran', 'Rp ' . number_format($totalPayment, 0, ',', '.'))
                ->description('Donasi: Rp ' . number_format($totalDonation, 0, ',', '.') . ' · verified only')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
