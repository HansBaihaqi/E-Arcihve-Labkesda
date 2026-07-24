<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'E-Archive Labkesda') }} - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- PWA Support -->
    <meta name="theme-color" content="#4f46e5">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icon-192.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 bg-sidebar items-center justify-center p-12">
            <div class="max-w-md text-white">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500 mb-6">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold mb-3">E-Archive Labkesda</h1>
                <p class="text-gray-400 text-lg leading-relaxed">Sistem Pengarsipan Dokumen Laboratorium Kesehatan Daerah. Kelola arsip dokumen dengan aman dan terorganisir.</p>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <div class="lg:hidden mb-8 text-center">
                    <h1 class="text-2xl font-bold text-gray-900">E-Archive Labkesda</h1>
                    <p class="text-sm text-gray-500 mt-1">Sistem Pengarsipan Dokumen</p>
                </div>

                <div class="card p-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-1">Masuk ke akun Anda</h2>
                    <p class="text-sm text-gray-500 mb-6">Silakan masukkan kredensial untuk melanjutkan.</p>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" x-data="{ loading: false }" @submit="loading = true" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-input @error('email') border-red-500 @enderror" value="{{ old('email') }}" required autofocus autocomplete="username">
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-input @error('password') border-red-500 @enderror" required autocomplete="current-password">
                            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lupa password?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn-primary w-full justify-center" :disabled="loading">
                            <svg x-show="loading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
