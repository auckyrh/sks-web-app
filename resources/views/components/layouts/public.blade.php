@props(['title' => 'SKS ' . date('Y') . ' — Sanggar Kitab Suci'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="/favicon-96x96.png?v=20260331" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg?v=20260331" />
    <link rel="shortcut icon" href="/favicon.ico?v=20260331" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=20260331" />
    <meta name="apple-mobile-web-app-title" content="Sanggar Kitab Suci Santo Yakobus" />
    <link rel="manifest" href="/site.webmanifest?v=20260331" />
    @livewireStyles
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
    </style>
    {{ $styles ?? '' }}
</head>
<body>
<div class="page-wrap">

    {{-- Header --}}
    <header class="site-header">
        <div class="header-inner">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/LOGO-SKS.png') }}" alt="Logo SKS" class="header-logo">
            </a>
            <a href="{{ route('home') }}" class="header-center" style="text-decoration:none;">
                <div class="header-title">Sanggar Kitab Suci</div>
                <div class="header-sub">Gereja Katolik Santo Yakobus Surabaya</div>
            </a>
            <a href="https://santoyakobus.org/" target="_blank" rel="noopener noreferrer">
                <img src="{{ asset('images/LOGO-PAROKI-YAKOBUS-BLACK.png') }}" alt="Logo Paroki" class="header-logo">
            </a>
        </div>
    </header>

    {{-- Main Content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer>
        <div>
            <a href="/login" class="footer-admin-link">Masuk sebagai Panitia</a>
        </div>
        <p class="footer-copy">© {{ date('Y') }} Sanggar Kitab Suci — Gereja Katolik Santo Yakobus Surabaya</p>
    </footer>

</div>
@livewireScripts
{{ $scripts ?? '' }}
</body>
</html>
