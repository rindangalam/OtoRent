@extends('layouts.public')

@section('title', 'Kontak — OtoRent')

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
    .faq-toggle { cursor: pointer; }
</style>

{{-- Hero --}}
<section class="relative bg-primary overflow-hidden pt-20">
    <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-secondary-container/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-20%] left-[-10%] w-80 h-80 bg-primary-500/20 rounded-full blur-3xl"></div>
    <div class="relative z-10 px-4 sm:px-6 lg:px-8 py-24 lg:py-32 max-w-[1280px] mx-auto text-center">
        <span class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20 text-white font-caption-caps text-caption-caps uppercase tracking-widest mb-6">
            <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
            Kontak Kami
        </span>
        <h1 class="text-white font-display-hero text-display-hero-mobile md:text-display-hero max-w-3xl mx-auto mb-6">
            Kami Siap <span class="text-secondary-container">Membantu</span> Anda
        </h1>
        <p class="text-white/70 text-lg leading-relaxed max-w-2xl mx-auto">
            Punya pertanyaan seputar sewa kendaraan? Tim kami siap melayani Anda 24 jam, 7 hari seminggu.
        </p>
    </div>
</section>

{{-- Contact Info --}}
<section class="py-24 px-4 sm:px-6 lg:px-8 max-w-[1280px] mx-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-20">
        @php
            $infos = [
                ['icon' => 'location_on', 'title' => 'Alamat', 'desc' => 'Jl. Kemang Raya No. 88, Jakarta Selatan 12730', 'extra' => ''],
                ['icon' => 'call', 'title' => 'Telepon / WA', 'desc' => '0812-3456-7890', 'extra' => 'Tersedia 24 jam'],
                ['icon' => 'mail', 'title' => 'Email', 'desc' => 'halo@otorent.com', 'extra' => 'Balasan &lt; 24 jam'],
                ['icon' => 'schedule', 'title' => 'Jam Operasional', 'desc' => 'Setiap hari 24 jam', 'extra' => 'Termasuk hari libur'],
            ];
        @endphp
        @foreach ($infos as $info)
        <div class="p-8 rounded-3xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 reveal">
            <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-primary text-3xl">{{ $info['icon'] }}</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-primary mb-2">{{ $info['title'] }}</h3>
            <p class="text-on-surface-variant font-body-md text-body-md">{{ $info['desc'] }}</p>
            <p class="text-secondary font-body-sm text-body-sm mt-1">{{ $info['extra'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        {{-- Form --}}
        <div class="reveal">
            <span class="text-secondary font-caption-caps text-caption-caps uppercase tracking-widest block mb-4">Kirim Pesan</span>
            <h2 class="font-headline-lg text-headline-lg text-primary mb-6">Ada Pertanyaan? Tulis Di Sini</h2>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-body-md text-body-md" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('kontak.store') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block font-body-md text-body-md text-primary mb-2">Nama Lengkap *</label>
                        <input class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200" id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Nama Anda">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <label for="phone" class="block font-body-md text-body-md text-primary mb-2">No. Telepon</label>
                        <input class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200" id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" placeholder="08xx-xxxx-xxxx">
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                </div>
                <div>
                    <label for="email" class="block font-body-md text-body-md text-primary mb-2">Email *</label>
                    <input class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <label for="subject" class="block font-body-md text-body-md text-primary mb-2">Subjek *</label>
                    <select id="subject" name="subject" required class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200">
                        <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Pilih topik pertanyaan</option>
                        @foreach (['Informasi Sewa', 'Proses Booking', 'Pembayaran', 'Layanan Driver', 'Sewa Korporat', 'Lainnya'] as $topic)
                            <option value="{{ $topic }}" {{ old('subject') === $topic ? 'selected' : '' }}>{{ $topic }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                </div>
                <div>
                    <label for="message" class="block font-body-md text-body-md text-primary mb-2">Pesan *</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Tulis pertanyaan atau kebutuhan Anda di sini..." class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-on-surface placeholder:text-outline/60 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200">{{ old('message') }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                </div>
                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-primary-500 hover:-translate-y-1 transition-all duration-300 btn-interact">
                    Kirim Pesan
                </button>
            </form>
        </div>

        {{-- FAQ --}}
        <div class="reveal" style="transition-delay: 150ms">
            <span class="text-secondary font-caption-caps text-caption-caps uppercase tracking-widest block mb-4">FAQ</span>
            <h2 class="font-headline-lg text-headline-lg text-primary mb-6">Pertanyaan yang Sering Diajukan</h2>
            <div class="space-y-4">
                @php
                    $faqs = [
                        ['q' => 'Apakah ada minimal lama sewa?', 'a' => 'Tidak ada. Anda bebas menyewa mulai dari 12 jam hingga bulanan. Semakin lama durasi sewa, semakin besar diskon yang Anda dapatkan.'],
                        ['q' => 'Apa saja syarat untuk menyewa?', 'a' => 'Cukup KTP asli (Warga Negara Indonesia) dan SIM A yang masih berlaku. Untuk sewa dengan driver, SIM tidak wajib.'],
                        ['q' => 'Bagaimana cara pembayaran?', 'a' => 'Pembayaran dilakukan via transfer bank ke rekening resmi OtoRent. Setelah upload bukti transfer, tim kami akan verifikasi dalam hitungan jam.'],
                        ['q' => 'Apakah bisa diantar ke lokasi?', 'a' => 'Bisa. Kami menyediakan layanan antar-jemput kendaraan ke alamat Anda dengan ongkos yang transparan, termasuk pengantaran ke bandara dan hotel.'],
                        ['q' => 'Apakah kendaraan diasuransikan?', 'a' => 'Seluruh unit kami dilindungi asuransi all-risk. Kerusakan yang bukan karena kelalaian penyewa akan ditanggung sepenuhnya.'],
                    ];
                @endphp
                @foreach ($faqs as $faq)
                <div class="rounded-2xl bg-surface-container-lowest border border-outline-variant/30 overflow-hidden faq-toggle" onclick="this.querySelector('.faq-answer').classList.toggle('hidden'); this.querySelector('.faq-icon').textContent = this.querySelector('.faq-answer').classList.contains('hidden') ? 'add' : 'remove';">
                    <div class="flex items-center justify-between gap-4 p-5">
                        <h3 class="font-headline-md text-headline-md text-primary">{{ $faq['q'] }}</h3>
                        <span class="material-symbols-outlined text-secondary faq-icon">add</span>
                    </div>
                    <div class="faq-answer hidden px-5 pb-5">
                        <p class="text-on-surface-variant font-body-md text-body-md">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Map CTA --}}
<section class="pb-24 px-4 sm:px-6 lg:px-8 max-w-[1280px] mx-auto">
    <div class="relative overflow-hidden rounded-[2.5rem] bg-primary px-8 py-16 lg:p-20 text-center reveal">
        <div class="absolute top-[-30%] right-[-5%] w-80 h-80 bg-secondary-container/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-40%] left-[-5%] w-96 h-96 bg-primary-500/20 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <h2 class="text-white font-headline-lg text-headline-lg mb-4 max-w-2xl mx-auto">Butuh Jawaban Cepat?</h2>
            <p class="text-white/70 mb-10 max-w-xl mx-auto">Hubungi WhatsApp kami dan dapatkan respon dalam hitungan menit, kapan pun Anda butuh.</p>
            <a href="https://wa.me/6281234567890?text=Halo%20OtoRent%2C%20saya%20ingin%20bertanya%20tentang%20sewa%20kendaraan." target="_blank" rel="noopener" class="inline-flex items-center gap-3 px-8 py-4 bg-secondary-container text-on-secondary-fixed font-bold rounded-xl shadow-lg hover:shadow-secondary-container/20 hover:-translate-y-1 transition-all duration-300 btn-interact">
                <span class="material-symbols-outlined">chat</span>
                Chat WhatsApp
            </a>
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
