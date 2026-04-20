@php
    $data   = $this->getData();
    $grades = $data['grades'];
    $sizes  = $data['sizes'];

    // Split grades into 2 columns
    $gradeChunks = array_chunk($grades, (int) ceil(count($grades) / 2));

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
        <div class="grid gap-x-4" style="grid-template-columns: repeat({{ count($gradeChunks) }}, 1fr)">
            @foreach ($gradeChunks as $chunk)
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($chunk as $item)
                        <div class="flex items-center justify-between py-1.5">
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $item['label'] }}</span>
                            <span class="ml-4 text-base font-bold tabular-nums text-primary-600 dark:text-primary-400">
                                {{ $item['count'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endforeach
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
