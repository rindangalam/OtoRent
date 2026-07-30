@extends('layouts.admin')
@section('content')
<style>
    .fade-in { opacity: 0; animation: fadeSlideIn 0.4s ease-out forwards; }
    @keyframes fadeSlideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.1s; }
</style>
<div class="space-y-6 fade-in stagger-1">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-headline-md text-on-surface">Pembayaran</h1>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-4 fade-in stagger-2">
        <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="flex flex-col sm:flex-row gap-3">
            <select name="status" class="sm:w-48 px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                <option value="">Semua Status</option>
                @foreach(\App\Enums\StatusPembayaran::cases() as $status)
                    <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl hover:opacity-90 transition-all">Filter</button>
        </form>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20">
        <div class="overflow-x-auto">
            @if($pembayarans->isEmpty())
                <div class="p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-outline-variant/50 mx-auto mb-4 block">payments</span>
                    <h3 class="font-bold text-on-surface-variant mb-1">Belum ada pembayaran</h3>
                    <p class="text-body-md text-on-surface-variant">Pembayaran akan muncul setelah customer mengirim bukti bayar.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-caption-caps text-on-surface-variant uppercase tracking-wider bg-surface-container-low">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Booking</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Jumlah</th>
                            <th class="px-6 py-3">Metode</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @foreach($pembayarans as $pembayaran)
                        <tr class="hover:bg-surface-container/50 transition-colors duration-150">
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">#{{ str_pad($pembayaran->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">#{{ str_pad($pembayaran->booking_id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-3 text-body-md font-medium text-on-surface">{{ $pembayaran->booking->user->name ?? '-' }}</td>
                            <td class="px-6 py-3 text-body-md font-medium text-on-surface">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ $pembayaran->metode->label() }}</td>
                            <td class="px-6 py-3">
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
                            </td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">
                                {{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-end">
                                    <a href="{{ route('admin.pembayaran.show', $pembayaran) }}" class="p-2 text-on-surface-variant hover:text-secondary-container hover:bg-secondary-container/10 rounded-xl transition" title="Lihat Detail">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if($pembayarans->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10">
            {{ $pembayarans->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
