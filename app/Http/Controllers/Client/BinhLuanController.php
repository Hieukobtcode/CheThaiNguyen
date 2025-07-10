<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BinhLuan;
use App\Models\DonHang;
use Illuminate\Http\Request;

class BinhLuanController extends Controller
{

    public function index()
    {
        //
    }

    public function luu(Request $request)
    {
        $request->validate([
            'san_pham_id' => 'required|exists:san_phams,id',
            'danh_gia' => 'required|integer|min:1|max:5',
            'noi_dung' => 'required|string|max:1000',
        ]);

        $nguoiDungId = auth()->id();
        $sanPhamId = $request->san_pham_id;

        // Kiểm tra sản phẩm này có thuộc đơn hàng đã hoàn thành của người dùng không
        $donHang = DonHang::where('nguoi_dung_id', $nguoiDungId)
            ->where('trang_thai', 'da_hoan_thanh')
            ->whereHas('chiTietDonHangs', function ($query) use ($sanPhamId) {
                $query->where('san_pham_id', $sanPhamId);
            })
            ->first();

        if (!$donHang) {
            return redirect()->back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm đã mua và hoàn thành đơn hàng.');
        }

        $daDanhGia = BinhLuan::where('nguoi_dung_id', $nguoiDungId)
            ->where('san_pham_id', $sanPhamId)
            ->exists();

        if ($daDanhGia) {
            return redirect()->back()->with('warning', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        // Lưu bình luận
        BinhLuan::create([
            'nguoi_dung_id' => $nguoiDungId,
            'san_pham_id' => $sanPhamId,
            'noi_dung' => $request->noi_dung,
            'trang_thai' => 'hien',
            'danh_gia' => $request->danh_gia,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
