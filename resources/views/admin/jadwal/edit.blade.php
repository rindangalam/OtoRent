@extends('layouts.admin')
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.jadwal.index') }}" class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Jadwal</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.jadwal.update', $jadwal) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Driver</label>
                    <select name="driver_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id', $jadwal->driver_id) == $driver->id ? 'selected' : '' }}>{{ $driver->nama_driver }}</option>
                        @endforeach
                    </select>
                    @error('driver_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kendaraan</label>
                    <select name="kendaraan_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        @foreach($kendaraans as $kendaraan)
                            <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id', $jadwal->kendaraan_id) == $kendaraan->id ? 'selected' : '' }}>{{ $kendaraan->nama_kendaraan }} ({{ $kendaraan->plat_nomor }})</option>
                        @endforeach
                    </select>
                    @error('kendaraan_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal) }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                @error('tanggal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i')) }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('waktu_mulai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i')) }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('waktu_selesai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    <option value="tersedia" {{ old('status', $jadwal->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="tidak_tersedia" {{ old('status', $jadwal->status) === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">Simpan</button>
                <a href="{{ route('admin.jadwal.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
