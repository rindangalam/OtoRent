@extends('layouts.admin')
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.kendaraan.index') }}" class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Kendaraan</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.kendaraan.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kendaraan</label>
                <input type="text" name="nama_kendaraan" value="{{ old('nama_kendaraan') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                @error('nama_kendaraan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Plat Nomor</label>
                    <input type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" required placeholder="B 1234 CD"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-mono focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('plat_nomor') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                    <select name="jenis" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        <option value="">Pilih Jenis</option>
                        @foreach(\App\Enums\JenisKendaraan::cases() as $jenis)
                            <option value="{{ $jenis->value }}" {{ old('jenis') === $jenis->value ? 'selected' : '' }}>{{ $jenis->label() }}</option>
                        @endforeach
                    </select>
                    @error('jenis') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                    <input type="text" name="warna" value="{{ old('warna') }}" required placeholder="Putih"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('warna') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" required min="1990" max="{{ date('Y') + 1 }}"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('tahun') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" required min="1" max="60" placeholder="7"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('kapasitas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Sewa per Hari (Rp)</label>
                    <input type="number" name="harga_sewa_per_hari" value="{{ old('harga_sewa_per_hari') }}" required min="0" step="1000"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('harga_sewa_per_hari') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        @foreach(\App\Enums\StatusKendaraan::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status', 'tersedia') === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                <input type="file" name="gambar" accept="image/jpg,image/jpeg,image/png,image/webp"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                <p class="mt-1 text-xs text-gray-400">Format: JPG, JPEG, PNG, Webp. Maks 5MB.</p>
                @error('gambar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">Simpan</button>
                <a href="{{ route('admin.kendaraan.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
