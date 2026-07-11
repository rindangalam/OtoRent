@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Driver</h1>
        <a href="{{ route('admin.driver.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Baru
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            @if($drivers->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600 mb-1">Belum ada driver</h3>
                    <p class="text-sm text-gray-400">Mulai tambahkan data driver baru.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50/50">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">No Telp</th>
                            <th class="px-6 py-3">SIM</th>
                            <th class="px-6 py-3">Tarif/Hari</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($drivers as $driver)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-primary-50 overflow-hidden flex-shrink-0">
                                        @if($driver->foto)
                                            <img src="{{ asset('storage/uploads/drivers/' . $driver->foto) }}" alt="{{ $driver->nama_driver }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-primary-400 text-sm font-semibold">
                                                {{ substr($driver->nama_driver, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">{{ $driver->nama_driver }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $driver->no_telp }}</td>
                            <td class="px-6 py-3">
                                <span class="text-sm text-gray-600">{{ $driver->sim->label() }}</span>
                            </td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($driver->tarif_per_hari, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $statusColors = [
                                        'aktif' => 'bg-green-50 text-green-700 border-green-200',
                                        'tidak_aktif' => 'bg-gray-50 text-gray-700 border-gray-200',
                                        'sedang_bertugas' => 'bg-blue-50 text-blue-700 border-blue-200',
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
                                    <a href="{{ route('admin.driver.edit', $driver) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.driver.destroy', $driver) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus driver ini?')">
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
    </div>
</div>
@endsection
