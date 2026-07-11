@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Kendaraan</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalKendaraan }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17h8M8 17v-4h8v4M8 17H5a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v4a2 2 0 01-2 2h-3m-8 0H5" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Booking Aktif</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $activeBookings }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Service Pending</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingService }}</p>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Bookings --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Booking Terbaru</h2>
            </div>
            <div class="overflow-x-auto">
                @if($recentBookings->isEmpty())
                    <div class="p-8 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-sm text-gray-500">Belum ada booking</p>
                    </div>
                @else
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">Customer</th>
                                <th class="px-6 py-3">Kendaraan</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentBookings as $booking)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3">
                                    <span class="text-sm font-medium text-gray-800">{{ $booking->user->name ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="text-sm text-gray-600">{{ $booking->kendaraan->nama_kendaraan ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="text-sm font-medium text-gray-800">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    @php
                                        $status = $booking->status->value;
                                        $colors = [
                                            'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                            'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'ongoing' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            'completed' => 'bg-green-50 text-green-700 border-green-200',
                                            'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colors[$status] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                        {{ $booking->status->label() }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- Status Kendaraan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Status Kendaraan</h2>
            </div>
            <div class="p-6">
                <canvas id="statusKendaraanChart" height="220"></canvas>
                <div class="mt-4 space-y-2">
                    @foreach(['tersedia' => 'Tersedia', 'disewa' => 'Disewa', 'service' => 'Servis'] as $val => $label)
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full {{ $val === 'tersedia' ? 'bg-green-400' : ($val === 'disewa' ? 'bg-blue-400' : 'bg-yellow-400') }}"></span>
                                <span class="text-gray-600">{{ $label }}</span>
                            </div>
                            <span class="font-semibold text-gray-800">{{ $statusKendaraan[$val] ?? 0 }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('statusKendaraanChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Disewa', 'Servis'],
                datasets: [{
                    data: [{{ $statusKendaraan['tersedia'] ?? 0 }}, {{ $statusKendaraan['disewa'] ?? 0 }}, {{ $statusKendaraan['service'] ?? 0 }}],
                    backgroundColor: ['#4ade80', '#60a5fa', '#facc15'],
                    borderWidth: 0,
                    borderRadius: 4,
                    spacing: 2,
                }]
            },
            options: {
                responsive: true,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                },
            }
        });
    }
});
</script>
@endpush
@endsection
