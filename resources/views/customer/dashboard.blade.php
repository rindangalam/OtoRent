@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-500 mt-1">Kelola penyewaan kendaraan Anda di sini.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Booking Aktif</p>
                    <p class="text-3xl font-bold text-primary-500 mt-1">{{ $activeBookings }}</p>
                </div>
                <div class="w-12 h-12 bg-primary-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Sedang Disewa</p>
                    <p class="text-3xl font-bold text-indigo-500 mt-1">{{ $ongoingCount }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Selesai</p>
                    <p class="text-3xl font-bold text-green-500 mt-1">{{ $completedCount }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Booking Terakhir</h2>
            <a href="{{ route('booking.create') }}" class="inline-flex items-center px-4 py-2 bg-accent-500 text-white text-sm font-medium rounded-lg hover:bg-accent-600 transition">
                + Buat Booking Baru
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-6 py-3 font-medium text-gray-500">#</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Kendaraan</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Tanggal</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Status</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-500">Total</th>
                        <th class="text-center px-6 py-3 font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentBookings as $booking)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $booking->id }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $booking->kendaraan->nama_kendaraan }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $booking->tanggal_mulai->format('d M') }} - {{ $booking->tanggal_selesai->format('d M Y') }}</td>
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
                            <td class="px-6 py-4 text-right text-gray-900 font-medium">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('booking.show', $booking) }}" class="text-primary-500 hover:text-primary-600 font-medium text-sm">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p>Belum ada booking.</p>
                                    <a href="{{ route('booking.create') }}" class="text-primary-500 hover:text-primary-600 font-medium text-sm">Booking sekarang</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
