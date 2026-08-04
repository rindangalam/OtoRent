<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\PembayaranController;
use App\Http\Controllers\Customer\ProfilController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KendaraanController as AdminKendaraan;
use App\Http\Controllers\Admin\DriverController as AdminDriver;
use App\Http\Controllers\Admin\JadwalController as AdminJadwal;
use App\Http\Controllers\Admin\BookingController as AdminBooking;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaran;
use App\Http\Controllers\Admin\ServiceController as AdminService;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/layanan', [PublicPageController::class, 'layanan'])->name('layanan');
Route::get('/kontak', [PublicPageController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [PublicPageController::class, 'kontakStore'])->name('kontak.store');
Route::get('/kendaraan', [KendaraanController::class, 'index'])->name('kendaraan.index');
Route::get('/kendaraan/{kendaraan}', [KendaraanController::class, 'show'])->name('kendaraan.show');

// Profile routes (Breeze compatibility)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Customer routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/booking/{booking}/bayar', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/booking/{booking}/bayar', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

// Admin routes
Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('kendaraan', AdminKendaraan::class)->except(['show']);
    Route::resource('driver', AdminDriver::class)->except(['show']);
    Route::get('jadwal', [AdminJadwal::class, 'index'])->name('jadwal.index');
    Route::get('jadwal/create', [AdminJadwal::class, 'create'])->name('jadwal.create');
    Route::post('jadwal', [AdminJadwal::class, 'store'])->name('jadwal.store');
    Route::get('jadwal/{jadwal}/edit', [AdminJadwal::class, 'edit'])->name('jadwal.edit');
    Route::put('jadwal/{jadwal}', [AdminJadwal::class, 'update'])->name('jadwal.update');
    Route::delete('jadwal/{jadwal}', [AdminJadwal::class, 'destroy'])->name('jadwal.destroy');
    Route::get('booking', [AdminBooking::class, 'index'])->name('booking.index');
    Route::get('booking/{booking}', [AdminBooking::class, 'show'])->name('booking.show');
    Route::put('booking/{booking}/status', [AdminBooking::class, 'updateStatus'])->name('booking.updateStatus');
    Route::get('pembayaran', [AdminPembayaran::class, 'index'])->name('pembayaran.index');
    Route::get('pembayaran/{pembayaran}', [AdminPembayaran::class, 'show'])->name('pembayaran.show');
    Route::put('pembayaran/{pembayaran}/verifikasi', [AdminPembayaran::class, 'verifikasi'])->name('pembayaran.verifikasi');
    Route::put('pembayaran/{pembayaran}/tolak', [AdminPembayaran::class, 'tolak'])->name('pembayaran.tolak');
    Route::resource('service', AdminService::class)->except(['show']);
    Route::get('laporan', [AdminLaporan::class, 'index'])->name('laporan.index');
});

require __DIR__.'/auth.php';
