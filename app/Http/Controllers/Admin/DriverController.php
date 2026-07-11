<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\JenisSIM;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $query = Driver::query();

        if ($request->filled('search')) {
            $query->where('nama_driver', 'like', '%' . $request->search . '%');
        }

        $drivers = $query->latest()->paginate(15)->withQueryString();

        return view('admin.driver.index', compact('drivers'));
    }

    public function create()
    {
        $simList = JenisSIM::cases();

        return view('admin.driver.create', compact('simList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_driver' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:1000',
            'sim' => 'required|in:' . implode(',', array_column(JenisSIM::cases(), 'value')),
            'tarif_per_hari' => 'required|numeric|min:0',
            'foto' => 'required|image|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/drivers', $filename, 'public');
            $validated['foto'] = $filename;
        }

        Driver::create($validated);

        return redirect()->route('admin.driver.index')
            ->with('success', 'Driver berhasil ditambahkan.');
    }

    public function edit(Driver $driver)
    {
        $simList = JenisSIM::cases();

        return view('admin.driver.edit', compact('driver', 'simList'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'nama_driver' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:1000',
            'sim' => 'required|in:' . implode(',', array_column(JenisSIM::cases(), 'value')),
            'tarif_per_hari' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,tidak_aktif,sedang_bertugas',
            'foto' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if ($driver->foto && Storage::disk('public')->exists('uploads/drivers/' . $driver->foto)) {
                Storage::disk('public')->delete('uploads/drivers/' . $driver->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/drivers', $filename, 'public');
            $validated['foto'] = $filename;
        } else {
            unset($validated['foto']);
        }

        $driver->update($validated);

        return redirect()->route('admin.driver.index')
            ->with('success', 'Driver berhasil diperbarui.');
    }

    public function destroy(Driver $driver)
    {
        if ($driver->foto && Storage::disk('public')->exists('uploads/drivers/' . $driver->foto)) {
            Storage::disk('public')->delete('uploads/drivers/' . $driver->foto);
        }

        $driver->delete();

        return redirect()->route('admin.driver.index')
            ->with('success', 'Driver berhasil dihapus.');
    }
}
