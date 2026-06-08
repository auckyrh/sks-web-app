@php
/**
 * Class accent colors — defined as raw hex values so we can use
 * inline styles safely (Tailwind purges dynamic class names).
 */
$accents = [
    'kecil'  => [
        'primary'  => '#f59e0b',   // amber-500
        'light'    => '#fef3c7',   // amber-100
        'text'     => '#92400e',   // amber-800
        'dark'     => '#78350f',   // amber-900
    ],
    'tengah' => [
        'primary'  => '#10b981',   // emerald-500
        'light'    => '#d1fae5',   // emerald-100
        'text'     => '#065f46',   // emerald-900
        'dark'     => '#064e3b',
    ],
    'besar'  => [
        'primary'  => '#06b6d4',   // cyan-500
        'light'    => '#cffafe',   // cyan-100
        'text'     => '#155e75',   // cyan-900
        'dark'     => '#164e63',
    ],
];

$navItems = [
    ['key' => 'rundown',     'label' => 'Rundown',     'url' => "/{$period->year}/rundown",    'icon' => 'event_note'],
    ['key' => 'tata_tertib', 'label' => 'Tata Tertib', 'url' => "/{$period->year}/tata-tertib",'icon' => 'gavel'],
    ['key' => 'informasi',   'label' => 'Informasi',   'url' => "/{$period->year}/informasi",  'icon' => 'info'],
    ['key' => 'kontak',      'label' => 'Kontak',      'url' => "/{$period->year}/kontak",     'icon' => 'contact_support'],
    ['key' => 'kelompok',    'label' => 'Kelompok',    'url' => "/{$period->year}/kelompok",   'icon' => 'groups'],
];

$currentSegment = 'kelompok';

$search = trim($search ?? '');
@endphp

