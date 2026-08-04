<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Enums\MetodePembayaran;
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

        if (!in_array($booking->status->value, ['pending', 'confirmed'])) {
            return redirect()->route('booking.show', $booking)
                ->with('error', 'Booking ini sudah diproses pembayarannya.');
        }

        if ($booking->pembayaran && $booking->pembayaran->status->value === StatusPembayaran::MenungguVerifikasi->value) {
            return redirect()->route('booking.show', $booking)
                ->with('error', 'Pembayaran sedang menunggu verifikasi admin.');
        }

        $booking->load('kendaraan');

        return view('customer.pembayaran.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($booking->status->value, ['pending', 'confirmed'])) {
            return redirect()->route('booking.show', $booking)
                ->with('error', 'Booking ini sudah diproses pembayarannya.');
        }

        if ($booking->pembayaran && $booking->pembayaran->status->value === StatusPembayaran::MenungguVerifikasi->value) {
            return redirect()->route('booking.show', $booking)
                ->with('error', 'Pembayaran sudah dikirim dan sedang menunggu verifikasi.');
        }

        $validated = $request->validate([
            'bukti_bayar' => 'required|image|max:2048',
            'metode' => 'required|in:' . implode(',', array_column(MetodePembayaran::cases(), 'value')),
        ]);

        $file = $request->file('bukti_bayar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('uploads/bukti-bayar', $filename, 'public');

        if ($booking->pembayaran && $booking->pembayaran->status->value === StatusPembayaran::Ditolak->value) {
            $booking->pembayaran->update([
                'metode' => $validated['metode'],
                'bukti_bayar' => $filename,
                'status' => StatusPembayaran::MenungguVerifikasi,
                'tanggal_bayar' => now(),
            ]);
        } else {
            Pembayaran::create([
                'booking_id' => $booking->id,
                'metode' => $validated['metode'],
                'jumlah_bayar' => $booking->grand_total,
                'status' => StatusPembayaran::MenungguVerifikasi,
                'bukti_bayar' => $filename,
                'tanggal_bayar' => now(),
            ]);
        }

        return redirect()->route('booking.show', $booking)
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }
}
