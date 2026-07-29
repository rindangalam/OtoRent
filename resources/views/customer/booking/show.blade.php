@extends('layouts.customer')

@section('title', 'Booking #' . $booking->id)

@section('content')
    <div class="mb-6">
        <a href="{{ route('booking.index') }}" class="inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-accent-500 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-on-surface">Booking #{{ $booking->id }}</h1>
        @php
            $statusColors = [
                'pending' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                'confirmed' => 'bg-status-info/10 text-status-info border-status-info/20',
                'ongoing' => 'bg-primary/10 text-primary border-primary/20',
                'completed' => 'bg-status-success/10 text-status-success border-status-success/20',
                'cancelled' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
            ];
            $sColor = $statusColors[$booking->status->value] ?? 'bg-surface-container-high/10 text-on-surface-variant border-outline-variant/20';
        @endphp
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $sColor }}">{{ $booking->status->label() }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6">
            <h2 class="text-lg font-semibold text-on-surface mb-4">Info Booking</h2>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-sm text-on-surface-variant">Kendaraan</dt>
                    <dd class="text-sm font-medium text-on-surface">{{ $booking->kendaraan->nama_kendaraan }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-on-surface-variant">Tipe Sewa</dt>
                    <dd class="text-sm font-medium text-on-surface">
                        @if ($booking->tipe_sewa === 'driver')
                            Pakai Driver
                        @else
                            Lepas Kunci
                            @if ($booking->metode_antar)
                                <span class="text-on-surface-variant">— {{ $booking->metode_antar === 'diantar' ? 'Mobil Diantar' : 'Jemput Sendiri' }}</span>
                            @endif
                        @endif
                    </dd>
                </div>
                @if ($booking->tipe_sewa === 'driver' && $booking->driver)
                    <div class="flex justify-between">
                        <dt class="text-sm text-on-surface-variant">Driver</dt>
                        <dd class="text-sm font-medium text-on-surface">{{ $booking->driver->nama_driver }}</dd>
                    </div>
                @endif
                <div class="flex justify-between">
                    <dt class="text-sm text-on-surface-variant">Tanggal Mulai</dt>
                    <dd class="text-sm font-medium text-on-surface">{{ $booking->tanggal_mulai->format('d M Y') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-on-surface-variant">Tanggal Selesai</dt>
                    <dd class="text-sm font-medium text-on-surface">{{ $booking->tanggal_selesai->format('d M Y') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-on-surface-variant">Durasi</dt>
                    <dd class="text-sm font-medium text-on-surface">{{ $booking->durasi_hari }} hari</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-on-surface-variant">
                        @if ($booking->tipe_sewa === 'driver')
                            Lokasi Jemput
                        @elseif ($booking->metode_antar === 'diantar')
                            Lokasi Pengantaran
                        @else
                            Alamat Lokasi Rental
                        @endif
                    </dt>
                    <dd class="text-sm font-medium text-on-surface">{{ $booking->lokasi_jemput }}</dd>
                </div>
                @if ($booking->lokasi_tujuan)
                    <div class="flex justify-between">
                        <dt class="text-sm text-on-surface-variant">Lokasi Tujuan</dt>
                        <dd class="text-sm font-medium text-on-surface">{{ $booking->lokasi_tujuan }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="space-y-6">
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6">
                <h2 class="text-lg font-semibold text-on-surface mb-4">Ringkasan Biaya</h2>
                <dl class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <dt class="text-on-surface-variant">Kendaraan ({{ $booking->durasi_hari }} hari)</dt>
                        <dd class="font-medium text-on-surface">Rp {{ number_format($booking->total_kendaraan, 0, ',', '.') }}</dd>
                    </div>
                    @if ($booking->total_driver > 0)
                        <div class="flex justify-between text-sm">
                            <dt class="text-on-surface-variant">Driver ({{ $booking->durasi_hari }} hari)</dt>
                            <dd class="font-medium text-on-surface">Rp {{ number_format($booking->total_driver, 0, ',', '.') }}</dd>
                        </div>
                    @endif
                    @if ($booking->ongkos_antar > 0)
                        <div class="flex justify-between text-sm">
                            <dt class="text-on-surface-variant">Ongkos Antar</dt>
                            <dd class="font-medium text-on-surface">Rp {{ number_format($booking->ongkos_antar, 0, ',', '.') }}</dd>
                        </div>
                    @endif
                    <div class="border-t border-outline-variant/20 pt-3 flex justify-between">
                        <dt class="font-semibold text-on-surface">Grand Total</dt>
                        <dd class="font-bold text-accent-500 text-lg">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6">
                <h2 class="text-lg font-semibold text-on-surface mb-4">Status Pembayaran</h2>
                @php
                    $payment = $booking->pembayaran;
                @endphp
                @if (!$payment)
                    <div class="text-center py-4">
                        <p class="text-on-surface-variant mb-4">Belum melakukan pembayaran</p>
                        <a href="{{ route('pembayaran.create', $booking) }}" class="inline-flex items-center px-6 py-3 bg-accent-500 text-white text-sm font-medium rounded-lg hover:bg-accent-600 transition">
                            Bayar Sekarang
                        </a>
                    </div>
                @elseif ($payment->status->value === 'menunggu_verifikasi')
                    <div class="flex items-center gap-3 p-4 bg-status-warning/10 border border-status-warning/20 rounded-lg">
                        <svg class="w-5 h-5 text-status-warning shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-status-warning">Menunggu Verifikasi</p>
                            <p class="text-xs text-status-warning mt-0.5">Bukti bayar sedang diperiksa admin.</p>
                        </div>
                    </div>
                @elseif ($payment->status->value === 'lunas')
                    <div class="flex items-center gap-3 p-4 bg-status-success/10 border border-status-success/20 rounded-lg">
                        <svg class="w-5 h-5 text-status-success shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-status-success">Lunas</p>
                            <p class="text-xs text-status-success mt-0.5">Pembayaran telah diverifikasi.</p>
                        </div>
                    </div>
                @elseif ($payment->status->value === 'ditolak')
                    <div class="text-center py-4 space-y-4">
                        <div class="flex items-center gap-3 p-4 bg-status-danger/10 border border-status-danger/20 rounded-lg">
                            <svg class="w-5 h-5 text-status-danger shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <div class="text-left">
                                <p class="text-sm font-medium text-status-danger">Pembayaran Ditolak</p>
                                @if ($payment->catatan_admin)
                                    <p class="text-xs text-status-danger mt-0.5">{{ $payment->catatan_admin }}</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('pembayaran.create', $booking) }}" class="inline-flex items-center px-6 py-3 bg-accent-500 text-white text-sm font-medium rounded-lg hover:bg-accent-600 transition">
                            Upload Ulang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($booking->catatan)
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6">
            <h2 class="text-lg font-semibold text-on-surface mb-2">Catatan</h2>
            <p class="text-sm text-on-surface-variant">{{ $booking->catatan }}</p>
        </div>
    @endif
@endsection
