@php
    $layout = in_array(auth()->user()->role, ['admin', 'staff'], true) ? 'layouts.admin' : 'layouts.customer';
@endphp
@extends($layout)

@section('title', 'Profil')

@section('content')
<header class="mb-8">
    <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Profil</h2>
    <p class="font-body-md text-body-md text-on-surface-variant">Kelola informasi profil Anda.</p>
</header>

<form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('patch')

    <div class="space-y-2">
        <label class="block font-label-md text-label-md text-on-surface" for="name">Nama</label>
        <input class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 " id="name" name="name" value="{{ old('name', $user->name) }}" required>
        @error('name')
            <p class="text-sm text-status-danger mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block font-label-md text-label-md text-on-surface" for="email">Email</label>
        <input class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 " id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
        @error('email')
            <p class="text-sm text-status-danger mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-4">
        <button type="submit" class="px-6 py-3 bg-secondary-container text-on-secondary-container font-bold rounded-lg hover:shadow-md transition-all">Simpan</button>
        @if (session('status') === 'profile-updated')
            <p class="text-sm text-status-success self-center">Tersimpan.</p>
        @endif
    </div>
</form>

<hr class="my-8 border-outline-variant/30">

<form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4" onsubmit="return confirm('Yakin ingin menghapus akun?')">
    @csrf
    @method('delete')

    <h3 class="font-headline-md text-headline-md text-status-danger">Hapus Akun</h3>
    <p class="text-sm text-on-surface-variant">Setelah akun dihapus, semua data akan hilang permanen.</p>

    <div class="space-y-2">
        <label class="block font-label-md text-label-md text-on-surface" for="delete-password">Kata Sandi</label>
        <input class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 " id="delete-password" name="password" type="password" placeholder="Masukkan kata sandi" required>
    </div>

    <button type="submit" class="px-6 py-3 bg-status-danger text-white font-bold rounded-lg hover:opacity-90 transition-all">Hapus Akun</button>
</form>
@endsection
