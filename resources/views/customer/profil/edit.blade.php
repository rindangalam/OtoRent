@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-on-surface">Profil Saya</h1>
        <p class="text-on-surface-variant mt-1">Kelola informasi akun Anda.</p>
    </div>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('profil.update') }}">
            @csrf
            @method('PUT')

            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6 mb-6">
                <div class="flex items-center gap-6 mb-6">
                    <div class="w-20 h-20 rounded-full bg-primary-200 flex items-center justify-center text-primary-800 shrink-0">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-medium text-on-surface">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-on-surface-variant">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-on-surface-variant mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                            class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm" required>
                        @error('name')
                            <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-on-surface-variant mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm" required>
                        @error('email')
                            <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-on-surface-variant mb-1">No. Telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                            class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm">
                        @error('phone')
                            <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-on-surface-variant mb-1">Alamat</label>
                    <textarea id="address" name="address" rows="3"
                        class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm">{{ old('address', auth()->user()->address) }}</textarea>
                    @error('address')
                        <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="inline-flex items-center px-6 py-3 bg-accent-500 text-white text-sm font-medium rounded-lg hover:bg-accent-600 transition">
                Simpan Perubahan
            </button>
        </form>
    </div>
@endsection
