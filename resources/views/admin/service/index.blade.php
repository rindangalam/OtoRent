@extends('layouts.admin')
@section('title', 'Service Kendaraan')
@section('content')
<style>
    .fade-in { opacity: 0; animation: fadeSlideIn 0.4s ease-out forwards; }
    @keyframes fadeSlideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.1s; }
</style>
<div class="space-y-6 fade-in stagger-1">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-headline-md text-on-surface">Service Kendaraan</h1>
        <a href="{{ route('admin.service.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl hover:opacity-90 transition-all">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Jadwalkan Service
        </a>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 fade-in stagger-2">
        <div class="overflow-x-auto">
            @if($services->isEmpty())
                <div class="p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-outline-variant/50 mx-auto mb-4 block">build</span>
                    <h3 class="font-bold text-on-surface-variant mb-1">Belum ada jadwal service</h3>
                    <p class="text-body-md text-on-surface-variant">Jadwalkan service kendaraan untuk perawatan rutin atau perbaikan.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-caption-caps text-on-surface-variant uppercase tracking-wider bg-surface-container-low">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Kendaraan</th>
                            <th class="px-6 py-3">Jenis</th>
                            <th class="px-6 py-3">Deskripsi</th>
                            <th class="px-6 py-3">Biaya</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @foreach($services as $service)
                        <tr class="hover:bg-surface-container/50 transition-colors duration-150">
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-body-md font-medium text-on-surface">{{ $service->kendaraan->nama_kendaraan ?? '-' }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $jenisColors = [
                                        'rutin' => 'bg-status-info/10 text-status-info border-status-info/20',
                                        'perbaikan' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                                        'ganti_suku_cadang' => 'bg-status-danger/10 text-status-danger border-status-danger/20',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $jenisColors[$service->jenis_service->value] ?? '' }}">
                                    {{ $service->jenis_service->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant max-w-xs truncate">{{ $service->deskripsi }}</td>
                            <td class="px-6 py-3 text-body-md font-medium text-on-surface">Rp {{ number_format($service->biaya, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ \Carbon\Carbon::parse($service->tanggal_service)->format('d M Y') }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $serviceColors = [
                                        'dijadwalkan' => 'bg-status-info/10 text-status-info border-status-info/20',
                                        'sedang_dikerjakan' => 'bg-status-warning/10 text-status-warning border-status-warning/20',
                                        'selesai' => 'bg-status-success/10 text-status-success border-status-success/20',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $serviceColors[$service->status->value] ?? '' }}">
                                    {{ $service->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.service.edit', $service) }}" class="p-2 text-on-surface-variant hover:text-status-info hover:bg-status-info/10 rounded-xl transition" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.service.destroy', $service) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal service ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-on-surface-variant hover:text-status-danger hover:bg-status-danger/10 rounded-xl transition" title="Hapus">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if($services->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10">
            {{ $services->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
