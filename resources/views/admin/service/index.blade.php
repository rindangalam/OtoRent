@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Service Kendaraan</h1>
        <a href="{{ route('admin.service.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Jadwalkan Service
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            @if($services->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600 mb-1">Belum ada jadwal service</h3>
                    <p class="text-sm text-gray-400">Jadwalkan service kendaraan untuk perawatan rutin atau perbaikan.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50/50">
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
                    <tbody class="divide-y divide-gray-50">
                        @foreach($services as $service)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $service->kendaraan->nama_kendaraan ?? '-' }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $jenisColors = [
                                        'rutin' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'perbaikan' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'ganti_suku_cadang' => 'bg-red-50 text-red-700 border-red-200',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $jenisColors[$service->jenis_service->value] ?? '' }}">
                                    {{ $service->jenis_service->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600 max-w-xs truncate">{{ $service->deskripsi }}</td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($service->biaya, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($service->tanggal_service)->format('d M Y') }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $serviceColors = [
                                        'dijadwalkan' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'sedang_dikerjakan' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'selesai' => 'bg-green-50 text-green-700 border-green-200',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $serviceColors[$service->status->value] ?? '' }}">
                                    {{ $service->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.service.edit', $service) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.service.destroy', $service) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal service ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
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
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $services->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
