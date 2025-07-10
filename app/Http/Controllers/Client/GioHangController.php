<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ChiTietGioHang;
use App\Models\GioHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GioHangController extends Controller
{

    //Danh sách sản phẩm trong giỏ hàng
    public function index()
    {
        $nguoiDungId = Auth::id();

        $gioHang = GioHang::where('nguoi_dung_id', $nguoiDungId)->first();

        if (!$gioHang) {
            return view('gio_hang.index', [
                'chiTietGioHangs' => [],
                'tongTien' => 0,
            ]);
        }

        $chiTietGioHangs = $gioHang->chiTietGioHangs()->with('sanPham')->get();

        $tongTien = $chiTietGioHangs->sum(function ($item) {
            return $item->so_luong * $item->sanPham->gia;
        });

        return view('client.danh-sach-gio-hang', compact('chiTietGioHangs', 'tongTien'));
    }

    public function create()
    {
        //
    }

    //Thêm sản phẩm vào giỏ hàng
    public function store(Request $request)
    {
        $request->validate([
            'san_pham_id' => 'required|exists:san_phams,id',
            'so_luong' => 'required|integer|min:1'
        ]);

        $nguoiDungId = Auth::id();

        $sanPham = SanPham::findOrFail($request->san_pham_id);

        $gioHang = GioHang::firstOrCreate(
            ['nguoi_dung_id' => $nguoiDungId]
        );

        $chiTiet = ChiTietGioHang::where('gio_hang_id', $gioHang->id)
            ->where('san_pham_id', $sanPham->id)
            ->first();

        $soLuongDaCo = $chiTiet ? $chiTiet->so_luong : 0;
        $soLuongMuonThem = $request->so_luong;
        $tongSoLuong = $soLuongDaCo + $soLuongMuonThem;

        if ($tongSoLuong > $sanPham->so_luong) {
            return redirect()->back()->with('error', 'Số lượng sản phẩm trong kho không đủ.');
        }

        if ($chiTiet) {
            $chiTiet->so_luong = $tongSoLuong;
            $chiTiet->save();
        } else {
            ChiTietGioHang::create([
                'gio_hang_id' => $gioHang->id,
                'san_pham_id' => $sanPham->id,
                'so_luong' => $soLuongMuonThem,
            ]);
        }

        return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công!');
    }

    public function capNhatSoLuong(Request $request, $id)
    {
        $chiTiet = ChiTietGioHang::with('sanPham')->find($id);

        if (!$chiTiet) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy chi tiết giỏ hàng'], 404);
        }

        $soLuongMoi = (int) $request->input('so_luong');

        if ($soLuongMoi < 1) {
            return response()->json(['status' => 'error', 'message' => 'Số lượng tối thiểu là 1'], 400);
        }

        $soLuongTonKho = $chiTiet->sanPham->so_luong ?? 0;

        if ($soLuongMoi > $soLuongTonKho) {
            return response()->json([
                'status' => 'error',
                'message' => 'Số lượng vượt quá số lượng trong kho (' . $soLuongTonKho . ')'
            ], 400);
        }

        $chiTiet->so_luong = $soLuongMoi;
        $chiTiet->save();

        $gioHang = GioHang::where('nguoi_dung_id', Auth::id())->first();
        $tongTien = 0;

        if ($gioHang) {
            $tongTien = $gioHang->chiTietGioHangs()->with('sanPham')->get()->sum(function ($item) {
                return $item->so_luong * $item->sanPham->gia;
            });
        }

        return response()->json([
            'status' => 'success',
            'don_gia' => number_format($chiTiet->so_luong * $chiTiet->sanPham->gia),
            'tong_tien' => number_format($tongTien)
        ]);
    }

    //Xóa sản phẩm
    public function xoaSanPham($id)
    {
        $chiTiet = ChiTietGioHang::find($id);

        if (!$chiTiet) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
        }

        $chiTiet->delete();

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
