@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Kendaraan</h1>
        <a href="{{ route('admin.kendaraan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Baru
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.kendaraan.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau plat nomor..."
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
            </div>
            <div class="sm:w-48">
                <select name="jenis" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition bg-white">
                    <option value="">Semua Jenis</option>
                    @foreach(\App\Enums\JenisKendaraan::cases() as $jenis)
                        <option value="{{ $jenis->value }}" {{ request('jenis') === $jenis->value ? 'selected' : '' }}>{{ $jenis->label() }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Cari</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            @if($kendaraans->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17h8M8 17v-4h8v4M8 17H5a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v4a2 2 0 01-2 2h-3m-8 0H5" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600 mb-1">Belum ada kendaraan</h3>
                    <p class="text-sm text-gray-400">Mulai tambahkan kendaraan baru untuk disewakan.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50/50">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Plat</th>
                            <th class="px-6 py-3">Jenis</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Harga/Hari</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($kendaraans as $kendaraan)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-3 text-sm text-gray-500">{{ ($kendaraans->currentPage() - 1) * $kendaraans->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                        @if($kendaraan->gambar)
                                            <img src="{{ asset('storage/uploads/kendaraan/' . $kendaraan->gambar) }}" alt="{{ $kendaraan->nama_kendaraan }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">{{ $kendaraan->nama_kendaraan }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600 font-mono">{{ $kendaraan->plat_nomor }}</td>
                            <td class="px-6 py-3">
                                <span class="text-sm text-gray-600">{{ $kendaraan->jenis->label() }}</span>
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $statusColors = [
                                        'tersedia' => 'bg-green-50 text-green-700 border-green-200',
                                        'disewa' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'service' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusColors[$kendaraan->status->value] ?? '' }}">
                                    {{ $kendaraan->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.kendaraan.edit', $kendaraan) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.kendaraan.destroy', $kendaraan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
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
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $kendaraans->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
