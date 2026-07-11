@extends('layouts.admin')
@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.booking.index') }}" class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Booking #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h1>
        @php
            $statusColors = [
                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                'ongoing' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                'completed' => 'bg-green-50 text-green-700 border-green-200',
                'cancelled' => 'bg-red-50 text-red-700 border-red-200',
            ];
        @endphp
        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusColors[$booking->status->value] ?? '' }}">
            {{ $booking->status->label() }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info Booking --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Informasi Booking</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Customer</p>
                        <p class="text-sm font-medium text-gray-800">{{ $booking->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $booking->user->email ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Kendaraan</p>
                        <p class="text-sm font-medium text-gray-800">{{ $booking->kendaraan->nama_kendaraan ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $booking->kendaraan->plat_nomor ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Tipe Sewa</p>
                        <p class="text-sm font-medium text-gray-800">
                            @if ($booking->tipe_sewa === 'driver')
                                Pakai Driver
                            @else
                                Lepas Kunci
                                @if ($booking->metode_antar)
                                    — {{ $booking->metode_antar === 'diantar' ? 'Mobil Diantar' : 'Jemput Sendiri' }}
                                @endif
                            @endif
                        </p>
                    </div>
                    @if ($booking->tipe_sewa === 'driver')
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Driver</p>
                        <p class="text-sm font-medium text-gray-800">{{ $booking->driver->nama_driver ?? '-' }}</p>
                        @if($booking->driver)
                            <p class="text-xs text-gray-400">{{ $booking->driver->no_telp }}</p>
                        @endif
                    </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Durasi</p>
                        <p class="text-sm font-medium text-gray-800">{{ $booking->durasi_hari }} hari</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Tanggal Mulai</p>
                        <p class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Tanggal Selesai</p>
                        <p class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">
                            @if ($booking->tipe_sewa === 'driver')
                                Lokasi Jemput
                            @elseif ($booking->metode_antar === 'diantar')
                                Lokasi Pengantaran
                            @else
                                Alamat Lokasi Rental
                            @endif
                        </p>
                        <p class="text-sm font-medium text-gray-800">{{ $booking->lokasi_jemput }}</p>
                    </div>
                    @if($booking->lokasi_tujuan)
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Lokasi Tujuan</p>
                        <p class="text-sm font-medium text-gray-800">{{ $booking->lokasi_tujuan }}</p>
                    </div>
                    @endif
                    @if($booking->catatan)
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Catatan</p>
                        <p class="text-sm text-gray-600">{{ $booking->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Ringkasan Biaya --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Ringkasan Biaya</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Kendaraan ({{ $booking->durasi_hari }} hari &times; Rp {{ number_format($booking->kendaraan->harga_sewa_per_hari ?? 0, 0, ',', '.') }})</span>
                        <span class="font-medium text-gray-800">Rp {{ number_format($booking->total_kendaraan, 0, ',', '.') }}</span>
                    </div>
                    @if($booking->total_driver > 0)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Driver ({{ $booking->durasi_hari }} hari &times; Rp {{ number_format($booking->driver->tarif_per_hari ?? 0, 0, ',', '.') }})</span>
                        <span class="font-medium text-gray-800">Rp {{ number_format($booking->total_driver, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($booking->ongkos_antar > 0)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Ongkos Antar</span>
                        <span class="font-medium text-gray-800">Rp {{ number_format($booking->ongkos_antar, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="border-t border-gray-100 pt-3 flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-800">Grand Total</span>
                        <span class="text-lg font-bold text-primary-500">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Status Management --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Ubah Status</h2>
                <div class="space-y-3">
                    @if($booking->status->value === 'pending')
                        <form method="POST" action="{{ route('admin.booking.updateStatus', $booking) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Konfirmasi Booking
                            </button>
                        </form>
                    @endif

                    @if($booking->status->value === 'confirmed')
                        <form method="POST" action="{{ route('admin.booking.updateStatus', $booking) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="ongoing">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Mulai Sewa
                            </button>
                        </form>
                    @endif

                    @if($booking->status->value === 'ongoing')
                        <form method="POST" action="{{ route('admin.booking.updateStatus', $booking) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Selesaikan
                            </button>
                        </form>
                    @endif

                    @if(!in_array($booking->status->value, ['completed', 'cancelled']))
                        <form method="POST" action="{{ route('admin.booking.updateStatus', $booking) }}" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-red-200 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batalkan
                            </button>
                        </form>
                    @endif

                    @if(in_array($booking->status->value, ['completed', 'cancelled']))
                        <p class="text-sm text-gray-400 text-center py-2">Tidak ada aksi tersedia</p>
                    @endif
                </div>
            </div>

            {{-- Pembayaran --}}
            @if($booking->pembayaran)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Pembayaran</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Metode</span>
                        <span class="font-medium text-gray-800">{{ $booking->pembayaran->metode->label() }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Jumlah</span>
                        <span class="font-medium text-gray-800">Rp {{ number_format($booking->pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Status</span>
                        @php
                            $payColors = [
                                'belum_bayar' => 'bg-gray-50 text-gray-700 border-gray-200',
                                'menunggu_verifikasi' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'lunas' => 'bg-green-50 text-green-700 border-green-200',
                                'refund' => 'bg-orange-50 text-orange-700 border-orange-200',
                                'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                            ];
                        @endphp
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $payColors[$booking->pembayaran->status->value] ?? '' }}">
                            {{ $booking->pembayaran->status->label() }}
                        </span>
                    </div>
                    <a href="{{ route('admin.pembayaran.show', $booking->pembayaran) }}" class="block text-center text-sm text-primary-500 hover:text-primary-600 font-medium pt-2">
                        Lihat Detail Pembayaran
                    </a>
                </div>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-2">Pembayaran</h2>
                <p class="text-sm text-gray-400">Belum ada pembayaran.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
