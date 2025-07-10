<?php

namespace App\Http\Controllers\Client;

use App\Models\NguoiDung;
use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\LichSuDiem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ThongTinCaNhanController extends Controller
{
    // Trang thông tin cá nhân
    public function profile()
    {
        $nguoiDung = Auth::user();
        return view('client.thong-tin-ca-nhan', compact('nguoiDung'));
    }

    // Cập nhật thông tin cá nhân, bao gồm ảnh đại diện
    public function update(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:nguoi_dungs,email,' . Auth::id(),
            'so_dien_thoai' => 'nullable|string|max:20',
            'ngay_sinh' => 'nullable|date',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = NguoiDung::find(Auth::id());

        if ($user) {
            $user->ten = $request->ten;
            $user->email = $request->email;
            $user->so_dien_thoai = $request->so_dien_thoai;
            $user->ngay_sinh = $request->ngay_sinh;

            if ($request->hasFile('hinh_anh')) {
                // Xoá ảnh cũ nếu có
                if ($user->hinh_anh && Storage::disk('public')->exists($user->hinh_anh)) {
                    Storage::disk('public')->delete($user->hinh_anh);
                }

                // Lưu ảnh mới
                $file = $request->file('hinh_anh');
                $path = $file->store('nguoi_dung', 'public'); 
                $user->hinh_anh = $path;
            }

            $user->save();
        }

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }


    //Đặt lại mật khẩu
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = NguoiDung::find(Auth::id());

        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Mật khẩu đã được cập nhật thành công.');
    }


    public function lichSuDiem()
    {
        $nguoiDung = Auth::user();

        $list = LichSuDiem::where('nguoi_dung_id', $nguoiDung->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $tongDiemHienTai = $nguoiDung->tong_diem;

        return view('client.lich-su-diem', compact('list', 'tongDiemHienTai'));
    }

    public function donHang(Request $request)
    {
        $nguoiDungId = Auth::id();

        $trangThais = [
            'tat_ca' => 'Tất cả',
            'cho_xac_nhan' => 'Chờ xác nhận',
            'dang_giao' => 'Đang giao',
            'da_giao' => 'Đã giao',
            'da_hoan_thanh' => 'Đã hoàn thành',
            'da_huy' => 'Đã hủy',
        ];

        $activeTab = $request->get('tab', 'tat_ca');

        $donHangsQuery = DonHang::where('nguoi_dung_id', $nguoiDungId)
            ->orderByDesc('created_at');

        if ($activeTab !== 'tat_ca') {
            $donHangsQuery->where('trang_thai', $activeTab);
        }

        $donHangs = $donHangsQuery->paginate(10)->appends(['tab' => $activeTab]);

        return view('client.danh-sach-don-hang', compact('donHangs', 'trangThais', 'activeTab'));
    }


    public function huy($id)
    {
        $donHang = DonHang::where('id', $id)
            ->where('nguoi_dung_id', Auth::id())
            ->firstOrFail();

        if ($donHang->trang_thai !== 'cho_xac_nhan') {
            return redirect()->route('don-hang.danh-sach')->with('error', 'Chỉ đơn hàng đang chờ xác nhận mới có thể hủy.');
        }

        $donHang->trang_thai = 'da_huy';
        $donHang->save();

        return redirect()->route('don-hang.danh-sach')->with('success', 'Đơn hàng đã được hủy.');
    }

    public function chiTietDonHang($id)
    {
        $donHang = DonHang::with(['chiTietDonHangs.sanPham', 'voucher'])->findOrFail($id);

        if ($donHang->nguoi_dung_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        $lichSuDiem = LichSuDiem::where('nguoi_dung_id', $donHang->nguoi_dung_id)
            ->where('mo_ta', 'like', '%' . $donHang->ma_van_don . '%')
            ->where('loai', '=', "Sử dụng điểm")
            ->first();

        $diemDaSuDung = $lichSuDiem ? abs($lichSuDiem->diem) : 0;

        return view('client.chi-tiet-don-hang', compact('donHang', 'diemDaSuDung'));
    }


    public function xacNhanDaGiao($id)
    {
        try {
            $donHang = DonHang::findOrFail($id);

            if ($donHang->trang_thai !== 'da_giao') {
                return redirect()->back()->with('error', 'Chỉ đơn hàng đang giao mới có thể hoàn thành.');
            }

            $donHang->trang_thai = 'da_hoan_thanh';
            $donHang->trang_thai_thanh_toan = 'da_thanh_toan';
            $donHang->save();

            $nguoiDung = NguoiDung::with('capBac')->findOrFail($donHang->nguoi_dung_id);

            $tyLe = $nguoiDung->capBac->ti_le_tich_diem ?? 0;
            Log::info("Tỷ lệ tích điểm theo cap_bac_id: $tyLe");

            $diemCong = floor(($donHang->tong_tien * $tyLe) / 100);
            Log::info("Điểm cộng: $diemCong");

            if ($diemCong > 0) {
                $nguoiDung->tong_diem += $diemCong;
                $nguoiDung->save();

                $url = route('don-hang.chi-tiet', ['id' => $donHang->id]);
                LichSuDiem::create([
                    'nguoi_dung_id' => $nguoiDung->id,
                    'diem' => $diemCong,
                    'loai' => 'Tích điểm',
                    'mo_ta' => 'Cộng ' . $diemCong . " điểm khi xác nhận đơn hàng " . $donHang->ma_van_don,
                ]);

                Log::info("Cộng điểm và lưu lịch sử điểm cho người dùng ID {$nguoiDung->id}");
            }

            return redirect()->back()->with('success', 'Đơn hàng hoàn thành — đã tích điểm cho khách hàng.');
        } catch (\Exception $e) {
            Log::error("Lỗi khi hoàn thành đơn hàng ID $id: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái đơn hàng.');
        }
    }
}
