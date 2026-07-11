<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Enums\StatusPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function create(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status->value !== 'pending') {
            return redirect()->route('booking.show', $booking)
                ->with('error', 'Booking ini sudah diproses pembayarannya.');
        }

        $booking->load('kendaraan');

        return view('customer.pembayaran.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'bukti_bayar' => 'required|image|max:2048',
        ]);

        $file = $request->file('bukti_bayar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('uploads/bukti-bayar', $filename, 'public');

        Pembayaran::create([
            'booking_id' => $booking->id,
            'metode' => 'transfer_manual',
            'jumlah_bayar' => $booking->grand_total,
            'status' => StatusPembayaran::MenungguVerifikasi,
            'bukti_bayar' => $filename,
            'tanggal_bayar' => now(),
        ]);

        return redirect()->route('booking.show', $booking)
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }
}
