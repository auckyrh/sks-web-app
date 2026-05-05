<x-filament-widgets::widget>
    <style>
        .tsw-wrap { padding: 0.25rem 0; }
        .tsw-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1rem;
        }
        .tsw-title { font-size: 0.8125rem; font-weight: 700; color: #111827; }
        .dark .tsw-title { color: #f3f4f6; }
        .tsw-sub { font-size: 0.75rem; color: #6b7280; margin-top: 0.1rem; }
        .tsw-pill {
            font-size: 0.75rem; font-weight: 600;
            background: #fef3c7; color: #92400e;
            border-radius: 99px; padding: 0.2rem 0.75rem;
        }
        .dark .tsw-pill { background: rgba(251,191,36,0.15); color: #fbbf24; }

        .tsw-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 0.625rem;
        }
        .tsw-row {
            background: #f9fafb;
            border: 1px solid #f3f4f6;
            border-radius: 0.75rem;
            padding: 0.75rem;
        }
        .dark .tsw-row { background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.06); }
        .tsw-row-label { font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem; }
        .dark .tsw-row-label { color: #d1d5db; }
        .tsw-row-count { font-size: 1.375rem; font-weight: 700; color: #111827; line-height: 1; }
        .dark .tsw-row-count { color: #f9fafb; }
        .tsw-row-pct { font-size: 0.7rem; color: #9ca3af; margin-top: 0.1rem; }
        .tsw-bar-bg { background: #e5e7eb; border-radius: 99px; height: 4px; margin-top: 0.5rem; overflow: hidden; }
        .dark .tsw-bar-bg { background: rgba(255,255,255,0.08); }
        .tsw-bar-fill { background: linear-gradient(90deg, #f59e0b, #d97706); height: 100%; border-radius: 99px; transition: width 0.3s; }

        /* "Belum memilih" card — orange warning */
        .tsw-row-unset {
            background: #fff7ed;
            border-color: #fed7aa;
        }
        .dark .tsw-row-unset { background: rgba(154,52,18,0.1); border-color: rgba(253,186,116,0.2); }
        .tsw-row-unset .tsw-row-label { color: #9a3412; }
        .dark .tsw-row-unset .tsw-row-label { color: #fb923c; }
        .tsw-row-unset .tsw-row-count { color: #c2410c; }
        .dark .tsw-row-unset .tsw-row-count { color: #fb923c; }
        .tsw-bar-fill-unset { background: linear-gradient(90deg, #fb923c, #ea580c); }
    </style>

    <div class="tsw-wrap">
        <div class="tsw-header">
            <div>
                <p class="tsw-title">Committee T-shirt Sizes — SKS {{ $periodYear }}</p>
                <p class="tsw-sub">{{ $total }} total assignments</p>
            </div>
            @if($unsetCount > 0)
                <span class="tsw-pill" style="background:#fff7ed; color:#9a3412;">
                    ⚠ {{ $unsetCount }} belum memilih
                </span>
            @else
                <span class="tsw-pill">✓ All set</span>
            @endif
        </div>

        <div class="tsw-grid">
            {{-- Belum memilih — always first if any --}}
            @if($unsetCount > 0)
                @php $pct = $total > 0 ? round($unsetCount / $total * 100) : 0; @endphp
                <div class="tsw-row tsw-row-unset">
                    <p class="tsw-row-label">Belum memilih</p>
                    <p class="tsw-row-count">{{ $unsetCount }}</p>
                    <p class="tsw-row-pct">{{ $pct }}% of total</p>
                    <div class="tsw-bar-bg">
                        <div class="tsw-bar-fill tsw-bar-fill-unset" style="width:{{ $pct }}%;"></div>
                    </div>
                </div>
            @endif

            {{-- Per-size rows --}}
            @foreach($rows as $row)
                <div class="tsw-row">
                    <p class="tsw-row-label">{{ $row['label'] }}</p>
                    <p class="tsw-row-count">{{ $row['count'] }}</p>
                    <p class="tsw-row-pct">{{ $row['percent'] }}% of total</p>
                    <div class="tsw-bar-bg">
                        <div class="tsw-bar-fill" style="width:{{ $row['percent'] }}%;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament-widgets::widget>
