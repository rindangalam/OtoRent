@extends('layouts.admin')
@section('title', 'Detail Booking')
@section('content')
<style>
    .fade-in { opacity: 0; animation: fadeSlideIn 0.4s ease-out forwards; }
    @keyframes fadeSlideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.1s; }
    .stagger-3 { animation-delay: 0.15s; }
</style>
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-3 fade-in stagger-1">
        <a href="{{ route('admin.booking.index') }}" class="text-on-surface-variant hover:text-on-surface transition">
            <span class="material-symbols-outlined text-[24px]">arrow_back</span>
        </a>
        <h1 class="text-headline-md text-on-surface">Booking #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h1>
        @php
            $statusColors = [
                'pending' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                'confirmed' => 'bg-status-info/10 text-status-info border-status-info/20',
                'ongoing' => 'bg-status-info/10 text-status-info border-status-info/20',
                'completed' => 'bg-status-success/10 text-status-success border-status-success/20',
                'cancelled' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
            ];
        @endphp
        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusColors[$booking->status->value] ?? '' }}">
            {{ $booking->status->label() }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6 fade-in stagger-2">
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h2 class="text-label-lg text-on-surface mb-4">Informasi Booking</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Customer</p>
                        <p class="text-body-md font-medium text-on-surface">{{ $booking->user->name ?? '-' }}</p>
                        <p class="text-body-md text-on-surface-variant">{{ $booking->user->email ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Kendaraan</p>
                        <p class="text-body-md font-medium text-on-surface">{{ $booking->kendaraan->nama_kendaraan ?? '-' }}</p>
                        <p class="text-body-md text-on-surface-variant">{{ $booking->kendaraan->plat_nomor ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Tipe Sewa</p>
                        <p class="text-body-md font-medium text-on-surface">
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
                        <p class="text-caption-caps text-on-surface-variant mb-1">Driver</p>
                        <p class="text-body-md font-medium text-on-surface">{{ $booking->driver->nama_driver ?? '-' }}</p>
                        @if($booking->driver)
                            <p class="text-body-md text-on-surface-variant">{{ $booking->driver->no_telp }}</p>
                        @endif
                    </div>
                    @endif
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Durasi</p>
                        <p class="text-body-md font-medium text-on-surface">{{ $booking->durasi_hari }} hari</p>
                    </div>
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Tanggal Mulai</p>
                        <p class="text-body-md font-medium text-on-surface">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Tanggal Selesai</p>
                        <p class="text-body-md font-medium text-on-surface">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-caption-caps text-on-surface-variant mb-1">
                            @if ($booking->tipe_sewa === 'driver')
                                Lokasi Jemput
                            @elseif ($booking->metode_antar === 'diantar')
                                Lokasi Pengantaran
                            @else
                                Alamat Lokasi Rental
                            @endif
                        </p>
                        <p class="text-body-md font-medium text-on-surface">{{ $booking->lokasi_jemput }}</p>
                    </div>
                    @if($booking->lokasi_tujuan)
                    <div class="sm:col-span-2">
                        <p class="text-caption-caps text-on-surface-variant mb-1">Lokasi Tujuan</p>
                        <p class="text-body-md font-medium text-on-surface">{{ $booking->lokasi_tujuan }}</p>
                    </div>
                    @endif
                    @if($booking->catatan)
                    <div class="sm:col-span-2">
                        <p class="text-caption-caps text-on-surface-variant mb-1">Catatan</p>
                        <p class="text-body-md text-on-surface-variant">{{ $booking->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h2 class="text-label-lg text-on-surface mb-4">Ringkasan Biaya</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-body-md">
                        <span class="text-on-surface-variant">Kendaraan ({{ $booking->durasi_hari }} hari &times; Rp {{ number_format($booking->kendaraan->harga_sewa_per_hari ?? 0, 0, ',', '.') }})</span>
                        <span class="font-medium text-on-surface">Rp {{ number_format($booking->total_kendaraan, 0, ',', '.') }}</span>
                    </div>
                    @if($booking->total_driver > 0)
                    <div class="flex items-center justify-between text-body-md">
                        <span class="text-on-surface-variant">Driver ({{ $booking->durasi_hari }} hari &times; Rp {{ number_format($booking->driver->tarif_per_hari ?? 0, 0, ',', '.') }})</span>
                        <span class="font-medium text-on-surface">Rp {{ number_format($booking->total_driver, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($booking->ongkos_antar > 0)
                    <div class="flex items-center justify-between text-body-md">
                        <span class="text-on-surface-variant">Ongkos Antar</span>
                        <span class="font-medium text-on-surface">Rp {{ number_format($booking->ongkos_antar, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="border-t border-outline-variant/10 pt-3 flex items-center justify-between">
                        <span class="text-label-lg font-semibold text-on-surface">Grand Total</span>
                        <span class="text-headline-md font-bold text-secondary-container">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6 fade-in stagger-3">
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h2 class="text-label-lg text-on-surface mb-4">Ubah Status</h2>
                <div class="space-y-3">
                    @if($booking->status->value === 'pending')
                        <form method="POST" action="{{ route('admin.booking.updateStatus', $booking) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-status-info text-on-primary text-label-md rounded-xl hover:opacity-90 transition-all">
                                <span class="material-symbols-outlined text-[18px]">check</span>
                                Konfirmasi Booking
                            </button>
                        </form>
                    @endif

                    @if($booking->status->value === 'confirmed')
                        <form method="POST" action="{{ route('admin.booking.updateStatus', $booking) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="ongoing">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-status-info text-on-primary text-label-md rounded-xl hover:opacity-90 transition-all">
                                <span class="material-symbols-outlined text-[18px]">play_arrow</span>
                                Mulai Sewa
                            </button>
                        </form>
                    @endif

                    @if($booking->status->value === 'ongoing')
                        <form method="POST" action="{{ route('admin.booking.updateStatus', $booking) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-status-success text-on-primary text-label-md rounded-xl hover:opacity-90 transition-all">
                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                Selesaikan
                            </button>
                        </form>
                    @endif

                    @if(!in_array($booking->status->value, ['completed', 'cancelled']))
                        <form method="POST" action="{{ route('admin.booking.updateStatus', $booking) }}" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-surface-container border border-outline-variant/20 text-status-danger text-label-md rounded-xl hover:bg-status-danger/10 transition-all">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                                Batalkan
                            </button>
                        </form>
                    @endif

                    @if(in_array($booking->status->value, ['completed', 'cancelled']))
                        <p class="text-body-md text-on-surface-variant text-center py-2">Tidak ada aksi tersedia</p>
                    @endif
                </div>
            </div>

            @if($booking->pembayaran)
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h2 class="text-label-lg text-on-surface mb-4">Pembayaran</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-body-md">
                        <span class="text-on-surface-variant">Metode</span>
                        <span class="font-medium text-on-surface">{{ $booking->pembayaran->metode->label() }}</span>
                    </div>
                    <div class="flex items-center justify-between text-body-md">
                        <span class="text-on-surface-variant">Jumlah</span>
                        <span class="font-medium text-on-surface">Rp {{ number_format($booking->pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-body-md">
                        <span class="text-on-surface-variant">Status</span>
                        @php
                            $payColors = [
                                'belum_bayar' => 'bg-surface-container-high text-on-surface-variant border-outline-variant/20',
                                'menunggu_verifikasi' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                                'lunas' => 'bg-status-success/10 text-status-success border-status-success/20',
                                'refund' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                                'ditolak' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
                            ];
                        @endphp
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $payColors[$booking->pembayaran->status->value] ?? '' }}">
                            {{ $booking->pembayaran->status->label() }}
                        </span>
                    </div>
                    <a href="{{ route('admin.pembayaran.show', $booking->pembayaran) }}" class="block text-center text-body-md text-secondary-container hover:text-secondary font-medium pt-2">
                        Lihat Detail Pembayaran
                    </a>
                </div>
            </div>
            @else
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h2 class="text-label-lg text-on-surface mb-2">Pembayaran</h2>
                <p class="text-body-md text-on-surface-variant">Belum ada pembayaran.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
