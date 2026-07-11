@extends('layouts.admin')
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.driver.index') }}" class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Driver</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.driver.update', $driver) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Driver</label>
                <input type="text" name="nama_driver" value="{{ old('nama_driver', $driver->nama_driver) }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                @error('nama_driver') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No Telp</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp', $driver->no_telp) }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('no_telp') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis SIM</label>
                    <select name="sim" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        @foreach(\App\Enums\JenisSIM::cases() as $sim)
                            <option value="{{ $sim->value }}" {{ old('sim', $driver->sim->value) === $sim->value ? 'selected' : '' }}>{{ $sim->label() }}</option>
                        @endforeach
                    </select>
                    @error('sim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">{{ old('alamat', $driver->alamat) }}</textarea>
                @error('alamat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tarif per Hari (Rp)</label>
                    <input type="number" name="tarif_per_hari" value="{{ old('tarif_per_hari', $driver->tarif_per_hari) }}" required min="0" step="1000"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('tarif_per_hari') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        <option value="aktif" {{ old('status', $driver->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status', $driver->status) === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="sedang_bertugas" {{ old('status', $driver->status) === 'sedang_bertugas' ? 'selected' : '' }}>Sedang Bertugas</option>
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                @if($driver->foto)
                    <div class="mb-3">
                        <img src="{{ asset('storage/uploads/drivers/' . $driver->foto) }}" alt="{{ $driver->nama_driver }}" class="w-20 h-20 rounded-full object-cover border border-gray-200">
                        <p class="text-xs text-gray-400 mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
                    </div>
                @endif
                <input type="file" name="foto" accept="image/jpg,image/jpeg,image/png,image/webp"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                <p class="mt-1 text-xs text-gray-400">Format: JPG, JPEG, PNG, Webp. Maks 5MB.</p>
                @error('foto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">Simpan</button>
                <a href="{{ route('admin.driver.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
