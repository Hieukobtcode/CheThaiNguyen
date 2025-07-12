<?php

use App\Http\Controllers\Admin\BaiVietController;
use App\Http\Controllers\Admin\CapTheController;
use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\KhuyenMaiController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BinhLuanController as AdminBinhLuanController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\NguoiDungController;
use App\Http\Controllers\Admin\PhanHoiController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\BaiVietController as ClientBaiVietController;
use App\Http\Controllers\Client\BinhLuanController;
use App\Http\Controllers\Client\GioHangController;
use App\Http\Controllers\Client\DiaChiController;
use App\Http\Controllers\Client\DonHangController as ClientDonHangController;
use App\Http\Controllers\Client\SanPhamController as ClientSanPhamController;
use App\Http\Controllers\Client\ThanhToanController;
use App\Http\Controllers\Client\ThongTinCaNhanController;
use App\Http\Controllers\Client\TrangChuController;
use Illuminate\Support\Facades\Route;

// Trang chủ
Route::get('/', [TrangChuController::class, 'index'])->name('home');

//Search
Route::get('/search', [ClientSanPhamController::class, 'index']);

//Lọc theo danh mục
Route::get('/danh-muc/{id}', [ClientSanPhamController::class, 'locTheoDanhMuc'])->name('san-pham.loc-theo-danh-muc');

// Đăng nhập, đăng ký, đăng xuất
Route::post('/dang-nhap', [AuthController::class, 'xuLyDangNhap']);
Route::post('/dang-ky', [AuthController::class, 'xuLyDangKy']);
Route::get('/dang-xuat', [AuthController::class, 'dangXuat'])->name('dang-xuat');

// Quên mật khẩu
Route::get('/quen-mat-khau', [AuthController::class, 'hienThiQuenMatKhau'])->name('quen-mat-khau');
Route::post('/quen-mat-khau', [AuthController::class, 'xuLyQuenMatKhau']);

// Trang sản phẩm và bài viết 
Route::get('/san-pham/{slug}', [TrangChuController::class, 'chiTietSanPham'])->name('san-pham.show');
Route::get('/bai_viet', [ClientBaiVietController::class, 'danhSachBaiViet'])->name('bai_viet');
Route::get('/bai_viet/{id}', [ClientBaiVietController::class, 'chiTietBaiViet'])->name('bai_viet_client.show');

Route::middleware(['auth'])->group(function () {
    // Thông tin cá nhân
    Route::get('/thong-tin-ca-nhan', [ThongTinCaNhanController::class, 'profile'])->name('profile');
    Route::put('/thong-tin-ca-nhan/update', [ThongTinCaNhanController::class, 'update'])->name('profile.update');
    Route::post('/thong-tin-ca-nhan/change-password', [ThongTinCaNhanController::class, 'changePassword'])->name('profile.change-password');

    // Địa chỉ nhận hàng
    Route::get('/dia-chi', [DiaChiController::class, 'index'])->name('dia-chi');
    Route::post('/dia-chi/them', [DiaChiController::class, 'store'])->name('dia-chi.them');
    Route::get('/dia-chi/chon-mac-dinh/{id}', [DiaChiController::class, 'chonMacDinh'])->name('dia-chi.chon-mac-dinh');
    Route::put('/dia-chi/cap-nhat/{id}', [DiaChiController::class, 'update'])->name('dia-chi.cap-nhat');
    Route::delete('/dia-chi/xoa/{id}', [DiaChiController::class, 'destroy'])->name('dia-chi.xoa');

    //Giỏ hàng
    Route::post('/gio-hang/them', [GioHangController::class, 'store'])->name('gio-hang.them');
    Route::get('/gio-hang', [GioHangController::class, 'index'])->name('gio-hang.danh-sach');
    Route::delete('/cart/{id}', [GioHangController::class, 'xoaSanPham'])->name('gio_hang.xoa');
    Route::patch('/cart/{id}', [GioHangController::class, 'capNhatSoLuong'])->name('gio_hang.cap_nhat');

    //Thanh toán
    Route::get('/checkout', [ThanhToanController::class, 'hienThiTrangThanhToan'])->name('gio_hang.thanh_toan');
    Route::post('/checkout', [ThanhToanController::class, 'xuLyThanhToan'])->name('gio_hang.xu_ly_thanh_toan');

    //Khuyến mãi
    Route::post('/apply-voucher', [ThanhToanController::class, 'apply'])->name('apply.voucher');

    //Đổi điểm
    Route::post('/apply-point', [ThanhToanController::class, 'apply_point'])->name('apply.point');

    //Đơn hàng
    Route::get('don-hang', [ThongTinCaNhanController::class, 'donHang'])->name('don-hang.danh-sach');
    Route::get('don-hang/{id}/chi-tiet', [ThongTinCaNhanController::class, 'chiTietDonHang'])->name('don-hang.chi-tiet');
    Route::put('don-hang/{id}/huy', [ThongTinCaNhanController::class, 'huy'])->name('don-hang.huy');
    Route::put('don-hang/{id}/da-giao', [ThongTinCaNhanController::class, 'xacNhanDaGiao'])->name('don-hang.xac-nhan-da-giao');


    //Lịch sử điểm
    Route::get('/lich-su-diem', [ThongTinCaNhanController::class, 'lichSuDiem'])->name('lich-su-diem');

    //Đánh giá sản phẩm
    Route::post('/binh-luan/luu', [BinhLuanController::class, 'luu'])->name('binh-luan.luu');

    //Khuyến mãi
    Route::get('/khuyen-mai', [ThongTinCaNhanController::class, 'khuyenMai'])->name('khuyen-mai');

});

// ====================================ADMIN=====================================
Route::prefix('admin')->middleware(['auth', 'kiemtra.admin'])->group(function () {

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
    Route::resource('nguoi_dung', NguoiDungController::class);
    Route::post('nguoi_dung/{id}/toggle-trang-thai', [NguoiDungController::class, 'toggleTrangThai'])->name('nguoi_dung.toggleTrangThai');

    //Dơn hàng
    Route::get('don-hang', [DonHangController::class, 'index'])->name('don_hang.index');
    Route::get('don-hang/{id}/show', [DonHangController::class, 'show'])->name('don_hang.show');
    Route::post('don-hang/{id}/xac-nhan', [DonHangController::class, 'xacNhanDonHang'])->name('don-hang.xac-nhan');
    Route::post('don-hang/{id}/dang-giao', [DonHangController::class, 'xacNhanDangGiao'])->name('don-hang.dang-giao');
    Route::post('don-hang/{id}/da-giao', [DonHangController::class, 'xacNhanDaGiao'])->name('don-hang.da-giao');

    //Đánh giá
    Route::resource('binh_luan', AdminBinhLuanController::class);
    Route::post('phan-hoi', [PhanHoiController::class, 'store'])->name('phan_hoi.store');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
