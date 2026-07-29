@extends('layouts.customer')

@section('title', 'Buat Booking Baru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('kendaraan.index') }}" class="inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-accent-500 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Katalog
        </a>
    </div>

    <form method="POST" action="{{ route('booking.store') }}" class="max-w-3xl">
        @csrf

        <input type="hidden" name="kendaraan_id" value="{{ $kendaraan->id }}">

        <div x-data="{
            tipeSewa: '{{ old('tipe_sewa') }}',
            metodeAntar: '{{ old('metode_antar') }}',
            hargaPerHari: {{ $kendaraan->harga_sewa_per_hari }},
            tarifDriver: 0,
            ongkosAntar: {{ old('ongkos_antar', 0) }},
            durasi: 1,
            get totalKendaraan() { return this.hargaPerHari * this.durasi; },
            get totalDriver() { return this.tipeSewa === 'driver' ? this.tarifDriver * this.durasi : 0; },
            get grandTotal() { return this.totalKendaraan + this.totalDriver + this.ongkosAntar; },
            formatRp(n) { return 'Rp ' + n.toLocaleString('id-ID'); },
            init() {
                this.$watch('tipeSewa', () => {
                    this.metodeAntar = '';
                    this.tarifDriver = 0;
                    this.ongkosAntar = 0;
                    const driverSelect = document.getElementById('driver_id');
                    if (driverSelect) driverSelect.value = '';
                });
                this.$watch('metodeAntar', () => {
                    if (this.metodeAntar !== 'diantar') this.ongkosAntar = 0;
                });
            }
        }" class="space-y-6">

            {{-- Card: Kendaraan + Tipe Sewa --}}
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 overflow-hidden">

                {{-- Gambar + Info Kendaraan --}}
                <div class="relative">
                    @if($kendaraan->gambar)
                        <img src="{{ asset('storage/uploads/kendaraan/' . $kendaraan->gambar) }}" alt="{{ $kendaraan->nama_kendaraan }}"
                            class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-surface-container-high flex items-center justify-center">
                            <svg class="w-20 h-20 text-on-surface-variant/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 17h2v-4.5L16.5 7H11v10h2m4 0a2 2 0 11-4 0m4 0a2 2 0 100-4m-4 4a2 2 0 11-4 0m4 0a2 2 0 100-4" />
                            </svg>
                        </div>
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                        <h2 class="text-xl font-bold text-white">{{ $kendaraan->nama_kendaraan }}</h2>
                        <p class="text-sm text-white/80">{{ $kendaraan->jenis->label() }} · {{ $kendaraan->kapasitas }} penumpang · {{ $kendaraan->warna }}</p>
                    </div>
                </div>

                <div class="p-6 space-y-6">

                    {{-- Harga per hari --}}
                    <div class="flex items-center justify-between p-3 bg-primary-100 rounded-lg">
                        <span class="text-sm text-primary-800">Harga sewa</span>
                        <span class="text-lg font-bold text-primary-900">Rp {{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}<span class="text-sm font-normal text-primary-600"> / hari</span></span>
                    </div>

                    {{-- Tipe Sewa --}}
                    <div>
                        <label class="block text-sm font-semibold text-on-surface mb-3">Tipe Sewa</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="tipe_sewa" value="driver" x-model="tipeSewa" class="peer sr-only">
                                <div class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-outline-variant/20 peer-checked:border-accent-500 peer-checked:bg-accent-50 transition-all text-center hover:border-outline-variant">
                                    <svg class="w-8 h-8 text-on-surface-variant/50 peer-checked:text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-sm font-medium text-on-surface-variant peer-checked:text-accent-700">Pakai Driver</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="tipe_sewa" value="lepas_kunci" x-model="tipeSewa" class="peer sr-only">
                                <div class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-outline-variant/20 peer-checked:border-accent-500 peer-checked:bg-accent-50 transition-all text-center hover:border-outline-variant">
                                    <svg class="w-8 h-8 text-on-surface-variant/50 peer-checked:text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span class="text-sm font-medium text-on-surface-variant peer-checked:text-accent-700">Lepas Kunci</span>
                                </div>
                            </label>
                        </div>
                        @error('tipe_sewa')
                            <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ====== DETAIL: Pakai Driver ====== --}}
                    <div x-show="tipeSewa === 'driver'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4">

                        <div>
                            <label for="driver_id" class="block text-sm font-medium text-on-surface-variant mb-1">Pilih Driver</label>
                            <select id="driver_id" name="driver_id"
                                x-on:change="tarifDriver = parseFloat($event.target.selectedOptions[0]?.dataset?.tarif || 0)"
                                class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm">
                                <option value="">-- Pilih Driver --</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}" data-tarif="{{ $driver->tarif_per_hari }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->nama_driver }} — Rp {{ number_format($driver->tarif_per_hari, 0, ',', '.') }}/hari
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id')
                                <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="lokasi_jemput_driver" class="block text-sm font-medium text-on-surface-variant mb-1">Lokasi Jemput</label>
                            <input type="text" id="lokasi_jemput_driver" name="lokasi_jemput" value="{{ old('lokasi_jemput') }}" placeholder="Alamat penjemputan"
                                class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm" required>
                            @error('lokasi_jemput')
                                <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="lokasi_tujuan" class="block text-sm font-medium text-on-surface-variant mb-1">Lokasi Tujuan <span class="text-on-surface-variant/50">(opsional)</span></label>
                            <input type="text" id="lokasi_tujuan" name="lokasi_tujuan" value="{{ old('lokasi_tujuan') }}" placeholder="Ke mana tujuan Anda?"
                                class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm">
                            @error('lokasi_tujuan')
                                <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- ====== DETAIL: Lepas Kunci ====== --}}
                    <div x-show="tipeSewa === 'lepas_kunci'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4">

                        {{-- Pilihan: Diantar / Jemput Sendiri --}}
                        <div>
                            <label class="block text-sm font-semibold text-on-surface mb-3">Cara Mendapatkan Kendaraan</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="metode_antar" value="diantar" x-model="metodeAntar" class="peer sr-only">
                                    <div class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-outline-variant/20 peer-checked:border-accent-500 peer-checked:bg-accent-50 transition-all text-center hover:border-outline-variant">
                                        <svg class="w-8 h-8 text-on-surface-variant/50 peer-checked:text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                        <span class="text-sm font-medium text-on-surface-variant">Mobil Diantar</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="metode_antar" value="jemput_sendiri" x-model="metodeAntar" class="peer sr-only">
                                    <div class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-outline-variant/20 peer-checked:border-accent-500 peer-checked:bg-accent-50 transition-all text-center hover:border-outline-variant">
                                        <svg class="w-8 h-8 text-on-surface-variant/50 peer-checked:text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-sm font-medium text-on-surface-variant">Jemput Sendiri</span>
                                    </div>
                                </label>
                            </div>
                            @error('metode_antar')
                                <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jika Diantar: Lokasi + Ongkos --}}
                        <div x-show="metodeAntar === 'diantar'" x-transition class="space-y-4">
                            <div>
                                <label for="lokasi_jemput_diantar" class="block text-sm font-medium text-on-surface-variant mb-1">Lokasi Pengantaran</label>
                                <input type="text" id="lokasi_jemput_diantar" name="lokasi_jemput" value="{{ old('lokasi_jemput') }}" placeholder="Alamat pengantaran kendaraan"
                                    class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm" required>
                                @error('lokasi_jemput')
                                    <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="ongkos_antar" class="block text-sm font-medium text-on-surface-variant mb-1">Ongkos Antar</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-on-surface-variant">Rp</span>
                                    <input type="number" id="ongkos_antar" name="ongkos_antar" x-model.number="ongkosAntar" min="0" step="1000" placeholder="0"
                                        class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm pl-10" required>
                                </div>
                                <p class="text-xs text-on-surface-variant/50 mt-1">Masukkan ongkos antar sesuai kesepakatan</p>
                                @error('ongkos_antar')
                                    <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Jika Jemput Sendiri: Lokasi Rental --}}
                        <div x-show="metodeAntar === 'jemput_sendiri'" x-transition class="space-y-4">
                            <div class="flex items-start gap-3 p-4 bg-accent-50 rounded-lg border border-accent-200">
                                <svg class="w-5 h-5 text-accent-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm text-accent-800">Silakan datang ke lokasi rental untuk mengambil kendaraan yang telah disiapkan.</p>
                            </div>
                            <div>
                                <label for="lokasi_jemput_jemput" class="block text-sm font-medium text-on-surface-variant mb-1">Alamat Lokasi Rental</label>
                                <input type="text" id="lokasi_jemput_jemput" name="lokasi_jemput" value="{{ old('lokasi_jemput', 'Jl. Rental OtoRent, Kota') }}" placeholder="Alamat lokasi rental"
                                    class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm" required>
                                @error('lokasi_jemput')
                                    <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Tanggal --}}
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6">
                <h3 class="text-sm font-semibold text-on-surface mb-4">Tanggal Sewa</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-on-surface-variant mb-1">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" min="{{ date('Y-m-d') }}"
                            x-on:change="durasi = Math.max(1, Math.ceil((new Date(document.getElementById('tanggal_selesai').value) - new Date($el.value)) / (1000 * 60 * 60 * 24)) + 1)"
                            class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm" required>
                        @error('tanggal_mulai')
                            <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-on-surface-variant mb-1">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" min="{{ date('Y-m-d') }}"
                            x-on:change="durasi = Math.max(1, Math.ceil((new Date($el.value) - new Date(document.getElementById('tanggal_mulai').value)) / (1000 * 60 * 60 * 24)) + 1)"
                            class="w-full rounded-xl border-outline-variant/30 focus:ring-2 focus:ring-primary/20 text-sm" required>
                        @error('tanggal_selesai')
                            <p class="text-status-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Ringkasan Biaya --}}
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6">
                <h3 class="text-sm font-semibold text-on-surface mb-4">Ringkasan Biaya</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-on-surface-variant">
                            Kendaraan: <span x-text="durasi"></span> hari &times; Rp <span x-text="hargaPerHari.toLocaleString('id-ID')"></span>
                        </span>
                        <span class="font-medium text-on-surface" x-text="formatRp(totalKendaraan)"></span>
                    </div>
                    <template x-if="tipeSewa === 'driver' && tarifDriver > 0">
                        <div class="flex justify-between text-sm">
                            <span class="text-on-surface-variant">
                                Driver: <span x-text="durasi"></span> hari &times; Rp <span x-text="tarifDriver.toLocaleString('id-ID')"></span>
                            </span>
                            <span class="font-medium text-on-surface" x-text="formatRp(totalDriver)"></span>
                        </div>
                    </template>
                    <template x-if="metodeAntar === 'diantar' && ongkosAntar > 0">
                        <div class="flex justify-between text-sm">
                            <span class="text-on-surface-variant">Ongkos Antar</span>
                            <span class="font-medium text-on-surface" x-text="formatRp(ongkosAntar)"></span>
                        </div>
                    </template>
                    <div class="border-t border-outline-variant/20 pt-3 flex justify-between text-base">
                        <span class="font-semibold text-on-surface">Grand Total</span>
                        <span class="font-bold text-accent-500 text-lg" x-text="formatRp(grandTotal)"></span>
                    </div>
                </div>

                <input type="hidden" name="durasi_hari" x-bind:value="durasi">
                <input type="hidden" name="total_kendaraan" x-bind:value="totalKendaraan">
                <input type="hidden" name="total_driver" x-bind:value="totalDriver">
                <input type="hidden" name="grand_total" x-bind:value="grandTotal">
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-4">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-accent-500 text-white text-sm font-semibold rounded-lg hover:bg-accent-600 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Buat Booking
                </button>
                <a href="{{ route('kendaraan.index') }}" class="text-sm text-on-surface-variant hover:text-on-surface transition">Batal</a>
            </div>
        </div>
    </form>
@endsection
