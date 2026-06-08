<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#233a87">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>{{ config('app.name', 'TaskMate') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .icon-fill { font-variation-settings: 'FILL' 1; }
    </style>
</head>
<body class="flex min-h-screen text-on-surface bg-canvas">
    
    <x-sidebar />

    <!-- Main Content Canvas -->
    {{-- pb-[88px] = bottom-nav height (64px) + env safe-area + breathing room on mobile --}}
    <main class="md:ml-[240px] flex-1 min-h-screen p-margin-mobile md:p-margin-desktop bg-canvas pb-[88px] md:pb-margin-desktop">
        {{-- Flash Messages --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="fixed top-4 right-4 left-4 sm:left-auto sm:w-96 z-[60] bg-success/90 text-white px-4 py-3 rounded-xl shadow-level-2 backdrop-blur-md flex items-center gap-3 border border-success/30">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <span class="font-body-md text-body-md font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-white/80 hover:text-white bg-transparent border-0 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
        @endif

        @yield('content')
    </main>

    <x-bottom-nav />

</body>
</html>
