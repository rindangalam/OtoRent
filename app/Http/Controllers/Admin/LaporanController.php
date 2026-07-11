<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Enums\StatusPembayaran;
use App\Enums\StatusBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('tahun', Carbon::now()->year);
        $month = $request->input('bulan', Carbon::now()->month);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $totalPendapatan = Pembayaran::where('status', StatusPembayaran::Lunas)
            ->whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->sum('jumlah_bayar');

        $laporanData = Booking::with(['user', 'kendaraan'])
            ->where('status', StatusBooking::Completed)
            ->whereHas('pembayaran', function ($q) use ($startDate, $endDate) {
                $q->where('status', StatusPembayaran::Lunas)
                  ->whereBetween('tanggal_bayar', [$startDate, $endDate]);
            })
            ->latest()
            ->get();

        $totalBooking = $laporanData->count();

        $chartLabels = [];
        $chartData = [];
        for ($m = 1; $m <= 12; $m++) {
            $mStart = Carbon::createFromDate($year, $m, 1)->startOfMonth();
            $mEnd = Carbon::createFromDate($year, $m, 1)->endOfMonth();
            $chartLabels[] = Carbon::create()->month($m)->translatedFormat('M');
            $chartData[] = Pembayaran::where('status', StatusPembayaran::Lunas)
                ->whereBetween('tanggal_bayar', [$mStart, $mEnd])
                ->sum('jumlah_bayar');
        }

        return view('admin.laporan.index', compact(
            'year',
            'month',
            'totalPendapatan',
            'totalBooking',
            'laporanData',
            'chartLabels',
            'chartData'
        ));
    }
}
