<?php

namespace App\Http\Controllers;

use App\Enums\JenisKendaraan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kendaraan::where('status', 'tersedia');

        if ($request->filled('search')) {
            $query->where('nama_kendaraan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $kendaraans = $query->latest()->paginate(12)->withQueryString();
        $jenisList = JenisKendaraan::cases();

        return view('kendaraan.index', compact('kendaraans', 'jenisList'));
    }

    public function show(Kendaraan $kendaraan)
    {
        return view('kendaraan.show', compact('kendaraan'));
    }
}
