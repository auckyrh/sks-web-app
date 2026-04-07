@php
    /** @var \App\Models\Registration $record */
    use Illuminate\Support\Facades\Storage;
    $proofUrl = $record->payment_proof_path
        ? Storage::disk('public')->url($record->payment_proof_path)
        : null;
    $tier = $record->paymentTier;
@endphp

<div x-data="{ lightbox: false }" class="space-y-4 text-sm">

    {{-- Identitas --}}
    <div class="grid grid-cols-2 gap-x-6 gap-y-2 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Nama Anak</p>
            <p class="mt-0.5 font-medium text-gray-900 dark:text-white">{{ $record->child_full_name }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Nama Orang Tua</p>
            <p class="mt-0.5 font-medium text-gray-900 dark:text-white">{{ $record->parent_name }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Wilayah</p>
            <p class="mt-0.5 text-gray-800 dark:text-gray-200">{{ $record->wilayah?->name ?? '—' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Lingkungan</p>
            <p class="mt-0.5 text-gray-800 dark:text-gray-200">{{ $record->lingkungan?->name ?? '—' }}</p>
        </div>
    </div>

    {{-- Detail Pembayaran --}}
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 space-y-2">
        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">Detail Pembayaran</p>

        <div class="grid grid-cols-2 gap-x-6 gap-y-2">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Tier Pembayaran</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    {{ $tier ? $tier->name . ' — Rp ' . number_format($tier->amount, 0, ',', '.') : '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Nominal Dibayar</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    Rp {{ number_format($record->payment_amount ?? 0, 0, ',', '.') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Donasi Silang</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    Rp {{ number_format($record->donation_amount ?? 0, 0, ',', '.') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Tanggal Transfer</p>
                <p class="font-medium text-gray-900 dark:text-white">
                    {{ $record->payment_date?->format('d M Y') ?? '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Nama Rekening Pengirim</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $record->payer_name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Status Pembayaran</p>
                <p class="font-medium">
                    @if($record->payment_status === 'verified')
                        <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">Verified</span>
                    @elseif($record->payment_status === 'rejected')
                        <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-200">Rejected</span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                    @endif
                </p>
            </div>
        </div>

        @if($record->payment_verified_at)
            <div class="mt-2 pt-2 border-t border-gray-100 dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400">
                Diverifikasi oleh <strong>{{ $record->paymentVerifiedBy?->full_name ?? '—' }}</strong>
                pada {{ $record->payment_verified_at->format('d M Y, H:i') }}
            </div>
        @endif

        @if($record->rejection_reason)
            <div class="mt-2 rounded-md bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 p-3">
                <p class="text-xs font-semibold text-red-700 dark:text-red-300">Alasan Penolakan</p>
                <p class="mt-0.5 text-red-800 dark:text-red-200">{{ $record->rejection_reason }}</p>
            </div>
        @endif
    </div>

    {{-- Bukti Transfer --}}
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">Bukti Transfer</p>

        @if($proofUrl)
            <img
                src="{{ $proofUrl }}"
                alt="Bukti Transfer"
                class="max-h-48 w-auto rounded-lg border border-gray-200 dark:border-gray-600 cursor-zoom-in object-contain hover:opacity-90 transition-opacity"
                @click="lightbox = true"
            />
            <p class="mt-1 text-xs text-gray-400">Klik gambar untuk memperbesar</p>
        @else
            <p class="text-gray-400 italic">Belum ada bukti transfer.</p>
        @endif
    </div>

    {{-- Lightbox --}}
    @if($proofUrl)
        <div
            x-show="lightbox"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click.self="lightbox = false"
            @keydown.escape.window="lightbox = false"
            style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.85); padding:1rem; align-items:center; justify-content:center;"
            :style="lightbox ? 'display:flex; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.85); padding:1rem; align-items:center; justify-content:center;' : 'display:none;'"
        >
            <button
                @click="lightbox = false"
                style="position:absolute; top:1rem; right:1rem; background:rgba(0,0,0,0.5); color:#fff; border:none; border-radius:50%; width:2.5rem; height:2.5rem; font-size:1.25rem; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; line-height:1;"
                aria-label="Tutup"
            >✕</button>
            <img
                src="{{ $proofUrl }}"
                alt="Bukti Transfer"
                style="max-width:100%; max-height:90vh; border-radius:0.5rem; box-shadow:0 25px 50px rgba(0,0,0,0.5); object-fit:contain;"
            />
        </div>
    @endif
</div>
