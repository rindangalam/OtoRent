@extends('layouts.admin')
@section('content')
<style>
    .fade-in { opacity: 0; animation: fadeSlideIn 0.4s ease-out forwards; }
    @keyframes fadeSlideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
<div class="max-w-3xl fade-in">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.jadwal.index') }}" class="text-on-surface-variant hover:text-on-surface transition">
            <span class="material-symbols-outlined text-[24px]">arrow_back</span>
        </a>
        <h1 class="text-headline-md text-on-surface">Edit Jadwal</h1>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
        <form method="POST" action="{{ route('admin.jadwal.update', $jadwal) }}" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Driver</label>
                    <select name="driver_id" required class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id', $jadwal->driver_id) == $driver->id ? 'selected' : '' }}>{{ $driver->nama_driver }}</option>
                        @endforeach
                    </select>
                    @error('driver_id') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Kendaraan</label>
                    <select name="kendaraan_id" required class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                        @foreach($kendaraans as $kendaraan)
                            <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id', $jadwal->kendaraan_id) == $kendaraan->id ? 'selected' : '' }}>{{ $kendaraan->nama_kendaraan }} ({{ $kendaraan->plat_nomor }})</option>
                        @endforeach
                    </select>
                    @error('kendaraan_id') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-label-md text-on-surface-variant mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal) }}" required
                    class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                @error('tanggal') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i')) }}" required
                        class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                    @error('waktu_mulai') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i')) }}" required
                        class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                    @error('waktu_selesai') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-label-md text-on-surface-variant mb-1">Status</label>
                <select name="status" required class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                    <option value="tersedia" {{ old('status', $jadwal->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="tidak_tersedia" {{ old('status', $jadwal->status) === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl hover:opacity-90 transition-all">Simpan</button>
                <a href="{{ route('admin.jadwal.index') }}" class="px-6 py-2.5 bg-surface-container text-on-surface-variant text-label-md rounded-xl hover:bg-surface-variant transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
