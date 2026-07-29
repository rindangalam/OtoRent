@extends('layouts.guest')

@section('title', 'Verifikasi Email — OtoRent')

@section('content')
<header class="mb-8">
    <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Verifikasi Email</h2>
    <p class="font-body-md text-body-md text-on-surface-variant">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>
</header>

@if (session('status') == 'verification-link-sent')
    <div class="mb-6 font-medium text-sm text-status-success bg-status-success/10 border border-status-success/20 rounded-lg p-3">
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
    </div>
@endif

<div class="flex items-center justify-between gap-4">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <x-primary-button>
            {{ __('Resend Verification Email') }}
        </x-primary-button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="font-bold text-primary hover:text-primary-container transition-colors underline decoration-2 underline-offset-4">
            {{ __('Log Out') }}
        </button>
    </form>
</div>
@endsection
