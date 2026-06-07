<x-filament-panels::page>
<style>
    /* ── Layout ────────────────────────────────────────────────────────────── */
    .dk-wrap         { display: flex; flex-direction: column; gap: 1.25rem; padding-bottom: 3rem; }

    /* ── Stat bar ──────────────────────────────────────────────────────────── */
    .dk-stats        { display: flex; flex-wrap: wrap; gap: 0.75rem; }
    .dk-stat         { flex: 1; min-width: 9rem; background: white; border: 1px solid #e5e7eb;
                       border-radius: 1rem; padding: 0.875rem 1.125rem; }
    .dark .dk-stat   { background: rgb(30 30 35); border-color: rgb(55 55 65); }
    .dk-stat-label   { font-size: 0.7rem; font-weight: 600; text-transform: uppercase;
                       letter-spacing: 0.06em; color: #9ca3af; margin-bottom: 0.25rem; }
    .dk-stat-value   { font-size: 1.625rem; font-weight: 700; line-height: 1;
                       color: #1f2937; }
    .dark .dk-stat-value { color: #f3f4f6; }
    .dk-stat-value.ok   { color: #059669; }
    .dk-stat-value.warn { color: #d97706; }

    /* ── Toolbar ───────────────────────────────────────────────────────────── */
    .dk-toolbar      { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
    .dk-link-btn     { display: inline-flex; align-items: center; gap: 0.375rem;
                       font-size: 0.8125rem; font-weight: 500; color: #6b7280;
                       border: 1px solid #e5e7eb; border-radius: 0.5rem;
                       padding: 0.375rem 0.875rem; text-decoration: none;
                       transition: border-color 0.15s, color 0.15s; }
    .dk-link-btn:hover { border-color: #d97706; color: #d97706; }
    .dark .dk-link-btn { border-color: rgb(55 55 65); color: #9ca3af; }
    .dark .dk-link-btn:hover { border-color: #d97706; color: #fbbf24; }

    /* ── Tabs ──────────────────────────────────────────────────────────────── */
    .dk-tabs         { display: flex; gap: 0.5rem; flex-wrap: wrap; }
    .dk-tab          { padding: 0.4375rem 1.125rem; border-radius: 99px; font-size: 0.875rem;
                       font-weight: 500; cursor: pointer; border: 1.5px solid transparent;
                       transition: all 0.15s; background: white; color: #6b7280;
                       border-color: #e5e7eb; }
    .dark .dk-tab    { background: rgb(30 30 35); color: #9ca3af; border-color: rgb(55 55 65); }
    .dk-tab.active   { background: #d97706; color: white; border-color: #d97706; }
    .dk-tab:hover:not(.active) { border-color: #d97706; color: #d97706; }

    /* ── No data ───────────────────────────────────────────────────────────── */
    .dk-empty        { background: white; border-radius: 1.125rem; padding: 3rem;
                       text-align: center; border: 1px solid #e5e7eb; }
    .dark .dk-empty  { background: rgb(30 30 35); border-color: rgb(55 55 65); }

    /* ── Team grid + cards ─────────────────────────────────────────────────── */
    .dk-grid         { display: grid; grid-template-columns: repeat(auto-fill, minmax(17rem, 1fr));
                       gap: 1rem; }
    .dk-card         { background: white; border: 1px solid #e5e7eb; border-radius: 1.125rem;
                       padding: 1rem 1.125rem; }
    .dark .dk-card   { background: rgb(30 30 35); border-color: rgb(55 55 65); }
    .dk-card-header  { display: flex; align-items: center; justify-content: space-between;
                       margin-bottom: 0.75rem; }
    .dk-card-name    { font-weight: 700; font-size: 0.9375rem; color: #1f2937; }
    .dark .dk-card-name { color: #f3f4f6; }
    .dk-card-count   { font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.6rem;
                       border-radius: 99px; }
    .dk-card-count.full  { background: #d1fae5; color: #059669; }
    .dk-card-count.under { background: #fef3c7; color: #d97706; }
    .dk-card-count.over  { background: #fee2e2; color: #dc2626; }

    /* ── Member list ───────────────────────────────────────────────────────── */
    .dk-member-list  { list-style: none; margin: 0; padding: 0;
                       display: flex; flex-direction: column; gap: 0.25rem; }
    .dk-member       { display: flex; align-items: center; justify-content: space-between;
                       gap: 0.5rem; font-size: 0.8125rem; color: #374151; padding: 0.25rem 0;
                       border-bottom: 1px solid #f3f4f6; }
    .dark .dk-member { color: #d1d5db; border-bottom-color: rgb(45 45 55); }
    .dk-member:last-child { border-bottom: none; }
    .dk-member-left  { display: flex; align-items: center; gap: 0.375rem; flex: 1; min-width: 0; }
    .dk-member-num   { color: #9ca3af; font-size: 0.7rem; width: 1.25rem; text-align: right;
                       shrink: 0; }
    .dk-member-name  { font-weight: 500; white-space: nowrap; overflow: hidden;
                       text-overflow: ellipsis; }
    .dk-member-chips { display: flex; align-items: center; gap: 0.25rem; flex-shrink: 0; }
    .dk-chip         { font-size: 0.625rem; font-weight: 600; padding: 0.125rem 0.4rem;
                       border-radius: 99px; }
    .dk-chip-p       { background: #fce7f3; color: #9d174d; }
    .dk-chip-l       { background: #dbeafe; color: #1e40af; }
    .dk-chip-grade   { background: #f3f4f6; color: #6b7280; }
    .dark .dk-chip-grade { background: rgb(45 45 55); color: #9ca3af; }

    /* ── Pindah button ─────────────────────────────────────────────────────── */
    .dk-pindah       { font-size: 0.6875rem; font-weight: 600; padding: 0.1875rem 0.5rem;
                       border-radius: 0.375rem; border: 1px solid #e5e7eb; color: #6b7280;
                       background: transparent; cursor: pointer; white-space: nowrap;
                       transition: all 0.15s; flex-shrink: 0; }
    .dk-pindah:hover { border-color: #d97706; color: #d97706; }
    .dark .dk-pindah { border-color: rgb(55 55 65); color: #9ca3af; }
    .dark .dk-pindah:hover { border-color: #d97706; color: #fbbf24; }

    .dk-unassigned-badge { display: inline-block; font-size: 0.625rem; font-weight: 600;
                           background: #f3f4f6; color: #9ca3af; padding: 0.125rem 0.4rem;
                           border-radius: 99px; }
</style>

@if(! $period)
    <div class="dk-empty">
        <div style="font-size:2.5rem;margin-bottom:.5rem">📋</div>
        <p style="font-weight:600;color:#6b7280">Tidak ada periode aktif saat ini.</p>
    </div>
@else
<div class="dk-wrap">

    {{-- ── Status bar ──────────────────────────────────────────────────────── --}}
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
            <div class="dk-stat-value" style="font-size:1.125rem;padding-top:.25rem">
                SKS {{ $period->year }}
            </div>
        </div>
    </div>

    {{-- ── Toolbar ──────────────────────────────────────────────────────────── --}}
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

    {{-- ── Class tabs ───────────────────────────────────────────────────────── --}}
    <div class="dk-tabs">
        @foreach($classes as $classData)
            <button
                wire:click="$set('activeTab', '{{ $classData['tab'] }}')"
                class="dk-tab {{ $activeTab === $classData['tab'] ? 'active' : '' }}"
            >
                {{ $classData['label'] }}
                <span style="opacity:.75;font-size:.75rem;margin-left:.25rem">({{ $classData['total'] }})</span>
            </button>
        @endforeach
    </div>

    {{-- ── Team cards ───────────────────────────────────────────────────────── --}}
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
                            $team   = $teamData['model'];
                            $count  = $teamData['count'];
                            $target = $teamData['target'];
                            $countClass = match(true) {
                                $count === $target => 'full',
                                $count < $target   => 'under',
                                default            => 'over',
                            };
                        @endphp
                        <div class="dk-card">
                            <div class="dk-card-header">
                                <span class="dk-card-name">{{ $team->name }}</span>
                                <span class="dk-card-count {{ $countClass }}">
                                    {{ $count }}/{{ $target }}
                                </span>
                            </div>

                            @if($team->participants->isEmpty())
                                <p style="font-size:.8125rem;color:#9ca3af;font-style:italic">
                                    Belum ada peserta.
                                </p>
                            @else
                                <ol class="dk-member-list">
                                    @foreach($team->participants->sortBy('child_full_name') as $i => $participant)
                                        <li class="dk-member">
                                            <div class="dk-member-left">
                                                <span class="dk-member-num">{{ $i + 1 }}.</span>
                                                <span class="dk-member-name"
                                                      title="{{ $participant->child_full_name }}">
                                                    {{ $participant->nickname ?: $participant->child_full_name }}
                                                </span>
                                            </div>
                                            <div class="dk-member-chips">
                                                <span class="dk-chip {{ $participant->gender === 'P' ? 'dk-chip-p' : 'dk-chip-l' }}">
                                                    {{ $participant->gender }}
                                                </span>
                                                <span class="dk-chip dk-chip-grade">Gr{{ $participant->grade }}</span>
                                                @if($participant->registration?->wilayah)
                                                    <span class="dk-chip dk-chip-grade"
                                                          title="{{ $participant->registration->wilayah->name }}"
                                                          style="max-width:4rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                                        {{ $participant->registration->wilayah->name }}
                                                    </span>
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

{{-- Filament action modals are rendered here --}}
<x-filament-actions::modals />
</x-filament-panels::page>
