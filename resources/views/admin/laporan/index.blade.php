@extends('layouts.admin')
@section('content')
<style>
    .fade-in { opacity: 0; animation: fadeSlideIn 0.4s ease-out forwards; }
    @keyframes fadeSlideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.1s; }
    .stagger-3 { animation-delay: 0.15s; }
    .stagger-4 { animation-delay: 0.2s; }
</style>
<div class="space-y-6">
    <h1 class="text-headline-md text-on-surface fade-in stagger-1">Laporan</h1>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-4 fade-in stagger-1">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col sm:flex-row gap-3">
            <select name="bulan" class="px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('bulan', date('m')) == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month((int) $m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <select name="tahun" class="px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                @foreach(range(date('Y') - 2, date('Y') + 1) as $y)
                    <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl hover:opacity-90 transition-all">Tampilkan</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 fade-in stagger-2">
        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/20">
            <p class="text-label-md text-on-surface-variant">Total Pendapatan</p>
            <p class="text-headline-md font-bold text-status-success mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/20">
            <p class="text-label-md text-on-surface-variant">Total Booking Selesai</p>
            <p class="text-headline-md font-bold text-on-surface mt-1">{{ $totalBooking }}</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/20">
            <p class="text-label-md text-on-surface-variant">Rata-rata per Booking</p>
            <p class="text-headline-md font-bold text-on-surface mt-1">{{ $totalBooking > 0 ? 'Rp ' . number_format($totalPendapatan / $totalBooking, 0, ',', '.') : 'Rp 0' }}</p>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6 fade-in stagger-3">
        <h2 class="text-label-lg text-on-surface mb-4">Pendapatan 6 Bulan Terakhir</h2>
        <canvas id="laporanChart" height="200"></canvas>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 fade-in stagger-4">
        <div class="px-6 py-4 border-b border-outline-variant/10">
            <h2 class="text-label-lg text-on-surface">Daftar Booking Selesai - {{ \Carbon\Carbon::create()->month((int) request('bulan', date('m')))->translatedFormat('F') }} {{ request('tahun', date('Y')) }}</h2>
        </div>
        <div class="overflow-x-auto">
            @if(!isset($laporanData) || $laporanData->isEmpty())
                <div class="p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-outline-variant/50 mx-auto mb-4 block">bar_chart</span>
                    <h3 class="font-bold text-on-surface-variant mb-1">Tidak ada data</h3>
                    <p class="text-body-md text-on-surface-variant">Belum ada booking selesai di periode ini.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-caption-caps text-on-surface-variant uppercase tracking-wider bg-surface-container-low">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Kendaraan</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Durasi</th>
                            <th class="px-6 py-3">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @php $grandTotal = 0; @endphp
                        @foreach($laporanData as $booking)
                            @php $grandTotal += $booking->grand_total; @endphp
                            <tr class="hover:bg-surface-container/50 transition-colors duration-150">
                                <td class="px-6 py-3 text-body-md text-on-surface-variant">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-3 text-body-md font-medium text-on-surface">{{ $booking->user->name ?? '-' }}</td>
                                <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ $booking->kendaraan->nama_kendaraan ?? '-' }}</td>
                                <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}</td>
                                <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ $booking->durasi_hari }} hari</td>
                                <td class="px-6 py-3 text-body-md font-medium text-status-success">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-surface-container-low">
                            <td colspan="5" class="px-6 py-3 text-body-md font-semibold text-on-surface text-right">Total</td>
                            <td class="px-6 py-3 text-body-md font-bold text-status-success">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('laporanChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels ?? []) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($chartData ?? []) !!},
                    backgroundColor: '#1e3a5f',
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                                if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'rb';
                                return 'Rp ' + value;
                            }
                        },
                        grid: { color: '#e0e3e5' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection
