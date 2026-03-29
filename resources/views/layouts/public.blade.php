<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKS {{ date('Y') }} — Sanggar Kitab Suci</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireStyles
</head>
<body class="bg-gray-50 min-h-screen">

<!-- Header -->
<header class="bg-white shadow-sm">
    <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between">
        <img src="{{ asset('images/LOGO-SKS.png') }}" alt="Logo SKS" class="h-14 w-14 object-contain">
        <div class="text-center">
            <div class="font-bold text-gray-800 text-sm leading-tight">Sanggar Kitab Suci</div>
            <div class="text-xs text-gray-500">Gereja Katolik Santo Yakobus Surabaya</div>
        </div>
        <img src="{{ asset('images/LOGO-PAROKI-YAKOBUS-BLACK.png') }}" alt="Logo Paroki Santo Yakobus" class="h-14 w-14 object-contain">
    </div>
</header>

<!-- Content -->
<main class="max-w-2xl mx-auto px-4 py-8">
    {{ $slot }}
</main>

<footer class="text-center text-xs text-gray-400 py-6">
    © {{ date('Y') }} Sanggar Kitab Suci — Gereja Katolik Santo Yakobus Surabaya
</footer>

@livewireScripts
</body>
</html>