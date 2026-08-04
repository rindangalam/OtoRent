@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
<style>
    .animate-in {
        animation: slideUpFade 0.6s ease-out forwards;
        opacity: 0;
    }
    @keyframes slideUpFade {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }
    .stagger-5 { animation-delay: 0.5s; }
    @keyframes pulse-soft {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.05); }
        100% { opacity: 1; transform: scale(1); }
    }
    .pulse-timer {
        animation: pulse-soft 2s infinite ease-in-out;
    }
    @keyframes slideFromRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .table-row-animate {
        opacity: 0;
        animation: slideFromRight 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

{{-- Welcome Header --}}
<header class="flex justify-between items-center animate-in stagger-1">
    <div>
        <h2 class="text-headline-lg text-headline-lg text-primary flex items-center gap-2">
            Halo, {{ auth()->user()->name }} <span class="inline-block animate-wave" style="animation: wave 1.5s infinite ease-in-out; transform-origin: 70% 70%;">👋</span>
        </h2>
        <p class="text-on-surface-variant text-body-md">Selamat datang kembali! Perjalanan Anda berikutnya menanti.</p>
    </div>
    <div class="flex items-center gap-4">
        <button class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-variant transition-colors relative">
            <span class="material-symbols-outlined">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 bg-status-danger rounded-full"></span>
        </button>
        <div class="w-10 h-10 rounded-full bg-primary-fixed overflow-hidden border-2 border-primary/10 flex items-center justify-center text-primary font-bold text-sm">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>
</header>

{{-- Stat Cards --}}
<section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-8 animate-in stagger-2">
    <div class="glass-card p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-primary-fixed text-primary rounded-lg">
                <span class="material-symbols-outlined">event_available</span>
            </div>
            @if($activeBookings > 0)
            <span class="text-status-success text-label-md flex items-center">+{{ $activeBookings }}</span>
            @endif
        </div>
        <p class="text-label-md text-on-surface-variant">Booking Aktif</p>
        <h3 class="text-2xl font-bold text-primary mt-1 counter" data-target="{{ $activeBookings }}">0</h3>
    </div>
    <div class="glass-card p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-surface-container-high text-on-surface-variant rounded-lg">
                <span class="material-symbols-outlined">task_alt</span>
            </div>
        </div>
        <p class="text-label-md text-on-surface-variant">Total Selesai</p>
        <h3 class="text-2xl font-bold text-primary mt-1 counter" data-target="{{ $completedCount }}">0</h3>
    </div>
    <div class="glass-card p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-secondary-fixed text-secondary rounded-lg">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">stars</span>
            </div>
        </div>
        <p class="text-label-md text-on-surface-variant">Total Booking</p>
        <h3 class="text-2xl font-bold text-primary mt-1 counter" data-target="{{ $totalBooking }}">0</h3>
    </div>
    <div class="glass-card p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-tertiary-fixed text-tertiary rounded-lg">
                <span class="material-symbols-outlined">confirmation_number</span>
            </div>
        </div>
        <p class="text-label-md text-on-surface-variant">Berlangsung</p>
        <h3 class="text-2xl font-bold text-primary mt-1 counter" data-target="{{ $ongoingCount }}">0</h3>
    </div>
</section>

{{-- Recent Bookings Table --}}
<section class="glass-card rounded-xl shadow-sm overflow-hidden mt-8 animate-in stagger-3">
    <div class="p-6 border-b border-outline-variant/20 flex justify-between items-center">
        <h3 class="text-headline-md text-primary">Booking Terakhir</h3>
        <a href="{{ route('booking.index') }}" class="text-primary text-label-md hover:underline decoration-secondary-container decoration-2 underline-offset-4">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-surface-container-low text-on-surface-variant text-label-md">
                <tr>
                    <th class="px-6 py-4">Kendaraan</th>
                    <th class="px-6 py-4">Tgl Sewa</th>
                    <th class="px-6 py-4">Total Biaya</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse ($recentBookings as $booking)
                <tr class="table-row-animate stagger-{{ min($loop->index + 1, 5) }} hover:bg-surface-container-lowest/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-10 rounded-md overflow-hidden bg-surface-container shadow-inner flex items-center justify-center text-lg">
                                🚗
                            </div>
                            <div>
                                <p class="text-label-md text-primary">{{ $booking->kendaraan->nama_kendaraan }}</p>
                                <p class="text-xs text-on-surface-variant">#{{ $booking->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-body-md text-on-surface">{{ $booking->tanggal_mulai->format('d M') }} - {{ $booking->tanggal_selesai->format('d M Y') }}</td>
                    <td class="px-6 py-4 font-bold text-primary">Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusStyles = [
                                'pending' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                                'confirmed' => 'bg-status-info/10 text-status-info border-status-info/20',
                                'ongoing' => 'bg-status-info/10 text-status-info border-status-info/20',
                                'completed' => 'bg-status-success/10 text-status-success border-status-success/20',
                                'cancelled' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
                            ];
                            $style = $statusStyles[$booking->status->value] ?? 'bg-surface-container-low text-on-surface-variant';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $style }} border">{{ $booking->status->label() }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('booking.show', $booking) }}" class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors">arrow_forward</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl block mb-2">event_busy</span>
                        Belum ada booking.
                        <a href="{{ route('booking.create') }}" class="block text-primary hover:underline mt-2">Booking sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const elements = document.querySelectorAll('.animate-in');
        elements.forEach(el => { el.style.opacity = '1'; });

        const counters = document.querySelectorAll('.counter');
        if (counters.length > 0) {
            const speed = 200;
            const startCounters = () => {
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const inc = target / speed;
                    const updateCount = () => {
                        const currentCount = +counter.innerText;
                        if (currentCount < target) {
                            counter.innerText = Math.ceil(currentCount + inc);
                            setTimeout(updateCount, 1);
                        } else {
                            counter.innerText = target.toLocaleString();
                        }
                    };
                    updateCount();
                });
            };
            setTimeout(startCounters, 400);
        }

        const cards = document.querySelectorAll('.glass-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                const icon = card.querySelector('.material-symbols-outlined');
                if (icon) {
                    icon.style.transform = 'scale(1.2) rotate(-10deg)';
                    icon.style.transition = 'transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
                }
            });
            card.addEventListener('mouseleave', () => {
                const icon = card.querySelector('.material-symbols-outlined');
                if (icon) {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                }
            });
        });
    });
