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
    <nav class="hidden sm:flex items-center gap-6 mb-8 pb-4 border-b border-[#f0e8d8]">
        @foreach($navItems as $item)
            @php $isActiveNav = ($currentSegment === $item['key']); @endphp
            <a href="{{ $item['url'] }}"
               class="pb-3 text-sm font-semibold whitespace-nowrap transition-all relative"
               style="{{ $isActiveNav
                   ? 'color:#f59e0b; border-bottom: 2px solid #f59e0b; margin-bottom: -1px;'
                   : 'color:#78716c; border-bottom: 2px solid transparent; margin-bottom: -1px;' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- ── Page Header (hidden when searching) ────────────────────────────────── --}}
    @if(!$isSearching)
    <div class="mb-6">
        <h1 style="font-family:'Lora',serif; font-size:28px; font-weight:700; color:#1c1410; line-height:1.2;">
            Kelompok
        </h1>
        <p class="text-sm mt-1" style="color:#9c7a48; font-family:'DM Sans',sans-serif;">
            SKS {{ $period->year }} — {{ $period->theme }}
        </p>
    </div>
    @endif

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
            {{-- ✓ Ditemukan banner --}}
            <div class="flex items-center gap-2 mb-5 px-3 py-2.5 rounded-xl" style="background:#d1fae5;">
                <span class="ms ms-fill text-[18px]" style="color:#059669;">check_circle</span>
                <p class="text-sm font-semibold" style="color:#065f46;">
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

                            {{-- ANGGOTA KELOMPOK section label --}}
                            <p class="text-[10px] font-bold tracking-widest uppercase mb-2 mt-1" style="color:#9c7a48;">
                                Anggota Kelompok
                            </p>

                            {{-- Participants --}}
                            <ul class="space-y-1.5">
                                @foreach($team->participants as $i => $participant)
                                    @php
                                        $name      = $participant->nickname ?: $participant->child_full_name;
                                        $isMatch   = str_contains(strtolower($name), strtolower($search));
                                        $genderDot = $participant->gender === 'F' ? '#ec4899' : '#3b82f6';
                                    @endphp
                                    <li class="flex items-center gap-2.5 rounded-lg transition-colors
                                        {{ $isMatch ? '-mx-2 px-2 py-1.5 border' : 'py-0.5' }}"
                                        style="{{ $isMatch ? "background:{$ac['light']}; border-color:{$ac['primary']}40;" : '' }}">
                                        <span class="w-2 h-2 rounded-full shrink-0"
                                              style="background:{{ $genderDot }};"></span>
                                        <span class="text-sm {{ $isMatch ? 'font-bold' : '' }}"
                                              style="color:{{ $isMatch ? $ac['text'] : '#374151' }};">
                                            {{ $name }}
                                        </span>
                                        @if($isMatch)
                                            <span class="ml-auto text-[10px] text-white px-1.5 py-0.5 rounded-full font-bold shrink-0 uppercase tracking-wide"
                                                  style="background:{{ $ac['primary'] }};">
                                                Pencarian
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Count + suggestion --}}
                            <p class="text-xs mt-3" style="color:#9c7a48;">
                                {{ $team->participants->count() }} peserta
                            </p>
                        </div>

                        {{-- Suggestion footer --}}
                        <div class="px-5 pb-4 pt-3 border-t border-[#f0e8d8]">
                            <p class="text-xs mb-2" style="color:#9c7a48;">
                                Bukan ini yang kamu cari?
                            </p>
                            <p class="text-xs mb-3" style="color:#78716c;">
                                Coba cari berdasarkan nama orang tua atau nomor pendaftaran jika nama panggilan tidak ditemukan.
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <button wire:click="$set('search', '{{ $search }}')"
                                        class="text-xs px-3 py-1.5 rounded-full border transition-opacity hover:opacity-70"
                                        style="border-color:{{ $ac['primary'] }}40; color:{{ $ac['text'] }}; background:{{ $ac['light'] }};">
                                    #{{ ucfirst($search) }}?
                                </button>
                                <button wire:click="$set('search', 'Anak{{ $team->name }}')"
                                        class="text-xs px-3 py-1.5 rounded-full border transition-opacity hover:opacity-70"
                                        style="border-color:{{ $ac['primary'] }}40; color:{{ $ac['text'] }}; background:{{ $ac['light'] }};">
                                    #Anak{{ $team->name }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            {{-- No result --}}
            <div class="flex flex-col items-center justify-center py-14 text-center rounded-3xl"
                 style="background: radial-gradient(circle at center, rgba(245,158,11,0.05) 0%, transparent 70%);">
                <div class="w-32 h-32 mb-5 flex items-center justify-center bg-white rounded-full"
                     style="box-shadow: 0px 8px 28px rgba(28,20,16,0.08);">
                    <span class="ms text-[56px]" style="color:#f59e0b; font-size:56px;">groups</span>
                </div>
                <h2 style="font-family:'Lora',serif; font-size:22px; font-weight:600; color:#1c1410;" class="mb-2">
                    Nama tidak ditemukan
                </h2>
                <p class="text-sm max-w-[280px]" style="color:#78716c;">
                    Coba periksa kembali ejaan namanya atau cari berdasarkan kategori lain.
                </p>
                <button
                    wire:click="$set('search', '')"
                    class="mt-7 px-6 py-3 rounded-xl text-sm font-semibold transition-all hover:opacity-90 active:scale-95"
                    style="background:#fea619; color:#ffffff; box-shadow: 0 2px 8px rgba(254,166,25,0.35);">
                    Lihat Semua Daftar
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
                        Kelas {{ ucfirst($eventClass->level) }}
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
                        Kelas {{ strtoupper($activeClassData->level) }} — {{ strtoupper($activeClassData->saint_name) }}
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
                                        <ul class="space-y-1.5">
                                            @foreach($team->participants as $i => $participant)
                                                @php $name = $participant->nickname ?: $participant->child_full_name; @endphp
                                                <li class="flex items-center gap-2">
                                                    <span class="w-1.5 h-1.5 rounded-full shrink-0"
                                                          style="background:{{ $ac['primary'] }};"></span>
                                                    <span class="text-sm truncate" style="color:#374151;">
                                                        {{ $name }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <p class="text-xs mt-3" style="color:#9c7a48;">
                                            {{ $team->participants->count() }} peserta
                                        </p>
                                    @endif
                                </div>

                                {{-- Detail link --}}
                                <div class="px-5 pb-4 border-t border-[#f0e8d8] pt-3">
                                    <button class="flex items-center gap-1 text-xs font-semibold transition-opacity hover:opacity-70"
                                            style="color:{{ $ac['primary'] }};">
                                        Lihat Detail Kelompok
                                        <span class="ms text-[16px]" style="color:{{ $ac['primary'] }};">chevron_right</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

        @endif

        {{-- ── Atmospheric Banner ─────────────────────────────────────────── --}}
        <div class="mt-10 rounded-2xl overflow-hidden relative"
             style="background: linear-gradient(135deg, #78350f 0%, #92400e 40%, #b45309 100%); min-height: 120px;">
            <div class="absolute inset-0 opacity-20"
                 style="background-image: radial-gradient(circle at 30% 50%, rgba(251,191,36,0.6) 0%, transparent 60%), radial-gradient(circle at 80% 20%, rgba(245,158,11,0.4) 0%, transparent 50%);"></div>
            <div class="relative z-10 p-6 flex flex-col justify-center" style="min-height:120px;">
                <p class="text-xs font-bold tracking-widest uppercase mb-1" style="color:rgba(251,191,36,0.8);">
                    SKS {{ $period->year }}
                </p>
                <h3 style="font-family:'Lora',serif; font-size:20px; font-weight:700; color:#ffffff; line-height:1.3;">
                    Menabur Kasih,<br>Memanen Iman
                </h3>
                @if($period->theme)
                    <p class="text-xs mt-2" style="color:rgba(255,255,255,0.65);">{{ $period->theme }}</p>
                @endif
            </div>
        </div>

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
