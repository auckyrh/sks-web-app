<x-filament-panels::page>
<style>
    /* ── Layout ─────────────────────────────────────────────────────────────── */
    .dk-wrap        { display: flex; flex-direction: column; gap: 1.25rem; padding-bottom: 3rem; }

    /* ── Stat bar ────────────────────────────────────────────────────────────── */
    .dk-stats       { display: flex; flex-wrap: wrap; gap: 0.75rem; }
    .dk-stat        { flex: 1; min-width: 9rem; background: white; border: 1px solid #e5e7eb;
                      border-radius: 1rem; padding: 0.875rem 1.25rem; }
    .dark .dk-stat  { background: rgb(30 30 35); border-color: rgb(55 55 65); }
    .dk-stat-label  { font-size: 0.7rem; font-weight: 600; text-transform: uppercase;
                      letter-spacing: 0.06em; color: #9ca3af; margin-bottom: 0.25rem; }
    .dk-stat-value  { font-size: 1.75rem; font-weight: 700; line-height: 1; color: #1f2937; }
    .dark .dk-stat-value     { color: #f3f4f6; }
    .dk-stat-value.ok        { color: #059669; }
    .dk-stat-value.warn      { color: #d97706; }

    /* ── Toolbar ─────────────────────────────────────────────────────────────── */
    .dk-toolbar     { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
    .dk-link-btn    { display: inline-flex; align-items: center; gap: 0.375rem;
                      font-size: 0.8125rem; font-weight: 500; color: #6b7280;
                      border: 1px solid #e5e7eb; border-radius: 0.5rem;
                      padding: 0.375rem 0.875rem; text-decoration: none;
                      transition: border-color 0.15s, color 0.15s; }
    .dk-link-btn:hover             { border-color: #d97706; color: #d97706; }
    .dark .dk-link-btn             { border-color: rgb(55 55 65); color: #9ca3af; }
    .dark .dk-link-btn:hover       { border-color: #d97706; color: #fbbf24; }

    /* ── Tabs ────────────────────────────────────────────────────────────────── */
    .dk-tabs        { display: flex; gap: 0.5rem; flex-wrap: wrap; }
    .dk-tab         { padding: 0.4375rem 1.25rem; border-radius: 99px; font-size: 0.875rem;
                      font-weight: 500; cursor: pointer; border: 1.5px solid #e5e7eb;
                      background: white; color: #6b7280; transition: all 0.15s; }
    .dark .dk-tab   { background: rgb(30 30 35); color: #9ca3af; border-color: rgb(55 55 65); }
    .dk-tab.active  { background: #d97706; color: white; border-color: #d97706; }
    .dk-tab:hover:not(.active) { border-color: #d97706; color: #d97706; }

    /* ── No data ─────────────────────────────────────────────────────────────── */
    .dk-empty       { background: white; border-radius: 1.125rem; padding: 3rem;
                      text-align: center; border: 1px solid #e5e7eb; }
    .dark .dk-empty { background: rgb(30 30 35); border-color: rgb(55 55 65); }

    /* ── 2-column grid ───────────────────────────────────────────────────────── */
    .dk-grid        { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
    @media (max-width: 768px) { .dk-grid { grid-template-columns: 1fr; } }

    /* ── Card ────────────────────────────────────────────────────────────────── */
    .dk-card        { background: white; border: 1px solid #e5e7eb; border-radius: 1.25rem;
                      overflow: hidden; }
    .dark .dk-card  { background: rgb(30 30 35); border-color: rgb(55 55 65); }

    .dk-card-header { display: flex; align-items: center; justify-content: space-between;
                      padding: 0.875rem 1.25rem 0.75rem;
                      border-bottom: 1px solid #f3f4f6; }
    .dark .dk-card-header { border-bottom-color: rgb(45 45 55); }
    .dk-card-title  { font-weight: 700; font-size: 1rem; color: #1f2937; }
    .dark .dk-card-title { color: #f3f4f6; }

    .dk-card-count  { font-size: 0.8125rem; font-weight: 700; padding: 0.25rem 0.75rem;
                      border-radius: 99px; }
    .dk-card-count.full  { background: #d1fae5; color: #065f46; }
    .dk-card-count.under { background: #fef3c7; color: #92400e; }
    .dk-card-count.over  { background: #fee2e2; color: #991b1b; }

    /* ── Gender summary bar under header ─────────────────────────────────────── */
    .dk-gender-bar  { display: flex; gap: 0.5rem; align-items: center;
                      padding: 0.375rem 1.25rem; background: #fafafa;
                      border-bottom: 1px solid #f3f4f6; font-size: 0.75rem; }
    .dark .dk-gender-bar         { background: rgb(25 25 30); border-bottom-color: rgb(45 45 55); }
    .dk-gender-pill              { display: inline-flex; align-items: center; gap: 0.25rem;
                                   font-weight: 600; padding: 0.1rem 0.5rem;
                                   border-radius: 99px; }
    .dk-gender-pill-p            { background: #fce7f3; color: #9d174d; }
    .dk-gender-pill-l            { background: #dbeafe; color: #1e40af; }
    .dark .dk-gender-pill-p      { background: #4a1942; color: #f9a8d4; }
    .dark .dk-gender-pill-l      { background: #1e3a5f; color: #93c5fd; }

    /* ── Member rows ─────────────────────────────────────────────────────────── */
    .dk-member-list { list-style: none; margin: 0; padding: 0.25rem 0; }
    .dk-member      { display: flex; align-items: center; gap: 0.625rem;
                      padding: 0.4375rem 1.25rem; border-bottom: 1px solid #f9fafb;
                      transition: background 0.1s; }
    .dark .dk-member             { border-bottom-color: rgb(38 38 45); }
    .dk-member:last-child        { border-bottom: none; }
    .dk-member:hover             { background: #fffbeb; }
    .dark .dk-member:hover       { background: rgb(40 35 20); }

    /* number */
    .dk-num         { font-size: 0.7rem; font-weight: 600; color: #d1d5db;
                      width: 1.375rem; text-align: right; flex-shrink: 0; }

    /* gender dot — prominent colored circle */
    .dk-dot         { width: 0.625rem; height: 0.625rem; border-radius: 50%;
                      flex-shrink: 0; margin-top: 0.05rem; }
    .dk-dot-p       { background: #ec4899; box-shadow: 0 0 0 2px #fce7f3; }
    .dk-dot-l       { background: #3b82f6; box-shadow: 0 0 0 2px #dbeafe; }
    .dark .dk-dot-p { box-shadow: 0 0 0 2px #4a1942; }
    .dark .dk-dot-l { box-shadow: 0 0 0 2px #1e3a5f; }

    /* name */
    .dk-name        { font-size: 0.875rem; font-weight: 600; color: #111827;
                      flex: 1; min-width: 0; }
    .dark .dk-name  { color: #f3f4f6; }

    /* meta chips */
    .dk-meta        { display: flex; align-items: center; gap: 0.3rem; flex-shrink: 0; }
    .dk-chip        { font-size: 0.6875rem; font-weight: 600; padding: 0.15rem 0.45rem;
                      border-radius: 99px; white-space: nowrap; }
    .dk-chip-grade  { background: #f3f4f6; color: #6b7280; }
    .dark .dk-chip-grade { background: rgb(45 45 55); color: #9ca3af; }
    .dk-chip-wilayah { background: #f0fdf4; color: #166534; max-width: 5.5rem;
                       overflow: hidden; text-overflow: ellipsis; }
    .dark .dk-chip-wilayah { background: #052e16; color: #86efac; }
    .dk-chip-umum   { background: #f9fafb; color: #9ca3af; }
    .dark .dk-chip-umum { background: rgb(40 40 50); color: #6b7280; }

    /* pindah */
    .dk-pindah      { font-size: 0.6875rem; font-weight: 600; padding: 0.25rem 0.625rem;
                      border-radius: 0.375rem; border: 1px solid #e5e7eb; color: #6b7280;
                      background: transparent; cursor: pointer; white-space: nowrap;
                      transition: all 0.15s; flex-shrink: 0; }
    .dk-pindah:hover             { border-color: #d97706; color: #d97706; background: #fffbeb; }
    .dark .dk-pindah             { border-color: rgb(55 55 65); color: #9ca3af; }
    .dark .dk-pindah:hover       { border-color: #d97706; color: #fbbf24; background: rgb(40 35 20); }
</style>

@if(! $period)
    <div class="dk-empty">
        <div style="font-size:2.5rem;margin-bottom:.5rem">📋</div>
        <p style="font-weight:600;color:#6b7280">Tidak ada periode aktif saat ini.</p>
    </div>
@else
<div class="dk-wrap">

    {{-- ── Status bar ───────────────────────────────────────────────────────── --}}
    <div class="dk-stats">
        <div class="dk-stat">
            <div class="dk-stat-label">Total Peserta</div>
            <div class="dk-stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="dk-stat">
            <div class="dk-stat-label">Sudah di Tim</div>
            <div class="dk-stat-value {{ $stats['assigned'] === $stats['total'] && $stats['total'] > 0 ? 'ok' : 'warn' }}">
                {{ $stats['assigned'] }}
            </div>
        </div>
        <div class="dk-stat">
            <div class="dk-stat-label">Belum di Tim</div>
            <div class="dk-stat-value {{ $stats['unassigned'] === 0 ? 'ok' : 'warn' }}">
                {{ $stats['unassigned'] }}
            </div>
        </div>
        <div class="dk-stat">
            <div class="dk-stat-label">Periode</div>
            <div class="dk-stat-value" style="font-size:1.125rem;padding-top:.3rem">
                SKS {{ $period->year }}
            </div>
        </div>
    </div>

    {{-- ── Toolbar ───────────────────────────────────────────────────────────── --}}
    <div class="dk-toolbar">
        <a href="{{ \App\Filament\Resources\TeamAssignmentConstraintResource::getUrl('index') }}"
           class="dk-link-btn">
            <x-heroicon-o-lock-closed style="width:1rem;height:1rem" />
            Kelola Constraints
        </a>
        <a href="{{ \App\Filament\Resources\TeamResource::getUrl('index') }}"
           class="dk-link-btn">
            <x-heroicon-o-user-group style="width:1rem;height:1rem" />
            Lihat Tim
        </a>
    </div>

    {{-- ── Class tabs ────────────────────────────────────────────────────────── --}}
    <div class="dk-tabs">
        @foreach($classes as $classData)
            <button
                wire:click="$set('activeTab', '{{ $classData['tab'] }}')"
                class="dk-tab {{ $activeTab === $classData['tab'] ? 'active' : '' }}"
            >
                {{ $classData['label'] }}
                <span style="opacity:.7;font-size:.75rem;margin-left:.3rem">({{ $classData['total'] }})</span>
            </button>
        @endforeach
    </div>

    {{-- ── Team cards ────────────────────────────────────────────────────────── --}}
    @foreach($classes as $classData)
        @if($activeTab === $classData['tab'])
            @if($classData['teams']->isEmpty())
                <div class="dk-empty">
                    <div style="font-size:2rem;margin-bottom:.5rem">👥</div>
                    <p style="font-weight:600;color:#6b7280">Belum ada tim untuk kelas ini.</p>
                </div>
            @else
                <div class="dk-grid">
                    @foreach($classData['teams'] as $teamData)
                        @php
                            $team       = $teamData['model'];
                            $count      = $teamData['count'];
                            $target     = $teamData['target'];
                            $countClass = match(true) {
                                $count === $target => 'full',
                                $count < $target   => 'under',
                                default            => 'over',
                            };
                            $girlCount  = $team->participants->where('gender', 'P')->count();
                            $boyCount   = $team->participants->where('gender', 'L')->count();
                        @endphp
                        <div class="dk-card">

                            {{-- Card header --}}
                            <div class="dk-card-header">
                                <span class="dk-card-title">{{ $team->name }}</span>
                                <span class="dk-card-count {{ $countClass }}">{{ $count }}/{{ $target }}</span>
                            </div>

                            {{-- Gender summary bar --}}
                            @if($count > 0)
                            <div class="dk-gender-bar">
                                <span class="dk-gender-pill dk-gender-pill-p">
                                    ♀ {{ $girlCount }} perempuan
                                </span>
                                <span class="dk-gender-pill dk-gender-pill-l">
                                    ♂ {{ $boyCount }} laki-laki
                                </span>
                            </div>
                            @endif

                            {{-- Member list --}}
                            @if($team->participants->isEmpty())
                                <p style="padding:1rem 1.25rem;font-size:.8125rem;color:#9ca3af;font-style:italic">
                                    Belum ada peserta.
                                </p>
                            @else
                                <ol class="dk-member-list">
                                    @foreach($team->participants->sortBy('child_full_name')->values() as $i => $participant)
                                        @php
                                            $wilayah  = $participant->registration?->wilayah?->name;
                                            $isUmum   = ! $wilayah;
                                            $displayName = $participant->nickname ?: $participant->child_full_name;
                                        @endphp
                                        <li class="dk-member">
                                            <span class="dk-num">{{ $i + 1 }}.</span>

                                            {{-- Gender dot --}}
                                            <span class="dk-dot {{ $participant->gender === 'P' ? 'dk-dot-p' : 'dk-dot-l' }}"></span>

                                            {{-- Name --}}
                                            <span class="dk-name" title="{{ $participant->child_full_name }}">
                                                {{ $displayName }}
                                            </span>

                                            {{-- Meta: grade + wilayah + pindah --}}
                                            <div class="dk-meta">
                                                <span class="dk-chip dk-chip-grade">Gr{{ $participant->grade }}</span>

                                                @if($wilayah)
                                                    <span class="dk-chip dk-chip-wilayah" title="{{ $wilayah }}">
                                                        {{ $wilayah }}
                                                    </span>
                                                @else
                                                    <span class="dk-chip dk-chip-umum">Umum</span>
                                                @endif

                                                <button
                                                    wire:click="mountAction('pindah', { 'id': {{ $participant->id }} })"
                                                    class="dk-pindah"
                                                >
                                                    Pindah
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    @endforeach

</div>
@endif

<x-filament-actions::modals />
</x-filament-panels::page>
