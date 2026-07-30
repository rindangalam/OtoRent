@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<style>
    .dash-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .dash-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -6px rgba(2, 36, 72, 0.1);
    }
    .fade-in {
        opacity: 0;
        animation: fadeSlideIn 0.5s ease-out forwards;
    }
    @keyframes fadeSlideIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.1s; }
    .stagger-3 { animation-delay: 0.15s; }
    .stagger-4 { animation-delay: 0.2s; }
</style>

<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="dash-card bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/20 fade-in stagger-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-on-surface-variant">Total Kendaraan</p>
                    <p class="text-2xl font-bold text-primary mt-1">{{ $totalKendaraan }}</p>
                </div>
                <div class="w-12 h-12 bg-primary-fixed text-primary rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined">directions_car</span>
                </div>
            </div>
        </div>

        <div class="dash-card bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/20 fade-in stagger-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-on-surface-variant">Booking Aktif</p>
                    <p class="text-2xl font-bold text-primary mt-1">{{ $activeBookings }}</p>
                </div>
                <div class="w-12 h-12 bg-secondary-fixed text-secondary rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined">event_available</span>
                </div>
            </div>
        </div>

        <div class="dash-card bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/20 fade-in stagger-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-on-surface-variant">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold text-primary mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-status-success/10 text-status-success rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined">payments</span>
                </div>
            </div>
        </div>

        <div class="dash-card bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/20 fade-in stagger-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-on-surface-variant">Service Pending</p>
                    <p class="text-2xl font-bold text-primary mt-1">{{ $pendingService }}</p>
                </div>
                <div class="w-12 h-12 bg-status-danger/10 text-status-danger rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined">build</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 fade-in stagger-3">
            <div class="px-6 py-4 border-b border-outline-variant/20 flex justify-between items-center">
                <h2 class="font-headline-md text-headline-md text-primary">Booking Terbaru</h2>
                <a href="{{ route('admin.booking.index') }}" class="text-label-md text-primary hover:text-secondary-container transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                @if($recentBookings->isEmpty())
                    <div class="p-12 text-center">
                        <span class="material-symbols-outlined text-5xl text-outline-variant/50 block mb-3">event_busy</span>
                        <p class="text-body-md text-on-surface-variant">Belum ada booking</p>
                    </div>
                @else
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-caption-caps text-on-surface-variant uppercase tracking-wider bg-surface-container-low">
                                <th class="px-6 py-3">Customer</th>
                                <th class="px-6 py-3">Kendaraan</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            @foreach($recentBookings as $booking)
                            <tr class="hover:bg-surface-container-low/50 transition-colors duration-150">
                                <td class="px-6 py-3">
                                    <span class="text-sm font-medium text-on-surface">{{ $booking->user->name ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="text-sm text-on-surface-variant">{{ $booking->kendaraan->nama_kendaraan ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="text-sm font-medium text-on-surface">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    @php
                                        $statusStyles = [
                                            'pending' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                                            'confirmed' => 'bg-status-info/10 text-status-info border-status-info/20',
                                            'ongoing' => 'bg-status-info/10 text-status-info border-status-info/20',
                                            'completed' => 'bg-status-success/10 text-status-success border-status-success/20',
                                            'cancelled' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
                                        ];
                                        $style = $statusStyles[$booking->status->value] ?? 'bg-surface-container-low text-on-surface-variant';
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $style }}">
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

        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 fade-in stagger-4">
            <div class="px-6 py-4 border-b border-outline-variant/20">
                <h2 class="font-headline-md text-headline-md text-primary">Status Kendaraan</h2>
            </div>
            <div class="p-6">
                <canvas id="statusKendaraanChart" height="220"></canvas>
                <div class="mt-4 space-y-2">
                    @foreach(['tersedia' => 'Tersedia', 'disewa' => 'Disewa', 'service' => 'Servis'] as $val => $label)
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full {{ $val === 'tersedia' ? 'bg-status-success' : ($val === 'disewa' ? 'bg-status-info' : 'bg-status-warning') }}"></span>
                                <span class="text-on-surface-variant">{{ $label }}</span>
                            </div>
                            <span class="font-semibold text-on-surface">{{ $statusKendaraan[$val] ?? 0 }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
                    backgroundColor: ['#22c55e', '#3b82f6', '#f59e0b'],
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
