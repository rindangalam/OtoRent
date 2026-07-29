@extends('layouts.customer')

@section('title', 'Pembayaran Booking #' . $booking->id)

@section('content')
    <div class="mb-6">
        <a href="{{ route('booking.show', $booking) }}" class="inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-accent-500 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="max-w-2xl">
        <h1 class="text-2xl font-bold text-on-surface mb-2">Pembayaran Booking #{{ $booking->id }}</h1>
        <p class="text-on-surface-variant mb-6">Lakukan pembayaran untuk mengonfirmasi booking Anda.</p>

        <form method="POST" action="{{ route('pembayaran.store', $booking) }}" enctype="multipart/form-data">
            @csrf

            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6 mb-6">
                <div class="flex justify-between items-center pb-4 border-b border-outline-variant/10">
                    <span class="text-on-surface-variant">Grand Total</span>
                    <span class="text-2xl font-bold text-accent-500">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6 mb-6">
                <h2 class="text-lg font-semibold text-on-surface mb-4">Metode Pembayaran</h2>
                <label class="flex items-center gap-3 p-4 bg-surface-container-low border border-outline-variant/20 rounded-lg cursor-pointer">
                    <input type="radio" name="metode" value="transfer_manual" checked class="text-accent-500 focus:ring-accent-500">
                    <div>
                        <span class="text-sm font-medium text-on-surface">Transfer Manual</span>
                        <p class="text-xs text-on-surface-variant">Bayar via transfer bank</p>
                    </div>
                </label>
                @error('metode')
                    <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6 mb-6">
                <h2 class="text-lg font-semibold text-on-surface mb-4">Informasi Transfer</h2>
                <div class="p-4 bg-primary-100 rounded-lg border border-primary-200 space-y-2">
                    <p class="text-sm font-medium text-primary-800">Transfer ke:</p>
                    <p class="text-base font-bold text-primary-900">Bank BCA - 1234567890</p>
                    <p class="text-sm text-primary-700">a.n OtoRent Indonesia</p>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6 mb-6">
                <h2 class="text-lg font-semibold text-on-surface mb-4">Upload Bukti Bayar</h2>
                <div x-data="{ preview: null }">
                    <label class="block text-sm font-medium text-on-surface-variant mb-2">Pilih file gambar bukti transfer</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-outline-variant/30 border-dashed rounded-xl hover:border-accent-300 transition cursor-pointer"
                        @click="$refs.fileInput.click()"
                        @dragover.prevent="$el.classList.add('border-accent-300', 'bg-accent-50')"
                        @dragleave.prevent="$el.classList.remove('border-accent-300', 'bg-accent-50')"
                        @drop.prevent="
                            $el.classList.remove('border-accent-300', 'bg-accent-50');
                            const file = $event.dataTransfer.files[0];
                            $refs.fileInput.files = $event.dataTransfer.files;
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = (e) => preview = e.target.result;
                                reader.readAsDataURL(file);
                            }
                        ">
                        <div class="text-center">
                            <template x-if="!preview">
                                <div>
                                    <svg class="mx-auto h-12 w-12 text-on-surface-variant/50" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-2 text-sm text-on-surface-variant">
                                        <span class="font-medium text-accent-500 hover:text-accent-600">Klik untuk upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-on-surface-variant/50 mt-1">JPG, JPEG, PNG, WEBP (max 2MB)</p>
                                </div>
                            </template>
                            <template x-if="preview">
                                <div class="relative">
                                    <img :src="preview" class="max-h-48 mx-auto rounded-lg shadow-sm">
                                    <button type="button" @click="preview = null; $refs.fileInput.value = ''" class="mt-2 text-sm text-status-danger hover:text-status-danger/80">Hapus</button>
                                </div>
                            </template>
                        </div>
                    </div>
                    <input type="file" name="bukti_bayar" accept="image/jpeg,image/png,image/webp,image/jpg"
                        x-ref="fileInput" class="hidden"
                        @change="
                            const file = $event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = (e) => preview = e.target.result;
                                reader.readAsDataURL(file);
                            }
                        ">
                    @error('bukti_bayar')
                        <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-accent-500 text-white text-sm font-medium rounded-lg hover:bg-accent-600 transition">
                Kirim Bukti Bayar
            </button>
        </form>
    </div>
@endsection
