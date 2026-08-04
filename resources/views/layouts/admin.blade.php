<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') | OtoRent</title>

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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--color-outline-variant); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--color-outline); }
    </style>
</head>
<body class="font-sans antialiased bg-background text-on-background selection:bg-secondary-container selection:text-on-secondary-container">

<div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-background/50 lg:hidden"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-40 w-64 bg-primary text-on-primary transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:z-auto flex flex-col">

        <div class="flex items-center justify-between h-16 px-6 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1">
                <span class="text-xl font-bold text-on-primary">Oto</span><span class="text-xl font-bold text-secondary-container">Rent</span>
                <span class="ml-2 text-xs bg-secondary-container text-on-secondary-container px-2 py-0.5 rounded-full font-semibold">Admin</span>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-on-primary/70 hover:text-on-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-on-primary' : 'text-on-primary/70 hover:bg-white/10 hover:text-on-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="pt-4 pb-2 px-3">
                <p class="text-xs font-semibold text-on-primary/40 uppercase tracking-wider">Kelola</p>
            </div>

            <a href="{{ route('admin.kendaraan.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.kendaraan.*') ? 'bg-white/15 text-on-primary' : 'text-on-primary/70 hover:bg-white/10 hover:text-on-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17h8M8 17v-4h8v4M8 17H5a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v4a2 2 0 01-2 2h-3m-8 0H5" />
                </svg>
                <span>Kendaraan</span>
            </a>

            <a href="{{ route('admin.driver.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.driver.*') ? 'bg-white/15 text-on-primary' : 'text-on-primary/70 hover:bg-white/10 hover:text-on-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Driver</span>
            </a>

            <a href="{{ route('admin.jadwal.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.jadwal.*') ? 'bg-white/15 text-on-primary' : 'text-on-primary/70 hover:bg-white/10 hover:text-on-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Jadwal</span>
            </a>

            <a href="{{ route('admin.booking.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.booking.*') ? 'bg-white/15 text-on-primary' : 'text-on-primary/70 hover:bg-white/10 hover:text-on-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Booking</span>
            </a>

            <a href="{{ route('admin.pembayaran.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.pembayaran.*') ? 'bg-white/15 text-on-primary' : 'text-on-primary/70 hover:bg-white/10 hover:text-on-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Pembayaran</span>
            </a>

            <a href="{{ route('admin.service.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.service.*') ? 'bg-white/15 text-on-primary' : 'text-on-primary/70 hover:bg-white/10 hover:text-on-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Service</span>
            </a>

            <div class="pt-4 pb-2 px-3">
                <p class="text-xs font-semibold text-on-primary/40 uppercase tracking-wider">Lainnya</p>
            </div>

            <a href="{{ route('admin.laporan.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-white/15 text-on-primary' : 'text-on-primary/70 hover:bg-white/10 hover:text-on-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Laporan</span>
            </a>
        </nav>

        <div class="px-3 py-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium text-on-primary/70 hover:bg-white/10 hover:text-on-primary transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">

        <header class="bg-surface-container-lowest border-b border-outline-variant/30 sticky top-0 z-20">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6">
                <button @click="sidebarOpen = true" class="lg:hidden text-on-surface-variant hover:text-on-surface">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="hidden sm:block">
                    <h1 class="text-lg font-semibold text-on-surface">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-primary-fixed text-primary flex items-center justify-center text-sm font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                        <span class="hidden sm:inline text-sm font-medium text-on-surface">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <x-alert />
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