<style>
    .ms { font-family: 'Material Symbols Outlined'; font-weight: normal; font-style: normal; font-size: 24px; line-height: 1; letter-spacing: normal; text-transform: none; display: inline-block; white-space: nowrap; word-wrap: normal; direction: ltr; -webkit-font-smoothing: antialiased; }
    .ms-fill { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .team-card { box-shadow: 0px 4px 20px rgba(28, 20, 16, 0.04); }
    .team-card:hover { box-shadow: 0px 8px 28px rgba(28, 20, 16, 0.08); }
    .search-bar:focus-within { box-shadow: 0 0 0 2px rgba(245,158,11,0.25); border-color: #f59e0b; }
    @media (max-width: 639px) {
        body { padding-bottom: calc(72px + env(safe-area-inset-bottom, 0px)); }
    }
</style>

<div>

    {{-- ── Desktop: Top Navigation (hidden on mobile) ────────────────────────── --}}
    <nav class="hidden sm:flex items-center gap-1 mb-8 pb-5 border-b border-[#f0e8d8]">
        @foreach($navItems as $item)
            @php $isActiveNav = ($currentSegment === $item['key']); @endphp
            <a href="{{ $item['url'] }}"
               class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all"
               style="{{ $isActiveNav
                   ? 'background:#f59e0b; color:#fff; box-shadow:0 2px 8px rgba(245,158,11,0.35);'
                   : 'background:#fff; color:#78716c; border:1px solid #f0e8d8;' }}
                   {{ $isActiveNav ? '' : 'hover:border-color:#fcd34d;' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- ── Page Header ──────────────────────────────────────────────────────── --}}
    <div class="mb-6">
        <h1 style="font-family:'Lora',serif; font-size:28px; font-weight:700; color:#1c1410; line-height:1.2;">
            Kelompok
        </h1>
        <p class="text-sm mt-1" style="color:#9c7a48; font-family:'DM Sans',sans-serif;">
            SKS {{ $period->year }} — {{ $period->theme }}
        </p>
    </div>

    {{-- ── Search Bar (hero) ────────────────────────────────────────────────── --}}
    <div class="relative mb-7 search-bar bg-white border border-[#f0e8d8] rounded-full transition-all"
         style="box-shadow: 0px 4px 20px rgba(28,20,16,0.04);">
        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <span class="ms text-xl" style="color:#9c7a48;">search</span>
        </div>
        <input
            wire:model.live.debounce.300ms="search"
            type="text"
            placeholder="Cari nama anakmu di sini..."
            class="w-full bg-transparent border-none outline-none py-4 pr-12 text-sm"
            style="font-family:'DM Sans',sans-serif; color:#1c1410; font-size:15px; padding-left:3rem;"
        />
        @if($search !== '')
            <button
                wire:click="$set('search', '')"
                class="absolute inset-y-0 right-4 flex items-center transition-opacity hover:opacity-70">
                <span class="ms text-xl" style="color:#9c7a48;">cancel</span>
            </button>
        @endif
    </div>

    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    {{-- SEARCH MODE                                                           --}}
    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    @if($isSearching)

        @if(count($searchResults) > 0)
            {{-- Success header --}}
            <div class="flex items-center gap-1.5 mb-4" style="color:#10b981;">
                <span class="ms ms-fill text-[20px]">check_circle</span>
                <p class="text-sm font-semibold">
                    Ditemukan! Menampilkan hasil untuk "{{ $search }}"
                </p>
            </div>

            <div class="space-y-4">
                @foreach($searchResults as $result)
                    @php
                        $team  = $result['team'];
                        $class = $result['class'];
                        $ac    = $accents[$class->level] ?? $accents['kecil'];
                    @endphp

                    {{-- Team card (search result) --}}
                    <div class="bg-white rounded-[20px] overflow-hidden team-card border border-[#f0e8d8] relative transition-shadow">
                        {{-- Accent bar --}}
                        <div class="h-1.5 w-full" style="background: {{ $ac['primary'] }};"></div>

                        {{-- Watermark number --}}
                        <div class="absolute top-2 right-3 pointer-events-none select-none"
                             style="opacity:0.08; font-family:'Lora',serif; font-size:96px; font-weight:700; line-height:1; color:{{ $ac['primary'] }};">
                            {{ str_pad($team->number, 2, '0', STR_PAD_LEFT) }}
                        </div>

                        <div class="p-5 relative z-10">
                            {{-- Team header --}}
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 style="font-family:'Lora',serif; font-size:17px; font-weight:600; color:{{ $ac['text'] }}; line-height:1.3;">
                                        {{ $team->name }}
                                    </h3>
                                    <div class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                         style="background:{{ $ac['light'] }}; color:{{ $ac['dark'] }};">
                                        <span>{{ ucfirst($class->level) }}</span>
                                        &nbsp;·&nbsp;
                                        <span>Tim {{ $team->number }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Facilitators --}}
                            @if($team->facilitators->isNotEmpty())
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach($team->facilitators as $fac)
                                        <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                                            {{ $fac->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Participants --}}
                            <ol class="space-y-1.5">
                                @foreach($team->participants as $i => $participant)
                                    @php
                                        $name      = $participant->nickname ?: $participant->child_full_name;
                                        $isMatch   = str_contains(strtolower($name), strtolower($search));
                                        $genderDot = $participant->gender === 'F' ? '#ec4899' : '#3b82f6';
                                    @endphp
                                    <li class="flex items-center gap-2.5 rounded-lg transition-colors
                                        {{ $isMatch ? '-mx-2 px-2 py-1.5 border' : '' }}"
                                        style="{{ $isMatch ? "background:{$ac['light']}; border-color:{$ac['primary']}40;" : '' }}">
                                        <span class="text-xs w-5 text-right shrink-0 tabular-nums" style="color:#9c7a48;">
                                            {{ $i + 1 }}.
                                        </span>
                                        <span class="w-2 h-2 rounded-full shrink-0"
                                              style="background:{{ $genderDot }};"></span>
                                        <span class="text-sm {{ $isMatch ? 'font-bold' : '' }}"
                                              style="color:{{ $isMatch ? $ac['text'] : '#374151' }};">
                                            {{ $name }}
                                        </span>
                                        @if($isMatch)
                                            <span class="ml-auto text-[10px] text-white px-1.5 py-0.5 rounded-full font-bold shrink-0"
                                                  style="background:{{ $ac['primary'] }};">
                                                Cocok
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>

                            {{-- Count --}}
                            <p class="text-xs mt-3 text-right" style="color:#9c7a48;">
                                {{ $team->participants->count() }} peserta
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            {{-- No result --}}
            <div class="flex flex-col items-center justify-center py-12 text-center rounded-3xl"
                 style="background: linear-gradient(135deg, #fef3c7 0%, #fef8f0 100%);">
                <div class="w-24 h-24 mb-5 flex items-center justify-center bg-white rounded-full"
                     style="box-shadow: 0px 4px 20px rgba(28,20,16,0.08);">
                    <span class="ms text-5xl" style="color:#f59e0b;">groups</span>
                </div>
                <h2 style="font-family:'Lora',serif; font-size:20px; font-weight:600; color:#1c1410;" class="mb-2">
                    Nama tidak ditemukan
                </h2>
                <p class="text-sm max-w-[260px]" style="color:#78716c;">
                    Coba periksa kembali ejaan namanya. Pencarian menggunakan nama panggilan.
                </p>
                <button
                    wire:click="$set('search', '')"
                    class="mt-6 px-5 py-2.5 rounded-xl text-sm font-semibold transition-opacity hover:opacity-80"
                    style="background:#fef3c7; color:#92400e;">
                    Lihat Semua Kelompok
                </button>
            </div>
        @endif

    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    {{-- BROWSE MODE                                                           --}}
    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    @else

        @if($allClasses->isEmpty())
            {{-- No teams at all --}}
            <div class="bg-white rounded-2xl p-8 text-center" style="box-shadow: 0px 4px 20px rgba(28,20,16,0.04);">
                <span class="ms text-5xl mb-3 block" style="color:#d1c4be;">groups</span>
                <h2 style="font-family:'Lora',serif; font-size:18px; font-weight:600; color:#1c1410;" class="mb-2">
                    Data kelompok belum tersedia
                </h2>
                <p class="text-sm" style="color:#78716c;">
                    Pembagian kelompok sedang disiapkan oleh panitia SKS {{ $period->year }}.
                </p>
            </div>
        @else

            {{-- Class Tab Switcher --}}
            <div class="flex p-1.5 rounded-full mb-2 gap-1" style="background:#ece7e6;">
                @foreach($allClasses as $eventClass)
                    @php $ac = $accents[$eventClass->level] ?? $accents['kecil']; @endphp
                    <button
                        wire:click="$set('activeClass', '{{ $eventClass->level }}')"
                        class="flex-1 py-3 text-center rounded-full text-sm font-semibold transition-all duration-200 whitespace-nowrap"
                        style="{{ $activeClass === $eventClass->level
                            ? "background:{$ac['primary']}; color:#ffffff; box-shadow: 0 2px 8px {$ac['primary']}50;"
                            : 'color:#78716c; background:transparent;' }}">
                        {{ ucfirst($eventClass->level) }}
                    </button>
                @endforeach
            </div>

            {{-- Active class section label --}}
            @php
                $activeClassData = $allClasses->firstWhere('level', $activeClass);
                $ac              = $accents[$activeClass] ?? $accents['kecil'];
            @endphp

            @if($activeClassData)
                <div class="flex items-center gap-2 mb-6 mt-5">
                    <span class="w-8 h-1 rounded-full" style="background:{{ $ac['primary'] }};"></span>
                    <p class="text-xs font-bold tracking-widest uppercase" style="color:{{ $ac['text'] }};">
                        Kelas {{ ucfirst($activeClassData->level) }} — {{ $activeClassData->saint_name }}
                    </p>
                </div>

                @if($activeClassData->teams->isEmpty())
                    <p class="text-sm italic" style="color:#9c7a48;">Belum ada tim di kelas ini.</p>
                @else
                    {{-- Team Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @foreach($activeClassData->teams as $team)
                            <div class="bg-white rounded-[20px] overflow-hidden team-card border border-[#f0e8d8] relative transition-shadow">
                                {{-- Accent bar --}}
                                <div class="h-1.5 w-full" style="background:{{ $ac['primary'] }};"></div>

                                {{-- Watermark number --}}
                                <div class="absolute top-2 right-3 pointer-events-none select-none"
                                     style="opacity:0.08; font-family:'Lora',serif; font-size:96px; font-weight:700; line-height:1; color:{{ $ac['primary'] }};">
                                    {{ str_pad($team->number, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <div class="p-5 relative z-10">
                                    {{-- Team header --}}
                                    <div class="flex justify-between items-start mb-3">
                                        <h3 style="font-family:'Lora',serif; font-size:16px; font-weight:600; color:{{ $ac['text'] }}; line-height:1.3; max-width:75%;">
                                            {{ $team->name }}
                                        </h3>
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full shrink-0"
                                              style="background:{{ $ac['light'] }}; color:{{ $ac['dark'] }};">
                                            Tim {{ $team->number }}
                                        </span>
                                    </div>

                                    {{-- Facilitators --}}
                                    @if($team->facilitators->isNotEmpty())
                                        <div class="flex flex-wrap gap-1 mb-3">
                                            @foreach($team->facilitators as $fac)
                                                <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">
                                                    {{ $fac->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Participants --}}
                                    @if($team->participants->isEmpty())
                                        <p class="text-xs italic" style="color:#9c7a48;">Belum ada peserta.</p>
                                    @else
                                        <ol class="space-y-1.5">
                                            @foreach($team->participants as $i => $participant)
                                                @php
                                                    $name      = $participant->nickname ?: $participant->child_full_name;
                                                    $genderDot = $participant->gender === 'F' ? '#ec4899' : '#3b82f6';
                                                @endphp
                                                <li class="flex items-center gap-2">
                                                    <span class="text-xs w-5 text-right shrink-0 tabular-nums"
                                                          style="color:#9c7a48;">{{ $i + 1 }}.</span>
                                                    <span class="w-2 h-2 rounded-full shrink-0"
                                                          style="background:{{ $genderDot }};"></span>
                                                    <span class="text-sm truncate" style="color:#374151;">
                                                        {{ $name }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ol>

                                        <p class="text-xs mt-3 text-right" style="color:#9c7a48;">
                                            {{ $team->participants->count() }} peserta
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

        @endif

    @endif

    {{-- ── Bottom Navigation Bar (mobile only, fixed) ──────────────────────── --}}
    <nav class="sm:hidden fixed bottom-0 left-0 right-0 z-50 flex justify-around items-center px-2 bg-white border-t border-[#f0e8d8] rounded-t-2xl"
         style="box-shadow: 0 -4px 20px rgba(28,20,16,0.06); padding-bottom: env(safe-area-inset-bottom, 8px); padding-top: 8px; height: auto;">
        @foreach($navItems as $item)
            @php $isActive = ($item['key'] === $currentSegment); @endphp
            <a href="{{ $item['url'] }}"
               class="flex flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1.5 transition-all {{ $isActive ? 'scale-110' : '' }}"
               style="{{ $isActive
                   ? 'color:#f59e0b; background: rgba(245,158,11,0.12);'
                   : 'color:#a8a29e;' }}">
                <span class="ms {{ $isActive ? 'ms-fill' : '' }} text-[22px]">{{ $item['icon'] }}</span>
                <span class="text-[10px] font-semibold leading-none whitespace-nowrap">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

</div>
