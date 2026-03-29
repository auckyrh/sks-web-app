<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKS {{ date('Y') }} — Sanggar Kitab Suci Santo Yakobus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background: #fdf8f0;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(245,158,11,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(217,119,6,0.06) 0%, transparent 50%),
                radial-gradient(circle at 60% 10%, rgba(251,191,36,0.05) 0%, transparent 40%);
            pointer-events: none;
            z-index: 0;
        }

        .page-wrap {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Header ── */
        .site-header {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #f0e8d8;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .header-inner {
            max-width: 680px;
            margin: 0 auto;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-logo { height: 48px; width: 48px; object-fit: contain; }
        .header-center { text-align: center; }
        .header-title {
            font-family: 'Lora', serif;
            font-size: 0.875rem;
            font-weight: 700;
            color: #1c1410;
            line-height: 1.2;
        }
        .header-sub {
            font-size: 0.6875rem;
            color: #9c7a48;
            margin-top: 0.125rem;
        }

        /* ── Main ── */
        main {
            flex: 1;
            max-width: 680px;
            width: 100%;
            margin: 0 auto;
            padding: 2.5rem 1.25rem 3rem;
        }

        /* ── Hero ── */
        .hero {
            text-align: center;
            margin-bottom: 1.75rem;
            animation: fade-up 0.5s ease both;
        }
        .hero-logo {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f0d080;
            box-shadow: 0 8px 32px rgba(217,119,6,0.18);
            margin: 0 auto 1.25rem;
            display: block;
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
        .hero-desc {
            font-size: 0.875rem;
            color: #7a6248;
            line-height: 1.7;
            max-width: 400px;
            margin: 0 auto;
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
        }
        .tier-card.active {
            background: #fff;
            border: 1.5px solid #6ee7b7;
            box-shadow: 0 2px 12px rgba(52,211,153,0.1);
        }
        .tier-card.upcoming {
            background: #fff;
            border: 1.5px solid #e8d090;
            box-shadow: 0 2px 12px rgba(217,176,60,0.08);
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

        /* ── Closed state ── */
        .closed-notice {
            background: #fff;
            border: 1.5px solid #f0e8d8;
            border-radius: 20px;
            padding: 1.375rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 3px 14px rgba(180,140,60,0.08);
            animation: fade-up 0.5s ease both;
        }
        .closed-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: #f5f5f5;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .closed-icon svg { width: 26px; height: 26px; color: #9ca3af; }

        /* ── Footer ── */
        footer {
            text-align: center;
            padding: 1.5rem 1.25rem 2rem;
            position: relative;
            z-index: 1;
        }
        .footer-admin-link {
            display: inline-block;
            font-size: 0.7rem;
            color: #d4c4a8;
            text-decoration: none;
            margin-bottom: 0.75rem;
            transition: color 0.2s;
            letter-spacing: 0.02em;
        }
        .footer-admin-link:hover { color: #a08060; }
        .footer-copy { font-size: 0.7rem; color: #c8b890; }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="page-wrap">

    {{-- Header --}}
    <header class="site-header">
        <div class="header-inner">
            <img src="{{ asset('images/LOGO-SKS.png') }}" alt="Logo SKS" class="header-logo">
            <div class="header-center">
                <div class="header-title">Sanggar Kitab Suci</div>
                <div class="header-sub">Gereja Katolik Santo Yakobus Surabaya</div>
            </div>
            <img src="{{ asset('images/LOGO-PAROKI-YAKOBUS-BLACK.png') }}" alt="Logo Paroki" class="header-logo">
        </div>
    </header>

    {{-- Main Content --}}
    <main>

        {{-- Hero --}}
        <div class="hero">
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

            <div class="hero-divider"></div>

{{--            <p class="hero-desc">--}}
{{--                COMMENTED. DO NOT DELETE.--}}
{{--                Program pembinaan iman anak melalui pengenalan Kitab Suci secara menyenangkan dan kreatif, untuk siswa Sekolah Dasar kelas 1 hingga 6.--}}
{{--            </p>--}}
        </div>

        {{-- Payment Tier Cards --}}
        @if($activePeriod && $activePeriod->is_active)
            <div class="tier-section">
                <div class="tier-section-label">Info Biaya Pendaftaran</div>
                <div class="tier-cards-wrap">

                    @if($activeTier)
                        <div class="tier-card active">
                            <div class="tier-card-header">
                                {{-- Heroicon: check-circle --}}
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
                                    {{-- Heroicon: pencil-square --}}
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
                                {{-- Heroicon: clock --}}
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

            @if($activePeriod && $activePeriod->is_active)
{{--                <button type="button" onclick="handleDaftarClick()" class="action-card primary" style="width:100%; cursor:pointer; border:none; text-align:left;">--}}
{{--                    <div class="action-icon">--}}
{{--                        --}}{{-- Heroicon: pencil-square --}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />--}}
{{--                        </svg>--}}
{{--                    </div>--}}
{{--                    <div class="action-body">--}}
{{--                        <div class="action-title">Klik Di Sini untuk Mendaftar</div>--}}
{{--                        <div class="action-desc">Isi formulir pendaftaran anak Anda untuk SKS {{ $activePeriod->year }}</div>--}}
{{--                    </div>--}}
{{--                    <span class="action-arrow">--}}
{{--                        --}}{{-- Heroicon: arrow-right --}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />--}}
{{--                        </svg>--}}
{{--                    </span>--}}
{{--                </button>--}}
            @else
                <div class="closed-notice">
                    <div class="closed-icon">
                        {{-- Heroicon: lock-closed --}}
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
                    {{-- Heroicon: magnifying-glass --}}
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

    </main>

    {{-- Footer --}}
    <footer>
        <div>
            <a href="/admin/login" class="footer-admin-link">Masuk sebagai Panitia</a>
        </div>
        <p class="footer-copy">© {{ date('Y') }} Sanggar Kitab Suci — Gereja Katolik Santo Yakobus Surabaya</p>
    </footer>

</div>

<script>
    const formUrl      = @json(route('registration.form'));
    const upcomingTier = @json($upcomingTierData);

    function handleDaftarClick() {
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
</body>
</html>
