<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController; // Pastikan ini di-import
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route Profile (Bawaan Laravel Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- BAGIAN INI YANG DITAMBAHKAN ---
// Route Khusus Admin (Hanya bisa diakses oleh user dengan role 'admin')
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Verifikasi User
    Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
    Route::patch('/users/{id}/status', [AdminController::class, 'updateStatusUser'])->name('users.updateStatus');

    // Verifikasi Pemesanan
    Route::get('/bookings', [AdminController::class, 'indexBookings'])->name('bookings.index');
    Route::patch('/bookings/{id}/status', [AdminController::class, 'updateStatusBooking'])->name('bookings.updateStatus');

    // Verifikasi Pembayaran
    Route::get('/payments', [AdminController::class, 'indexPayments'])->name('payments.index');
    Route::patch('/payments/{id}/status', [AdminController::class, 'updateStatusPayment'])->name('payments.updateStatus');
});

require __DIR__.'/auth.php';
