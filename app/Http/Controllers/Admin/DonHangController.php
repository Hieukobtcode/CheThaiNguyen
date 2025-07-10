<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\ThongBao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DonHangController extends Controller
{
    public function index()
    {
        $donHangs = DonHang::with('nguoiDung')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.don-hang.index', compact('donHangs'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $donHang = DonHang::with(['chiTietDonHangs.sanPham', 'nguoiDung', 'voucher', 'diaChi'])
            ->findOrFail($id);

        return view('admin.don-hang.show', compact('donHang'));
    }

    public function xacNhanDonHang($id)
    {
        try {
            $donHang = DonHang::findOrFail($id);

            if ($donHang->trang_thai !== 'cho_xac_nhan') {
                return redirect()->back()->with('error', 'Chỉ có thể xác nhận đơn hàng đang chờ xác nhận.');
            }

            $donHang->trang_thai = 'da_xac_nhan';
            $donHang->save();
            // Gửi thông báo
            ThongBao::create([
                'nguoi_dung_id' => $donHang->nguoi_dung_id,
                'tieu_de' => 'Đơn hàng #' . $donHang->id . ' đã được xác nhận',
                'noi_dung' => 'Cảm ơn bạn đã đặt hàng! Đơn hàng của bạn đang chuẩn bị được giao.',
                'loai' => 'cap_nhat_don_hang',
                'thoi_gian_gui' => now(),
            ]);

            return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận thành công.');
        } catch (\Exception $e) {
            Log::error("Lỗi khi xác nhận đơn hàng ID: $id - " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xác nhận đơn hàng.');
        }
    }

    public function xacNhanDangGiao($id)
    {
        try {
            $donHang = DonHang::findOrFail($id);

            if ($donHang->trang_thai !== 'da_xac_nhan') {
                return redirect()->back()->with('error', 'Chỉ có thể giao đơn hàng đã được xác nhận.');
            }

            $donHang->trang_thai = 'dang_giao';
            $donHang->save();
            ThongBao::create([
                'nguoi_dung_id' => $donHang->nguoi_dung_id,
                'tieu_de' => 'Đơn hàng #' . $donHang->id . ' đang được giao',
                'noi_dung' => 'Đơn hàng của bạn đang được vận chuyển. Vui lòng để ý điện thoại để nhận hàng.',
                'loai' => 'cap_nhat_don_hang',
                'thoi_gian_gui' => now(),
            ]);

            return redirect()->back()->with('success', 'Đơn hàng đã được chuyển sang trạng thái đang giao.');
        } catch (\Exception $e) {
            Log::error("Lỗi khi cập nhật trạng thái đơn hàng ID: $id - " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật đơn hàng.');
        }
    }

    public function xacNhanDaGiao($id)
    {
        try {
            $donHang = DonHang::findOrFail($id);

            if ($donHang->trang_thai !== 'dang_giao') {
                return redirect()->back()->with('error', 'Chỉ đơn hàng đang giao mới có thể chuyển sang trạng thái đã giao.');
            }

            $donHang->trang_thai = 'da_giao';
            $donHang->save();
            ThongBao::create([
                'nguoi_dung_id' => $donHang->nguoi_dung_id,
                'tieu_de' => 'Đơn hàng #' . $donHang->id . ' đã được giao',
                'noi_dung' => 'Cảm ơn bạn đã mua hàng. Nếu hài lòng, hãy để lại đánh giá nhé!',
                'loai' => 'cap_nhat_don_hang',
                'thoi_gian_gui' => now(),
            ]);

            return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận là đã giao.');
        } catch (\Exception $e) {
            Log::error("Lỗi khi cập nhật trạng thái đã giao cho đơn hàng ID $id: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái đơn hàng.');
        }
    }
    
}
