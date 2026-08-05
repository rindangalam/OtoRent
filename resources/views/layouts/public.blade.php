<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OtoRent') — Solusi Rental Mobil Terpercaya</title>
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
<body class="bg-background text-on-background font-sans antialiased selection:bg-secondary-container selection:text-on-secondary-container overflow-x-hidden">

<x-demo-banner sticky />

<nav class="{{ demo_mode() ? 'sticky top-8' : 'fixed top-0' }} w-full z-50 bg-surface shadow-sm transition-all duration-300 ease-out h-20" id="main-nav">
    <div class="flex justify-between items-center h-full px-4 sm:px-6 lg:px-8 max-w-[1280px] mx-auto">
        <div class="flex items-center gap-8">
            <a href="{{ route('landing') }}" class="font-bold text-xl sm:text-2xl tracking-tighter text-primary">
                Oto<span class="text-secondary-container">Rent</span>
            </a>
            <div class="hidden md:flex gap-6 items-center">
                <a href="{{ route('landing') }}" class="font-body-md text-body-md {{ request()->routeIs('landing') ? 'text-primary font-bold border-b-2 border-secondary-container' : 'text-on-surface hover:text-primary' }} transition-colors duration-200">Beranda</a>
                <a href="{{ route('kendaraan.index') }}" class="font-body-md text-body-md {{ request()->routeIs('kendaraan.*') ? 'text-primary font-bold border-b-2 border-secondary-container' : 'text-on-surface hover:text-primary' }} transition-colors duration-200">Kendaraan</a>
                <a href="{{ route('layanan') }}" class="font-body-md text-body-md {{ request()->routeIs('layanan') ? 'text-primary font-bold border-b-2 border-secondary-container' : 'text-on-surface hover:text-primary' }} transition-colors duration-200">Layanan</a>
                <a href="{{ route('kontak') }}" class="font-body-md text-body-md {{ request()->routeIs('kontak*') ? 'text-primary font-bold border-b-2 border-secondary-container' : 'text-on-surface hover:text-primary' }} transition-colors duration-200">Kontak</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden lg:flex items-center bg-surface-container rounded-full px-4 py-2 gap-2">
                <span class="material-symbols-outlined text-outline">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-sm w-32 outline-none text-on-surface placeholder:text-outline" placeholder="Cari mobil..." type="text">
            </div>
            <button class="material-symbols-outlined p-2 text-surface hover:bg-surface-container rounded-full transition-all hidden sm:block">notifications</button>
            @auth
                <a href="{{ auth()->user()->role->value === 'admin' || auth()->user()->role->value === 'staff' ? route('admin.dashboard') : route('customer.dashboard') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-full font-label-md text-label-md hover:bg-primary-container hover:shadow-md transition-all hidden sm:block">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-on-surface hover:text-primary transition-colors">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-full font-label-md text-label-md hover:bg-primary-container hover:shadow-md transition-all hidden sm:block">Masuk</a>
                <a href="{{ route('register') }}" class="text-sm font-medium text-on-surface hover:text-primary transition-colors hidden sm:block">Daftar</a>
            @endauth
            <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md text-surface hover:bg-surface-container">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
</nav>

<div id="mobile-menu" class="hidden md:hidden bg-surface border-t border-outline-variant/30 shadow-lg">
    <div class="px-4 py-4 space-y-1 max-w-[1280px] mx-auto">
        <a href="{{ route('landing') }}" class="block px-3 py-2.5 rounded-md font-body-md text-body-md {{ request()->routeIs('landing') ? 'bg-secondary-container/10 text-primary font-bold' : 'text-on-surface hover:bg-surface-container' }} transition-colors">Beranda</a>
        <a href="{{ route('kendaraan.index') }}" class="block px-3 py-2.5 rounded-md font-body-md text-body-md {{ request()->routeIs('kendaraan.*') ? 'bg-secondary-container/10 text-primary font-bold' : 'text-on-surface hover:bg-surface-container' }} transition-colors">Kendaraan</a>
        <a href="{{ route('layanan') }}" class="block px-3 py-2.5 rounded-md font-body-md text-body-md {{ request()->routeIs('layanan') ? 'bg-secondary-container/10 text-primary font-bold' : 'text-on-surface hover:bg-surface-container' }} transition-colors">Layanan</a>
        <a href="{{ route('kontak') }}" class="block px-3 py-2.5 rounded-md font-body-md text-body-md {{ request()->routeIs('kontak*') ? 'bg-secondary-container/10 text-primary font-bold' : 'text-on-surface hover:bg-surface-container' }} transition-colors">Kontak</a>
        <div class="border-t border-outline-variant/20 pt-3 mt-3 space-y-1">
            @auth
                <a href="{{ auth()->user()->role->value === 'admin' || auth()->user()->role->value === 'staff' ? route('admin.dashboard') : route('customer.dashboard') }}" class="block px-3 py-2.5 rounded-md font-body-md text-body-md text-primary font-bold bg-primary/5 hover:bg-primary/10 transition-colors">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2.5 rounded-md font-body-md text-body-md text-on-surface hover:bg-surface-container transition-colors">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2.5 rounded-md font-body-md text-body-md bg-primary text-on-primary text-center hover:bg-primary-container transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="block px-3 py-2.5 rounded-md font-body-md text-body-md text-on-surface hover:bg-surface-container transition-colors">Daftar</a>
            @endauth
        </div>
    </div>
