<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DiaChi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaChiController extends Controller
{

    public function index()
    {
        $diaChis = DiaChi::where('nguoi_dung_id', Auth::id())->get();
        return view('client.dia-chi-nhan-hang', compact('diaChis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_nguoi_nhan' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20',
            'tinh_thanh' => 'required|string',
            'quan_huyen' => 'required|string',
            'phuong_xa' => 'required|string',
            'dia_chi' => 'required|string|max:255',
        ]);

        $nguoiDungId = Auth::id();

        $soLuongDiaChi = DiaChi::where('nguoi_dung_id', $nguoiDungId)->count();
        if ($soLuongDiaChi >= 3) {
            return redirect()->back()->with('error', 'Bạn chỉ có thể thêm tối đa 3 địa chỉ.');
        }

        DiaChi::create([
            'nguoi_dung_id'   => $nguoiDungId,
            'ho_va_ten'       => $request->ten_nguoi_nhan,
            'so_dien_thoai'   => $request->so_dien_thoai,
            'tinh_thanh'      => $request->tinh_thanh,
            'quan_huyen'      => $request->quan_huyen,
            'phuong_xa'       => $request->phuong_xa,
            'dia_chi_cu_the'  => $request->dia_chi,
            'mac_dinh'        => ($soLuongDiaChi === 0) ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Thêm địa chỉ thành công!');
    }


    public function capNhat(Request $request, $id)
    {
        $request->validate([
            'ten_nguoi_nhan' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20',
            'dia_chi' => 'required|string',
        ]);

        $diaChi = DiaChi::where('id', $id)->where('nguoi_dung_id', Auth::id())->firstOrFail();

        $diaChi->update([
            'ho_va_ten' => $request->ten_nguoi_nhan,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi_cu_the' => $request->dia_chi,
            // Có thể thêm cập nhật tỉnh, huyện, xã nếu cần
        ]);

        return redirect()->back()->with('success', 'Cập nhật địa chỉ thành công!');
    }

    public function chonMacDinh($id)
    {
        $userId = Auth::id();

        $diaChiMacDinh = DiaChi::where('id', $id)
            ->where('nguoi_dung_id', $userId)
            ->first();

        if (!$diaChiMacDinh) {
            return back()->with('error', 'Không tìm thấy địa chỉ để đặt mặc định.');
        }

        DiaChi::where('nguoi_dung_id', $userId)->update(['mac_dinh' => 0]);

        $diaChiMacDinh->mac_dinh = 1;
        $diaChiMacDinh->save();

        return back()->with('success', 'Đã đặt địa chỉ này làm mặc định.');
    }


    public function destroy($id)
    {
        $nguoiDungId = Auth::id();

        $diaChi = DiaChi::find($id);

        if (!$diaChi) {
            return redirect()->back()->with('error', 'Địa chỉ không tồn tại.');
        }

        if ($diaChi->nguoi_dung_id !== $nguoiDungId) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa địa chỉ này.');
        }

        $tongDiaChi = DiaChi::where('nguoi_dung_id', $nguoiDungId)->count();
        if ($tongDiaChi <= 1) {
            return redirect()->back()->with('error', 'Bạn phải để ít nhất 1 địa chỉ.');
        }

        $diaChi->delete();

        return redirect()->back()->with('success', 'Xóa địa chỉ thành công.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ho_va_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20',
            'tinh_thanh' => 'required|string|max:100',
            'quan_huyen' => 'required|string|max:100',
            'phuong_xa' => 'required|string|max:100',
            'dia_chi_cu_the' => 'required|string|max:255',
        ]);

        $diaChi = DiaChi::findOrFail($id);

        $diaChi->update([
            'ho_va_ten' => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'tinh_thanh' => $request->tinh_thanh,
            'quan_huyen' => $request->quan_huyen,
            'phuong_xa' => $request->phuong_xa,
            'dia_chi_cu_the' => $request->dia_chi_cu_the,
        ]);

        return redirect()->back()->with('success', 'Cập nhật địa chỉ thành công.');
    }
}
