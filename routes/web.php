<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// Giriş sayfası (oturum açık değilken)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Oturum açıkken erişilebilen sayfalar
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('odalar', RoomController::class)
        ->except(['show'])
        ->parameters(['odalar' => 'oda']);
    Route::resource('misafirler', GuestController::class)
        ->parameters(['misafirler' => 'misafir']);
    Route::resource('rezervasyonlar', ReservationController::class)
        ->except(['show'])
        ->parameters(['rezervasyonlar' => 'rezervasyon']);

    Route::patch('rezervasyonlar/{rezervasyon}/check-in', [ReservationController::class, 'checkIn'])
        ->name('rezervasyonlar.check-in');
    Route::patch('rezervasyonlar/{rezervasyon}/check-out', [ReservationController::class, 'checkOut'])
        ->name('rezervasyonlar.check-out');
    Route::patch('rezervasyonlar/{rezervasyon}/cancel', [ReservationController::class, 'cancel'])
        ->name('rezervasyonlar.cancel');
});
