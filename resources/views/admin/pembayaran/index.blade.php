@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Pembayaran</h1>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="flex flex-col sm:flex-row gap-3">
            <select name="status" class="sm:w-48 px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                <option value="">Semua Status</option>
                @foreach(\App\Enums\StatusPembayaran::cases() as $status)
                    <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Filter</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            @if($pembayarans->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600 mb-1">Belum ada pembayaran</h3>
                    <p class="text-sm text-gray-400">Pembayaran akan muncul setelah customer mengirim bukti bayar.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50/50">
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
                    <tbody class="divide-y divide-gray-50">
                        @foreach($pembayarans as $pembayaran)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-3 text-sm text-gray-500">#{{ str_pad($pembayaran->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">#{{ str_pad($pembayaran->booking_id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $pembayaran->booking->user->name ?? '-' }}</td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $pembayaran->metode->label() }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $payColors = [
                                        'belum_bayar' => 'bg-gray-50 text-gray-700 border-gray-200',
                                        'menunggu_verifikasi' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'lunas' => 'bg-green-50 text-green-700 border-green-200',
                                        'refund' => 'bg-orange-50 text-orange-700 border-orange-200',
                                        'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $payColors[$pembayaran->status->value] ?? '' }}">
                                    {{ $pembayaran->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600">
                                {{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-end">
                                    <a href="{{ route('admin.pembayaran.show', $pembayaran) }}" class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
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
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $pembayarans->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