</script>
@endsection

@section('right-panel')
<style>
    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(15deg); }
        75% { transform: rotate(-15deg); }
    }
</style>

{{-- Current Trip Tracking --}}
<section class="animate-in stagger-4">
    <h4 class="text-label-md text-primary mb-4 uppercase tracking-widest text-xs">Perjalanan Saat Ini</h4>
    @php
        $currentTrip = $recentBookings->firstWhere('status', \App\Enums\StatusBooking::Ongoing);
    @endphp
    @if($currentTrip)
    <div class="bg-primary text-on-primary p-6 rounded-2xl shadow-xl relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-secondary-container/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative z-10 space-y-4">
            <div class="flex justify-between items-center">
                <span class="px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[10px] font-black rounded uppercase pulse-timer">Aktif</span>
                <span class="text-xs opacity-70">Berlangsung</span>
            </div>
            <div>
                <p class="text-xs opacity-70 mb-1">{{ $currentTrip->kendaraan->nama_kendaraan }}</p>
                <h5 class="text-headline-md text-lg">#{{ $currentTrip->kendaraan->plat_nomor ?? 'N/A' }}</h5>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-xs">
                    <span>Durasi</span>
                    <span>{{ $currentTrip->tanggal_mulai->diffInDays($currentTrip->tanggal_selesai) + 1 }} Hari</span>
                </div>
                <div class="w-full bg-on-primary/20 h-1.5 rounded-full overflow-hidden">
                    @php
                        $totalDays = $currentTrip->tanggal_mulai->diffInDays($currentTrip->tanggal_selesai) + 1;
                        $elapsedDays = $currentTrip->tanggal_mulai->diffInDays(now());
                        $progress = min(100, max(0, ($elapsedDays / max(1, $totalDays)) * 100));
                    @endphp
                    <div class="bg-secondary-container h-full transition-all duration-1000 ease-out" style="width: {{ $progress }}%"></div>
                </div>
            </div>
            <button class="w-full py-3 bg-on-primary text-primary font-bold rounded-lg hover:bg-secondary-container hover:text-on-secondary-container hover:shadow-lg transition-all flex items-center justify-center gap-2 text-sm">
                <span class="material-symbols-outlined text-sm">location_on</span>
                Lacak Lokasi
            </button>
        </div>
    </div>
    @else
    <div class="bg-primary text-on-primary p-6 rounded-2xl shadow-xl relative overflow-hidden">
        <div class="relative z-10 space-y-4 text-center">
            <span class="material-symbols-outlined text-4xl opacity-50">directions_car</span>
            <p class="text-sm opacity-70">Tidak ada perjalanan aktif saat ini.</p>
            <a href="{{ route('booking.create') }}" class="inline-block py-3 px-6 bg-on-primary text-primary font-bold rounded-lg hover:bg-secondary-container hover:text-on-secondary-container transition-all text-sm">Sewa Sekarang</a>
        </div>
    </div>
    @endif
</section>

{{-- Promo Banner --}}
<section class="mt-8 bg-secondary-container/10 border-2 border-dashed border-secondary-container/30 p-4 rounded-xl hover:bg-secondary-container/20 transition-all duration-300 animate-in stagger-4" style="animation-delay: 0.5s">
    <div class="flex items-center gap-3 mb-2">
        <span class="material-symbols-outlined text-secondary-container animate-bounce">redeem</span>
        <h5 class="font-bold text-sm text-primary">Promo Akhir Pekan!</h5>
    </div>
    <p class="text-xs text-on-surface-variant mb-3">Gunakan kode <span class="font-bold text-primary">OTOULTRA</span> untuk diskon 25% semua tipe SUV.</p>
    <button class="text-xs font-bold text-secondary-container hover:text-secondary transition-colors uppercase tracking-wider">Klaim Sekarang</button>
</section>
@endsection
