@extends('layouts.public')

@section('title', 'OtoRent — Sewa Mobil Mewah & Premium')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
    @keyframes float {
        0%, 100% { transform: translateY(0) scale(1.05); }
        50% { transform: translateY(-20px) scale(1.05); }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    .btn-interact {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-interact:active {
        transform: scale(0.95);
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
</style>

{{-- Hero Section --}}
<header class="relative h-screen flex items-center overflow-hidden bg-primary pt-20">
    {{-- WebGL Background --}}
    <div class="absolute inset-0 z-0">
        <x-webgl-shader color1="0.118, 0.227, 0.373" color2="0.043, 0.114, 0.231" accent="0.961, 0.620, 0.043" />
    </div>
    <div class="relative z-10 px-4 sm:px-6 lg:px-8 max-w-[1280px] mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-8 glass-card p-10 rounded-[2.5rem] lg:bg-transparent lg:backdrop-blur-0 lg:border-0 lg:p-0">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20">
                <span class="w-2 h-2 rounded-full bg-status-success animate-ping"></span>
                <span class="text-white font-caption-caps text-caption-caps uppercase tracking-widest">Koleksi Elite 2024</span>
            </div>
            <h1 class="text-white font-display-hero text-display-hero-mobile md:text-display-hero max-w-xl">
                Definisi Baru <span class="text-secondary-container">Kemewahan</span> Dalam Berkendara.
            </h1>
            <p class="text-white/70 text-lg leading-relaxed max-w-lg">
                Nikmati perjalanan tanpa kompromi dengan armada premium kami. Dari sedan eksekutif hingga supercar, OtoRent menghadirkan standar kenyamanan tertinggi di Indonesia.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                @guest
                <a href="{{ route('register') }}" class="px-8 py-4 bg-secondary-container text-on-secondary-fixed font-bold rounded-xl shadow-lg hover:shadow-secondary-container/20 hover:-translate-y-1 transition-all duration-300 btn-interact text-center">
                    Pesan Sekarang
                </a>
                @else
                <a href="{{ route('booking.create') }}" class="px-8 py-4 bg-secondary-container text-on-secondary-fixed font-bold rounded-xl shadow-lg hover:shadow-secondary-container/20 hover:-translate-y-1 transition-all duration-300 btn-interact text-center">
                    Pesan Sekarang
                </a>
                @endguest
                <a href="{{ route('kendaraan.index') }}" class="px-8 py-4 bg-transparent border border-white/30 text-white font-bold rounded-xl hover:bg-white/10 transition-all duration-300 group inline-flex items-center justify-center gap-2 btn-interact">
                    Lihat Koleksi
                    <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
                </a>
            </div>
            <div class="flex items-center gap-8 pt-8">
                <div>
                    <div class="text-white font-headline-md text-headline-md">500+</div>
                    <div class="text-white/50 text-xs uppercase tracking-tighter">Armada Mewah</div>
                </div>
                <div>
                    <div class="text-white font-headline-md text-headline-md">15k+</div>
                    <div class="text-white/50 text-xs uppercase tracking-tighter">Klien Puas</div>
                </div>
                <div>
                    <div class="text-white font-headline-md text-headline-md">24/7</div>
                    <div class="text-white/50 text-xs uppercase tracking-tighter">Layanan VIP</div>
                </div>
            </div>
        </div>
        <div class="relative group hidden lg:block">
            <div class="absolute inset-0 bg-secondary-container/10 blur-[120px] rounded-full scale-75 -z-10 group-hover:scale-100 transition-transform duration-700"></div>
            <img class="w-full drop-shadow-[0_20px_50px_rgba(0,0,0,0.5)] transform animate-float transition-all duration-1000 ease-out" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBrHuX5_alk-4iHKq-_UKqxdg5w_swqydEis_aiviE-QQHKM4BZhrG-OmJmENcHwcNP1enf025Hw5RFqHZFg_uWnrMQb-_gF3G2uG9RkdU6hjs_PY2V_fYmUYel-kcbpX_YGlqc-nIPg7_mw5O9GV4feUYTQhuQNOT66jzN81tCYFCN9z2dsrnaZvtDvEvKwxTy8RyBycjjKf-bkcOJ6tBrI-QZsC_ATEKxRqjtHN8xkSbTvEZe5X4H4w" alt="Luxury Sedan">
        </div>
    </div>
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-50">
        <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center p-1">
            <div class="w-1 h-2 bg-white rounded-full animate-bounce"></div>
        </div>
    </div>
</header>

{{-- Why Choose Us - Bento Grid --}}
<section class="py-24 px-4 sm:px-6 lg:px-8 max-w-[1280px] mx-auto bg-background">
    <div class="text-center mb-16 reveal">
        <span class="text-secondary font-caption-caps text-caption-caps uppercase tracking-widest block mb-4">Keunggulan Kami</span>
        <h2 class="font-headline-lg text-headline-lg text-primary">Mengapa OtoRent?</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-8 rounded-3xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-2 reveal">
            <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-primary text-3xl">verified_user</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-primary mb-4">Asuransi All-Risk</h3>
            <p class="text-on-surface-variant font-body-md text-body-md">Perjalanan tenang dengan perlindungan asuransi menyeluruh untuk setiap unit armada kami.</p>
        </div>
        <div class="p-8 rounded-3xl bg-primary text-white shadow-xl hover:shadow-primary/20 transition-all duration-300 hover:-translate-y-2 reveal" style="transition-delay: 100ms;">
            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-secondary-container text-3xl" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
            </div>
            <h3 class="font-headline-md text-headline-md mb-4">Armada Terbaru</h3>
            <p class="text-white/70 font-body-md text-body-md">Kami hanya menyediakan mobil dengan usia di bawah 2 tahun untuk menjamin performa maksimal.</p>
        </div>
        <div class="p-8 rounded-3xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-2 reveal" style="transition-delay: 200ms;">
            <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-primary text-3xl">local_shipping</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-primary mb-4">Antar-Jemput VIP</h3>
            <p class="text-on-surface-variant font-body-md text-body-md">Layanan pengantaran unit langsung ke depan pintu rumah atau bandara di seluruh kota besar.</p>
        </div>
    </div>
</section>

{{-- Featured Fleet Grid --}}
<section class="py-24 bg-surface-container-low  overflow-hidden" id="fleet">
    <div class="px-4 sm:px-6 lg:px-8 max-w-[1280px] mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6 reveal">
            <div class="space-y-4">
                <span class="text-secondary font-caption-caps text-caption-caps uppercase tracking-widest">Koleksi Terpilih</span>
                <h2 class="font-headline-lg text-headline-lg text-primary">Temukan Kendaraan Impian Anda</h2>
            </div>
            <a href="{{ route('kendaraan.index') }}" class="text-sm font-medium text-primary hover:text-secondary-container transition-colors">Lihat Semua &rarr;</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($kendaraans as $kendaraan)
            <div class="group bg-white  rounded-[2rem] overflow-hidden border border-outline-variant/20 hover:shadow-2xl transition-all duration-500 reveal" style="transition-delay: {{ $loop->index * 100 }}ms">
                <div class="relative h-64 overflow-hidden">
                    <div class="absolute top-4 left-4 z-10">
                        @php
                            $statusClass = $kendaraan->status === 'tersedia' ? 'bg-status-success' : ($kendaraan->status === 'disewa' ? 'bg-primary' : 'bg-secondary-container');
                            $statusText = $kendaraan->status === 'tersedia' ? 'Tersedia' : ($kendaraan->status === 'disewa' ? 'Terlaris' : 'Promo');
                        @endphp
                        <span class="{{ $statusClass }} text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">{{ $statusText }}</span>
                    </div>
                    @if($kendaraan->gambar)
                        <img src="{{ asset('storage/uploads/kendaraan/' . $kendaraan->gambar) }}" alt="{{ $kendaraan->nama_kendaraan }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-primary-200 to-primary-300 flex items-center justify-center text-5xl">🚗</div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                        <a href="{{ route('kendaraan.show', $kendaraan) }}" class="w-full py-3 bg-white text-primary font-bold rounded-xl translate-y-4 group-hover:translate-y-0 transition-transform btn-interact text-center">Detail Kendaraan</a>
                    </div>
                </div>
                <div class="p-8">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-headline-md text-headline-md text-primary">{{ $kendaraan->nama_kendaraan }}</h4>
                            <p class="text-on-surface-variant text-sm">{{ $kendaraan->jenis->label() ?? 'Premium' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-secondary font-bold text-xl">Rp {{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}</span>
                            <span class="text-on-surface-variant text-xs block">/ hari</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-6 border-t border-surface-variant">
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px]">airline_seat_recline_extra</span>
                            <span class="text-xs font-semibold">{{ $kendaraan->kapasitas }} Kursi</span>
                        </div>
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px]">settings_accessibility</span>
                            <span class="text-xs font-semibold">{{ $kendaraan->transmisi ?? 'Matic' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px]">local_gas_station</span>
                            <span class="text-xs font-semibold">{{ $kendaraan->bahan_bakar ?? 'Bensin' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-on-surface-variant">
                Belum ada kendaraan tersedia.
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Testimonials Section --}}
<section class="py-24 px-4 sm:px-6 lg:px-8 max-w-[1280px] mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="reveal">
            <span class="text-secondary font-caption-caps text-caption-caps uppercase tracking-widest block mb-4">Testimoni Klien</span>
            <h2 class="font-headline-lg text-headline-lg text-primary mb-8">Apa Kata Mereka Tentang Layanan Kami?</h2>
            <div class="space-y-8">
                <div class="p-8 rounded-3xl bg-surface shadow-sm border border-outline-variant/20 italic text-on-surface-variant relative">
                    <span class="material-symbols-outlined absolute -top-4 -left-2 text-6xl text-primary/5 select-none" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                    "Layanan OtoRent benar-benar profesional. Saya memesan unit untuk keperluan bisnis di Jakarta dan mobil diantar tepat waktu dengan kondisi yang sangat bersih dan prima. Sangat direkomendasikan!"
                    <div class="mt-6 flex items-center gap-4 not-italic">
                        <div class="w-12 h-12 rounded-full bg-surface-container-high overflow-hidden">
                            <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBMTliomFJ3D5MeoDsjkARusUwX6bi4cddJfL0DBSszFjfHxZtLSrPhmruwCqA7esmhu1jIFWbUay08eBUoiRCfNe0ew5CFHZpZTdEftebKIuoJ660OnOMNy0f_zBzgEbLhjBQe9SATMaEPg-bXrNwkSAqoKoTfV-ZPD2j7Ex0UvVbrtE6zPESFcv2Rl_zLlF8ZZcQ-QBNfDBxNsDTnW1mMzJ6DCAoZE6rRugWwetr2kpThdN_oz3jEtQ" alt="Budi Santoso">
                        </div>
                        <div>
                            <div class="font-bold text-primary">Budi Santoso</div>
                            <div class="text-xs text-on-surface-variant">CEO, Tech Global Indonesia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative reveal" style="transition-delay: 200ms;">
            <div class="aspect-square rounded-[3rem] overflow-hidden">
                <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBiKV7U9p-lWLoug-iJk_-_VZuGtXpbbjsFWVrnVUFywTP4Xdpk5hu0XPCHT-IaIXABKTniy2wdTR229Iusynx-xY9YU1mg5QVybR5tPkI0m3yI8uI0VxPuKPuntmKcNX1FvJQ4KYZWNCE1VAYISduQQ9PODbZRLwYzmI47m_4jeBo8LF_RSQdfGt-qA_VynwaJze33mqROb2jV5vX-5VtTR8GksBu1fxn_Q7Bzw9fa33d_1TwjiPFgzg" alt="Luxury Interior">
            </div>
            <div class="absolute -bottom-8 -right-8 p-8 bg-white  rounded-3xl shadow-2xl max-w-xs border border-outline-variant/20 hidden sm:block">
                <div class="flex items-center gap-1 text-status-warning mb-2">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="font-bold text-primary">Skor Kepuasan 4.9/5</p>
                <p class="text-sm text-on-surface-variant">Berdasarkan lebih dari 5.000 ulasan terverifikasi klien kami.</p>
            </div>
        </div>
    </div>
</section>

<script>
    // Scroll Reveal Intersection Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection
