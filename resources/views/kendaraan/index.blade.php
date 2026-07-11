@extends('layouts.public')

@section('title', 'Kendaraan Kami')

@section('content')

<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Kendaraan Kami</h1>
            <p class="mt-2 text-gray-500">Temukan kendaraan yang sesuai dengan kebutuhan Anda</p>
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route('kendaraan.index') }}" class="bg-white rounded-xl shadow-sm p-5 mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                    <input id="search" type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nama kendaraan..."
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                </div>
                <div>
                    <label for="jenis" class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                    <select id="jenis" name="jenis"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenisList as $jenis)
                            <option value="{{ $jenis->value }}" {{ request('jenis') === $jenis->value ? 'selected' : '' }}>
                                {{ $jenis->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition">
                        Filter
                    </button>
                </div>
            </div>
        </form>

        {{-- Grid Kendaraan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($kendaraans as $kendaraan)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                        <div class="aspect-[4/3] bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center overflow-hidden">
                            @if($kendaraan->gambar)
                                <img src="{{ asset('storage/uploads/kendaraan/' . $kendaraan->gambar) }}" alt="{{ $kendaraan->nama_kendaraan }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-5xl">🚗</span>
                            @endif
                        </div>
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-semibold text-gray-900 text-lg">{{ $kendaraan->nama_kendaraan }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full
                                {{ $kendaraan->status->value === 'tersedia' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $kendaraan->status->value === 'disewa' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $kendaraan->status->value === 'service' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $kendaraan->status->label() }}
                            </span>
                        </div>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full bg-primary-50 text-primary-700">
                                {{ $kendaraan->jenis->label() }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                {{ $kendaraan->kapasitas }} penumpang
                            </span>
                        </div>

                        <p class="mt-4 text-xl font-bold text-accent-600">
                            Rp{{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}
                            <span class="text-sm font-normal text-gray-500">/hari</span>
                        </p>

                        <a href="{{ route('kendaraan.show', $kendaraan) }}"
                            class="mt-4 inline-flex w-full items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="text-5xl mb-4">🚗</div>
                    <h3 class="text-lg font-semibold text-gray-900">Tidak ada kendaraan</h3>
                    <p class="mt-1 text-gray-500">Tidak ditemukan kendaraan yang sesuai dengan filter Anda.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $kendaraans->links() }}
        </div>

    </div>
</div>

@endsection
