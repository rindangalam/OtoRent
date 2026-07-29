@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-headline-md text-on-surface">Booking</h1>
    </div>

    {{-- Filter --}}
    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-4">
        <form method="GET" action="{{ route('admin.booking.index') }}" class="flex flex-col sm:flex-row gap-3">
            <select name="status" class="sm:w-48 px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                <option value="">Semua Status</option>
                @foreach(\App\Enums\StatusBooking::cases() as $status)
                    <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 bg-surface-container text-on-surface-variant text-label-md rounded-xl transition">Filter</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20">
        <div class="overflow-x-auto">
            @if($bookings->isEmpty())
                <div class="p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-outline-variant/50 mx-auto mb-4 block">book_online</span>
                    <h3 class="text-label-lg text-on-surface-variant mb-1">Belum ada booking</h3>
                    <p class="text-body-md text-on-surface-variant">Booking akan muncul di sini setelah customer melakukan pemesanan.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-caption-caps text-on-surface-variant bg-surface-container-low">
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
                    <tbody class="divide-y divide-outline-variant/10">
                        @foreach($bookings as $booking)
                        <tr class="hover:bg-surface-container/50 cursor-pointer" onclick="window.location='{{ route('admin.booking.show', $booking) }}'">
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-3 text-body-md font-medium text-on-surface">{{ $booking->user->name ?? '-' }}</td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ $booking->kendaraan->nama_kendaraan ?? '-' }}</td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ $booking->driver->nama_driver ?? 'Lepas Kunci' }}</td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">
                                {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ $booking->durasi_hari }} hari</td>
                            <td class="px-6 py-3 text-body-md font-medium text-on-surface">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10">
            {{ $bookings->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
