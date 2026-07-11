<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | OtoRent</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <nav x-data="{ mobileOpen: false, profileOpen: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-8">
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 shrink-0">
                        <span class="text-xl font-bold text-primary-500">Oto</span><span class="text-xl font-bold text-accent-500">Rent</span>
                    </a>
                    <div class="hidden sm:flex items-center gap-6">
                        <a href="{{ route('customer.dashboard') }}" class="text-sm font-medium {{ request()->routeIs('customer.dashboard') ? 'text-primary-500' : 'text-gray-600' }} hover:text-primary-500 transition">Dashboard</a>
                        <a href="{{ route('booking.index') }}" class="text-sm font-medium {{ request()->routeIs('booking.*') ? 'text-primary-500' : 'text-gray-600' }} hover:text-primary-500 transition">Booking</a>
                        <a href="{{ route('booking.create') }}" class="text-sm font-medium {{ request()->routeIs('booking.create') ? 'text-primary-500' : 'text-gray-600' }} hover:text-primary-500 transition">Sewa Baru</a>
                    </div>
                </div>
                <div class="hidden sm:flex items-center gap-4">
                    <a href="{{ route('profil.edit') }}" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition">{{ auth()->user()->name }}</a>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">Logout</button>
                    </form>
                </div>
                <button @click="mobileOpen = ! mobileOpen" class="sm:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileOpen, 'inline-flex': ! mobileOpen}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! mobileOpen, 'inline-flex': mobileOpen}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div :class="{'block': mobileOpen, 'hidden': ! mobileOpen}" class="hidden sm:hidden border-t border-gray-100">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">Dashboard</a>
                <a href="{{ route('booking.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">Booking</a>
                <a href="{{ route('booking.create') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">Sewa Baru</a>
                <a href="{{ route('profil.edit') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">Profil</a>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
</body>
</html>
