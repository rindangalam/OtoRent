@extends('layouts.guest')

@section('title', 'Masuk ke OtoRent')

@section('content')
<header class="mb-8">
    <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Selamat Datang Kembali</h2>
    <p class="font-body-md text-body-md text-on-surface-variant">Silakan masuk untuk mengelola pesanan Anda.</p>
</header>

<div class="grid grid-cols-2 gap-4 mb-8">
    <button class="flex items-center justify-center gap-2 py-3 px-4 rounded-lg border border-outline-variant hover:bg-surface-container-low transition-colors duration-200 group ">
        <svg class="w-5 h-5" viewBox="0 0 24 24">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"></path>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
        </svg>
        <span class="font-label-md text-label-md text-on-surface">Google</span>
    </button>
    <button class="flex items-center justify-center gap-2 py-3 px-4 rounded-lg border border-outline-variant hover:bg-surface-container-low transition-colors duration-200 group ">
        <svg class="w-5 h-5 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
        </svg>
        <span class="font-label-md text-label-md text-on-surface">Facebook</span>
    </button>
</div>

<div class="relative mb-8 text-center">
    <hr class="border-outline-variant ">
    <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-surface-container-lowest px-4 font-caption-caps text-caption-caps text-outline uppercase ">Atau</span>
</div>

@if (session('status'))
    <div class="mb-4 text-sm font-medium text-status-success bg-status-success/10 border border-status-success/20 rounded-lg p-3">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <div class="space-y-2">
        <label class="block font-label-md text-label-md text-on-surface" for="email">Alamat Email</label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                <span class="material-symbols-outlined">mail</span>
            </div>
            <input class="block w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 " id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com">
        </div>
        @error('email')
            <p class="text-sm text-status-danger mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <div class="flex justify-between items-center">
            <label class="block font-label-md text-label-md text-on-surface" for="password">Kata Sandi</label>
            @if (Route::has('password.request'))
                <a class="font-label-md text-label-md text-primary hover:underline decoration-2 underline-offset-4 " href="{{ route('password.request') }}">Lupa sandi?</a>
            @endif
        </div>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                <span class="material-symbols-outlined">lock</span>
            </div>
            <input class="block w-full pl-10 pr-12 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 " id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi">
            <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-on-surface transition-colors " type="button" id="togglePassword">
                <span class="material-symbols-outlined">visibility</span>
            </button>
        </div>
        @error('password')
            <p class="text-sm text-status-danger mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-outline-variant text-secondary-container focus:ring-secondary-container/30 ">
            <span class="ml-2 text-sm text-on-surface-variant">Ingat saya</span>
        </label>
    </div>

    <button class="w-full py-4 px-6 bg-secondary-container text-on-secondary-container font-bold rounded-lg shadow-sm hover:shadow-md hover:bg-secondary-container/90 hover:-translate-y-0.5 transition-all duration-200 active:scale-[0.98] focus:ring-4 focus:ring-secondary-container/30 " type="submit">
        Masuk Sekarang
    </button>
</form>

<div class="mt-10 text-center pt-8 border-t border-outline-variant/30 ">
    <p class="font-body-md text-body-md text-on-surface-variant">
        Belum punya akun?
        <a class="font-bold text-primary hover:text-primary-container transition-colors " href="{{ route('register') }}">Daftar di sini</a>
    </p>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('.material-symbols-outlined').textContent = type === 'password' ? 'visibility' : 'visibility_off';
        });
    }
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', () => {
            const formGroup = input.closest('.space-y-2');
            if (formGroup) {
                formGroup.classList.add('scale-[1.01]', 'transition-transform');
            }
        });
        input.addEventListener('blur', () => {
            const formGroup = input.closest('.space-y-2');
            if (formGroup) {
                formGroup.classList.remove('scale-[1.01]');
            }
        });
    });
</script>
@endsection
