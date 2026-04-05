@php
    $period = $this->getPeriod();
@endphp

@if ($period)
    <div class="fi-wi-stats-overview-stat relative h-full overflow-hidden rounded-xl border border-amber-200 bg-gradient-to-br from-amber-50 to-white p-6 shadow-sm dark:border-amber-800/40 dark:from-amber-950/30 dark:to-gray-900">

        {{-- decorative ring --}}
        <div class="pointer-events-none absolute -right-10 -top-10 h-48 w-48 rounded-full bg-amber-100/60 dark:bg-amber-900/20"></div>
        <div class="pointer-events-none absolute -bottom-6 -right-4 h-28 w-28 rounded-full bg-amber-200/40 dark:bg-amber-900/10"></div>

        <div class="relative flex h-full flex-col justify-between gap-4">

            {{-- Left: year + theme --}}
            <div class="flex items-center gap-4">
                @if ($period->event_logo)
                    <img src="{{ Storage::url($period->event_logo) }}" alt="Event Logo"
                         class="h-14 w-14 rounded-lg object-contain shadow-sm ring-1 ring-amber-200 dark:ring-amber-700">
                @else
                    <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-amber-100 shadow-sm ring-1 ring-amber-200 dark:bg-amber-900/40 dark:ring-amber-700">
                        <x-heroicon-o-star class="h-7 w-7 text-amber-500" />
                    </div>
                @endif

                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold tracking-tight text-amber-700 dark:text-amber-400">
                            SKS {{ $period->year }}
                        </span>
{{--                        <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700 dark:bg-green-900/40 dark:text-green-400">--}}
{{--                            Aktif--}}
{{--                        </span>--}}
                    </div>
                    <p class="mt-0.5 text-sm font-medium text-gray-600 dark:text-gray-300">
                        {{ $period->theme ?? '—' }}
                    </p>
                </div>
            </div>

            {{-- Right: date info --}}
            <div class="flex flex-wrap gap-4 text-sm">

                @if ($period->event_start_date && $period->event_end_date)
                    <div class="flex items-center gap-1.5 text-gray-500 dark:text-gray-400">
                        <x-heroicon-o-calendar-days class="h-4 w-4 flex-shrink-0 text-amber-400" />
                        <span>
                            {{ $period->event_start_date->translatedFormat('d M Y') }}
                            —
                            {{ $period->event_end_date->translatedFormat('d M Y') }}
                        </span>
                    </div>
                @endif

                @if ($period->registration_open_at && $period->registration_close_at)
                    @php
                        $now = now();
                        $regOpen   = $period->registration_open_at;
                        $regClose  = $period->registration_close_at;
                        $isRegOpen = $now->between($regOpen, $regClose);
                    @endphp
                    <div class="flex items-center gap-1.5 text-gray-500 dark:text-gray-400">
                        <x-heroicon-o-clipboard-document-check class="h-4 w-4 flex-shrink-0 text-amber-400" />
                        <span>
                            Registrasi:
                            {{ $regOpen->translatedFormat('d M') }} — {{ $regClose->translatedFormat('d M Y') }}
                        </span>
                        @if ($isRegOpen)
                            <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700 dark:bg-green-900/40 dark:text-green-400">
                                Buka
                            </span>
                        @elseif ($now->lt($regOpen))
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                Belum dibuka
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                Ditutup
                            </span>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
@else
    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900">
        Tidak ada periode event yang aktif saat ini.
        <a href="{{ \App\Filament\Resources\EventPeriodResource::getUrl('index') }}" class="ml-1 font-semibold text-amber-600 underline hover:text-amber-700">
            Kelola Periode
        </a>
    </div>
@endif
