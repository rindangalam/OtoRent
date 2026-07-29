@props(['status' => '', 'type' => ''])

@php
    $colors = [
        'pending' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
        'menunggu' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
        'menunggu_verifikasi' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
        'confirmed' => 'bg-status-info/10 text-status-info border-status-info/20',
        'dikonfirmasi' => 'bg-status-info/10 text-status-info border-status-info/20',
        'dijadwalkan' => 'bg-status-info/10 text-status-info border-status-info/20',
        'ongoing' => 'bg-status-info/10 text-status-info border-status-info/20',
        'sedang_bertugas' => 'bg-status-info/10 text-status-info border-status-info/20',
        'sedang_dikerjakan' => 'bg-status-info/10 text-status-info border-status-info/20',
        'completed' => 'bg-status-success/10 text-status-success border-status-success/20',
        'lunas' => 'bg-status-success/10 text-status-success border-status-success/20',
        'selesai' => 'bg-status-success/10 text-status-success border-status-success/20',
        'tersedia' => 'bg-status-success/10 text-status-success border-status-success/20',
        'cancelled' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
        'dibatalkan' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
        'ditolak' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
        'tidak_aktif' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
        'refund' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
        'belum_bayar' => 'bg-surface-container-high text-on-surface-variant border-outline-variant/20',
        'disewa' => 'bg-status-info/10 text-status-info border-status-info/20',
        'service' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
    ];

    $statusKey = str_replace(' ', '_', strtolower(trim($status)));
    $class = $colors[$statusKey] ?? 'bg-surface-container-high text-on-surface-variant border-outline-variant/20';
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $class }}">
    {{ $status }}
</span>
