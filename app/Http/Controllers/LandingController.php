<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;

class LandingController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::where('status', 'tersedia')
            ->latest()
            ->take(4)
            ->get();

        return view('landing', compact('kendaraans'));
    }
}
