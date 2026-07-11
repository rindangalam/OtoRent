<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\ServiceKendaraan;
use App\Enums\StatusBooking;
use App\Enums\StatusPembayaran;
use App\Enums\StatusService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKendaraan = Kendaraan::count();
        $kendaraanTersedia = Kendaraan::where('status', 'tersedia')->count();
        $kendaraanDisewa = Kendaraan::where('status', 'disewa')->count();
        $kendaraanService = Kendaraan::where('status', 'service')->count();

        $activeBookings = Booking::whereIn('status', [
            StatusBooking::Confirmed,
            StatusBooking::Ongoing,
        ])->count();

        $totalRevenue = Pembayaran::where('status', StatusPembayaran::Lunas)
            ->whereMonth('tanggal_bayar', Carbon::now()->month)
            ->whereYear('tanggal_bayar', Carbon::now()->year)
            ->sum('jumlah_bayar');

        $pendingService = ServiceKendaraan::whereIn('status', [
            StatusService::Dijadwalkan,
            StatusService::SedangDikerjakan,
        ])->count();

        $recentBookings = Booking::with(['user', 'kendaraan'])
            ->latest()
            ->take(5)
            ->get();

        $statusKendaraan = [
            'tersedia' => $kendaraanTersedia,
            'disewa' => $kendaraanDisewa,
            'service' => $kendaraanService,
        ];

        return view('admin.dashboard', compact(
            'totalKendaraan',
            'activeBookings',
            'totalRevenue',
            'pendingService',
            'recentBookings',
            'statusKendaraan'
        ));
    }
}
