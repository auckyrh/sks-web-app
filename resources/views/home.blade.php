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

        /* ── Warm patterned background ── */
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
            margin-bottom: 2.5rem;
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

        /* ── Period info badge ── */
        .period-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #fffbf0, #fff3cc);
            border: 1.5px solid #f0d080;
            border-radius: 99px;
            padding: 0.35rem 1rem;
            font-size: 0.75rem;
            color: #92600a;
            font-weight: 500;
            margin-top: 1rem;
        }
        .period-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #22c55e;
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.75); }
        }

        /* ── Tier badges ── */
        .tier-badges {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 1rem;
            align-items: center;
        }
        .tier-badge-item {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            font-size: 0.775rem;
            line-height: 1.4;
            text-align: left;
            max-width: 340px;
            width: 100%;
        }
        .tier-badge-item.active {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 1.5px solid #6ee7b7;
            color: #065f46;
        }
        .tier-badge-item.upcoming {
            background: linear-gradient(135deg, #fffbf0, #fff3cc);
            border: 1.5px solid #f0d080;
            color: #92600a;
        }
        .tier-badge-icon { font-size: 1rem; flex-shrink: 0; }
        .tier-badge-label { font-weight: 600; }
        .tier-badge-dates { font-size: 0.7rem; opacity: 0.8; margin-top: 0.1rem; }

        /* ── Action Cards ── */
        .actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-card {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 1.375rem 1.5rem;
            border-radius: 20px;
            text-decoration: none;
            border: 1.5px solid transparent;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            animation: fade-up 0.5s ease both;
        }
        .action-card:hover {
            transform: translateY(-3px);
        }
        .action-card:active { transform: translateY(0); }

        .action-card.primary {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 6px 24px rgba(217,119,6,0.28);
        }
        .action-card.primary:hover {
            box-shadow: 0 10px 32px rgba(217,119,6,0.36);
        }

        .action-card.secondary {
            background: #fff;
            border-color: #f0e8d8;
            box-shadow: 0 3px 14px rgba(180,140,60,0.08);
            animation-delay: 0.08s;
        }
        .action-card.secondary:hover {
            border-color: #f59e0b;
            box-shadow: 0 6px 20px rgba(180,140,60,0.14);
        }

        .action-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .action-card.primary .action-icon {
            background: rgba(255,255,255,0.2);
        }
        .action-card.secondary .action-icon {
            background: linear-gradient(135deg, #fffbf0, #fff3cc);
            border: 1px solid #f0d080;
        }

        .action-body { flex: 1; }
        .action-title {
            font-family: 'Lora', serif;
            font-weight: 700;
            font-size: 1rem;
            line-height: 1.2;
        }
        .action-card.primary .action-title { color: #fff; }
        .action-card.secondary .action-title { color: #1c1410; }

        .action-desc {
            font-size: 0.775rem;
            margin-top: 0.25rem;
            line-height: 1.4;
        }
        .action-card.primary .action-desc { color: rgba(255,255,255,0.8); }
        .action-card.secondary .action-desc { color: #a08060; }

        .action-arrow {
            font-size: 1.1rem;
            flex-shrink: 0;
            transition: transform 0.2s;
        }
        .action-card.primary .action-arrow { color: rgba(255,255,255,0.7); }
        .action-card.secondary .action-arrow { color: #d4b070; }
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
            font-size: 1.5rem;
            flex-shrink: 0;
        }

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
        .footer-copy {
            font-size: 0.7rem;
            color: #c8b890;
        }

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
                <img src="{{ Storage::disk('public')->url($activePeriod->event_logo) }}"
                     alt="Logo SKS" class="hero-logo">
            @else
                <img src="{{ asset('images/LOGO-SKS.png') }}"
                     alt="Logo SKS" class="hero-logo">
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

            <p class="hero-desc">
                Program pembinaan iman anak melalui pengenalan Kitab Suci secara menyenangkan dan kreatif, untuk siswa Sekolah Dasar kelas 1 hingga 6.
            </p>

            @if($activePeriod && $activePeriod->is_active)
                <div class="tier-badges">
                    @if($activeTier)
                        <div class="tier-badge-item active">
                            <span class="tier-badge-icon">🟢</span>
                            <div>
                                <div class="tier-badge-label">Pendaftaran {{ $activeTier->name }} Sedang Dibuka</div>
                                <div class="tier-badge-dates">
                                    {{ $activeTier->valid_from->locale('id')->isoFormat('D MMM Y') }} – {{ $activeTier->valid_until->locale('id')->isoFormat('D MMM Y') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($upcomingTier)
                        <div class="tier-badge-item upcoming">
                            <span class="tier-badge-icon">🕐</span>
                            <div>
                                <div class="tier-badge-label">Pendaftaran {{ $upcomingTier->name }} Akan Dibuka</div>
                                <div class="tier-badge-dates">
                                    {{ $upcomingTier->valid_from->locale('id')->isoFormat('D MMM Y') }} – {{ $upcomingTier->valid_until->locale('id')->isoFormat('D MMM Y') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- Action Cards --}}
        <div class="actions">

            @if($activePeriod && $activePeriod->is_active)
                {{-- Registration open --}}
                <button type="button" onclick="handleDaftarClick()" class="action-card primary" style="width:100%; cursor:pointer; border:none; text-align:left;">
                    <div class="action-icon">📝</div>
                    <div class="action-body">
                        <div class="action-title">Daftar Sekarang</div>
                        <div class="action-desc">Isi formulir pendaftaran anak Anda untuk SKS {{ $activePeriod->year }}</div>
                    </div>
                    <span class="action-arrow">→</span>
                </button>
            @else
                {{-- Registration closed --}}
                <div class="closed-notice">
                    <div class="closed-icon">🔒</div>
                    <div>
                        <div style="font-family:'Lora',serif; font-weight:700; color:#5c4032; font-size:0.9375rem;">Pendaftaran Belum Dibuka</div>
                        <div style="font-size:0.775rem; color:#a08060; margin-top:0.25rem; line-height:1.4;">Silakan pantau informasi dari panitia SKS Santo Yakobus.</div>
                    </div>
                </div>
            @endif

            <a href="{{ route('registration.status') }}" class="action-card secondary">
                <div class="action-icon">🔍</div>
                <div class="action-body">
                    <div class="action-title">Cek Status Pendaftaran</div>
                    <div class="action-desc">Periksa status dan nomor pendaftaran anak Anda</div>
                </div>
                <span class="action-arrow">→</span>
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
    const formUrl     = @json(route('registration.form'));
    const upcomingTier = @json($upcomingTierData);

    function handleDaftarClick() {
        Swal.fire({
            title: 'Apakah Anda umat Paroki Santo Yakobus?',
            icon: 'question',
            showDenyButton: true,
            confirmButtonText: '✅ Ya, saya umat Paroki',
            denyButtonText: '❌ Tidak',
            confirmButtonColor: '#d97706',
            denyButtonColor: '#6b7280',
            reverseButtons: false,
            customClass: { popup: 'swal-font' },
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = formUrl;
            } else if (result.isDenied) {
                if (upcomingTier) {
                    Swal.fire({
                        title: 'Pendaftaran Umum Belum Dibuka',
                        html: `Pendaftaran untuk <strong>${upcomingTier.name}</strong> (umum) akan dibuka pada:<br><br>`
                            + `<strong style="color:#d97706; font-size:1rem;">${upcomingTier.valid_from} – ${upcomingTier.valid_until}</strong><br><br>`
                            + `Silakan pantau informasi dari panitia SKS Santo Yakobus.`,
                        icon: 'info',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#d97706',
                    });
                } else {
                    Swal.fire({
                        title: 'Pendaftaran Umum Sudah Dibuka',
                        html: `Silakan lanjutkan pendaftaran Anda.<br><br>`
                            + `Jika ada pertanyaan, hubungi panitia SKS Santo Yakobus.`,
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
