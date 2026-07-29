@extends('layouts.guest')

@section('title', 'Konfirmasi Password — OtoRent')

@section('content')
<header class="mb-8">
    <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Konfirmasi Password</h2>
    <p class="font-body-md text-body-md text-on-surface-variant">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
</header>

<form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
    @csrf

    <div class="space-y-2">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end">
        <x-primary-button>
            {{ __('Confirm') }}
        </x-primary-button>
    </div>
</form>
@endsection
