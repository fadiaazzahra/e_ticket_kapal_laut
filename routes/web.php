<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jadwal', [HomeController::class, 'jadwal'])->name('jadwal');

// Auth Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout Route (Authenticated Users Only)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Customer Ticket Booking Routes (Authenticated Users Only)
Route::middleware('auth')->group(function () {
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/payment/{id}', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/payment/{id}', [BookingController::class, 'submitPayment'])->name('booking.submitPayment');
    Route::get('/booking/ticket/{kode}', [BookingController::class, 'ticket'])->name('booking.ticket');
    Route::get('/history', [BookingController::class, 'history'])->name('booking.history');
});

// Admin Panel Routes (Admin Only)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Kelola Kapal
    Route::get('/kapals', [AdminController::class, 'kapals'])->name('admin.kapals');
    Route::post('/kapals', [AdminController::class, 'storeKapal'])->name('admin.kapals.store');
    Route::put('/kapals/{id_kapal}', [AdminController::class, 'updateKapal'])->name('admin.kapals.update');
    Route::delete('/kapals/{id_kapal}', [AdminController::class, 'destroyKapal'])->name('admin.kapals.destroy');

    // Kelola Jadwal
    Route::get('/jadwals', [AdminController::class, 'jadwals'])->name('admin.jadwals');
    Route::post('/jadwals', [AdminController::class, 'storeJadwal'])->name('admin.jadwals.store');
    Route::put('/jadwals/{id_jadwal}', [AdminController::class, 'updateJadwal'])->name('admin.jadwals.update');
    Route::delete('/jadwals/{id_jadwal}', [AdminController::class, 'destroyJadwal'])->name('admin.jadwals.destroy');

    // Kelola Pemesanan / Data Penumpang
    Route::get('/pemesanans', [AdminController::class, 'pemesanans'])->name('admin.pemesanans');

    // Kelola Pembayaran
    Route::get('/pembayarans', [AdminController::class, 'pembayarans'])->name('admin.pembayarans');
    Route::post('/pembayarans/{id_pembayaran}/confirm', [AdminController::class, 'confirmPayment'])->name('admin.pembayarans.confirm');

    // Kelola Pengguna
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Laporan
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('/laporan/export', [AdminController::class, 'exportLaporan'])->name('admin.laporan.export');
});
