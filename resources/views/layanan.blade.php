@extends('layouts.public')

@section('title', 'Layanan — OtoRent')

@section('content')
<style>
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
</style>

{{-- Hero --}}
<section class="relative bg-primary overflow-hidden {{ demo_mode() ? 'pt-0' : 'pt-20' }}">
    <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-secondary-container/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-20%] left-[-10%] w-80 h-80 bg-primary-500/20 rounded-full blur-3xl"></div>
    <div class="relative z-10 px-4 sm:px-6 lg:px-8 py-24 lg:py-32 max-w-[1280px] mx-auto text-center">
        <span class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20 text-white font-caption-caps text-caption-caps uppercase tracking-widest mb-6">
            <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
            Layanan Kami
        </span>
        <h1 class="text-white font-display-hero text-display-hero-mobile md:text-display-hero max-w-3xl mx-auto mb-6">
            Solusi Rental <span class="text-secondary-container">Premium</span> Untuk Segala Kebutuhan
        </h1>
        <p class="text-white/70 text-lg leading-relaxed max-w-2xl mx-auto">
            Dari perjalanan dinas hingga liburan keluarga, OtoRent menyediakan armada dan layanan yang dirancang untuk kenyamanan maksimal Anda.
        </p>
    </div>
</section>

{{-- Service Cards --}}
<section class="py-24 px-4 sm:px-6 lg:px-8 max-w-[1280px] mx-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $services = [
                ['icon' => 'directions_car', 'title' => 'Sewa Harian', 'desc' => 'Fleksibilitas penuh dengan tarif harian kompetitif. Pilih unit favorit Anda dan mulai perjalanan hari ini juga.'],
                ['icon' => 'calendar_month', 'title' => 'Sewa Bulanan', 'desc' => 'Hemat lebih banyak dengan paket sewa bulanan. Ideal untuk kebutuhan mobilitas jangka menengah.'],
                ['icon' => 'person_pin_circle', 'title' => 'Layanan Chauffeur', 'desc' => 'Sopir profesional, ramah, dan berpengalaman. Terlatih untuk memberikan pelayanan terbaik.'],
                ['icon' => 'business_center', 'title' => 'Sewa Korporat', 'desc' => 'Solusi mobilitas untuk perusahaan dengan penagihan terpusat, prioritas unit, dan dukungan 24/7.'],
                ['icon' => 'flight_takeoff', 'title' => 'Antar-Jemput Bandara', 'desc' => 'Penjemputan tepat waktu di bandara dengan driver berpengalaman dan kendaraan ber-AC.'],
                ['icon' => 'celebration', 'title' => 'Wedding & Event', 'desc' => 'Armada mewah untuk hari istimewa Anda: wedding car, rombongan tamu, hingga kendaraan kru acara.'],
                ['icon' => 'schedule', 'title' => 'Sewa Durasi Panjang', 'desc' => 'Kontrak 3 bulan ke atas dengan harga spesial, perawatan berkala, dan asuransi lengkap.'],
                ['icon' => 'verified_user', 'title' => 'Asuransi All-Risk', 'desc' => 'Setiap unit dilindungi asuransi all-risk sehingga perjalanan Anda selalu tenang dan terlindungi.'],
            ];
        @endphp
        @foreach ($services as $service)
        <div class="group p-8 rounded-3xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 reveal">
            <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-secondary-container group-hover:scale-110 transition-all duration-300">
                <span class="material-symbols-outlined text-primary text-3xl group-hover:text-on-secondary-container"> {{ $service['icon'] }}</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-primary mb-3">{{ $service['title'] }}</h3>
            <p class="text-on-surface-variant font-body-md text-body-md">{{ $service['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- How It Works --}}
<section class="py-24 bg-surface-container-low px-4 sm:px-6 lg:px-8">
    <div class="max-w-[1280px] mx-auto">
        <div class="text-center mb-16 reveal">
            <span class="text-secondary font-caption-caps text-caption-caps uppercase tracking-widest block mb-4">Cara Kerja</span>
            <h2 class="font-headline-lg text-headline-lg text-primary">Sewa Dalam 4 Langkah Mudah</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            @php
                $steps = [
                    ['num' => '01', 'title' => 'Pilih Kendaraan', 'desc' => 'Telusuri koleksi armada kami dan pilih unit yang sesuai kebutuhan Anda.'],
                    ['num' => '02', 'title' => 'Buat Booking', 'desc' => 'Tentukan tanggal sewa, pilih layanan driver, dan lengkapi detail perjalanan.'],
                    ['num' => '03', 'title' => 'Bayar Mudah', 'desc' => 'Transfer bank, upload bukti, dan pembayaran diverifikasi dalam hitungan jam.'],
                    ['num' => '04', 'title' => 'Kendaraan Siap', 'desc' => 'Unit diantar bersih dan prima ke lokasi Anda, atau jemput sendiri di cabang kami.'],
                ];
            @endphp
            @foreach ($steps as $step)
            <div class="text-center reveal" style="transition-delay: {{ $loop->index * 100 }}ms">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-primary text-secondary-container font-headline-lg text-headline-lg font-extrabold flex items-center justify-center mb-6 shadow-lg">{{ $step['num'] }}</div>
                <h3 class="font-headline-md text-headline-md text-primary mb-3">{{ $step['title'] }}</h3>
                <p class="text-on-surface-variant font-body-md text-body-md max-w-xs mx-auto">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-24 px-4 sm:px-6 lg:px-8 max-w-[1280px] mx-auto">
    <div class="relative overflow-hidden rounded-[2.5rem] bg-primary px-8 py-16 lg:p-20 text-center reveal">
        <div class="absolute top-[-30%] right-[-5%] w-80 h-80 bg-secondary-container/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-40%] left-[-5%] w-96 h-96 bg-primary-500/20 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <h2 class="text-white font-headline-lg text-headline-lg mb-4 max-w-2xl mx-auto">Siap Memulai Perjalanan Premium Anda?</h2>
            <p class="text-white/70 mb-10 max-w-xl mx-auto">Pilih kendaraan impian Anda sekarang dan nikmati layanan sewa terbaik di Indonesia.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('kendaraan.index') }}" class="px-8 py-4 bg-secondary-container text-on-secondary-fixed font-bold rounded-xl shadow-lg hover:shadow-secondary-container/20 hover:-translate-y-1 transition-all duration-300 btn-interact">
                    Lihat Koleksi Armada
                </a>
                <a href="{{ route('kontak') }}" class="px-8 py-4 bg-transparent border border-white/30 text-white font-bold rounded-xl hover:bg-white/10 transition-all duration-300 btn-interact">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    const observerOptions = { threshold: 0.1, rootMargin: "0px 0px -50px 0px" };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, observerOptions);
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection
