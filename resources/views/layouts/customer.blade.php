<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | OtoRent</title>
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
        .glass-panel {
            background: rgba(247, 249, 251, 0.6);
            backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

    </style>
</head>
<body class="font-sans antialiased text-on-background bg-background min-h-screen">
    {{-- Sidebar (lg+) --}}
    <aside class="fixed left-0 top-0 h-full w-64 hidden lg:flex flex-col glass-panel shadow-lg p-6 space-y-4 z-40 border-r border-outline-variant/20">
        <div class="mb-6">
            <a href="{{ route('customer.dashboard') }}" class="text-headline-md font-extrabold text-primary tracking-tighter">OtoRent</a>
            <p class="text-label-md text-on-surface-variant opacity-70">Premium Mobility</p>
        </div>
        <nav class="flex-grow space-y-1">
            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('customer.dashboard') ? 'bg-secondary-container text-on-secondary-container rounded-lg font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high hover:translate-x-1 rounded-lg' }} transition-all">
                <span class="material-symbols-outlined {{ request()->routeIs('customer.dashboard') ? '' : '' }}" style="{{ request()->routeIs('customer.dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
                <span class="text-label-md">Dashboard</span>
            </a>
            <a href="{{ route('booking.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('booking.*') && !request()->routeIs('booking.create') ? 'bg-secondary-container text-on-secondary-container rounded-lg font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high hover:translate-x-1 rounded-lg' }} transition-all">
                <span class="material-symbols-outlined {{ request()->routeIs('booking.*') ? 'filled' : '' }}">calendar_today</span>
                <span class="text-label-md">Reservasi</span>
            </a>
            <a href="{{ route('booking.create') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('booking.create') ? 'bg-secondary-container text-on-secondary-container rounded-lg font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high hover:translate-x-1 rounded-lg' }} transition-all">
                <span class="material-symbols-outlined">directions_car</span>
                <span class="text-label-md">Sewa Baru</span>
            </a>
            <a href="{{ route('profil.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('profil.*') ? 'bg-secondary-container text-on-secondary-container rounded-lg font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high hover:translate-x-1 rounded-lg' }} transition-all">
                <span class="material-symbols-outlined">settings</span>
                <span class="text-label-md">Pengaturan</span>
            </a>
        </nav>
        <div class="pt-6 border-t border-outline-variant/30 flex flex-col gap-2">
            <a href="#" class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined">help</span>
                <span class="text-label-md">Bantuan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-2 text-status-danger hover:opacity-80 transition-opacity w-full">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-label-md">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile Top Bar --}}
    <nav x-data="{ mobileOpen: false }" class="lg:hidden bg-surface-container-lowest/80 backdrop-blur-lg border-b border-outline-variant/10 sticky top-0 z-50">
        <div class="flex justify-between h-16 items-center px-4">
            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-1">
                <span class="text-xl font-bold text-primary">Oto</span><span class="text-xl font-bold text-secondary-container">Rent</span>
            </a>
            <div class="flex items-center gap-3">

                <button @click="mobileOpen = ! mobileOpen" class="p-2 rounded-md text-on-surface-variant hover:bg-surface-container">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileOpen, 'inline-flex': ! mobileOpen}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! mobileOpen, 'inline-flex': mobileOpen}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div :class="{'block': mobileOpen, 'hidden': ! mobileOpen}" class="hidden border-t border-outline-variant/20">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('customer.dashboard') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-surface hover:bg-surface-container' }}">Dashboard</a>
                <a href="{{ route('booking.index') }}" class="block px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('booking.*') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-surface hover:bg-surface-container' }}">Booking</a>
                <a href="{{ route('booking.create') }}" class="block px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('booking.create') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-surface hover:bg-surface-container' }}">Sewa Baru</a>
                <a href="{{ route('profil.edit') }}" class="block px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('profil.*') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-surface hover:bg-surface-container' }}">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-sm font-medium rounded-lg text-on-surface hover:bg-surface-container">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 lg:ml-64">
            <div class="bg-status-success/10 border border-status-success/20 text-status-success px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 lg:ml-64">
            <div class="bg-status-danger/10 border border-status-danger/20 text-status-danger px-4 py-3 rounded-lg text-sm">{{ session('error') }}</div>
        </div>
    @endif

    {{-- Main Content Area --}}
    <main class="lg:ml-64 min-h-screen flex flex-col lg:flex-row">
        <div class="flex-grow p-4 lg:p-8 max-w-5xl">
            @yield('content')
        </div>
        @hasSection('right-panel')
        <aside class="w-full lg:w-80 glass-panel p-6 lg:p-8 border-l border-outline-variant/20">
            @yield('right-panel')
        </aside>
        @endif
    </main>

    {{-- Mobile Bottom Nav --}}
    <nav class="fixed bottom-0 left-0 w-full bg-surface-container-lowest/80 backdrop-blur-lg border-t border-outline-variant/10 lg:hidden flex justify-around p-3 z-50">
        <a href="{{ route('customer.dashboard') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('customer.dashboard') ? 'text-secondary-container' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined" style="{{ request()->routeIs('customer.dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
            <span class="text-[10px] {{ request()->routeIs('customer.dashboard') ? 'font-bold' : '' }}">Beranda</span>
        </a>
        <a href="{{ route('booking.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('booking.*') && !request()->routeIs('booking.create') ? 'text-secondary-container' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined">calendar_today</span>
            <span class="text-[10px]">Booking</span>
        </a>
        <a href="{{ route('booking.create') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('booking.create') ? 'text-secondary-container' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined">add_circle</span>
            <span class="text-[10px]">Sewa</span>
        </a>
        <a href="{{ route('kendaraan.index') }}" class="flex flex-col items-center gap-1 text-on-surface-variant">
            <span class="material-symbols-outlined">directions_car</span>
            <span class="text-[10px]">Armada</span>
        </a>
        <a href="{{ route('profil.edit') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('profil.*') ? 'text-secondary-container' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px]">Profil</span>
        </a>
    </nav>
</body>
</html>
