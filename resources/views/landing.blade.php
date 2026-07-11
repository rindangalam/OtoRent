@extends('layouts.public')

@section('title', 'OtoRent')

@section('content')

{{-- Hero --}}
<section class="relative bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxkZWZzPjxwYXR0ZXJuIGlkPSJncmlkIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiPjxwYXRoIGQ9Ik0gNDAgMCBMIDAgMCAwIDQwIiBmaWxsPSJub25lIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')] opacity-30"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 lg:py-40">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight">
                Solusi Rental Mobil Terpercaya
            </h1>
            <p class="mt-6 text-lg sm:text-xl text-primary-100 leading-relaxed">
                Sewa kendaraan dengan mudah, cepat, dan terjangkau. Nikmati perjalanan Anda tanpa khawatir bersama OtoRent.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('kendaraan.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-primary-500 bg-white rounded-lg hover:bg-gray-100 transition shadow-lg">
                    Lihat Kendaraan
                </a>
                @guest
                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-white bg-accent-500 rounded-lg hover:bg-accent-600 transition shadow-lg">
                    Booking Sekarang
                </a>
                @else
                <a href="{{ route('booking.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-white bg-accent-500 rounded-lg hover:bg-accent-600 transition shadow-lg">
                    Booking Sekarang
                </a>
                @endguest
            </div>
        </div>
    </div>
</section>

{{-- Layanan --}}
<section class="py-16 sm:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Layanan Kami</h2>
            <p class="mt-4 text-gray-500 text-lg">Berbagai pilihan layanan untuk kebutuhan perjalanan Anda</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-md transition text-center">
                <div class="w-14 h-14 mx-auto bg-primary-100 rounded-xl flex items-center justify-center text-3xl mb-5">
                    🚗
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Lepas Kunci</h3>
                <p class="text-gray-500 leading-relaxed">
                    Sewa kendaraan tanpa driver. Anda bebas menentukan perjalanan sendiri dengan kendaraan pilihan.
                </p>
            </div>
            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-md transition text-center">
                <div class="w-14 h-14 mx-auto bg-accent-100 rounded-xl flex items-center justify-center text-3xl mb-5">
                    👤
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Dengan Driver</h3>
                <p class="text-gray-500 leading-relaxed">
                    Sewa kendaraan lengkap dengan driver berpengalaman. Nikmati perjalanan tanpa repot.
                </p>
            </div>
            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-md transition text-center">
                <div class="w-14 h-14 mx-auto bg-green-100 rounded-xl flex items-center justify-center text-3xl mb-5">
                    🔧
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Service Berkala</h3>
                <p class="text-gray-500 leading-relaxed">
                    Layanan perawatan dan service kendaraan secara berkala untuk performa terbaik.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Kendaraan Populer --}}
<section class="py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Kendaraan Populer</h2>
                <p class="mt-2 text-gray-500">Pilihan kendaraan terbaik untuk perjalanan Anda</p>
            </div>
            <a href="{{ route('kendaraan.index') }}" class="hidden sm:inline-flex text-sm font-medium text-primary-500 hover:text-primary-600 transition">
                Lihat Semua &rarr;
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($kendaraans as $kendaraan)
            <a href="{{ route('kendaraan.show', $kendaraan) }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                <div class="aspect-[4/3] bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center overflow-hidden">
                    @if($kendaraan->gambar)
                        <img src="{{ asset('storage/uploads/kendaraan/' . $kendaraan->gambar) }}" alt="{{ $kendaraan->nama_kendaraan }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-5xl">🚗</span>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-semibold text-gray-900 group-hover:text-primary-500 transition">{{ $kendaraan->nama_kendaraan }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ $kendaraan->jenis->label() }} &middot; {{ $kendaraan->kapasitas }} penumpang</p>
                    <p class="mt-3 text-lg font-bold text-accent-600">
                        Rp{{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/hari</span>
                    </p>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                Belum ada kendaraan tersedia.
            </div>
            @endforelse
        </div>
        <div class="mt-8 text-center sm:hidden">
            <a href="{{ route('kendaraan.index') }}" class="inline-flex items-center text-sm font-medium text-primary-500 hover:text-primary-600">
                Lihat Semua Kendaraan &rarr;
            </a>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 sm:py-20 bg-gradient-to-br from-primary-500 to-primary-700">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold text-white">Siap Memesan Kendaraan?</h2>
        <p class="mt-4 text-lg text-primary-100">Dapatkan kendaraan impian Anda sekarang. Proses mudah dan cepat!</p>
        <div class="mt-8">
            <a href="{{ route('kendaraan.index') }}" class="inline-flex items-center px-8 py-3.5 text-base font-semibold text-primary-500 bg-white rounded-lg hover:bg-gray-100 transition shadow-lg">
                Lihat Semua Kendaraan
            </a>
        </div>
    </div>
</section>

@endsection
