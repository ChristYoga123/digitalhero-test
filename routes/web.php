<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('index');

// Service Routes
Route::prefix('service')->name('service')->group(function()
{
    Route::get('/', [ServiceController::class, 'index'])->name('.index');
});
