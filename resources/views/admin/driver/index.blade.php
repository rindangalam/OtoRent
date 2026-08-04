@extends('layouts.admin')
@section('title', 'Driver')
@section('content')
<style>
    .fade-in { opacity: 0; animation: fadeSlideIn 0.4s ease-out forwards; }
    @keyframes fadeSlideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.1s; }
</style>
<div class="space-y-6 fade-in stagger-1">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-headline-md text-on-surface">Driver</h1>
        <a href="{{ route('admin.driver.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-secondary-container text-on-secondary-container text-label-md rounded-xl hover:opacity-90 transition-all">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Baru
        </a>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/20 fade-in stagger-2">
        <div class="overflow-x-auto">
            @if($drivers->isEmpty())
                <div class="p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-outline-variant/50 mx-auto mb-4 block">person</span>
                    <h3 class="font-bold text-on-surface-variant mb-1">Belum ada driver</h3>
                    <p class="text-body-md text-on-surface-variant">Mulai tambahkan data driver baru.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-caption-caps text-on-surface-variant uppercase tracking-wider bg-surface-container-low">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">No Telp</th>
                            <th class="px-6 py-3">SIM</th>
                            <th class="px-6 py-3">Tarif/Hari</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @foreach($drivers as $driver)
                        <tr class="hover:bg-surface-container/50 transition-colors duration-150">
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-primary-container overflow-hidden flex-shrink-0">
                                        @if($driver->foto)
                                            <img src="{{ asset('storage/uploads/drivers/' . $driver->foto) }}" alt="{{ $driver->nama_driver }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-on-primary-container text-sm font-semibold">
                                                {{ substr($driver->nama_driver, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-body-md font-medium text-on-surface">{{ $driver->nama_driver }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-body-md text-on-surface-variant">{{ $driver->no_telp }}</td>
                            <td class="px-6 py-3">
                                <span class="text-body-md text-on-surface-variant">{{ $driver->sim->label() }}</span>
                            </td>
                            <td class="px-6 py-3 text-body-md font-medium text-on-surface">Rp {{ number_format($driver->tarif_per_hari, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $statusColors = [
                                        'aktif' => 'bg-status-success/10 text-status-success border-status-success/20',
                                        'tidak_aktif' => 'bg-surface-container-high text-on-surface-variant border-outline-variant/20',
                                        'sedang_bertugas' => 'bg-status-info/10 text-status-info border-status-info/20',
                                    ];
                                    $statusLabels = [
                                        'aktif' => 'Aktif',
                                        'tidak_aktif' => 'Tidak Aktif',
                                        'sedang_bertugas' => 'Sedang Bertugas',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusColors[$driver->status] ?? '' }}">
                                    {{ $statusLabels[$driver->status] ?? $driver->status }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.driver.edit', $driver) }}" class="p-2 text-on-surface-variant hover:text-status-info hover:bg-status-info/10 rounded-xl transition" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.driver.destroy', $driver) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus driver ini?')">
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
    </div>
</div>
@endsection
