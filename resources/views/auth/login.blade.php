<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — OtoRent</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <a href="{{ route('landing') }}" class="text-3xl font-extrabold tracking-tight">
            <span class="text-primary-500">Oto</span><span class="text-accent-500">Rent</span>
        </a>
        <p class="mt-2 text-sm text-gray-500">Masuk ke akun Anda</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-8">
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600 bg-green-50 rounded-lg p-3">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5 flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-primary-500 shadow-sm focus:ring-primary-500">
                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                        Lupa password?
                    </a>
                @endif
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-accent-500 rounded-lg hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 transition">
                    Login
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-primary-500 hover:text-primary-600">Register</a>
        </p>
    </div>
</div>

</body>
</html>
