@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Booking</h1>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.booking.index') }}" class="flex flex-col sm:flex-row gap-3">
            <select name="status" class="sm:w-48 px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                <option value="">Semua Status</option>
                @foreach(\App\Enums\StatusBooking::cases() as $status)
                    <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Filter</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            @if($bookings->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600 mb-1">Belum ada booking</h3>
                    <p class="text-sm text-gray-400">Booking akan muncul di sini setelah customer melakukan pemesanan.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50/50">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Kendaraan</th>
                            <th class="px-6 py-3">Driver</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Durasi</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50/50 cursor-pointer" onclick="window.location='{{ route('admin.booking.show', $booking) }}'">
                            <td class="px-6 py-3 text-sm text-gray-500">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $booking->user->name ?? '-' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $booking->kendaraan->nama_kendaraan ?? '-' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $booking->driver->nama_driver ?? 'Lepas Kunci' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $booking->durasi_hari }} hari</td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $bookings->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
