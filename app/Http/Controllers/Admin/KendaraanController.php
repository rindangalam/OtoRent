<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\JenisKendaraan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kendaraan::query();

        if ($request->filled('search')) {
            $query->where('nama_kendaraan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $kendaraans = $query->latest()->paginate(15)->withQueryString();
        $jenisList = JenisKendaraan::cases();

        return view('admin.kendaraan.index', compact('kendaraans', 'jenisList'));
    }

    public function create()
    {
        $jenisList = JenisKendaraan::cases();

        return view('admin.kendaraan.create', compact('jenisList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20|unique:kendaraans,plat_nomor',
            'jenis' => 'required|in:' . implode(',', array_column(JenisKendaraan::cases(), 'value')),
            'warna' => 'required|string|max:50',
            'tahun' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'kapasitas' => 'required|integer|min:1|max:20',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'gambar' => 'required|image|max:5120',
            'deskripsi' => 'required|string|max:1000',
        ]);

        $file = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('uploads/kendaraan', $filename, 'public');
        $validated['gambar'] = $filename;

        Kendaraan::create($validated);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        $jenisList = JenisKendaraan::cases();

        return view('admin.kendaraan.edit', compact('kendaraan', 'jenisList'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20|unique:kendaraans,plat_nomor,' . $kendaraan->id,
            'jenis' => 'required|in:' . implode(',', array_column(JenisKendaraan::cases(), 'value')),
            'warna' => 'required|string|max:50',
            'tahun' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'kapasitas' => 'required|integer|min:1|max:20',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|max:5120',
            'deskripsi' => 'required|string|max:1000',
            'status' => 'required|in:tersedia,disewa,service',
        ]);

        if ($request->hasFile('gambar')) {
            if ($kendaraan->gambar && Storage::disk('public')->exists('uploads/kendaraan/' . $kendaraan->gambar)) {
                Storage::disk('public')->delete('uploads/kendaraan/' . $kendaraan->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/kendaraan', $filename, 'public');
            $validated['gambar'] = $filename;
        } else {
            unset($validated['gambar']);
        }

        $kendaraan->update($validated);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $hasActiveBooking = $kendaraan->bookings()
            ->whereIn('status', ['pending', 'confirmed', 'ongoing'])
            ->exists();

        if ($hasActiveBooking) {
            return redirect()->route('admin.kendaraan.index')
                ->with('error', 'Tidak bisa menghapus kendaraan yang memiliki booking aktif.');
        }

        if ($kendaraan->gambar && Storage::disk('public')->exists('uploads/kendaraan/' . $kendaraan->gambar)) {
            Storage::disk('public')->delete('uploads/kendaraan/' . $kendaraan->gambar);
        }

        $kendaraan->delete();

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}
