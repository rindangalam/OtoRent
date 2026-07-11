<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Driver;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['driver', 'kendaraan']);

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->driver_id);
        }

        $jadwals = $query->latest('tanggal')->paginate(15)->withQueryString();
        $drivers = Driver::where('status', 'aktif')->get();
        $kendaraans = Kendaraan::all();

        return view('admin.jadwal.index', compact('jadwals', 'drivers', 'kendaraans'));
    }

    public function create()
    {
        $drivers = Driver::where('status', 'aktif')->get();
        $kendaraans = Kendaraan::all();

        return view('admin.jadwal.create', compact('drivers', 'kendaraans'));
    }

    public function edit(Jadwal $jadwal)
    {
        $drivers = Driver::where('status', 'aktif')->get();
        $kendaraans = Kendaraan::all();

        return view('admin.jadwal.edit', compact('jadwal', 'drivers', 'kendaraans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        Jadwal::create($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
