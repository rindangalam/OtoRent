<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Enums\StatusBooking;
use App\Enums\StatusKendaraan;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'kendaraan', 'driver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();
        $statusList = StatusBooking::cases();

        return view('admin.booking.index', compact('bookings', 'statusList'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'kendaraan', 'driver', 'pembayaran']);

        return view('admin.booking.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,ongoing,completed,cancelled',
        ]);

        $newStatus = StatusBooking::from($validated['status']);
        $booking->update(['status' => $newStatus]);

        match ($newStatus) {
            StatusBooking::Ongoing => $this->handleOngoing($booking),
            StatusBooking::Completed => $this->handleCompleted($booking),
            StatusBooking::Cancelled => $this->handleCancelled($booking),
            default => null,
        };

        return redirect()->route('admin.booking.show', $booking)
            ->with('success', 'Status booking berhasil diperbarui.');
    }

    private function handleOngoing(Booking $booking): void
    {
        $booking->kendaraan->update(['status' => StatusKendaraan::Disewa]);

        if ($booking->driver) {
            $booking->driver->update(['status' => 'sedang_bertugas']);
        }
    }

    private function handleCompleted(Booking $booking): void
    {
        $booking->kendaraan->update(['status' => StatusKendaraan::Tersedia]);

        if ($booking->driver) {
            $booking->driver->update(['status' => 'aktif']);
        }
    }

    private function handleCancelled(Booking $booking): void
    {
        $booking->kendaraan->update(['status' => StatusKendaraan::Tersedia]);

        if ($booking->driver) {
            $booking->driver->update(['status' => 'aktif']);
        }
    }
}
