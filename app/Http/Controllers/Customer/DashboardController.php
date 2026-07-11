<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Enums\StatusBooking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalBooking = $user->bookings()->count();
        $activeBookings = $user->bookings()->whereIn('status', [StatusBooking::Pending, StatusBooking::Confirmed])->count();
        $ongoingCount = $user->bookings()->where('status', StatusBooking::Ongoing)->count();
        $completedCount = $user->bookings()->where('status', StatusBooking::Completed)->count();
        $recentBookings = $user->bookings()->with('kendaraan')->latest()->take(5)->get();

        return view('customer.dashboard', compact(
            'totalBooking',
            'activeBookings',
            'ongoingCount',
            'completedCount',
            'recentBookings'
        ));
    }
}
