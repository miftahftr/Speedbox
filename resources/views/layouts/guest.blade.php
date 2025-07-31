<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            {{-- Kolom Kiri: Bagian Visual & Branding (Hilang di Mobile) --}}
            <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-orange-500 to-orange-600 items-center justify-center p-12 text-white relative overflow-hidden">
                <div class="relative z-10 text-center">
                    <a href="/" class="text-5xl font-extrabold tracking-tight">
                        SpeedBox
                    </a>
                    <p class="mt-4 text-lg text-orange-100 max-w-sm">
                        Selamat datang kembali! Mari lanjutkan pengiriman barang dan pindahan Anda tanpa ribet.
                    </p>
                </div>
                 {{-- Elemen Desain Latar --}}
                <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full -translate-x-1/4 -translate-y-1/4"></div>
                <div class="absolute bottom-0 right-0 w-80 h-80 bg-white/10 rounded-full translate-x-1/4 translate-y-1/4"></div>
            </div>

            {{-- Kolom Kanan: Form --}}
            <div class="w-full lg:w-1/2 bg-slate-50 flex items-center justify-center p-6 sm:p-12">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>