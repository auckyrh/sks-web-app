<x-filament-panels::page>
    <style>
        /* ── Base ─────────────────────────────────────────────────────────── */
        .ip-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding-bottom: 2rem;
        }

        /* ── Banner ────────────────────────────────────────────────────────── */
        .ip-banner {
            background: linear-gradient(135deg, #92400e 0%, #d97706 55%, #fbbf24 100%);
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            padding: 1.75rem;
            color: #fff;
            box-shadow: 0 4px 24px rgba(180,83,9,0.28);
        }
        .ip-banner::before {
            content: '';
            position: absolute; top: -2.5rem; right: -2.5rem;
            width: 8rem; height: 8rem; border-radius: 50%;
            background: rgba(255,255,255,0.08);
            pointer-events: none;
        }
        .ip-banner::after {
            content: '';
            position: absolute; bottom: -2rem; right: 4rem;
            width: 5rem; height: 5rem; border-radius: 50%;
            background: rgba(255,255,255,0.06);
            pointer-events: none;
        }
        .ip-banner-inner {
            position: relative; z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .ip-banner-logo {
            flex-shrink: 0;
            height: 4.5rem;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 10px rgba(0,0,0,0.22));
            opacity: 0.93;
        }
        .ip-banner-greeting { font-size: 0.875rem; color: rgba(255,255,255,0.78); font-weight: 500; }
        .ip-banner-name     { font-size: 1.625rem; font-weight: 700; line-height: 1.2; margin-top: 0.1rem; color: #fff; }

        .ip-chip {
            display: inline-flex; align-items: center; gap: 0.375rem;
            background: rgba(255,255,255,0.18); backdrop-filter: blur(4px);
            border-radius: 99px; padding: 0.25rem 0.75rem;
            font-size: 0.75rem; font-weight: 600; color: #fff;
        }
        /* Coordinator chip — white bg with dark amber text, stands out on the yellow/amber banner */
        .ip-chip-coord {
            background: rgba(255,255,255,0.92); color: #78350f;
        }

        /* ── Warning box ────────────────────────────────────────────────────── */
        .ip-warn-box {
            display: flex; align-items: flex-start; gap: 0.75rem;
            background: #fff7ed; border: 1px solid #fed7aa;
            border-radius: 1rem; padding: 1rem;
        }
        .dark .ip-warn-box { background: rgba(154,52,18,0.15); border-color: rgba(253,186,116,0.3); }
        .ip-warn-icon {
            flex-shrink: 0;
            width: 2.25rem; height: 2.25rem;
            background: #ffedd5; border-radius: 0.625rem;
            display: flex; align-items: center; justify-content: center;
        }
        .dark .ip-warn-icon { background: rgba(154,52,18,0.3); }
        .ip-warn-title { font-size: 0.875rem; font-weight: 600; color: #9a3412; }
        .dark .ip-warn-title { color: #fb923c; }
        .ip-warn-body  { margin-top: 0.25rem; font-size: 0.75rem; color: #c2410c; }
        .dark .ip-warn-body  { color: #fdba74; }
        .ip-warn-link  { display: inline-block; margin-top: 0.5rem; font-size: 0.75rem; font-weight: 700; color: #c2410c; text-decoration: underline; text-underline-offset: 2px; }
        .dark .ip-warn-link  { color: #fb923c; }

        /* ── Cards ──────────────────────────────────────────────────────────── */
        .ip-card {
            background: #fff;
            border: 1px solid #fef3c7;
            border-radius: 1.125rem;
            padding: 1.375rem;
            box-shadow: 0 1px 8px rgba(180,83,9,0.07);
        }
        .dark .ip-card {
            background: rgb(31,41,55);
            border-color: rgba(251,191,36,0.15);
        }
        .ip-card-label {
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #d97706;
            margin-bottom: 1rem;
        }
        .dark .ip-card-label { color: #fbbf24; }

        /* ── Stat rows ──────────────────────────────────────────────────────── */
        .ip-stat-label { font-size: 0.75rem; color: #9ca3af; margin-bottom: 0.125rem; }
        .ip-stat-value { font-size: 0.9375rem; font-weight: 600; color: #111827; }
        .dark .ip-stat-value { color: #f3f4f6; }

        .ip-badge-success {
            display: inline-flex; align-items: center; gap: 0.25rem;
            background: #d1fae5; color: #065f46;
            border-radius: 99px; padding: 0.2rem 0.625rem;
            font-size: 0.7rem; font-weight: 600;
        }
        .ip-badge-warn {
            display: inline-flex; align-items: center;
            background: #ffedd5; color: #c2410c;
            border-radius: 99px; padding: 0.2rem 0.625rem;
            font-size: 0.7rem; font-weight: 600;
        }
        .dark .ip-badge-success { background: rgba(6,95,70,0.3);    color: #6ee7b7; }
        .dark .ip-badge-warn    { background: rgba(194,65,12,0.25);  color: #fdba74; }

        /* ── Profile card internals ─────────────────────────────────────────── */
        .ip-avatar-initials {
            width: 3.5rem; height: 3.5rem; border-radius: 50%;
            background: #fef3c7; color: #b45309;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem; font-weight: 700; flex-shrink: 0;
            border: 2px solid #fde68a;
        }
        .dark .ip-avatar-initials {
            background: rgba(251,191,36,0.12); color: #fbbf24;
            border-color: rgba(251,191,36,0.3);
        }

        .ip-missing-chip {
            display: inline-block;
            background: #fffbeb; color: #92400e;
            border: 1px solid #fde68a;
            border-radius: 99px; padding: 0.2rem 0.625rem;
            font-size: 0.7rem; font-weight: 500;
        }
        .dark .ip-missing-chip {
            background: rgba(251,191,36,0.08); color: #fbbf24;
            border-color: rgba(251,191,36,0.2);
        }

        .ip-user-name  { font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dark .ip-user-name  { color: #f9fafb; }
        .ip-user-email { font-size: 0.8125rem; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dark .ip-user-email { color: #9ca3af; }

        .ip-edit-btn {
            display: inline-flex; align-items: center; gap: 0.25rem;
            background: #fffbeb; color: #b45309;
            border: 1px solid #fde68a;
            border-radius: 0.5rem; padding: 0.25rem 0.625rem;
            font-size: 0.75rem; font-weight: 600;
            transition: background 0.15s; text-decoration: none;
        }
        .ip-edit-btn:hover { background: #fef3c7; }
        .dark .ip-edit-btn { background: rgba(251,191,36,0.08); color: #fbbf24; border-color: rgba(251,191,36,0.2); }
        .dark .ip-edit-btn:hover { background: rgba(251,191,36,0.16); }

        .ip-incomplete-box {
            margin-top: 1rem;
            background: #fffbeb; border: 1px solid #fde68a;
            border-radius: 0.75rem; padding: 0.75rem;
        }
        .dark .ip-incomplete-box {
            background: rgba(251,191,36,0.06); border-color: rgba(251,191,36,0.2);
        }
        .ip-incomplete-label { font-size: 0.7rem; font-weight: 700; color: #d97706; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.06em; }
        .dark .ip-incomplete-label { color: #fbbf24; }

        /* ── Admin link ─────────────────────────────────────────────────────── */
        .ip-admin-link {
            display: flex; align-items: center; justify-content: space-between;
            background: #fffbeb; border: 1px solid #fde68a;
            border-radius: 1.125rem; padding: 1rem;
            text-decoration: none; transition: background 0.2s;
        }
        .ip-admin-link:hover { background: #fef3c7; }
        .dark .ip-admin-link { background: rgba(251,191,36,0.06); border-color: rgba(251,191,36,0.18); }
        .dark .ip-admin-link:hover { background: rgba(251,191,36,0.12); }
        .ip-admin-icon-wrap {
            width: 2.5rem; height: 2.5rem;
            background: linear-gradient(135deg, #d97706, #92400e);
            border-radius: 0.75rem;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .ip-admin-title { font-size: 0.9375rem; font-weight: 600; color: #78350f; }
        .dark .ip-admin-title { color: #fde68a; }
        .ip-admin-sub   { font-size: 0.75rem; color: #b45309; }
        .dark .ip-admin-sub   { color: #fbbf24; }

        /* ── Footer logos ───────────────────────────────────────────────────── */
        .ip-footer-logos {
            display: flex; align-items: center; justify-content: center;
            gap: 1.5rem; padding-top: 0.5rem; opacity: 0.4;
        }
        .ip-footer-logos img { height: 2.25rem; width: auto; object-fit: contain; }
        .dark .ip-footer-logos img.logo-black { display: none; }
        .ip-footer-logos img.logo-white { display: none; }
        .dark .ip-footer-logos img.logo-white { display: block; }

        /* ── Responsive ─────────────────────────────────────────────────────── */
        .ip-two-col   { display: grid; grid-template-columns: 1fr; gap: 1rem; }
        .ip-stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

        @media (min-width: 640px) {
            .ip-banner     { padding: 2rem 2.25rem; }
            .ip-banner-logo { height: 5.5rem; }
            .ip-banner-name { font-size: 1.875rem; }
            .ip-card       { padding: 1.625rem; }
        }
        @media (min-width: 1024px) {
            .ip-two-col     { grid-template-columns: 1fr 1fr; }
            .ip-banner-logo { height: 6rem; }
        }
    </style>

    <div class="ip-wrap">

        {{-- ── Welcome Banner ──────────────────────────────────────────────── --}}
        <div class="ip-banner">
            <div class="ip-banner-inner">
                <div style="min-width:0; flex:1;">
                    <p class="ip-banner-greeting">Hello,</p>
                    <p class="ip-banner-name">{{ $user->nick_name ?: $user->full_name }}</p>

                    @if($assignment)
                        <div style="display:flex; flex-wrap:wrap; gap:0.5rem; margin-top:0.875rem;">
                            <span class="ip-chip">
                                <x-heroicon-s-user-group style="width:0.875rem;height:0.875rem;flex-shrink:0;" />
                                {{ $assignment->division->name }}
                            </span>
                            <span class="ip-chip">
                                <x-heroicon-s-calendar-days style="width:0.875rem;height:0.875rem;flex-shrink:0;" />
                                SKS {{ $assignment->eventPeriod->year }} - {{ $assignment->eventPeriod->theme }}
                            </span>
                            @if($assignment->position === 'coordinator')
                                <span class="ip-chip ip-chip-coord">
                                    <x-heroicon-s-star style="width:0.875rem;height:0.875rem;flex-shrink:0;" />
                                    Koordinator
                                </span>
                            @endif
                            @if($daysLeft !== null && $daysLeft > 0)
                                <span class="ip-chip">
                                    <x-heroicon-s-clock style="width:0.875rem;height:0.875rem;flex-shrink:0;" />
                                    {{ $daysLeft }} days to go
                                </span>
                            @elseif($daysLeft !== null && $daysLeft === 0)
                                <span class="ip-chip ip-chip-coord">🎉 Today is the day!</span>
                            @elseif($daysLeft !== null && $daysLeft < 0)
                                <span class="ip-chip">Event in progress</span>
                            @endif
                        </div>
                    @else
                        <p style="margin-top:0.5rem; font-size:0.875rem; color:rgba(255,255,255,0.65);">
                            No active assignment for this period.
                        </p>
                    @endif
                </div>

                @php
                    $logoSrc = $activePeriod?->event_logo
                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($activePeriod->event_logo)
                        : asset('images/LOGO-SKS-2026.png');
                @endphp
                <img src="{{ $logoSrc }}" alt="SKS Logo" class="ip-banner-logo" />
            </div>
        </div>

        {{-- ── T-shirt Size Warning ─────────────────────────────────────────── --}}
        @if($assignment && !$assignment->tshirt_size_id)
            <div class="ip-warn-box">
                <div class="ip-warn-icon">
                    <x-heroicon-s-exclamation-triangle style="width:1.125rem;height:1.125rem;color:#ea580c;" />
                </div>
                <div style="flex:1; min-width:0;">
                    <p class="ip-warn-title">T-shirt size not set</p>
                    <p class="ip-warn-body">Segera isi ukuran kaos kamu agar bisa disiapkan tepat waktu.</p>
                    <a href="/internal/profile" class="ip-warn-link">Isi sekarang →</a>
                </div>
            </div>
        @endif

        {{-- ── Two-column: Assignment + Profile ────────────────────────────── --}}
        <div class="ip-two-col">

            @if($assignment)
            <div class="ip-card">
                <p class="ip-card-label">Active Assignment</p>
                <div class="ip-stat-grid">
                    <div>
                        <p class="ip-stat-label">Division</p>
                        <p class="ip-stat-value">{{ $assignment->division->name }}</p>
                    </div>
                    <div>
                        <p class="ip-stat-label">Position</p>
                        <p class="ip-stat-value">
                            {{ $assignment->position === 'coordinator' ? 'Koordinator' : 'Anggota' }}
                        </p>
                    </div>
                    <div>
                        <p class="ip-stat-label">Period</p>
                        <p class="ip-stat-value">SKS {{ $assignment->eventPeriod->year }}</p>
                    </div>
                    <div>
                        <p class="ip-stat-label">Status</p>
                        @if($assignment->is_active)
                            <span class="ip-badge-success">
                                <span style="width:0.375rem;height:0.375rem;border-radius:50%;background:#10b981;display:inline-block;"></span>
                                Aktif
                            </span>
                        @else
                            <span class="ip-badge-warn">Tidak Aktif</span>
                        @endif
                    </div>
                    <div style="grid-column:1/-1;">
                        <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.25rem;">
                            <p class="ip-stat-label" style="margin-bottom:0;">T-shirt Size</p>
                            {{ $this->editTshirtSizeAction }}
                        </div>
                        <div>
                            @if($assignment->tshirtSize)
                                <p class="ip-stat-value">
                                    {{ $assignment->tshirtSize->label }}
                                    <span style="font-size:0.75rem; color:#9ca3af; font-weight:400;">
                                        (P {{ $assignment->tshirtSize->panjang }} × L {{ $assignment->tshirtSize->lebar }} cm)
                                    </span>
                                </p>
                            @else
                                <span class="ip-badge-warn">Belum diisi</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div style="margin-top:1rem; padding-top:0.875rem; border-top:1px solid #fef3c7;">
                    <a href="/internal/my-division"
                       style="display:inline-flex; align-items:center; gap:0.375rem; font-size:0.8125rem; font-weight:600; color:#b45309; text-decoration:none;">
                        <x-heroicon-s-user-group style="width:0.875rem;height:0.875rem;" />
                        View My Division
                        <x-heroicon-s-arrow-right style="width:0.75rem;height:0.75rem;" />
                    </a>
                </div>
            </div>
            @endif

            <div class="ip-card">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                    <p class="ip-card-label" style="margin-bottom:0;">My Profile</p>
                    <a href="/internal/profile" class="ip-edit-btn">
                        <x-heroicon-s-pencil-square style="width:0.75rem;height:0.75rem;" />
                        Edit Profile
                    </a>
                </div>

                <div style="display:flex; align-items:center; gap:1rem;">
                    @if($user->photo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($user->photo) }}"
                             alt="{{ $user->full_name }}"
                             style="width:3.5rem;height:3.5rem;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid #fde68a;">
                    @else
                        <div class="ip-avatar-initials">
                            {{ strtoupper(substr($user->full_name, 0, 1)) }}
                        </div>
                    @endif
                    <div style="min-width:0;">
                        <p class="ip-user-name">{{ $user->full_name }}</p>
                        <p class="ip-user-email">{{ $user->email }}</p>
                        @if($user->phone)
                            <p style="font-size:0.75rem; color:#9ca3af; margin-top:0.125rem;">{{ $user->phone }}</p>
                        @endif
                    </div>
                </div>

                @php
                    $missing = collect([
                        'Photo'      => !$user->photo,
                        'WhatsApp'   => !$user->phone,
                        'Birth date' => !$user->birth_date,
                        'Address'    => !$user->address,
                    ])->filter()->keys();
                @endphp
                @if($missing->isNotEmpty())
                    <div class="ip-incomplete-box">
                        <p class="ip-incomplete-label">Incomplete fields</p>
                        <div style="display:flex; flex-wrap:wrap; gap:0.375rem;">
                            @foreach($missing as $field)
                                <span class="ip-missing-chip">{{ $field }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>{{-- end .ip-two-col --}}

        {{-- ── Admin Panel Link ─────────────────────────────────────────────── --}}
        @if($isAdmin)
            <a href="/admin" class="ip-admin-link">
                <div style="display:flex; align-items:center; gap:0.875rem;">
                    <div class="ip-admin-icon-wrap">
                        <x-heroicon-s-shield-check style="width:1.25rem;height:1.25rem;color:#fff;" />
                    </div>
                    <div>
                        <p class="ip-admin-title">Go to Admin Panel</p>
                        <p class="ip-admin-sub">Manage data & system settings</p>
                    </div>
                </div>
                <x-heroicon-s-arrow-top-right-on-square style="width:1rem;height:1rem;color:#b45309;flex-shrink:0;" />
            </a>
        @endif

        {{-- ── Footer logos ─────────────────────────────────────────────────── --}}
        <div class="ip-footer-logos">
            <img src="{{ asset('images/LOGO-PAROKI-YAKOBUS-BLACK.png') }}" alt="Paroki" class="logo-black" />
            <img src="{{ asset('images/LOGO-PAROKI-YAKOBUS-WHITE.png') }}" alt="Paroki" class="logo-white" />
        </div>

    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
