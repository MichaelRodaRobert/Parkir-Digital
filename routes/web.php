<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route Profile (Laravel Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Khusus Pengguna Parkir
Route::middleware(['auth', 'role:pengguna'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::post('/booking', [UserController::class, 'storeBooking'])->name('booking.store');
    Route::post('/payment/{bookingId}', [UserController::class, 'storePayment'])->name('payment.store');
});

// Route Khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Verifikasi Akun User
    Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
    Route::patch('/users/{id}/status', [AdminController::class, 'updateStatusUser'])->name('users.updateStatus');

    // Verifikasi Pemesanan
    Route::get('/bookings', [AdminController::class, 'indexBookings'])->name('bookings.index');
    Route::patch('/bookings/{id}/status', [AdminController::class, 'updateStatusBooking'])->name('bookings.updateStatus');

    // Verifikasi Pembayaran
    Route::get('/payments', [AdminController::class, 'indexPayments'])->name('payments.index');
    Route::patch('/payments/{id}/status', [AdminController::class, 'updateStatusPayment'])->name('payments.updateStatus');

    // CRUD Pengumuman
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
});

require __DIR__.'/auth.php';