</div>

<main>
    @yield('content')
</main>

<footer class="w-full py-16 px-4 sm:px-6 lg:px-8 mt-auto bg-primary text-on-primary">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-[1280px] mx-auto">
        <div class="space-y-6">
            <span class="font-headline-md text-headline-md text-on-primary font-black tracking-tighter">OtoRent</span>
            <p class="text-on-primary/70 font-body-md text-body-md pr-4">
                Penyedia layanan sewa mobil premium nomor satu di Indonesia. Mewah, terpercaya, dan profesional.
            </p>
            <div class="flex gap-4">
                <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-secondary-container transition-colors" href="{{ route('layanan') }}">
                    <span class="material-symbols-outlined text-[20px]">public</span>
                </a>
                <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-secondary-container transition-colors" href="https://wa.me/6281234567890" target="_blank" rel="noopener">
                    <span class="material-symbols-outlined text-[20px]">chat</span>
                </a>
                <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-secondary-container transition-colors" href="{{ route('kontak') }}">
                    <span class="material-symbols-outlined text-[20px]">mail</span>
                </a>
            </div>
        </div>
        <div class="space-y-6">
            <h5 class="font-bold text-lg">Layanan</h5>
            <ul class="space-y-3 text-on-primary/70">
                                <li><a class="hover:text-secondary-container transition-colors" href="{{ route('layanan') }}">Sewa Harian</a></li>
                <li><a class="hover:text-secondary-container transition-colors" href="{{ route('layanan') }}">Sewa Bulanan</a></li>
                <li><a class="hover:text-secondary-container transition-colors" href="{{ route('layanan') }}">Layanan Chauffeur</a></li>
                <li><a class="hover:text-secondary-container transition-colors" href="{{ route('layanan') }}">Sewa Korporat</a></li>
            </ul>
        </div>
        <div class="space-y-6">
            <h5 class="font-bold text-lg">Perusahaan</h5>
            <ul class="space-y-3 text-on-primary/70">
                <li><a class="hover:text-secondary-container transition-colors" href="{{ route('kendaraan.index') }}">Tentang Kami</a></li>
                <li><a class="hover:text-secondary-container transition-colors" href="{{ route('kontak') }}">Lokasi</a></li>
                <li><a class="hover:text-secondary-container transition-colors" href="{{ route('kontak') }}">Karir</a></li>
                <li><a class="hover:text-secondary-container transition-colors" href="{{ route('kontak') }}">Blog</a></li>
            </ul>
        </div>
        <div class="space-y-6">
            <h5 class="font-bold text-lg">Berlangganan</h5>
            <p class="text-on-primary/70 text-sm">Dapatkan penawaran eksklusif langsung di email Anda.</p>
            <div class="flex flex-col gap-3">
                <input class="bg-white/10 border-white/20 rounded-xl px-4 py-3 focus:ring-secondary-container outline-none placeholder:text-white/30 text-white" placeholder="Email Anda" type="email">
                <button class="bg-secondary-container text-on-secondary-fixed py-3 rounded-xl font-bold hover:opacity-90 transition-opacity">Daftar Sekarang</button>
            </div>
        </div>
    </div>
    <div class="max-w-[1280px] mx-auto pt-16 mt-16 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-6">
        <p class="text-on-primary/50 text-sm">&copy; {{ date('Y') }} OtoRent. All rights reserved.</p>
        <div class="flex gap-8 text-sm text-on-primary/50">
            <a class="hover:text-white transition-colors" href="#">Privacy Policy</a>
            <a class="hover:text-white transition-colors" href="#">Terms of Service</a>
            <a class="hover:text-white transition-colors" href="#">Cookie Policy</a>
        </div>
    </div>
</footer>

<script>
    const nav = document.getElementById('main-nav');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            nav.classList.add('h-16', 'shadow-md');
            nav.classList.remove('h-20', 'shadow-sm');
        } else {
            nav.classList.add('h-20', 'shadow-sm');
            nav.classList.remove('h-16', 'shadow-md');
        }
    });

    const menuBtn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (menuBtn && menu) {
        menuBtn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }
</script>
</body>
</html>
