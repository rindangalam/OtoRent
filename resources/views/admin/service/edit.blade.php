@extends('layouts.admin')
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.service.index') }}" class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Service</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.service.update', $service) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kendaraan</label>
                <select name="kendaraan_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @foreach($kendaraans as $kendaraan)
                        <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id', $service->kendaraan_id) == $kendaraan->id ? 'selected' : '' }}>{{ $kendaraan->nama_kendaraan }} ({{ $kendaraan->plat_nomor }})</option>
                    @endforeach
                </select>
                @error('kendaraan_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Service</label>
                    <select name="jenis_service" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        @foreach(\App\Enums\JenisService::cases() as $jenis)
                            <option value="{{ $jenis->value }}" {{ old('jenis_service', $service->jenis_service) === $jenis->value ? 'selected' : '' }}>{{ $jenis->label() }}</option>
                        @endforeach
                    </select>
                    @error('jenis_service') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        @foreach(\App\Enums\StatusService::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status', $service->status->value) === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">{{ old('deskripsi', $service->deskripsi) }}</textarea>
                @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Biaya (Rp)</label>
                    <input type="number" name="biaya" value="{{ old('biaya', $service->biaya) }}" required min="0" step="1000"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('biaya') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Service</label>
                    <input type="date" name="tanggal_service" value="{{ old('tanggal_service', $service->tanggal_service) }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    @error('tanggal_service') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Selesai (Opsional)</label>
                <input type="date" name="estimasi_selesai" value="{{ old('estimasi_selesai', $service->estimasi_selesai) }}"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                @error('estimasi_selesai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">Simpan</button>
                <a href="{{ route('admin.service.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
