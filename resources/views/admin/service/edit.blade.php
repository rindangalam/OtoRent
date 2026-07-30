@extends('layouts.admin')
@section('content')
<style>
    .fade-in { opacity: 0; animation: fadeSlideIn 0.4s ease-out forwards; }
    @keyframes fadeSlideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
<div class="max-w-3xl fade-in">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.service.index') }}" class="text-on-surface-variant hover:text-on-surface transition">
            <span class="material-symbols-outlined text-[24px]">arrow_back</span>
        </a>
        <h1 class="text-headline-md text-on-surface">Edit Service</h1>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 p-6">
        <form method="POST" action="{{ route('admin.service.update', $service) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-label-md text-on-surface-variant mb-1">Kendaraan</label>
                <select name="kendaraan_id" required class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                    @foreach($kendaraans as $kendaraan)
                        <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id', $service->kendaraan_id) == $kendaraan->id ? 'selected' : '' }}>{{ $kendaraan->nama_kendaraan }} ({{ $kendaraan->plat_nomor }})</option>
                    @endforeach
                </select>
                @error('kendaraan_id') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Jenis Service</label>
                    <select name="jenis_service" required class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                        @foreach(\App\Enums\JenisService::cases() as $jenis)
                            <option value="{{ $jenis->value }}" {{ old('jenis_service', $service->jenis_service) === $jenis->value ? 'selected' : '' }}>{{ $jenis->label() }}</option>
                        @endforeach
                    </select>
                    @error('jenis_service') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                        @foreach(\App\Enums\StatusService::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status', $service->status->value) === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-label-md text-on-surface-variant mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4" required class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">{{ old('deskripsi', $service->deskripsi) }}</textarea>
                @error('deskripsi') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Biaya (Rp)</label>
                    <input type="number" name="biaya" value="{{ old('biaya', $service->biaya) }}" required min="0" step="1000"
                        class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                    @error('biaya') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-label-md text-on-surface-variant mb-1">Tanggal Service</label>
                    <input type="date" name="tanggal_service" value="{{ old('tanggal_service', $service->tanggal_service) }}" required
                        class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                    @error('tanggal_service') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-label-md text-on-surface-variant mb-1">Estimasi Selesai (Opsional)</label>
                <input type="date" name="estimasi_selesai" value="{{ old('estimasi_selesai', $service->estimasi_selesai) }}"
                    class="w-full px-4 py-2.5 border border-outline-variant/30 focus:ring-2 focus:ring-primary/20 rounded-xl text-body-md bg-surface-container-lowest outline-none transition">
                @error('estimasi_selesai') <p class="mt-1 text-sm text-status-danger">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl hover:opacity-90 transition-all">Simpan</button>
                <a href="{{ route('admin.service.index') }}" class="px-6 py-2.5 bg-surface-container text-on-surface-variant text-label-md rounded-xl hover:bg-surface-variant transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
