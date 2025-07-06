<?php

use App\Http\Controllers\Admin\BaiVietController;
use App\Http\Controllers\Admin\CapTheController;
use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\KhuyenMaiController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\NguoiDungController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.trang-chu');
})->name('home');


Route::prefix('admin')->middleware('auth')->group(function () {

    //Dasboard  
    Route::get('/', function () {
        return view('layouts.admin');
    })->name('admin.dashboard');

    // Bài viết 
    Route::resource('bai_viet', BaiVietController::class);

    //Danh mục
    Route::resource('danh_muc', DanhMucController::class);

    //Voucher
    Route::resource('voucher', KhuyenMaiController::class);

    //Sản phẩm
    Route::resource('san_pham', SanPhamController::class);

    //Thẻ thành viên
    Route::resource('cap_bac', CapTheController::class);

    //Banner
    Route::resource('banner', BannerController::class);

    //Người dùng
    Route::resource('nguoi_dung',NguoiDungController::class);
    Route::post('nguoi_dung/{id}/toggle-trang-thai', [NguoiDungController::class, 'toggleTrangThai'])->name('nguoi_dung.toggleTrangThai');
    
    //Dơn hàng
    Route::resource('don_hang',DonHangController::class);

});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
