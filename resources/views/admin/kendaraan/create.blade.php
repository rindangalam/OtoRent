@extends('layouts.admin')
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.kendaraan.index') }}" class="text-on-surface-variant hover:text-on-surface transition">
            <span class="material-symbols-outlined text-[24px]">arrow_back</span>
        </a>
        <h1 class="text-headline-md text-on-surface">Tambah Kendaraan</h1>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
        <form method="POST" action="{{ route('admin.kendaraan.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-label-md text-on-surface-variant mb-1">Nama Kendaraan</label>
                <input type="text" name="nama_kendaraan" value="{{ old('nama_kendaraan') }}" required
                    class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md outline-none transition">
                @error('nama_kendaraan') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Plat Nomor</label>
                    <input type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" required placeholder="B 1234 CD"
                        class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md font-mono outline-none transition">
                    @error('plat_nomor') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Jenis</label>
                    <select name="jenis" required class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                        <option value="">Pilih Jenis</option>
                        @foreach(\App\Enums\JenisKendaraan::cases() as $jenis)
                            <option value="{{ $jenis->value }}" {{ old('jenis') === $jenis->value ? 'selected' : '' }}>{{ $jenis->label() }}</option>
                        @endforeach
                    </select>
                    @error('jenis') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Warna</label>
                    <input type="text" name="warna" value="{{ old('warna') }}" required placeholder="Putih"
                        class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md outline-none transition">
                    @error('warna') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Tahun</label>
                    <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" required min="1990" max="{{ date('Y') + 1 }}"
                        class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md outline-none transition">
                    @error('tahun') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Kapasitas</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" required min="1" max="60" placeholder="7"
                        class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md outline-none transition">
                    @error('kapasitas') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Harga Sewa per Hari (Rp)</label>
                    <input type="number" name="harga_sewa_per_hari" value="{{ old('harga_sewa_per_hari') }}" required min="0" step="1000"
                        class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md outline-none transition">
                    @error('harga_sewa_per_hari') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                        @foreach(\App\Enums\StatusKendaraan::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status', 'tersedia') === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-label-md text-on-surface-variant mb-1">Gambar</label>
                <input type="file" name="gambar" accept="image/jpg,image/jpeg,image/png,image/webp"
                    class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md outline-none transition file:mr-4 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary-container file:text-on-primary-container hover:file:bg-primary-container/80">
                <p class="mt-1 text-xs text-on-surface-variant">Format: JPG, JPEG, PNG, Webp. Maks 5MB.</p>
                @error('gambar') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-label-md text-on-surface-variant mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4" required class="w-full px-4 py-2.5 border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md outline-none transition">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl transition">Simpan</button>
                <a href="{{ route('admin.kendaraan.index') }}" class="px-6 py-2.5 bg-surface-container text-on-surface-variant text-label-md rounded-xl transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
