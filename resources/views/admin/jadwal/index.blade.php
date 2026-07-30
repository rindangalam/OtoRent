@extends('layouts.admin')
@section('content')
<style>
    .fade-in { opacity: 0; animation: fadeSlideIn 0.4s ease-out forwards; }
    @keyframes fadeSlideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.1s; }
</style>
<div class="space-y-6" x-data="{ showForm: false }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 fade-in stagger-1">
        <h1 class="text-headline-md text-on-surface">Jadwal</h1>
        <button @click="showForm = !showForm" class="inline-flex items-center gap-2 px-4 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl hover:opacity-90 transition-all">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span x-text="showForm ? 'Tutup Form' : 'Tambah Jadwal'"></span>
        </button>
    </div>

    <div x-show="showForm" x-transition x-cloak class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6 fade-in stagger-2">
        <h2 class="text-label-lg text-on-surface mb-4">Jadwal Baru</h2>
        <form method="POST" action="{{ route('admin.jadwal.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Driver</label>
                    <select name="driver_id" required class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                        <option value="">Pilih Driver</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>{{ $driver->nama_driver }}</option>
                        @endforeach
                    </select>
                    @error('driver_id') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Kendaraan</label>
                    <select name="kendaraan_id" required class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                        <option value="">Pilih Kendaraan</option>
                        @foreach($kendaraans as $kendaraan)
                            <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>{{ $kendaraan->nama_kendaraan }} ({{ $kendaraan->plat_nomor }})</option>
                        @endforeach
                    </select>
                    @error('kendaraan_id') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                        class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                    @error('tanggal') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required
                        class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                    @error('waktu_mulai') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required
                        class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                    @error('waktu_selesai') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                        <option value="tersedia" {{ old('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak_tersedia" {{ old('status') === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    @error('status') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-5 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl hover:opacity-90 transition-all">Simpan</button>
                <button type="button" @click="showForm = false" class="px-5 py-2.5 bg-surface-container text-on-surface-variant text-label-md rounded-xl hover:bg-surface-variant transition-all">Batal</button>
            </div>
        </form>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20">
        <div class="overflow-x-auto">
            @if($jadwals->isEmpty())
                <div class="p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-outline-variant/50 mx-auto mb-4 block">calendar_month</span>
                    <h3 class="font-bold text-on-surface-variant mb-1">Belum ada jadwal</h3>
                    <p class="text-body-md text-on-surface-variant">Buat jadwal baru untuk mengatur ketersediaan driver dan kendaraan.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-caption-caps text-on-surface-variant uppercase tracking-wider bg-surface-container-low">
                            <th class="px-6 py-3">Driver</th>
                            <th class="px-6 py-3">Kendaraan</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Waktu</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @foreach($jadwals as $jadwal)
                        <tr class="hover:bg-surface-container/50 transition-colors duration-150">
                            <td class="px-6 py-3 text-body-md font-medium text-on-surface">{{ $jadwal->driver->nama_driver ?? '-' }}</td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ $jadwal->kendaraan->nama_kendaraan ?? '-' }}</td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $jadwalStatusColors = [
                                        'tersedia' => 'bg-status-success/10 text-status-success border-status-success/20',
                                        'tidak_tersedia' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
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
                                    <a href="{{ route('admin.jadwal.edit', $jadwal) }}" class="p-2 text-on-surface-variant hover:text-status-info hover:bg-status-info/10 rounded-xl transition" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
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

        @if($jadwals->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10">
            {{ $jadwals->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
