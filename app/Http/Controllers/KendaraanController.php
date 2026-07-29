<?php

namespace App\Http\Controllers;

use App\Enums\JenisKendaraan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

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

        $sort = $request->get('sort', 'terbaru');
        $sortOrder = match ($sort) {
            'harga_terendah' => ['harga_sewa_per_hari', 'asc'],
            'harga_tertinggi' => ['harga_sewa_per_hari', 'desc'],
            default => ['created_at', 'desc'],
        };
        $query->orderBy($sortOrder[0], $sortOrder[1]);

        $kendaraans = $query->paginate(12)->withQueryString();
        $jenisList = JenisKendaraan::cases();

        return view('kendaraan.index', compact('kendaraans', 'jenisList'));
    }

    public function show(Kendaraan $kendaraan)
    {
        return view('kendaraan.show', compact('kendaraan'));
    }
}
