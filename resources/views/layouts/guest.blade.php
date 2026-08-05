<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=noto-serif:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: #022448;
            --color-on-primary: #ffffff;
            --color-primary-container: #1e3a5f;
            --color-on-primary-container: #8aa4cf;
            --color-primary-fixed: #d5e3ff;
            --color-primary-fixed-dim: #adc8f5;
            --color-on-primary-fixed: #001c3b;
            --color-on-primary-fixed-variant: #2d486d;
            --color-primary-50: #eef4ff;
            --color-primary-100: #dae6ff;
            --color-primary-200: #bccdfe;
            --color-primary-300: #8eabfc;
            --color-primary-400: #5a83f5;
            --color-primary-500: #305ee0;
            --color-primary-600: #1a44c5;
            --color-primary-700: #0a2b8a;
            --color-primary-800: #022448;
            --color-primary-900: #001c3b;
            --color-primary-950: #000e1d;
            --color-secondary: #855300;
            --color-on-secondary: #ffffff;
            --color-secondary-container: #fea619;
            --color-on-secondary-container: #684000;
            --color-secondary-fixed: #ffddb8;
            --color-secondary-fixed-dim: #ffb95f;
            --color-on-secondary-fixed: #2a1700;
            --color-on-secondary-fixed-variant: #653e00;
            --color-accent-50: #fffbeb;
            --color-accent-100: #fef3c7;
            --color-accent-200: #fde68a;
            --color-accent-300: #fcd34d;
            --color-accent-400: #fbbf24;
            --color-accent-500: #fea619;
            --color-accent-600: #d97706;
            --color-accent-700: #b45309;
            --color-tertiary: #18233b;
            --color-on-tertiary: #ffffff;
            --color-tertiary-container: #2e3952;
            --color-on-tertiary-container: #98a3c0;
            --color-tertiary-fixed: #d8e2ff;
            --color-tertiary-fixed-dim: #bbc6e5;
            --color-background: #f7f9fb;
            --color-on-background: #191c1e;
            --color-surface: #f7f9fb;
            --color-on-surface: #191c1e;
            --color-surface-dim: #d8dadc;
            --color-surface-bright: #f7f9fb;
            --color-surface-container-lowest: #ffffff;
            --color-surface-container-low: #f2f4f6;
            --color-surface-container: #eceef0;
            --color-surface-container-high: #e6e8ea;
            --color-surface-container-highest: #e0e3e5;
            --color-surface-variant: #e0e3e5;
            --color-on-surface-variant: #43474e;
            --color-outline: #74777f;
            --color-outline-variant: #c4c6cf;
            --color-inverse-surface: #2d3133;
            --color-inverse-on-surface: #eff1f3;
            --color-inverse-primary: #adc8f5;
            --color-surface-tint: #455f87;
            --color-surface-subtle: #eff6ff;
            --color-status-success: #22c55e;
            --color-status-warning: #f59e0b;
            --color-status-danger: #ef4444;
            --color-status-info: #3b82f6;
        }
    </style>
</head>
<body class="font-sans antialiased text-on-background min-h-screen flex flex-col selection:bg-secondary-container selection:text-on-secondary-container">
    <x-demo-banner />

    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-[-5%] left-[-5%] w-80 h-80 bg-secondary-container/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    <main class="flex-grow flex items-center justify-center px-4 sm:px-6 py-12">
        <div class="w-full max-w-[480px] transition-all duration-300 ease-out">
            <div class="text-center mb-8">
                <a href="{{ route('landing') }}" class="font-headline-lg text-headline-lg font-black text-primary tracking-tighter mb-2 block">OtoRent</a>
                <p class="font-body-md text-body-md text-on-surface-variant">Solusi Sewa Kendaraan Premium Anda</p>
            </div>

            <div class="bg-surface-container-lowest rounded-xl shadow-md border border-outline-variant/30 p-8 md:p-10 backdrop-blur-sm bg-opacity-95">
                @yield('content')
            </div>

            {{-- Footer Links --}}
            <div class="mt-8 flex justify-center gap-6">
                <a class="font-caption-caps text-caption-caps text-on-surface-variant/60 hover:text-primary transition-colors" href="#">Bantuan</a>
                <a class="font-caption-caps text-caption-caps text-on-surface-variant/60 hover:text-primary transition-colors" href="#">Privasi</a>
                <a class="font-caption-caps text-caption-caps text-on-surface-variant/60 hover:text-primary transition-colors" href="#">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </main>

    <style>
        .bg-mesh {
            background-color: #f7f9fb;
            background-image: radial-gradient(at 0% 0%, #d5e3ff 0px, transparent 50%),
                              radial-gradient(at 50% 0%, #ffddb8 0px, transparent 50%),
                              radial-gradient(at 100% 0%, #adc8f5 0px, transparent 50%);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
</body>
</html>
