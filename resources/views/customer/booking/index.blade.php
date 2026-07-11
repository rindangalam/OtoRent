@extends('layouts.customer')

@section('title', 'Riwayat Booking')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Booking</h1>
            <p class="text-gray-500 mt-1">Daftar semua penyewaan kendaraan Anda.</p>
        </div>
        <a href="{{ route('booking.create') }}" class="inline-flex items-center px-4 py-2 bg-accent-500 text-white text-sm font-medium rounded-lg hover:bg-accent-600 transition">
            + Booking Baru
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-6 py-3 font-medium text-gray-500">#</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Kendaraan</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Tanggal Sewa</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Durasi</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-500">Total</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Status</th>
                        <th class="text-center px-6 py-3 font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $booking->id }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $booking->kendaraan->nama_kendaraan }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $booking->tanggal_mulai->format('d M Y') }} - {{ $booking->tanggal_selesai->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $booking->durasi_hari }} hari</td>
                            <td class="px-6 py-4 text-right text-gray-900 font-medium">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $colors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'confirmed' => 'bg-blue-100 text-blue-700',
                                        'ongoing' => 'bg-indigo-100 text-indigo-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                    $color = $colors[$booking->status->value] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">{{ $booking->status->label() }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('booking.show', $booking) }}" class="text-primary-500 hover:text-primary-600 font-medium text-sm">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p>Belum ada riwayat booking.</p>
                                    <a href="{{ route('booking.create') }}" class="text-primary-500 hover:text-primary-600 font-medium text-sm">Booking sekarang</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($bookings->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
@endsection
