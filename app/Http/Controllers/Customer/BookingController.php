<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kendaraan;
use App\Models\Driver;
use App\Enums\StatusBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with('kendaraan')
            ->latest()
            ->paginate(10);

        return view('customer.booking.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        if (!$request->filled('kendaraan_id')) {
            return redirect()->route('kendaraan.index')
                ->with('info', 'Silakan pilih kendaraan terlebih dahulu.');
        }

        $kendaraan = Kendaraan::where('status', 'tersedia')->find($request->kendaraan_id);

        if (!$kendaraan) {
            return redirect()->route('kendaraan.index')
                ->with('error', 'Kendaraan tidak tersedia.');
        }

        $drivers = Driver::where('status', 'aktif')->get();

        return view('customer.booking.create', compact('kendaraan', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tipe_sewa' => 'required|in:driver,lepas_kunci',
            'metode_antar' => 'required_if:tipe_sewa,lepas_kunci|nullable|in:diantar,jemput_sendiri',
            'driver_id' => 'required_if:tipe_sewa,driver|nullable|exists:drivers,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi_jemput' => 'required|string|max:255',
            'lokasi_tujuan' => 'nullable|string|max:255',
            'ongkos_antar' => 'required_if:metode_antar,diantar|nullable|numeric|min:0',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $kendaraan = Kendaraan::findOrFail($validated['kendaraan_id']);
        $mulai = \Carbon\Carbon::parse($validated['tanggal_mulai']);
        $selesai = \Carbon\Carbon::parse($validated['tanggal_selesai']);

        if ($kendaraan->status->value !== 'tersedia') {
            return back()->withInput()
                ->with('error', 'Kendaraan tidak tersedia saat ini.');
        }

        $overlap = Booking::where('kendaraan_id', $kendaraan->id)
            ->whereNotIn('status', [StatusBooking::Completed->value, StatusBooking::Cancelled->value])
            ->where(function ($query) use ($mulai, $selesai) {
                $query->whereBetween('tanggal_mulai', [$mulai, $selesai])
                    ->orWhereBetween('tanggal_selesai', [$mulai, $selesai])
                    ->orWhere(function ($query) use ($mulai, $selesai) {
                        $query->where('tanggal_mulai', '<=', $mulai)
                            ->where('tanggal_selesai', '>=', $selesai);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->withInput()
                ->with('error', 'Kendaraan sudah dibooking pada rentang tanggal tersebut.');
        }

        $durasiHari = $mulai->diffInDays($selesai) + 1;

        $totalKendaraan = $kendaraan->harga_sewa_per_hari * $durasiHari;
        $totalDriver = 0;
        $ongkosAntar = 0;

        if ($validated['tipe_sewa'] === 'driver' && !empty($validated['driver_id'])) {
            $driver = Driver::findOrFail($validated['driver_id']);
            $totalDriver = $driver->tarif_per_hari * $durasiHari;
        }

        if ($validated['tipe_sewa'] === 'lepas_kunci' && ($validated['metode_antar'] ?? '') === 'diantar') {
            $ongkosAntar = $validated['ongkos_antar'] ?? 0;
        }

        $grandTotal = $totalKendaraan + $totalDriver + $ongkosAntar;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'kendaraan_id' => $validated['kendaraan_id'],
            'tipe_sewa' => $validated['tipe_sewa'],
            'metode_antar' => $validated['metode_antar'] ?? null,
            'ongkos_antar' => $ongkosAntar,
            'driver_id' => $validated['driver_id'] ?? null,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'lokasi_jemput' => $validated['lokasi_jemput'],
            'lokasi_tujuan' => $validated['lokasi_tujuan'] ?? null,
            'durasi_hari' => $durasiHari,
            'total_kendaraan' => $totalKendaraan,
            'total_driver' => $totalDriver,
            'grand_total' => $grandTotal,
            'status' => StatusBooking::Pending,
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()->route('booking.show', $booking)
            ->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['kendaraan', 'driver', 'pembayaran']);

        return view('customer.booking.show', compact('booking'));
    }
}
