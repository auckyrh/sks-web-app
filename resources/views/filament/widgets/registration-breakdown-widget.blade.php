@php
    $data   = $this->getData();
    $grades = $data['grades'];
    $sizes  = $data['sizes'];
    $totalF = $data['totalF'];
    $totalM = $data['totalM'];

    // Split sizes into 3 columns
    $sizeChunks = count($sizes)
        ? array_chunk($sizes, (int) ceil(count($sizes) / 3))
        : [];
@endphp

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

    {{-- Grade breakdown --}}
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
            Pendaftaran per Kelas
        </p>

        {{-- Header row --}}
        <div class="mb-1 flex items-center border-b border-gray-100 pb-1.5 dark:border-gray-800">
            <span class="flex-1 text-xs font-semibold text-gray-400 dark:text-gray-500">Kelas</span>
            <span class="text-xs font-semibold" style="width:56px; text-align:center; color:#f472b6;">♀ P</span>
            <span class="text-xs font-semibold" style="width:56px; text-align:center; color:#60a5fa;">♂ L</span>
            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500" style="width:60px; text-align:right;">Total</span>
        </div>

        {{-- Grade rows --}}
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @foreach ($grades as $item)
                <div class="flex items-center py-1.5">
                    <span class="flex-1 text-sm text-gray-600 dark:text-gray-300">{{ $item['label'] }}</span>
                    <span class="text-sm tabular-nums" style="width:56px; text-align:center; color:#ec4899;">{{ $item['f'] }}</span>
                    <span class="text-sm tabular-nums" style="width:56px; text-align:center; color:#3b82f6;">{{ $item['m'] }}</span>
                    <span class="text-sm font-bold tabular-nums text-primary-600 dark:text-primary-400" style="width:60px; text-align:right;">{{ $item['count'] }}</span>
                </div>
            @endforeach
        </div>

        {{-- Totals row --}}
        <div class="mt-1 flex items-center border-t border-gray-200 pt-2 dark:border-gray-700">
            <span class="flex-1 text-xs font-bold text-gray-500 dark:text-gray-400">Total</span>
            <span class="text-sm font-bold tabular-nums" style="width:56px; text-align:center; color:#ec4899;">{{ $totalF }}</span>
            <span class="text-sm font-bold tabular-nums" style="width:56px; text-align:center; color:#3b82f6;">{{ $totalM }}</span>
            <span class="text-sm font-bold tabular-nums text-primary-600 dark:text-primary-400" style="width:60px; text-align:right;">{{ $totalF + $totalM }}</span>
        </div>
    </div>

    {{-- T-shirt size breakdown --}}
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
            Ukuran Kaos
        </p>
        @if (count($sizeChunks))
            <div class="grid gap-x-4" style="grid-template-columns: repeat({{ count($sizeChunks) }}, 1fr)">
                @foreach ($sizeChunks as $chunk)
                    <div class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($chunk as $item)
                            <div class="flex items-center justify-between py-1.5">
                                <span class="text-sm text-gray-600 dark:text-gray-300">{{ $item['label'] }}</span>
                                <span class="ml-4 text-base font-bold tabular-nums text-violet-600 dark:text-violet-400">
                                    {{ $item['count'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-400">Belum ada data ukuran kaos.</p>
        @endif
    </div>

</div>
