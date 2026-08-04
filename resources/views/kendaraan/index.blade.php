@extends('layouts.public')

@section('title', 'Katalog Kendaraan')

@section('content')
<style>
    .active-tab {
        position: relative;
    }
    .active-tab::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 3px;
        background-color: var(--color-secondary-container);
        border-radius: 99px;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .stagger-card {
        opacity: 0;
        animation: fadeInUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    @keyframes pulse-soft {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    .pulse-soft {
        animation: pulse-soft 2s infinite;
    }
    .icon-box:hover .material-symbols-outlined {
        transform: scale(1.1) translateY(-2px);
        color: var(--color-secondary-container);
        font-variation-settings: 'FILL' 1;
    }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<main class="pt-24 pb-20 max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Hero Search Section --}}
    <section class="py-16">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-12">
            <div class="max-w-2xl">
                <h1 class="text-display-hero text-display-hero text-primary mb-6 tracking-tight">Katalog Kendaraan</h1>
                <p class="text-body-lg text-body-lg text-on-surface-variant leading-relaxed max-w-xl font-light">Eksplorasi koleksi kendaraan premium kami yang dikurasi khusus untuk kenyamanan dan performa terbaik di setiap perjalanan Anda.</p>
            </div>
            <form method="GET" action="{{ route('kendaraan.index') }}" class="relative w-full lg:w-[450px]">
                <input name="search" value="{{ request('search') }}" class="w-full pl-14 pr-6 py-5 rounded-2xl border-none bg-surface-container-high/50 backdrop-blur shadow-inner focus:ring-2 focus:ring-primary/20 transition-all duration-300 text-on-surface placeholder-outline text-body-md" placeholder="Cari tipe, merk, atau kategori..." type="text">
                <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            </form>
        </div>
    </section>

    {{-- Sticky Sub-Header with Category Filters --}}
    <nav class="sticky top-20 z-40 bg-background/80 backdrop-blur-xl py-6 border-b border-surface-variant/20 mb-16 shadow-xl shadow-black/[0.02]">
        <div class="flex items-center space-x-4 md:space-x-10 overflow-x-auto no-scrollbar">
            <a href="{{ route('kendaraan.index', array_merge(request()->except('jenis'), ['jenis' => ''])) }}"
               class="whitespace-nowrap px-4 py-1 text-label-md {{ !request('jenis') ? 'active-tab text-primary' : 'text-on-surface-variant hover:text-primary' }} transition-all">Semua</a>
            @foreach ($jenisList as $jenis)
            <a href="{{ route('kendaraan.index', array_merge(request()->except('jenis'), ['jenis' => $jenis->value])) }}"
               class="whitespace-nowrap px-4 py-1 text-label-md {{ request('jenis') === $jenis->value ? 'active-tab text-primary' : 'text-on-surface-variant hover:text-primary' }} transition-colors">{{ $jenis->label() }}</a>
            @endforeach
            <div class="flex-grow"></div>
            <div class="flex items-center space-x-3 border-l border-surface-variant/30 pl-10 hidden lg:flex">
                <span class="text-on-surface-variant/60 text-caption-caps text-caption-caps uppercase tracking-widest">Urutkan</span>
                <select name="sort" onchange="this.form.submit()" form="sort-form"
                    class="bg-transparent border-none focus:ring-0 text-label-md text-primary cursor-pointer hover:text-secondary-container transition-colors">
                    <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="harga_terendah" {{ request('sort') === 'harga_terendah' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="harga_tertinggi" {{ request('sort') === 'harga_tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
            </div>
        </div>
    </nav>

    {{-- Hidden form for sort --}}
    <form id="sort-form" method="GET" action="{{ route('kendaraan.index') }}">
        @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        @if(request('jenis'))
        <input type="hidden" name="jenis" value="{{ request('jenis') }}">
        @endif
    </form>

    {{-- Vehicle Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-12 gap-x-6">
        @forelse ($kendaraans as $kendaraan)
        <div class="stagger-card group relative bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-3 transition-all duration-500 flex flex-col" style="animation-delay: {{ ($loop->index % 12) * 0.1 + 0.1 }}s">
            <div class="aspect-[4/3] relative overflow-hidden">
                @if($kendaraan->gambar)
                <img src="{{ asset('storage/uploads/kendaraan/' . $kendaraan->gambar) }}" alt="{{ $kendaraan->nama_kendaraan }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                <div class="w-full h-full bg-gradient-to-br from-primary-200 to-primary-300 flex items-center justify-center text-5xl">🚗</div>
                @endif
                <div class="absolute top-5 left-5">
                    @php
                        $statusColors = [
                            'tersedia' => 'bg-status-success/10 backdrop-blur-md text-status-success border-status-success/20 pulse-soft',
                            'disewa' => 'bg-status-warning/10 backdrop-blur-md text-status-warning border-status-warning/20',
                            'service' => 'bg-status-danger/10 backdrop-blur-md text-status-danger border-status-danger/20',
                        ];
                        $statusColor = $statusColors[$kendaraan->status->value] ?? $statusColors['tersedia'];
                    @endphp
                    <span class="{{ $statusColor }} px-4 py-1.5 rounded-full text-caption-caps text-caption-caps border">{{ $kendaraan->status->label() }}</span>
                </div>
                <div class="absolute top-5 right-5 bg-primary/80 backdrop-blur-md text-on-primary px-4 py-1.5 rounded-xl text-label-md shadow-lg">
                    Rp {{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}<span class="text-[10px] font-light opacity-80 uppercase tracking-widest ml-1">/hari</span>
                </div>
            </div>
            <div class="p-8 flex flex-col flex-grow">
                <div class="mb-6">
                    <h3 class="text-headline-md text-primary mb-2 tracking-tight group-hover:text-secondary transition-colors">{{ $kendaraan->nama_kendaraan }}</h3>
                    <p class="text-body-md text-on-surface-variant/70 font-light">{{ $kendaraan->jenis->label() }} {{ $kendaraan->tahun }}</p>
                </div>
                <div class="grid grid-cols-3 gap-3 mb-10">
                    <div class="icon-box flex flex-col items-center p-3 bg-surface-container-low/50 rounded-xl transition-all duration-300">
                        <span class="material-symbols-outlined text-primary mb-2">airline_seat_recline_extra</span>
                        <span class="text-caption-caps text-[10px] text-on-surface-variant/80 uppercase tracking-tighter">{{ $kendaraan->kapasitas }} Kursi</span>
                    </div>
                    <div class="icon-box flex flex-col items-center p-3 bg-surface-container-low/50 rounded-xl transition-all duration-300">
                        <span class="material-symbols-outlined text-primary mb-2">directions_car</span>
                        <span class="text-caption-caps text-[10px] text-on-surface-variant/80 uppercase tracking-tighter">{{ $kendaraan->warna }}</span>
                    </div>
                    <div class="icon-box flex flex-col items-center p-3 bg-surface-container-low/50 rounded-xl transition-all duration-300">
                        <span class="material-symbols-outlined text-primary mb-2">calendar_today</span>
                        <span class="text-caption-caps text-[10px] text-on-surface-variant/80 uppercase tracking-tighter">{{ $kendaraan->tahun }}</span>
                    </div>
                </div>
                <a href="{{ route('kendaraan.show', $kendaraan) }}"
                   class="mt-auto w-full bg-secondary-container text-on-secondary-container py-4 rounded-xl text-label-md font-bold hover:shadow-xl hover:brightness-105 active:scale-[0.98] transition-all duration-300 text-center block">
                    Lihat Detail
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16">
            <div class="text-5xl mb-4">🚗</div>
            <h3 class="text-headline-md text-on-surface-variant">Tidak ada kendaraan</h3>
            <p class="mt-2 text-on-surface-variant/60">Tidak ditemukan kendaraan yang sesuai dengan filter Anda.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($kendaraans->hasPages())
    <div class="mt-24 flex justify-center items-center space-x-3">
        {{-- Previous Page Link --}}
        @if ($kendaraans->onFirstPage())
        <span class="w-12 h-12 flex items-center justify-center rounded-xl border border-surface-variant/30 text-on-surface-variant/30 cursor-not-allowed">
            <span class="material-symbols-outlined">chevron_left</span>
        </span>
        @else
        <a href="{{ $kendaraans->previousPageUrl() }}" class="w-12 h-12 flex items-center justify-center rounded-xl border border-surface-variant/30 text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-all duration-300">
            <span class="material-symbols-outlined">chevron_left</span>
        </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($kendaraans->getUrlRange(max(1, $kendaraans->currentPage() - 2), min($kendaraans->lastPage(), $kendaraans->currentPage() + 2)) as $page => $url)
        <a href="{{ $url }}" class="w-12 h-12 flex items-center justify-center rounded-xl transition-all duration-300 text-label-md
            {{ $page === $kendaraans->currentPage()
                ? 'bg-primary text-on-primary shadow-lg shadow-primary/20'
                : 'border border-surface-variant/30 text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary' }}">
            {{ $page }}
        </a>
        @endforeach

        {{-- Dots --}}
        @if ($kendaraans->currentPage() + 2 < $kendaraans->lastPage())
        <span class="px-2 text-on-surface-variant/30 font-light">•••</span>
        <a href="{{ $kendaraans->url($kendaraans->lastPage()) }}" class="w-12 h-12 flex items-center justify-center rounded-xl border border-surface-variant/30 text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-all duration-300 text-label-md">
            {{ $kendaraans->lastPage() }}
        </a>
        @endif

        {{-- Next Page Link --}}
        @if ($kendaraans->hasMorePages())
        <a href="{{ $kendaraans->nextPageUrl() }}" class="w-12 h-12 flex items-center justify-center rounded-xl border border-surface-variant/30 text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-all duration-300">
            <span class="material-symbols-outlined">chevron_right</span>
        </a>
        @else
        <span class="w-12 h-12 flex items-center justify-center rounded-xl border border-surface-variant/30 text-on-surface-variant/30 cursor-not-allowed">
            <span class="material-symbols-outlined">chevron_right</span>
        </span>
        @endif
    </div>
    @endif
</main>
@endsection
