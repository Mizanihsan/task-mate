<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TaskMate') }} - @yield('title')</title>

    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background min-h-screen flex text-on-surface">
    <!-- Main Container -->
    <div class="flex w-full min-h-screen">
        <!-- Left Side: Branding (Hidden on small screens) -->
        <div class="hidden md:flex md:w-1/2 bg-primary-container flex-col justify-center items-center p-lg relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-white opacity-5 blur-3xl"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-white opacity-5 blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center max-w-[448px]">
                <div class="mb-lg p-md bg-white rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.1)]">
                    <img alt="TaskMate Logo" class="w-32 h-32 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBR9CWGKgAF6nuG8qgmyHlll3qR0VN_iHdg4O31IJI1KlKs0vuZmbAiUtSo9ZKzmOz4oB5nHxNKST6yRjUocaxf-fN1xCa14REfBgrGVJJMQD8EKcHmNxZhpgB6DXU08Dstq5sosa3DKoh8sSuub_39UOYLW6fbMbYHdFB1gKveHDsI-EqraQSEe1p6CUV1_7ovscvoo79teLKA1hbWq1VhXZJNYpYLfywCRmiwv8wBoqMkes6eSZf59kzGhu727wy5IAyj85aSmYY"/>
                </div>
                <h1 class="font-headline-lg text-headline-lg text-on-primary font-bold mb-md">TaskMate</h1>
                <p class="font-body-lg text-body-lg text-on-primary-container text-opacity-90 max-w-[384px]">
                    Kelola tugasmu. Raih prestasi. The ultimate companion for your academic journey.
                </p>
            </div>
        </div>

        <!-- Right Side: Content -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-sm md:p-lg">
            @yield('content')
        </div>
    </div>
</body>
</html>
