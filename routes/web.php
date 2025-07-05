<?php

use App\Http\Controllers\Admin\BaiVietController;
use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\KhuyenMaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {

    // Dasboard 
    Route::get('/', function () {
        return view('layouts.admin');
    });

    // Bài viết 
    Route::resource('bai_viet', BaiVietController::class);

    //Danh mục
    Route::resource('danh_muc',DanhMucController::class);

    //Voucher
    Route::resource('voucher',KhuyenMaiController::class);
    
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
