<?php

use App\Services\MidtransPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans-callback', [MidtransPaymentService::class, 'midtransCallback']);
