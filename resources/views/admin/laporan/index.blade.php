@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Laporan</h1>

    {{-- Filter Bulan/Tahun --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col sm:flex-row gap-3">
            <select name="bulan" class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('bulan', date('m')) == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month((int) $m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <select name="tahun" class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                @foreach(range(date('Y') - 2, date('Y') + 1) as $y)
                    <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">Tampilkan</button>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
            <p class="text-2xl font-bold text-green-600 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-sm font-medium text-gray-500">Total Booking Selesai</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBooking }}</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <p class="text-sm font-medium text-gray-500">Rata-rata per Booking</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBooking > 0 ? 'Rp ' . number_format($totalPendapatan / $totalBooking, 0, ',', '.') : 'Rp 0' }}</p>
        </div>
    </div>

    {{-- Chart --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-4">Pendapatan 6 Bulan Terakhir</h2>
        <canvas id="laporanChart" height="200"></canvas>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-800">Daftar Booking Selesai - {{ \Carbon\Carbon::create()->month((int) request('bulan', date('m')))->translatedFormat('F') }} {{ request('tahun', date('Y')) }}</h2>
        </div>
        <div class="overflow-x-auto">
            @if(!isset($laporanData) || $laporanData->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600 mb-1">Tidak ada data</h3>
                    <p class="text-sm text-gray-400">Belum ada booking selesai di periode ini.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50/50">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Kendaraan</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Durasi</th>
                            <th class="px-6 py-3">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php $grandTotal = 0; @endphp
                        @foreach($laporanData as $booking)
                            @php $grandTotal += $booking->grand_total; @endphp
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3 text-sm text-gray-500">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $booking->user->name ?? '-' }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $booking->kendaraan->nama_kendaraan ?? '-' }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $booking->durasi_hari }} hari</td>
                                <td class="px-6 py-3 text-sm font-medium text-green-600">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50/80">
                            <td colspan="5" class="px-6 py-3 text-sm font-semibold text-gray-800 text-right">Total</td>
                            <td class="px-6 py-3 text-sm font-bold text-green-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
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
                        grid: { color: '#f3f4f6' }
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
