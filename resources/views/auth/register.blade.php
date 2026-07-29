@extends('layouts.guest')

@section('title', 'Daftar — OtoRent')

@section('content')
<header class="mb-8">
    <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Buat Akun Baru</h2>
    <p class="font-body-md text-body-md text-on-surface-variant">Isi data diri Anda untuk memulai.</p>
</header>

<form method="POST" action="{{ route('register') }}" class="space-y-6">
    @csrf

    <div class="space-y-2">
        <label class="block font-label-md text-label-md text-on-surface" for="name">Nama Lengkap</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
            class="block w-full bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 px-4 py-3"
            placeholder="Nama lengkap Anda">
        @error('name')
            <p class="text-sm text-status-danger mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block font-label-md text-label-md text-on-surface" for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
            class="block w-full bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 px-4 py-3"
            placeholder="nama@email.com">
        @error('email')
            <p class="text-sm text-status-danger mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block font-label-md text-label-md text-on-surface" for="phone">Nomor Telepon</label>
        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel"
            class="block w-full bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 px-4 py-3"
            placeholder="08xxxxxxxxxx">
        @error('phone')
            <p class="text-sm text-status-danger mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block font-label-md text-label-md text-on-surface" for="password">Password</label>
        <input id="password" type="password" name="password" required autocomplete="new-password"
            class="block w-full bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 px-4 py-3"
            placeholder="Min. 8 karakter">
        @error('password')
            <p class="text-sm text-status-danger mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block font-label-md text-label-md text-on-surface" for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
            class="block w-full bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 px-4 py-3"
            placeholder="Ulangi password">
        @error('password_confirmation')
            <p class="text-sm text-status-danger mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="w-full py-4 px-6 bg-secondary-container text-on-secondary-container font-bold rounded-lg shadow-sm hover:shadow-md hover:bg-secondary-container/90 hover:-translate-y-0.5 transition-all duration-200 active:scale-[0.98] focus:ring-4 focus:ring-secondary-container/30">
        Daftar Sekarang
    </button>
</form>

<div class="mt-10 text-center pt-8 border-t border-outline-variant/30">
    <p class="font-body-md text-body-md text-on-surface-variant">
        Sudah punya akun?
        <a class="font-bold text-primary hover:text-primary-container transition-colors" href="{{ route('login') }}">Masuk</a>
    </p>
</div>
@endsection
