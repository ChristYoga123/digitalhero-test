<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('index');

// Service Routes
Route::prefix('service')->name('service.')->group(function()
{
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/{service:slug}', [ServiceController::class, 'show'])->name('show');
    Route::post('/{service:slug}/booking', [BookingController::class, 'beli'])->name('booking');
});

Route::prefix('pembayaran')->name('pembayaran.')->group(function()
{
    Route::get('sukses', [BookingController::class, 'pembayaranSukses'])->name('sukses');
    Route::get('gagal', [BookingController::class, 'pembayaranGagal'])->name('gagal');
});
