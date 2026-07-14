<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// 🔹 ROUTE DASHBOARD UTAMA (Penyebab 404 Teratasi)
// Mengarahkan otomatis ke dashboard user atau admin sesuai role
Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth'])->group(function () {

    // ==========================================
    // ROUTE USER
    // ==========================================
    Route::middleware(['role:user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
        Route::post('/booking', [UserController::class, 'storeBooking'])->name('booking.store');
        Route::post('/payment/{bookingId}', [UserController::class, 'storePayment'])->name('payment.store');
        Route::get('/payments/history', [UserController::class, 'paymentHistory'])->name('payments.history');

        // 🖨️ Route Cetak Struk Tiket Parkir
        Route::get('/booking/{id}/receipt', [UserController::class, 'printReceipt'])->name('booking.receipt');
    });

    // ==========================================
    // ROUTE ADMIN
    // ==========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::patch('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
        Route::patch('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');

        Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
        Route::patch('/bookings/{id}/approve', [AdminController::class, 'approveBooking'])->name('bookings.approve');
        Route::patch('/bookings/{id}/reject', [AdminController::class, 'rejectBooking'])->name('bookings.reject');

        Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
        Route::patch('/payments/{id}/approve', [AdminController::class, 'approvePayment'])->name('payments.approve');
        Route::patch('/payments/{id}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');
    });

});

require __DIR__.'/auth.php';
