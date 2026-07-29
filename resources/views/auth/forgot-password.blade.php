@extends('layouts.guest')

@section('title', 'Lupa Password — OtoRent')

@section('content')
<header class="mb-8">
    <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Lupa Password</h2>
    <p class="font-body-md text-body-md text-on-surface-variant">Masukkan alamat email Anda dan kami akan mengirimkan tautan reset password.</p>
</header>

<x-auth-session-status class="mb-6" :status="session('status')" />

<form method="POST" action="{{ route('password.email') }}" class="space-y-6">
    @csrf

    <div class="space-y-2">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end">
        <x-primary-button>
            {{ __('Kirim Tautan Reset Password') }}
        </x-primary-button>
    </div>
</form>

<div class="mt-10 text-center pt-8 border-t border-outline-variant/30">
    <p class="font-body-md text-body-md text-on-surface-variant">
        <a class="font-bold text-primary hover:text-primary-container transition-colors" href="{{ route('login') }}">Kembali ke halaman masuk</a>
    </p>
</div>
@endsection
