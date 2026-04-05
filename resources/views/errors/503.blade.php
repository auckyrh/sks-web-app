<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Dalam Pemeliharaan — SKS Santo Yakobus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #fffbf5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            overflow: hidden;
        }

        /* Soft background blobs */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            pointer-events: none;
            z-index: 0;
        }
        .blob-1 { width: 500px; height: 500px; background: #fde68a; top: -150px; right: -150px; }
        .blob-2 { width: 350px; height: 350px; background: #fcd34d; bottom: -100px; left: -100px; }
        .blob-3 { width: 200px; height: 200px; background: #f59e0b; top: 40%; left: 10%; animation: float 8s ease-in-out infinite; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .card {
            position: relative;
            z-index: 1;
            background: #fff;
            border-radius: 24px;
            border: 1px solid #f5e6c8;
            box-shadow: 0 8px 40px rgba(180, 130, 30, 0.10), 0 2px 8px rgba(0,0,0,0.05);
            padding: 3rem 2.5rem;
            max-width: 480px;
            width: 100%;
            text-align: center;
        }

        @media (max-width: 480px) {
            .card { padding: 2rem 1.5rem; }
        }

        /* Logo */
        .logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .logo-img {
            height: 72px;
            width: 72px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 0 4px #fef3c7, 0 0 0 8px #fde68a80;
        }
        .logo-fallback {
            height: 72px;
            width: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 4px #fef3c7, 0 0 0 8px #fde68a80;
        }
        .logo-fallback svg { width: 36px; height: 36px; color: #fff; fill: none; stroke: currentColor; stroke-width: 1.5; }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #fef3c7;
            color: #92400e;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            border: 1px solid #fde68a;
            margin-bottom: 1.25rem;
        }
        .badge-dot {
            width: 6px; height: 6px;
            background: #f59e0b;
            border-radius: 50%;
            animation: pulse-dot 1.5s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.7); }
        }

        /* Heading */
        h1 {
            font-family: 'Lora', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #1c1917;
            line-height: 1.25;
            margin-bottom: 0.75rem;
        }
        @media (max-width: 480px) { h1 { font-size: 1.4rem; } }

        .subtitle {
            font-size: 0.95rem;
            color: #57534e;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* Progress bar */
        .progress-wrap {
            background: #fef3c7;
            border-radius: 999px;
            height: 6px;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #f59e0b, #fbbf24, #f59e0b);
            background-size: 200% 100%;
            border-radius: 999px;
            width: 70%;
            animation: shimmer 2s linear infinite;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ETA row */
        .eta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #78716c;
            margin-bottom: 2rem;
        }
        .eta svg { width: 14px; height: 14px; flex-shrink: 0; stroke: #d97706; fill: none; stroke-width: 1.8; }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #f5ede0;
            margin-bottom: 1.5rem;
        }

        /* Contact */
        .contact {
            font-size: 0.8rem;
            color: #a8a29e;
        }
        .contact a {
            color: #d97706;
            text-decoration: none;
            font-weight: 600;
        }
        .contact a:hover { text-decoration: underline; }

        /* Branding footer */
        .branding {
            margin-top: 1.75rem;
            font-size: 0.7rem;
            color: #c4b5a0;
            letter-spacing: 0.03em;
        }
    </style>
</head>
<body>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="card">

        {{-- Logo --}}
        <div class="logo-wrap">
            @php
                $activePeriod = \App\Models\EventPeriod::where('is_active', true)->first();
            @endphp
            @if ($activePeriod?->event_logo)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($activePeriod->event_logo) }}"
                     alt="SKS Logo" class="logo-img">
            @else
                <div class="logo-fallback">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
                </div>
            @endif
        </div>

        {{-- Status badge --}}
        <div class="badge">
            <span class="badge-dot"></span>
            Pemeliharaan Sistem
        </div>

        {{-- Heading --}}
        <h1>Sebentar ya,<br>kami sedang berbenah!</h1>

        {{-- Message from ENV --}}
        <p class="subtitle">
            {{ env('MAINTENANCE_MESSAGE', 'Sistem sedang dalam pemeliharaan untuk meningkatkan pengalaman Anda. Mohon kembali dalam beberapa saat.') }}
        </p>

        {{-- Progress bar --}}
        <div class="progress-wrap">
            <div class="progress-bar"></div>
        </div>

        {{-- ETA --}}
        @if(env('MAINTENANCE_ETA'))
        <p class="eta">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/></svg>
            Estimasi selesai: {{ env('MAINTENANCE_ETA') }}
        </p>
        @endif

        <hr class="divider">

        {{-- Contact --}}
        <p class="contact">
            Butuh bantuan mendesak? Hubungi
            <a href="https://wa.me/{{ preg_replace('/\D/', '', env('MAINTENANCE_CONTACT', '6281234567890')) }}">
                {{ env('MAINTENANCE_CONTACT', 'panitia via WhatsApp') }}
            </a>
        </p>

        <p class="branding">SKS Santo Yakobus &copy; {{ date('Y') }}</p>

    </div>

</body>
</html>
