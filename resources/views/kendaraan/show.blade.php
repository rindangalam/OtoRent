@extends('layouts.public')

@section('title', $kendaraan->nama_kendaraan)

@section('content')

<div class="bg-surface min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">

        {{-- Back link --}}
        <a href="{{ route('kendaraan.index') }}" class="inline-flex items-center text-label-md text-on-surface-variant hover:text-on-surface transition mb-6">
            <span class="material-symbols-outlined text-[18px] mr-1">arrow_back</span>
            Kembali ke Katalog
        </a>

        {{-- Main content --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- Left: Image --}}
            <div class="lg:col-span-3">
            <div class="aspect-[16/10] bg-gradient-to-br from-primary-200 to-primary-300 rounded-xl flex items-center justify-center shadow-sm overflow-hidden">
                @if($kendaraan->gambar)
                    <img src="{{ asset('storage/uploads/kendaraan/' . $kendaraan->gambar) }}" alt="{{ $kendaraan->nama_kendaraan }}" class="w-full h-full object-cover">
                @else
                    <span class="text-7xl">🚗</span>
                @endif
            </div>
            </div>

            {{-- Right: Info --}}
            <div class="lg:col-span-2">
                <div class="bg-surface-container-lowest rounded-xl shadow-sm p-6 sm:p-8">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h1 class="text-headline-lg text-headline-lg text-on-surface">{{ $kendaraan->nama_kendaraan }}</h1>
                            <span class="mt-2 inline-flex items-center px-3 py-1 text-label-md rounded-full bg-secondary-container/20 text-secondary-container">
                                {{ $kendaraan->jenis->label() }}
                            </span>
                        </div>
                        @php
                            $statusColors = [
                                'tersedia' => 'bg-status-success/10 text-status-success',
                                'disewa' => 'bg-status-warning/10 text-status-warning',
                                'service' => 'bg-status-danger/10 text-status-danger',
                            ];
                            $statusColor = $statusColors[$kendaraan->status->value] ?? 'bg-surface-variant/50 text-on-surface-variant';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 text-label-md rounded-full {{ $statusColor }}">
                            {{ $kendaraan->status->label() }}
                        </span>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between py-3 border-b border-outline-variant/10">
                            <span class="text-body-md text-on-surface-variant">Plat Nomor</span>
                            <span class="text-body-md font-medium text-on-surface">{{ $kendaraan->plat_nomor }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-outline-variant/10">
                            <span class="text-body-md text-on-surface-variant">Tahun</span>
                            <span class="text-body-md font-medium text-on-surface">{{ $kendaraan->tahun }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-outline-variant/10">
                            <span class="text-body-md text-on-surface-variant">Warna</span>
                            <span class="text-body-md font-medium text-on-surface">{{ $kendaraan->warna }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-outline-variant/10">
                            <span class="text-body-md text-on-surface-variant">Kapasitas</span>
                            <span class="text-body-md font-medium text-on-surface">{{ $kendaraan->kapasitas }} penumpang</span>
                        </div>
                        <div class="flex justify-between py-3">
                            <span class="text-body-md text-on-surface-variant">Status</span>
                            <span class="text-body-md font-medium
                                {{ $kendaraan->status->value === 'tersedia' ? 'text-status-success' : '' }}
                                {{ $kendaraan->status->value === 'disewa' ? 'text-status-warning' : '' }}
                                {{ $kendaraan->status->value === 'service' ? 'text-status-danger' : '' }}">
                                {{ $kendaraan->status->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-outline-variant/10">
                        <p class="text-body-md text-on-surface-variant mb-1">Harga Sewa</p>
                        <p class="text-display-sm text-display-sm font-bold text-accent-500">
                            Rp{{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}
                            <span class="text-body-md font-normal text-on-surface-variant">/hari</span>
                        </p>
                    </div>

                    <div class="mt-6">
                        @auth
                            <a href="{{ route('booking.create', ['kendaraan_id' => $kendaraan->id]) }}"
                                class="inline-flex w-full items-center justify-center px-6 py-3 text-label-lg text-label-lg font-semibold text-white bg-accent-500 rounded-lg hover:bg-accent-600 transition shadow-sm">
                                Booking Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex w-full items-center justify-center px-6 py-3 text-label-lg text-label-lg font-semibold text-white bg-accent-500 rounded-lg hover:bg-accent-600 transition shadow-sm">
                                Login untuk Booking
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="mt-8 bg-surface-container-lowest rounded-xl shadow-sm p-6 sm:p-8">
            <h2 class="text-headline-md text-on-surface mb-4">Deskripsi</h2>
            <p class="text-body-md text-on-surface-variant leading-relaxed">{{ $kendaraan->deskripsi }}</p>
        </div>

    </div>
</div>

@endsection
