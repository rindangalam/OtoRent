<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Booking;
use App\Enums\StatusPembayaran;
use App\Enums\StatusBooking;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['booking.user', 'booking.kendaraan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pembayarans = $query->latest()->paginate(15)->withQueryString();
        $statusList = StatusPembayaran::cases();

        return view('admin.pembayaran.index', compact('pembayarans', 'statusList'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['booking.user', 'booking.kendaraan', 'booking.driver']);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function verifikasi(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $pembayaran->update([
            'status' => StatusPembayaran::Lunas,
            'catatan_admin' => $validated['catatan_admin'] ?? 'Pembayaran diverifikasi',
        ]);

        $pembayaran->booking->update([
            'status' => StatusBooking::Confirmed,
        ]);

        return redirect()->route('admin.pembayaran.show', $pembayaran)
            ->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function tolak(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'catatan_admin' => 'required|string|max:1000',
        ]);

        $pembayaran->update([
            'status' => StatusPembayaran::Ditolak,
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return redirect()->route('admin.pembayaran.show', $pembayaran)
            ->with('success', 'Pembayaran berhasil ditolak.');
    }
}
