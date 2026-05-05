<x-filament-widgets::widget>
    @php
        $period   = \App\Models\EventPeriod::where('is_active', true)->first();
        $daysLeft = null;
        if ($period?->event_start_date) {
            $daysLeft = (int) now('Asia/Jakarta')->startOfDay()
                ->diffInDays($period->event_start_date->startOfDay(), false);
        }
    @endphp
    <a href="/internal"
       style="display:flex; align-items:center; justify-content:space-between;
              background: linear-gradient(135deg, #92400e 0%, #d97706 55%, #fbbf24 100%);
              border-radius: 0.875rem; padding: 1rem 1.25rem;
              text-decoration: none;
              box-shadow: 0 2px 12px rgba(180,83,9,0.2);
              transition: opacity 0.15s;"
       onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
        <div style="display:flex; align-items:center; gap:0.875rem;">
            <div style="width:2.25rem; height:2.25rem; background:rgba(255,255,255,0.2); border-radius:0.625rem;
                        display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <x-heroicon-s-users style="width:1.125rem; height:1.125rem; color:#fff;" />
            </div>
            <div>
                <p style="font-size:0.9375rem; font-weight:700; color:#fff; margin:0; line-height:1.3;">
                    Go to Internal Panel
                </p>
                <p style="font-size:0.75rem; color:rgba(255,255,255,0.75); margin:0;">
                    @if($daysLeft !== null && $daysLeft > 0)
                        SKS {{ $period->year }} — {{ $daysLeft }} days to go
                    @elseif($daysLeft !== null && $daysLeft === 0)
                        SKS {{ $period->year }} — Today is the day! 🎉
                    @elseif($daysLeft !== null && $daysLeft < 0)
                        SKS {{ $period->year }} — Event in progress
                    @else
                        Internal Panitia portal — profile, t-shirt size & assignments
                    @endif
                </p>
            </div>
        </div>
        <x-heroicon-s-arrow-top-right-on-square style="width:1rem; height:1rem; color:rgba(255,255,255,0.8); flex-shrink:0;" />
    </a>
</x-filament-widgets::widget>
