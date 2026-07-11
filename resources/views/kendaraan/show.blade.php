@extends('layouts.public')

@section('title', $kendaraan->nama_kendaraan)

@section('content')

<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">

        {{-- Back link --}}
        <a href="{{ route('kendaraan.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition mb-6">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Katalog
        </a>

        {{-- Main content --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- Left: Image --}}
            <div class="lg:col-span-3">
            <div class="aspect-[16/10] bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl flex items-center justify-center shadow-sm overflow-hidden">
                @if($kendaraan->gambar)
                    <img src="{{ asset('storage/uploads/kendaraan/' . $kendaraan->gambar) }}" alt="{{ $kendaraan->nama_kendaraan }}" class="w-full h-full object-cover">
                @else
                    <span class="text-7xl">🚗</span>
                @endif
            </div>
            </div>

            {{-- Right: Info --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $kendaraan->nama_kendaraan }}</h1>
                            <span class="mt-2 inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-primary-50 text-primary-700">
                                {{ $kendaraan->jenis->label() }}
                            </span>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full
                            {{ $kendaraan->status->value === 'tersedia' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $kendaraan->status->value === 'disewa' ? 'bg-amber-100 text-amber-800' : '' }}
                            {{ $kendaraan->status->value === 'service' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $kendaraan->status->label() }}
                        </span>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Plat Nomor</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kendaraan->plat_nomor }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Tahun</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kendaraan->tahun }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Warna</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kendaraan->warna }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Kapasitas</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kendaraan->kapasitas }} penumpang</span>
                        </div>
                        <div class="flex justify-between py-3">
                            <span class="text-sm text-gray-500">Status</span>
                            <span class="text-sm font-medium
                                {{ $kendaraan->status->value === 'tersedia' ? 'text-green-600' : '' }}
                                {{ $kendaraan->status->value === 'disewa' ? 'text-amber-600' : '' }}
                                {{ $kendaraan->status->value === 'service' ? 'text-red-600' : '' }}">
                                {{ $kendaraan->status->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Harga Sewa</p>
                        <p class="text-3xl font-bold text-accent-600">
                            Rp{{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}
                            <span class="text-base font-normal text-gray-500">/hari</span>
                        </p>
                    </div>

                    <div class="mt-6">
                        @auth
                            <a href="{{ route('booking.create', ['kendaraan_id' => $kendaraan->id]) }}"
                                class="inline-flex w-full items-center justify-center px-6 py-3 text-base font-semibold text-white bg-accent-500 rounded-lg hover:bg-accent-600 transition shadow-sm">
                                Booking Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex w-full items-center justify-center px-6 py-3 text-base font-semibold text-white bg-accent-500 rounded-lg hover:bg-accent-600 transition shadow-sm">
                                Login untuk Booking
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="mt-8 bg-white rounded-xl shadow-sm p-6 sm:p-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi</h2>
            <p class="text-gray-600 leading-relaxed">{{ $kendaraan->deskripsi }}</p>
        </div>

    </div>
</div>

@endsection
