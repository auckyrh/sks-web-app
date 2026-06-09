@php
    $data = $this->getData();
    $rows = $data['rows'];
    $max  = $data['max'];
    $total = array_sum(array_column($rows, 'count'));
@endphp

<div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
    <div class="mb-3 flex items-center justify-between">
        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
            Komite per Divisi
        </p>
        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">{{ $total }} total</span>
    </div>

    @if (empty($rows))
        <p class="text-sm text-gray-400">Belum ada data komite.</p>
    @else
        <div class="space-y-2">
            @foreach ($rows as $row)
                @php $pct = $max > 0 ? round(($row['count'] / $max) * 100) : 0; @endphp
                <div class="flex items-center gap-3">
                    {{-- Name --}}
                    <span class="w-36 shrink-0 truncate text-xs text-gray-600 dark:text-gray-300"
                          title="{{ $row['name'] }}">
                        {{ $row['name'] }}
                    </span>

                    {{-- Bar --}}
                    <div class="flex-1 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800" style="height:8px;">
                        <div class="h-full rounded-full transition-all duration-500"
                             style="width:{{ $pct }}%; background:{{ $row['color'] }};"></div>
                    </div>

                    {{-- Count --}}
                    <span class="w-6 shrink-0 text-right text-xs font-bold tabular-nums"
                          style="color:{{ $row['color'] }};">
                        {{ $row['count'] }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
