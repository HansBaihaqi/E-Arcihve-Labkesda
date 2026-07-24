<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'E-Archive Labkesda') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- PWA Support -->
    <meta name="theme-color" content="#4f46e5">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icon-192.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        @include('layouts.partials.sidebar')

        <div class="flex-1 flex flex-col min-w-0 lg:ml-64">
            @include('layouts.partials.navbar')

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @isset($breadcrumb)
                    @include('layouts.partials.breadcrumb', ['items' => $breadcrumb])
                @endisset

                {{ $slot }}
            </main>
        </div>
    </div>

    @include('components.toast')

    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-black/50 lg:hidden" @click="sidebarOpen = false"></div>
</body>
</html>
