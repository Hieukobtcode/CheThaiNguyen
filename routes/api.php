<?php

use App\Http\Controllers\Client\ThanhToanController;
use Illuminate\Support\Facades\Route;

Route::post('/zalopay-redirect', [ThanhToanController::class, 'xuLyRedirectZaloPay'])
    ->name('zalopay.callback');
Route::get('/zalopay-result', [ThanhToanController::class, 'xyLyResult'])->name('zalopay.result');
