@extends('layouts.admin')
@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.pembayaran.index') }}" class="text-on-surface-variant hover:text-on-surface transition">
            <span class="material-symbols-outlined text-[24px]">arrow_back</span>
        </a>
        <h1 class="text-headline-md text-on-surface">Detail Pembayaran</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info Pembayaran --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h2 class="text-label-lg text-on-surface mb-4">Informasi Pembayaran</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Booking</p>
                        <p class="text-body-md font-medium text-on-surface">#{{ str_pad($pembayaran->booking_id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Customer</p>
                        <p class="text-body-md font-medium text-on-surface">{{ $pembayaran->booking->user->name ?? '-' }}</p>
                        <p class="text-body-md text-on-surface-variant">{{ $pembayaran->booking->user->email ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Jumlah Bayar</p>
                        <p class="text-headline-md font-bold text-secondary-container">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Metode Pembayaran</p>
                        <p class="text-body-md font-medium text-on-surface">{{ $pembayaran->metode->label() }}</p>
                    </div>
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Tanggal Bayar</p>
                        <p class="text-body-md font-medium text-on-surface">{{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y, H:i') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-caption-caps text-on-surface-variant mb-1">Status</p>
                        @php
                            $payColors = [
                                'belum_bayar' => 'bg-surface-container-high text-on-surface-variant border-outline-variant/20',
                                'menunggu_verifikasi' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                                'lunas' => 'bg-status-success/10 text-status-success border-status-success/20',
                                'refund' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                                'ditolak' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
                            ];
                        @endphp
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $payColors[$pembayaran->status->value] ?? '' }}">
                            {{ $pembayaran->status->label() }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Bukti Bayar --}}
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h2 class="text-label-lg text-on-surface mb-4">Bukti Bayar</h2>
                @if($pembayaran->bukti_bayar)
                    <div class="rounded-xl overflow-hidden border border-outline-variant/20">
                        <img src="{{ asset('storage/uploads/bukti-bayar/' . $pembayaran->bukti_bayar) }}" alt="Bukti Bayar" class="w-full max-w-md">
                    </div>
                @else
                    <div class="p-8 text-center bg-surface-container rounded-xl border border-dashed border-outline-variant/30">
                        <span class="material-symbols-outlined text-5xl text-outline-variant/50 mx-auto mb-3 block">image</span>
                        <p class="text-body-md text-on-surface-variant">Belum ada bukti bayar</p>
                    </div>
                @endif
            </div>

            {{-- Catatan Admin --}}
            @if($pembayaran->catatan_admin)
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h2 class="text-label-lg text-on-surface mb-2">Catatan Admin</h2>
                <p class="text-body-md text-on-surface-variant">{{ $pembayaran->catatan_admin }}</p>
            </div>
            @endif
        </div>

        {{-- Sidebar Aksi --}}
        <div class="space-y-6">
            @if($pembayaran->status->value === 'menunggu_verifikasi')
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h2 class="text-label-lg text-on-surface mb-4">Verifikasi Pembayaran</h2>
                <div class="space-y-3">
                    <form method="POST" action="{{ route('admin.pembayaran.verifikasi', $pembayaran) }}">
                        @csrf
                        @method('PUT')
                        <textarea name="catatan_admin" rows="2" placeholder="Catatan admin (opsional)..."
                            class="w-full px-3 py-2 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md outline-none transition mb-3"></textarea>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-status-success text-on-primary text-label-md rounded-xl transition">
                            <span class="material-symbols-outlined text-[18px]">check</span>
                            Verifikasi
                        </button>
                    </form>

                    <div x-data="{ showReject: false }">
                        <button @click="showReject = !showReject" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-surface-container border border-outline-variant/20 text-status-danger text-label-md rounded-xl transition">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                            Tolak
                        </button>

                        <div x-show="showReject" x-transition x-cloak class="mt-3">
                            <form method="POST" action="{{ route('admin.pembayaran.tolak', $pembayaran) }}">
                                @csrf
                                @method('PUT')
                                <textarea name="catatan_admin" rows="3" required placeholder="Alasan penolakan..."
                                    class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md outline-none transition mb-3"></textarea>
                                @error('catatan_admin') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                                <button type="submit" class="w-full px-4 py-2.5 bg-status-danger text-on-primary text-label-md rounded-xl transition" onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                                    Konfirmasi Penolakan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h2 class="text-label-lg text-on-surface mb-4">Info Booking</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-body-md">
                        <span class="text-on-surface-variant">Kendaraan</span>
                        <span class="font-medium text-on-surface">{{ $pembayaran->booking->kendaraan->nama_kendaraan ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-body-md">
                        <span class="text-on-surface-variant">Grand Total</span>
                        <span class="font-medium text-on-surface">Rp {{ number_format($pembayaran->booking->grand_total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('admin.booking.show', $pembayaran->booking) }}" class="block text-center text-body-md text-secondary-container hover:text-secondary font-medium pt-2">
                        Lihat Detail Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
