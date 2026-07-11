@extends('layouts.admin')
@section('content')
<div class="space-y-6" x-data="{ showForm: false }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Jadwal</h1>
        <button @click="showForm = !showForm" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span x-text="showForm ? 'Tutup Form' : 'Tambah Jadwal'"></span>
        </button>
    </div>

    {{-- Inline Add Form --}}
    <div x-show="showForm" x-transition x-cloak class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-4">Jadwal Baru</h2>
        <form method="POST" action="{{ route('admin.jadwal.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Driver</label>
                    <select name="driver_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        <option value="">Pilih Driver</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>{{ $driver->nama_driver }}</option>
                        @endforeach
                    </select>
                    @error('driver_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kendaraan</label>
                    <select name="kendaraan_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        <option value="">Pilih Kendaraan</option>
                        @foreach($kendaraans as $kendaraan)
                            <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>{{ $kendaraan->nama_kendaraan }} ({{ $kendaraan->plat_nomor }})</option>
                        @endforeach
                    </select>
                    @error('kendaraan_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('tanggal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('waktu_mulai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('waktu_selesai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        <option value="tersedia" {{ old('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak_tersedia" {{ old('status') === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-5 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">Simpan</button>
                <button type="button" @click="showForm = false" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Batal</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            @if($jadwals->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600 mb-1">Belum ada jadwal</h3>
                    <p class="text-sm text-gray-400">Buat jadwal baru untuk mengatur ketersediaan driver dan kendaraan.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50/50">
                            <th class="px-6 py-3">Driver</th>
                            <th class="px-6 py-3">Kendaraan</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Waktu</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($jadwals as $jadwal)
                        <tr class="hover:bg-gray-50/50" x-data="{ editing: false }">
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $jadwal->driver->nama_driver ?? '-' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $jadwal->kendaraan->nama_kendaraan ?? '-' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $jadwalStatusColors = [
                                        'tersedia' => 'bg-green-50 text-green-700 border-green-200',
                                        'tidak_tersedia' => 'bg-red-50 text-red-700 border-red-200',
                                    ];
                                    $jadwalStatusLabels = [
                                        'tersedia' => 'Tersedia',
                                        'tidak_tersedia' => 'Tidak Tersedia',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $jadwalStatusColors[$jadwal->status] ?? '' }}">
                                    {{ $jadwalStatusLabels[$jadwal->status] ?? $jadwal->status }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.jadwal.edit', $jadwal) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
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

        @if($jadwals->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $jadwals->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
