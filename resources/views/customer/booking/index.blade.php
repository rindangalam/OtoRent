@extends('layouts.customer')

@section('title', 'Riwayat Booking')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">Riwayat Booking</h1>
            <p class="text-on-surface-variant mt-1">Daftar semua penyewaan kendaraan Anda.</p>
        </div>
        <a href="{{ route('booking.create') }}" class="inline-flex items-center px-4 py-2 bg-accent-500 text-white text-sm font-medium rounded-lg hover:bg-accent-600 transition">
            + Booking Baru
        </a>
    </div>

    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-outline-variant/10 bg-surface-container-low">
                        <th class="text-left px-6 py-3 font-medium text-on-surface-variant">#</th>
                        <th class="text-left px-6 py-3 font-medium text-on-surface-variant">Kendaraan</th>
                        <th class="text-left px-6 py-3 font-medium text-on-surface-variant">Tanggal Sewa</th>
                        <th class="text-left px-6 py-3 font-medium text-on-surface-variant">Durasi</th>
                        <th class="text-right px-6 py-3 font-medium text-on-surface-variant">Total</th>
                        <th class="text-left px-6 py-3 font-medium text-on-surface-variant">Status</th>
                        <th class="text-center px-6 py-3 font-medium text-on-surface-variant">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr class="border-b border-outline-variant/10 hover:bg-surface-container-high transition">
                            <td class="px-6 py-4 font-medium text-on-surface">#{{ $booking->id }}</td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $booking->kendaraan->nama_kendaraan }}</td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $booking->tanggal_mulai->format('d M Y') }} - {{ $booking->tanggal_selesai->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $booking->durasi_hari }} hari</td>
                            <td class="px-6 py-4 text-right text-on-surface font-medium">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $colors = [
                                        'pending' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                                        'confirmed' => 'bg-status-info/10 text-status-info border-status-info/20',
                                        'ongoing' => 'bg-primary/10 text-primary border-primary/20',
                                        'completed' => 'bg-status-success/10 text-status-success border-status-success/20',
                                        'cancelled' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
                                    ];
                                    $color = $colors[$booking->status->value] ?? 'bg-surface-container-high/10 text-on-surface-variant border-outline-variant/20';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $color }}">{{ $booking->status->label() }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('booking.show', $booking) }}" class="text-accent-500 hover:text-accent-600 font-medium text-sm">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-on-surface-variant/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p>Belum ada riwayat booking.</p>
                                    <a href="{{ route('booking.create') }}" class="text-accent-500 hover:text-accent-600 font-medium text-sm">Booking sekarang</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($bookings->hasPages())
            <div class="px-6 py-4 border-t border-outline-variant/10">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
@endsection
