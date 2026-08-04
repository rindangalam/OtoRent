@extends('layouts.admin')
@section('title', 'Kendaraan')
@section('content')
<style>
    .fade-in { opacity: 0; animation: fadeSlideIn 0.4s ease-out forwards; }
    @keyframes fadeSlideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.1s; }
</style>
<div class="space-y-6 fade-in stagger-1">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-headline-md text-on-surface">Kendaraan</h1>
        <a href="{{ route('admin.kendaraan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl hover:opacity-90 transition-all">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Baru
        </a>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-4 fade-in stagger-2">
        <form method="GET" action="{{ route('admin.kendaraan.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau plat nomor..."
                    class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
            </div>
            <div class="sm:w-48">
                <select name="jenis" class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                    <option value="">Semua Jenis</option>
                    @foreach(\App\Enums\JenisKendaraan::cases() as $jenis)
                        <option value="{{ $jenis->value }}" {{ request('jenis') === $jenis->value ? 'selected' : '' }}>{{ $jenis->label() }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl hover:opacity-90 transition-all">Cari</button>
        </form>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20">
        <div class="overflow-x-auto">
            @if($kendaraans->isEmpty())
                <div class="p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-outline-variant/50 mx-auto mb-4 block">directions_car</span>
                    <h3 class="font-bold text-on-surface-variant mb-1">Belum ada kendaraan</h3>
                    <p class="text-body-md text-on-surface-variant">Mulai tambahkan kendaraan baru untuk disewakan.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-caption-caps text-on-surface-variant uppercase tracking-wider bg-surface-container-low">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Plat</th>
                            <th class="px-6 py-3">Jenis</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Harga/Hari</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @foreach($kendaraans as $kendaraan)
                        <tr class="hover:bg-surface-container/50 transition-colors duration-150">
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ ($kendaraans->currentPage() - 1) * $kendaraans->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container overflow-hidden flex-shrink-0">
                                        @if($kendaraan->gambar)
                                            <img src="{{ asset('storage/uploads/kendaraan/' . $kendaraan->gambar) }}" alt="{{ $kendaraan->nama_kendaraan }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant">
                                                <span class="material-symbols-outlined text-[20px]">image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-body-md font-medium text-on-surface">{{ $kendaraan->nama_kendaraan }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant font-mono">{{ $kendaraan->plat_nomor }}</td>
                            <td class="px-6 py-3">
                                <span class="text-body-md text-on-surface-variant">{{ $kendaraan->jenis->label() }}</span>
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $statusColors = [
                                        'tersedia' => 'bg-status-success/10 text-status-success border-status-success/20',
                                        'disewa' => 'bg-status-info/10 text-status-info border-status-info/20',
                                        'service' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusColors[$kendaraan->status->value] ?? '' }}">
                                    {{ $kendaraan->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-body-md font-medium text-on-surface">Rp {{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.kendaraan.edit', $kendaraan) }}" class="p-2 text-on-surface-variant hover:text-status-info hover:bg-status-info/10 rounded-xl transition" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.kendaraan.destroy', $kendaraan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-on-surface-variant hover:text-status-danger hover:bg-status-danger/10 rounded-xl transition" title="Hapus">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if($kendaraans->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10">
            {{ $kendaraans->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
