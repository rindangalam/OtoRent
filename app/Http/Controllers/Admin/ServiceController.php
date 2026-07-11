<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceKendaraan;
use App\Models\Kendaraan;
use App\Enums\StatusService;
use App\Enums\StatusKendaraan;
use App\Enums\JenisService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceKendaraan::with('kendaraan');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $services = $query->latest('tanggal_service')->paginate(15)->withQueryString();
        $statusList = StatusService::cases();

        return view('admin.service.index', compact('services', 'statusList'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::all();
        $jenisList = JenisService::cases();

        return view('admin.service.create', compact('kendaraans', 'jenisList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'jenis_service' => 'required|in:' . implode(',', array_column(JenisService::cases(), 'value')),
            'deskripsi' => 'required|string|max:1000',
            'biaya' => 'required|numeric|min:0',
            'tanggal_service' => 'required|date',
            'estimasi_selesai' => 'nullable|date|after_or_equal:tanggal_service',
            'status' => 'required|in:' . implode(',', array_column(StatusService::cases(), 'value')),
        ]);

        ServiceKendaraan::create($validated);

        $kendaraan = Kendaraan::findOrFail($validated['kendaraan_id']);
        $kendaraan->update(['status' => StatusKendaraan::Service]);

        return redirect()->route('admin.service.index')
            ->with('success', 'Record service berhasil ditambahkan.');
    }

    public function edit(ServiceKendaraan $service)
    {
        $kendaraans = Kendaraan::all();
        $jenisList = JenisService::cases();
        $statusList = StatusService::cases();

        return view('admin.service.edit', compact('service', 'kendaraans', 'jenisList', 'statusList'));
    }

    public function update(Request $request, ServiceKendaraan $service)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'jenis_service' => 'required|in:' . implode(',', array_column(JenisService::cases(), 'value')),
            'deskripsi' => 'required|string|max:1000',
            'biaya' => 'required|numeric|min:0',
            'tanggal_service' => 'required|date',
            'estimasi_selesai' => 'nullable|date|after_or_equal:tanggal_service',
            'status' => 'required|in:' . implode(',', array_column(StatusService::cases(), 'value')),
        ]);

        $oldStatus = $service->status;
        $service->update($validated);

        if ($validated['status'] === StatusService::Selesai->value && $oldStatus !== StatusService::Selesai) {
            $service->kendaraan->update(['status' => StatusKendaraan::Tersedia]);
        }

        if ($validated['status'] !== StatusService::Selesai->value && $oldStatus === StatusService::Selesai) {
            $service->kendaraan->update(['status' => StatusKendaraan::Service]);
        }

        return redirect()->route('admin.service.index')
            ->with('success', 'Record service berhasil diperbarui.');
    }

    public function destroy(ServiceKendaraan $service)
    {
        $service->delete();

        return redirect()->route('admin.service.index')
            ->with('success', 'Record service berhasil dihapus.');
    }
}
