@props(['status' => '', 'type' => ''])

@php
    $colors = [
        'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        'menunggu' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        'menunggu_verifikasi' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
        'dikonfirmasi' => 'bg-blue-50 text-blue-700 border-blue-200',
        'dijadwalkan' => 'bg-blue-50 text-blue-700 border-blue-200',
        'ongoing' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'sedang_bertugas' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'sedang_dikerjakan' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'completed' => 'bg-green-50 text-green-700 border-green-200',
        'lunas' => 'bg-green-50 text-green-700 border-green-200',
        'selesai' => 'bg-green-50 text-green-700 border-green-200',
        'tersedia' => 'bg-green-50 text-green-700 border-green-200',
        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
        'dibatalkan' => 'bg-red-50 text-red-700 border-red-200',
        'ditolak' => 'bg-red-50 text-red-700 border-red-200',
        'ditidak_aktif' => 'bg-red-50 text-red-700 border-red-200',
        'refund' => 'bg-orange-50 text-orange-700 border-orange-200',
        'belum_bayar' => 'bg-gray-50 text-gray-700 border-gray-200',
        'disewa' => 'bg-amber-50 text-amber-700 border-amber-200',
        'service' => 'bg-amber-50 text-amber-700 border-amber-200',
    ];

    $statusKey = str_replace(' ', '_', strtolower(trim($status)));
    $class = $colors[$statusKey] ?? 'bg-gray-50 text-gray-700 border-gray-200';
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $class }}">
    {{ $status }}
</span>
