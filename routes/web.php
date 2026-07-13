<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Route Utama yang Memerlukan Login
Route::middleware(['auth', 'verified'])->group(function () {

    // Fallback Route 'dashboard'
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Khusus User
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
        Route::post('/booking', [UserController::class, 'storeBooking'])->name('booking.store');
        Route::post('/payment/{bookingId}', [UserController::class, 'storePayment'])->name('payment.store');
        Route::get('/payments/history', [UserController::class, 'paymentHistory'])->name('payments.history');
    });

    // Route Khusus Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
        Route::get('/payments', [AdminController::class, 'payments'])->name('payments');

        // Aksi Verifikasi Admin
        Route::patch('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
        Route::patch('/bookings/{id}/approve', [AdminController::class, 'approveBooking'])->name('bookings.approve');
        Route::patch('/bookings/{id}/reject', [AdminController::class, 'rejectBooking'])->name('bookings.reject');
        Route::patch('/payments/{id}/approve', [AdminController::class, 'approvePayment'])->name('payments.approve');
    });
});

require __DIR__.'/auth.php';
