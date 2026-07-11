<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OtoRent') — Solusi Rental Mobil Terpercaya</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900">

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-8">
                <a href="{{ route('landing') }}" class="text-xl font-bold tracking-tight">
                    <span class="text-primary-500">Oto</span><span class="text-accent-500">Rent</span>
                </a>
                <div class="hidden sm:flex items-center gap-6">
                    <a href="{{ route('landing') }}" class="text-sm font-medium {{ request()->routeIs('landing') ? 'text-primary-500' : 'text-gray-600 hover:text-gray-900' }}">
                        Beranda
                    </a>
                    <a href="{{ route('kendaraan.index') }}" class="text-sm font-medium {{ request()->routeIs('kendaraan.*') ? 'text-primary-500' : 'text-gray-600 hover:text-gray-900' }}">
                        Kendaraan
                    </a>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-4">
                @auth
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Logout
                        </button>
                    </form>
                    <a href="{{ auth()->user()->role->value === 'admin' || auth()->user()->role->value === 'staff' ? route('admin.dashboard') : route('customer.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-500 rounded-lg hover:bg-accent-600 transition">
                        Daftar
                    </a>
                @endauth
            </div>
            <button @click="open = ! open" class="sm:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('landing') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('landing') ? 'text-primary-500 bg-primary-50' : 'text-gray-600 hover:text-gray-900' }}">
                Beranda
            </a>
            <a href="{{ route('kendaraan.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('kendaraan.*') ? 'text-primary-500 bg-primary-50' : 'text-gray-600 hover:text-gray-900' }}">
                Kendaraan
            </a>
            <hr class="my-2">
            @auth
                <a href="{{ auth()->user()->role->value === 'admin' || auth()->user()->role->value === 'staff' ? route('admin.dashboard') : route('customer.dashboard') }}" class="block px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-md">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-md">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-md">
                    Login
                </a>
                <a href="{{ route('register') }}" class="block px-3 py-2 text-sm font-medium text-accent-600 hover:text-accent-700 rounded-md">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="bg-primary-500 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-3"><span class="text-white">Oto</span><span class="text-accent-500">Rent</span></h3>
                <p class="text-sm text-primary-200 leading-relaxed">
                    Solusi rental mobil terpercaya untuk perjalanan Anda. Mudah, cepat, dan terjangkau.
                </p>
            </div>
            <div>
                <h4 class="font-semibold mb-3 text-sm uppercase tracking-wider text-primary-200">Kontak</h4>
                <ul class="space-y-2 text-sm text-primary-100">
                    <li>Jl. Merdeka No. 123, Jakarta</li>
                    <li>021-12345678</li>
                    <li>info@otorent.id</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-3 text-sm uppercase tracking-wider text-primary-200">Menu</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('landing') }}" class="text-primary-100 hover:text-white transition">Beranda</a></li>
                    <li><a href="{{ route('kendaraan.index') }}" class="text-primary-100 hover:text-white transition">Kendaraan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-3 text-sm uppercase tracking-wider text-primary-200">Jam Operasional</h4>
                <ul class="space-y-2 text-sm text-primary-100">
                    <li>Senin - Sabtu: 08:00 - 20:00</li>
                    <li>Minggu: 09:00 - 17:00</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-primary-400 mt-8 pt-6 text-center text-sm text-primary-200">
            &copy; {{ date('Y') }} OtoRent. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
