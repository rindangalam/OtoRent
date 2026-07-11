@extends('layouts.admin')
@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.pembayaran.index') }}" class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pembayaran</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info Pembayaran --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Informasi Pembayaran</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Booking</p>
                        <p class="text-sm font-medium text-gray-800">#{{ str_pad($pembayaran->booking_id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Customer</p>
                        <p class="text-sm font-medium text-gray-800">{{ $pembayaran->booking->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $pembayaran->booking->user->email ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Jumlah Bayar</p>
                        <p class="text-lg font-bold text-primary-500">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Metode Pembayaran</p>
                        <p class="text-sm font-medium text-gray-800">{{ $pembayaran->metode->label() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Tanggal Bayar</p>
                        <p class="text-sm font-medium text-gray-800">{{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y, H:i') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Status</p>
                        @php
                            $payColors = [
                                'belum_bayar' => 'bg-gray-50 text-gray-700 border-gray-200',
                                'menunggu_verifikasi' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'lunas' => 'bg-green-50 text-green-700 border-green-200',
                                'refund' => 'bg-orange-50 text-orange-700 border-orange-200',
                                'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                            ];
                        @endphp
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $payColors[$pembayaran->status->value] ?? '' }}">
                            {{ $pembayaran->status->label() }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Bukti Bayar --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Bukti Bayar</h2>
                @if($pembayaran->bukti_bayar)
                    <div class="rounded-lg overflow-hidden border border-gray-200">
                        <img src="{{ asset('storage/uploads/bukti-bayar/' . $pembayaran->bukti_bayar) }}" alt="Bukti Bayar" class="w-full max-w-md">
                    </div>
                @else
                    <div class="p-8 text-center bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-gray-500">Belum ada bukti bayar</p>
                    </div>
                @endif
            </div>

            {{-- Catatan Admin --}}
            @if($pembayaran->catatan_admin)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-2">Catatan Admin</h2>
                <p class="text-sm text-gray-600">{{ $pembayaran->catatan_admin }}</p>
            </div>
            @endif
        </div>

        {{-- Sidebar Aksi --}}
        <div class="space-y-6">
            @if($pembayaran->status->value === 'menunggu_verifikasi')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Verifikasi Pembayaran</h2>
                <div class="space-y-3">
                    <form method="POST" action="{{ route('admin.pembayaran.verifikasi', $pembayaran) }}">
                        @csrf
                        @method('PUT')
                        <textarea name="catatan_admin" rows="2" placeholder="Catatan admin (opsional)..."
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition mb-3"></textarea>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Verifikasi
                        </button>
                    </form>

                    <div x-data="{ showReject: false }">
                        <button @click="showReject = !showReject" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-red-200 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tolak
                        </button>

                        <div x-show="showReject" x-transition x-cloak class="mt-3">
                            <form method="POST" action="{{ route('admin.pembayaran.tolak', $pembayaran) }}">
                                @csrf
                                @method('PUT')
                                <textarea name="catatan_admin" rows="3" required placeholder="Alasan penolakan..."
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition mb-3"></textarea>
                                @error('catatan_admin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                <button type="submit" class="w-full px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition" onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                                    Konfirmasi Penolakan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Info Booking</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Kendaraan</span>
                        <span class="font-medium text-gray-800">{{ $pembayaran->booking->kendaraan->nama_kendaraan ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Grand Total</span>
                        <span class="font-medium text-gray-800">Rp {{ number_format($pembayaran->booking->grand_total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('admin.booking.show', $pembayaran->booking) }}" class="block text-center text-sm text-primary-500 hover:text-primary-600 font-medium pt-2">
                        Lihat Detail Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
