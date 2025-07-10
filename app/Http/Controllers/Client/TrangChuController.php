<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BaiViet;
use App\Models\Banner;
use App\Models\BinhLuan;
use App\Models\DanhMuc;
use App\Models\SanPham;
use App\Models\ThongBao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrangChuController extends Controller
{
    //Trang chủ client
    public function index()
    {
        $banners = Banner::all();
        $news = BaiViet::latest()->take(4)->get();
        $sanPhams = SanPham::with('DanhMuc')->latest()->take(8)->get();



        return view('client.trang-chu', compact('banners', 'news', 'sanPhams'));
    }

    //Chi tiết sản phẩm
    public function chiTietSanPham($slug)
    {
        $sanPham = SanPham::where('slug', $slug)
            ->with('danhMuc')
            ->firstOrFail();

        $binhLuans = BinhLuan::with(['nguoiDung', 'phanHoi'])
            ->where('san_pham_id', $sanPham->id)
            ->where('trang_thai', 'hien')
            ->latest()
            ->get();


        $sanPhamLienQuan = SanPham::where('danh_muc_id', $sanPham->danh_muc_id)
            ->where('id', '!=', $sanPham->id)
            ->limit(8)
            ->get();

        return view('client.chi-tiet-san-pham', compact('sanPham', 'sanPhamLienQuan', 'binhLuans'));
    }
}
