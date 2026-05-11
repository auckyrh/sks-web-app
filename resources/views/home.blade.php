<x-layouts.public title="SKS {{ date('Y') }} — Sanggar Kitab Suci Santo Yakobus">

    <x-slot:styles>
        <style>
            /* ── Hero ── */
            .hero {
                position: relative;
                text-align: center;
                margin-bottom: 1.75rem;
                animation: fade-up 0.5s ease both;
                overflow: hidden;
            }
            .hero-bg-year {
                position: absolute;
                top: -1rem;
                right: -0.75rem;
                font-family: 'Lora', serif;
                font-size: clamp(7rem, 28vw, 10rem);
                font-weight: 700;
                color: rgba(245,158,11,0.065);
                line-height: 1;
                letter-spacing: -0.04em;
                pointer-events: none;
                user-select: none;
            }
            .hero-logo {
                width: 150px;
                height: 150px;
                border-radius: 16px;
                object-fit: contain;
                margin: 0 auto;
                display: block;
                filter: drop-shadow(0 8px 20px rgba(217,119,6,0.20));
                transition: transform 0.3s ease, filter 0.3s ease;
            }
            .hero-logo:hover {
                transform: scale(1.04);
                filter: drop-shadow(0 12px 28px rgba(217,119,6,0.30));
            }
            .hero-eyebrow {
                font-size: 0.7rem;
                font-weight: 600;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: #c4902a;
                margin-bottom: 0.5rem;
            }
            .hero-title {
                font-family: 'Lora', serif;
                font-size: clamp(1.6rem, 5vw, 2.2rem);
                font-weight: 700;
                color: #1c1410;
                line-height: 1.2;
                margin-bottom: 0.5rem;
            }
            .hero-year {
                font-family: 'Lora', serif;
                font-size: clamp(1.6rem, 5vw, 2.2rem);
                font-weight: 700;
                font-style: italic;
                color: #d97706;
            }
            .hero-theme {
                font-size: 0.9rem;
                color: #9c7a48;
                margin-top: 0.5rem;
                font-style: italic;
                line-height: 1.5;
            }
            .hero-divider {
                width: 48px;
                height: 2px;
                background: linear-gradient(90deg, #f59e0b, #fbbf24);
                border-radius: 2px;
                margin: 1rem auto;
            }

            /* ── Event Date Badge ── */
            .hero-event-date {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                background: #fffbeb;
                border: 1.5px solid #fde68a;
                border-radius: 999px;
                padding: 0.35rem 0.9rem;
                font-size: 0.78rem;
                font-weight: 600;
                color: #92400e;
                margin-top: 0.75rem;
                letter-spacing: 0.02em;
            }
            .hero-event-date svg {
                width: 13px; height: 13px;
                color: #d97706;
                flex-shrink: 0;
            }

            /* ── Status Badge ── */
            .hero-status-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.375rem;
                border-radius: 999px;
                padding: 0.3rem 0.8rem;
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                margin-bottom: 0.9rem;
            }
            .hero-status-badge.active {
                background: #ecfdf5;
                border: 1.5px solid #6ee7b7;
                color: #059669;
            }
            .hero-status-badge.closed {
                background: #fef2f2;
                border: 1.5px solid #fca5a5;
                color: #dc2626;
            }
            .hero-status-badge .dot {
                width: 6px; height: 6px;
                border-radius: 50%;
                flex-shrink: 0;
            }
            .hero-status-badge.active .dot {
                background: #059669;
                animation: pulse-dot 1.8s ease infinite;
            }
            .hero-status-badge.closed .dot {
                background: #dc2626;
            }
            @keyframes pulse-dot {
                0%, 100% { opacity: 1; transform: scale(1); }
                50%       { opacity: 0.5; transform: scale(0.75); }
            }

            /* ── Tier Section ── */
            .tier-section {
                margin-bottom: 1.75rem;
                animation: fade-up 0.5s ease 0.1s both;
            }

            .tier-section-label {
                font-size: 0.675rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: #c4902a;
                text-align: center;
                margin-bottom: 0.75rem;
            }

            .tier-cards-wrap {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .tier-card {
                border-radius: 16px;
                overflow: hidden;
                transition: transform 0.18s, box-shadow 0.18s;
            }
            .tier-card:hover { transform: translateY(-2px); }
            .tier-card.active {
                background: #fff;
                border: 1.5px solid #6ee7b7;
                box-shadow: 0 2px 12px rgba(52,211,153,0.1);
            }
            .tier-card.active:hover {
                box-shadow: 0 6px 20px rgba(52,211,153,0.18);
            }
            .tier-card.upcoming {
                background: #fff;
                border: 1.5px solid #e8d090;
                box-shadow: 0 2px 12px rgba(217,176,60,0.08);
            }
            .tier-card.upcoming:hover {
                box-shadow: 0 6px 20px rgba(217,176,60,0.16);
            }

            .tier-card-header {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.6rem 1.1rem;
            }
            .tier-card.active .tier-card-header { background: #ecfdf5; }
            .tier-card.upcoming .tier-card-header { background: #fffbeb; }

            .tier-card-header svg {
                width: 15px;
                height: 15px;
                flex-shrink: 0;
            }
            .tier-card.active .tier-card-header svg { color: #059669; }
            .tier-card.upcoming .tier-card-header svg { color: #b45309; }

            .tier-card-status {
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }
            .tier-card.active .tier-card-status { color: #059669; }
            .tier-card.upcoming .tier-card-status { color: #b45309; }

            .tier-card-body {
                padding: 0.875rem 1.1rem 1rem;
            }

            .tier-card-name {
                font-family: 'Lora', serif;
                font-size: 1rem;
                font-weight: 700;
                line-height: 1.2;
                margin-bottom: 0.35rem;
            }
            .tier-card.active .tier-card-name { color: #064e3b; }
            .tier-card.upcoming .tier-card-name { color: #78350f; }

            .tier-card-dates {
                font-size: 0.78rem;
                font-weight: 500;
                color: #6b7280;
                margin-bottom: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
            }

            .tier-card-price-row {
                display: flex;
                align-items: baseline;
                gap: 0.4rem;
            }
            .tier-card-price-label {
                font-size: 0.72rem;
                font-weight: 500;
                color: #9ca3af;
                text-transform: uppercase;
                letter-spacing: 0.06em;
            }
            .tier-card-amount {
                font-family: 'Lora', serif;
                font-size: 1.35rem;
                font-weight: 700;
            }
            .tier-card.active .tier-card-amount { color: #059669; }
            .tier-card.upcoming .tier-card-amount { color: #b45309; }

            .tier-card-daftar-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                margin-top: 0.875rem;
                padding: 0.5rem 1.1rem;
                background: #059669;
                color: #fff;
                font-family: 'DM Sans', sans-serif;
                font-size: 0.82rem;
                font-weight: 700;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                box-shadow: 0 3px 0 #047857, 0 4px 12px rgba(5,150,105,0.25);
                transition: transform 0.15s, box-shadow 0.15s;
            }
            .tier-card-daftar-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 0 #047857, 0 6px 16px rgba(5,150,105,0.3);
            }
            .tier-card-daftar-btn:active {
                transform: translateY(1px);
                box-shadow: 0 1px 0 #047857, 0 2px 6px rgba(5,150,105,0.2);
            }
            .tier-card-daftar-btn svg { width: 14px; height: 14px; }

            /* ── Action Buttons ── */
            .actions {
                display: flex;
                flex-direction: column;
                gap: 0.875rem;
                margin-bottom: 2rem;
            }

            .action-card {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem 1.25rem;
                border-radius: 14px;
                text-decoration: none;
                cursor: pointer;
                transition: transform 0.15s, box-shadow 0.15s, filter 0.15s;
                animation: fade-up 0.5s ease both;
            }
            .action-card:hover { transform: translateY(-2px); }
            .action-card:active { transform: translateY(1px); }

            .action-card.primary {
                background: #d97706;
                box-shadow: 0 4px 0 #b45309, 0 6px 20px rgba(180,90,0,0.30);
                border: none;
            }
            .action-card.primary:hover {
                background: #e08010;
                box-shadow: 0 6px 0 #b45309, 0 10px 28px rgba(180,90,0,0.35);
            }
            .action-card.primary:active {
                box-shadow: 0 1px 0 #b45309, 0 2px 8px rgba(180,90,0,0.25);
            }
            .action-card.secondary {
                background: #fff;
                border: 2px solid #d97706;
                box-shadow: 0 3px 0 #d4b070, 0 5px 16px rgba(180,140,60,0.12);
                animation-delay: 0.08s;
            }
            .action-card.secondary:hover {
                background: #fffbf0;
                box-shadow: 0 5px 0 #d4b070, 0 8px 20px rgba(180,140,60,0.18);
            }
            .action-card.secondary:active {
                box-shadow: 0 1px 0 #d4b070, 0 2px 6px rgba(180,140,60,0.1);
            }

            .action-icon {
                width: 44px; height: 44px;
                border-radius: 10px;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            }
            .action-icon svg { width: 24px; height: 24px; }
            .action-card.primary .action-icon { background: rgba(0,0,0,0.12); }
            .action-card.primary .action-icon svg { color: #fff; }
            .action-card.secondary .action-icon {
                background: #fff8e8;
                border: 1.5px solid #f0d080;
            }
            .action-card.secondary .action-icon svg { color: #d97706; }

            .action-body { flex: 1; }
            .action-title {
                font-family: 'DM Sans', sans-serif;
                font-weight: 700;
                font-size: 1rem;
                line-height: 1.2;
                letter-spacing: -0.01em;
            }
            .action-card.primary .action-title { color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.15); }
            .action-card.secondary .action-title { color: #92400e; }

            .action-desc {
                font-size: 0.76rem;
                margin-top: 0.2rem;
                line-height: 1.4;
            }
            .action-card.primary .action-desc { color: rgba(255,255,255,0.85); }
            .action-card.secondary .action-desc { color: #b45309; opacity: 0.75; }

            .action-arrow {
                flex-shrink: 0;
                transition: transform 0.15s;
            }
            .action-arrow svg { width: 20px; height: 20px; }
            .action-card.primary .action-arrow svg { color: rgba(255,255,255,0.9); }
            .action-card.secondary .action-arrow svg { color: #d97706; }
            .action-card:hover .action-arrow { transform: translateX(4px); }

            /* ── Closed / Notice states ── */
            .closed-notice {
                background: #fff;
                border: 1.5px solid #fecaca;
                border-radius: 20px;
                padding: 1.375rem 1.5rem;
                display: flex;
                align-items: center;
                gap: 1rem;
                box-shadow: 0 3px 14px rgba(220,38,38,0.06);
                animation: fade-up 0.5s ease both;
            }
            .closed-notice.not-open {
                border-color: #f0e8d8;
                box-shadow: 0 3px 14px rgba(180,140,60,0.08);
            }
            .closed-icon {
                width: 52px; height: 52px;
                border-radius: 14px;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            }
            .closed-icon.red { background: #fef2f2; }
            .closed-icon.red svg { width: 26px; height: 26px; color: #ef4444; }
            .closed-icon.gray { background: #f5f5f5; }
            .closed-icon.gray svg { width: 26px; height: 26px; color: #9ca3af; }

            @keyframes fade-up {
                from { opacity: 0; transform: translateY(18px); }
                to   { opacity: 1; transform: translateY(0); }
            }
        </style>
    </x-slot:styles>

    {{-- Hero --}}
    <div class="hero">
        @if($activePeriod)
            <div class="hero-bg-year" aria-hidden="true">{{ $activePeriod->year }}</div>
        @endif
        @if($activePeriod?->event_logo)
            <img src="{{ Storage::disk('public')->url($activePeriod->event_logo) }}" alt="Logo SKS" class="hero-logo">
        @else
            <img src="{{ asset('images/LOGO-SKS.png') }}" alt="Logo SKS" class="hero-logo">
        @endif

        <p class="hero-eyebrow">Gereja Katolik Santo Yakobus Surabaya</p>

        <h1 class="hero-title">
            Sanggar Kitab Suci
            @if($activePeriod)
                <span class="hero-year">{{ $activePeriod->year }}</span>
            @endif
        </h1>

        @if($activePeriod?->theme)
            <p class="hero-theme">"{{ $activePeriod->theme }}"</p>
        @endif

        {{-- Status badge --}}
        @if($activePeriod && $activePeriod->is_active)
            @if($activeTier)
                <div style="margin-top:0.75rem;">
                    <span class="hero-status-badge active">
                        <span class="dot"></span>
                        Pendaftaran Sedang Dibuka
                    </span>
                </div>
            @else
                <div style="margin-top:0.75rem;">
                    <span class="hero-status-badge closed">
                        <span class="dot"></span>
                        Pendaftaran Ditutup
                    </span>
                </div>
            @endif
        @endif

        {{-- Event dates --}}
        @if($activePeriod && ($activePeriod->event_start_date || $activePeriod->event_end_date))
            <div style="margin-top:0.5rem;">
                <span class="hero-event-date">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    @if($activePeriod->event_start_date && $activePeriod->event_end_date)
                        {{ $activePeriod->event_start_date->locale('id')->isoFormat('D MMM') }} &ndash; {{ $activePeriod->event_end_date->locale('id')->isoFormat('D MMM Y') }}
                    @elseif($activePeriod->event_start_date)
                        Mulai {{ $activePeriod->event_start_date->locale('id')->isoFormat('D MMM Y') }}
                    @endif
                </span>
            </div>
        @endif

        <div class="hero-divider"></div>
    </div>

    {{-- Payment Tier Cards — only when there are tiers to show --}}
    @if($activePeriod && $activePeriod->is_active && ($activeTier || $upcomingTier))
        <div class="tier-section">
            <div class="tier-section-label">Biaya Pendaftaran</div>
            <div class="tier-cards-wrap">

                @if($activeTier)
                    <div class="tier-card active">
                        <div class="tier-card-header">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span class="tier-card-status">Sedang Dibuka</span>
                        </div>
                        <div class="tier-card-body">
                            <div class="tier-card-name">Pendaftaran {{ $activeTier->name }}</div>
                            <div class="tier-card-dates">
                                {{ $activeTier->valid_from->locale('id')->isoFormat('D MMM Y') }} &ndash; {{ $activeTier->valid_until->locale('id')->isoFormat('D MMM Y') }}
                            </div>
                            <div class="tier-card-price-row">
                                <span class="tier-card-price-label">Biaya</span>
                                <span class="tier-card-amount">Rp {{ number_format($activeTier->amount, 0, ',', '.') }}</span>
                            </div>
                            <button type="button" onclick="handleDaftarClick()" class="tier-card-daftar-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Daftar Sekarang
                            </button>
                        </div>
                    </div>
                @endif

                @if($upcomingTier)
                    <div class="tier-card upcoming">
                        <div class="tier-card-header">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span class="tier-card-status">Akan Dibuka</span>
                        </div>
                        <div class="tier-card-body">
                            <div class="tier-card-name">Pendaftaran {{ $upcomingTier->name }}</div>
                            <div class="tier-card-dates">
                                {{ $upcomingTier->valid_from->locale('id')->isoFormat('D MMM Y') }} &ndash; {{ $upcomingTier->valid_until->locale('id')->isoFormat('D MMM Y') }}
                            </div>
                            <div class="tier-card-price-row">
                                <span class="tier-card-price-label">Biaya</span>
                                <span class="tier-card-amount">Rp {{ number_format($upcomingTier->amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    @endif

    {{-- Action Cards --}}
    <div class="actions">

        @if($activePeriod && $activePeriod->is_active && !$activeTier && !$upcomingTier)
            {{-- Period active but all registration tiers have passed --}}
            <div class="closed-notice">
                <div class="closed-icon red">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <div>
                    <div style="font-family:'Lora',serif; font-weight:700; color:#991b1b; font-size:0.9375rem;">Pendaftaran Sudah Ditutup</div>
                    <div style="font-size:0.775rem; color:#b91c1c; opacity:0.75; margin-top:0.25rem; line-height:1.4;">Masa pendaftaran untuk SKS {{ $activePeriod->year }} telah berakhir.</div>
                </div>
            </div>
        @elseif(!$activePeriod || !$activePeriod->is_active)
            {{-- No active period at all --}}
            <div class="closed-notice not-open">
                <div class="closed-icon gray">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <div>
                    <div style="font-family:'Lora',serif; font-weight:700; color:#5c4032; font-size:0.9375rem;">Pendaftaran Belum Dibuka</div>
                    <div style="font-size:0.775rem; color:#a08060; margin-top:0.25rem; line-height:1.4;">Silakan pantau informasi dari panitia SKS Santo Yakobus.</div>
                </div>
            </div>
        @endif

        <a href="{{ route('registration.status') }}" class="action-card secondary">
            <div class="action-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <div class="action-body">
                <div class="action-title">Cek Status Pendaftaran</div>
                <div class="action-desc">Periksa status dan nomor pendaftaran anak Anda</div>
            </div>
            <span class="action-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </span>
        </a>

    </div>

    <x-slot:scripts>
        <script>
            const formUrl         = @json(route('registration.form'));
            const upcomingTier    = @json($upcomingTierData);
            const skipParokiCheck = @json($skipParokiCheck);
            const registrationClosed = @json($registrationClosed);

            // Show SWAL if redirected here because registration is closed
            if (registrationClosed) {
                Swal.fire({
                    title: 'Pendaftaran Sudah Ditutup',
                    text: 'Maaf, masa pendaftaran sudah ditutup.',
                    icon: 'warning',
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#d97706',
                });
            }

            function handleDaftarClick() {
                if (skipParokiCheck) {
                    window.location.href = formUrl;
                    return;
                }

                Swal.fire({
                    title: 'Apakah Anda umat Paroki Santo Yakobus?',
                    icon: 'question',
                    showDenyButton: true,
                    confirmButtonText: 'Ya, saya umat Paroki',
                    denyButtonText: 'Tidak',
                    confirmButtonColor: '#d97706',
                    denyButtonColor: '#6b7280',
                    reverseButtons: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = formUrl;
                    } else if (result.isDenied) {
                        if (upcomingTier) {
                            Swal.fire({
                                title: 'Pendaftaran Umum Belum Dibuka',
                                html: `Pendaftaran <strong>${upcomingTier.name}</strong> untuk umum akan dibuka pada:<br><br>`
                                    + `<strong style="color:#d97706; font-size:1.05rem;">${upcomingTier.valid_from} &ndash; ${upcomingTier.valid_until}</strong><br><br>`
                                    + `Silakan pantau informasi dari panitia SKS Santo Yakobus.`,
                                icon: 'info',
                                confirmButtonText: 'Mengerti',
                                confirmButtonColor: '#d97706',
                            });
                        } else {
                            Swal.fire({
                                title: 'Pendaftaran Umum Sudah Dibuka',
                                html: `Silakan lanjutkan pendaftaran Anda.<br><br>Jika ada pertanyaan, hubungi panitia SKS Santo Yakobus.`,
                                icon: 'info',
                                confirmButtonText: 'Lanjut Daftar',
                                confirmButtonColor: '#d97706',
                            }).then((r) => {
                                if (r.isConfirmed) window.location.href = formUrl;
                            });
                        }
                    }
                });
            }
        </script>
    </x-slot:scripts>

</x-layouts.public>
