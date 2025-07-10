<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CapThe;
use App\Models\ChiTietDonHang;
use App\Models\DiaChi;
use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\LichSuDiem;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\NguoiDung;
use App\Models\SanPham;
use Exception;
use Illuminate\Support\Carbon;

class ThanhToanController extends Controller
{
    public function hienThiTrangThanhToan()
    {
        $nguoiDungId = Auth::id();

        $diaChi = DiaChi::where('nguoi_dung_id', $nguoiDungId)
            ->where('mac_dinh', 1)
            ->first();

        if (!$diaChi) {
            return redirect()->route('dia-chi')->with('error', "Hãy thêm địa chỉ nhận hàng trước khi thanh toán");
        }

        $gioHang = GioHang::where('nguoi_dung_id', $nguoiDungId)->first();

        if (!$gioHang || $gioHang->chiTietGioHangs()->count() === 0) {
            return redirect()->route('gio-hang.danh-sach')->with('error', 'Giỏ hàng trống.');
        }

        $chiTietGioHangs = $gioHang->chiTietGioHangs()->with('sanPham')->get();

        $tongTien = $chiTietGioHangs->sum(function ($item) {
            return $item->so_luong * $item->sanPham->gia;
        });

        return view('client.thanh-toan', compact('chiTietGioHangs', 'tongTien', 'diaChi'));
    }

    public function xuLyThanhToan(Request $request)
    {
        $nguoiDungId = Auth::id();
        $gioHang = GioHang::where('nguoi_dung_id', $nguoiDungId)->first();

        if (!$gioHang || $gioHang->chiTietGioHangs->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $diaChiId = $request->input('dia_chi_id');
        $phuongThuc = $request->input('phuong_thuc_thanh_toan');
        $ghiChu = $request->input('description');

        if (!$diaChiId) {
            return redirect()->route('dia-chi')->with('error', "Hãy chọn địa chỉ nhận hàng trước khi thanh toán");
        }

        $chiTiet = $gioHang->chiTietGioHangs()->with('sanPham')->get();
        $tongThanhToan = $request->input('total_money');
        $maVanDon = strtoupper(uniqid('DH'));

        $voucher = null;
        $voucherId = null;

        if ($request->input('couponCode') !== null) {
            $maVoucher = $request->input('couponCode');

            $voucher = Voucher::where('ma', $maVoucher)->first();

            if ($voucher) {
                $voucherId = $voucher->id;
            }
        }

        if ($phuongThuc === 'cod') {
            $soDiemSuDung = (int) $request->input('point', 0);
            Log::info("Số điểm sử dụng: " . $soDiemSuDung);
            DB::beginTransaction();
            try {
                $donHang = DonHang::create([
                    'nguoi_dung_id' => $nguoiDungId,
                    'dia_chi_id' => $diaChiId,
                    'voucher_id' => $voucherId,
                    'ma_van_don' => $maVanDon,
                    'tong_tien' => $tongThanhToan,
                    'trang_thai' => 'cho_xac_nhan',
                    'phuong_thuc_thanh_toan' => 'cod',
                    'ghi_chu' => $ghiChu,
                ]);

                foreach ($chiTiet as $item) {
                    ChiTietDonHang::create([
                        'don_hang_id' => $donHang->id,
                        'san_pham_id' => $item->san_pham_id,
                        'so_luong' => $item->so_luong,
                        'don_gia' => $item->sanPham->gia,
                    ]);

                    $sanPham = SanPham::find($item->san_pham_id);
                    if ($sanPham) {
                        $sanPham->so_luong -= $item->so_luong;
                        $sanPham->save();
                    }
                }

                if ($donHang->voucher_id) {
                    $voucher = Voucher::find($donHang->voucher_id);
                    if ($voucher && $voucher->so_luong > 0) {
                        $voucher->so_luong -= 1;
                        $voucher->save();
                    }
                }

                $gioHang->chiTietGioHangs()->delete();
                $this->capNhatCapTheNguoiDung($nguoiDungId);
                $nguoiDung = NguoiDung::find($nguoiDungId);
                if ($soDiemSuDung > 0) {
                    $nguoiDung->tong_diem -= $soDiemSuDung;
                    $nguoiDung->save();
                    $this->capNhatLichSuDiem($nguoiDungId, $soDiemSuDung, $donHang->id);
                }
                DB::commit();

                return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Lỗi đặt hàng: ' . $e->getMessage());
            }
        }

        // ============================ //
        // THANH TOÁN ONLINE - ZaloPay
        // ============================ //
        if ($phuongThuc === 'online') {
            $nguoiDung = Auth::user();
            $config = [
                "app_id" => 2553,
                "key1" => "PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL",
                "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
                "endpoint" => "https://sb-openapi.zalopay.vn/v2/create"
            ];

            $orderId = date("ymd") . "_" . $maVanDon;
            $soDiemSuDung = (int) $request->input('point', 0);

            $voucher = null;

            if ($request->input('couponCode') !== null) {
                $maVoucher = $request->input('couponCode');

                $voucher = Voucher::where('ma', $maVoucher)->first();

                if ($voucher) {
                    $voucherId = $voucher->id;
                } else {
                    $voucherId = null;
                }
            }
            $embedData = [
                'ghi_chu' => $ghiChu,
                'voucher_id' => $voucherId,
                'so_diem_su_dung' => $soDiemSuDung,
                'ma_van_don' => $maVanDon,
                'nguoi_dung_id' => $nguoiDungId,
                'dia_chi_id' => $diaChiId,
                'cart' => $chiTiet->map(function ($item) {
                    return [
                        'san_pham_id' => $item->san_pham_id,
                        'so_luong' => $item->so_luong,
                        'don_gia' => $item->sanPham->gia,
                    ];
                })->toArray(),
                'redirecturl' => route('zalopay.result', ['nguoi_dung_id' => $nguoiDung->id])

            ];

            $callbackUrl = route('zalopay.callback');

            $order = [
                "app_id" => $config["app_id"],
                "app_trans_id" => $orderId,
                "app_user" => "user_" . $nguoiDungId,
                "app_time" => round(microtime(true) * 1000),
                "amount" => $tongThanhToan,
                "item" => json_encode([]),
                "embed_data" => json_encode($embedData),
                "description" => "Thanh toán đơn hàng #" . $maVanDon,
                "bank_code" => "zalopayapp",
                "callback_url"  => $callbackUrl,
            ];

            $data = implode("|", [
                $order["app_id"],
                $order["app_trans_id"],
                $order["app_user"],
                $order["amount"],
                $order["app_time"],
                $order["embed_data"],
                $order["item"]
            ]);

            $order["mac"] = hash_hmac("sha256", $data, $config["key1"]);

            $response = Http::asForm()->post($config['endpoint'], $order);

            if ($response->successful() && $response['return_code'] == 1) {
                $redirectUrl = $embedData['redirecturl'];
                return redirect()->away($response['order_url'])
                    ->with('message', 'Tạo yêu cầu thanh toán thành công. Bạn sẽ được chuyển hướng đến ZaloPay.')
                    ->with('redirecturl', $redirectUrl);
            }

            $redirectUrl = $embedData['redirecturl'];
            return back()->with('error', 'Không thể tạo yêu cầu thanh toán ZaloPay.')
                ->with('redirecturl', $redirectUrl);
        }
    }

    // POST: ZaloPay gọi về (callback_url)
    public function xuLyRedirectZaloPay(Request $request)
    {
        Log::info("ZaloPay callback: Đã gọi callback xử lý thanh toán");

        $result = [];

        try {
            $key2 = "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz";

            $postdata = file_get_contents('php://input');
            Log::info("ZaloPay callback - Raw postdata: " . $postdata);

            if (empty($postdata)) {
                Log::error("ZaloPay callback: postdata rỗng");
                return response()->json(["return_code" => -1, "return_message" => "postdata rỗng"]);
            }

            $postdatajson = json_decode($postdata, true);
            if (!$postdatajson || !isset($postdatajson['data']) || !isset($postdatajson['mac'])) {
                Log::error("ZaloPay callback: Dữ liệu không hợp lệ", ['postdata' => $postdata]);
                return response()->json(["return_code" => -1, "return_message" => "Dữ liệu callback không hợp lệ"]);
            }

            $mac = hash_hmac("sha256", $postdatajson["data"], $key2);
            $requestmac = $postdatajson["mac"];
            Log::info("ZaloPay callback - Kiểm tra MAC", [
                'mac_server' => $mac,
                'mac_client' => $requestmac
            ]);

            if (strcmp($mac, $requestmac) != 0) {
                Log::warning("ZaloPay callback - MAC không khớp");
                $result["return_code"] = -1;
                $result["return_message"] = "mac not equal";
            } else {
                // Parse data JSON
                $datajson = json_decode($postdatajson["data"], true);
                Log::info("ZaloPay callback - datajson:", $datajson);

                $embedData = isset($datajson['embed_data']) ? json_decode($datajson['embed_data'], true) : null;
                Log::info("ZaloPay callback - embedData:", $embedData);

                $maVanDon = $embedData['ma_van_don'] ?? null;
                Log::info("ZaloPay callback - Mã vận đơn:", ['ma_van_don' => $maVanDon]);

                if ($maVanDon) {
                    $donHang = DonHang::where('ma_van_don', $maVanDon)->first();

                    if (!$donHang) {
                        Log::info("ZaloPay callback - Đơn hàng chưa tồn tại, bắt đầu tạo mới");

                        DB::beginTransaction();
                        try {
                            $donHang = DonHang::create([
                                'nguoi_dung_id' => $embedData['nguoi_dung_id'],
                                'dia_chi_id' => $embedData['dia_chi_id'],
                                'voucher_id' => $embedData['voucher_id'],
                                'tong_tien' => $datajson['amount'] ?? 0,
                                'trang_thai' => 'cho_xac_nhan',
                                'trang_thai_thanh_toan' => 'da_thanh_toan',
                                'ma_van_don' => $maVanDon,
                            ]);
                            $soDiemSuDung = $embedData['so_diem_su_dung'] ?? 0;
                            Log::info('Số điểm sử dụng: ' . $soDiemSuDung);
                            if ($soDiemSuDung > 0) {
                                $nguoiDung = NguoiDung::find($embedData['nguoi_dung_id']);
                                if ($nguoiDung) {
                                    $nguoiDung->tong_diem = $nguoiDung->tong_diem - $soDiemSuDung;
                                    $nguoiDung->save();
                                    Log::info("ZaloPay callback - Đã trừ điểm người dùng: $soDiemSuDung điểm");

                                    $this->capNhatLichSuDiem(
                                        $nguoiDung->id,
                                        $soDiemSuDung,
                                        $donHang->id
                                    );
                                }
                            }

                            Log::info("ZaloPay callback - Đã tạo đơn hàng thành công", ['don_hang_id' => $donHang->id]);

                            if (isset($embedData['cart']) && is_array($embedData['cart'])) {
                                foreach ($embedData['cart'] as $item) {
                                    ChiTietDonHang::create([
                                        'don_hang_id' => $donHang->id,
                                        'san_pham_id' => $item['san_pham_id'],
                                        'so_luong' => $item['so_luong'],
                                        'don_gia' => $item['don_gia'],
                                    ]);

                                    Log::info("ZaloPay callback - Thêm chi tiết đơn hàng", $item);

                                    $sanPham = SanPham::find($item['san_pham_id']);
                                    if ($sanPham) {
                                        $sanPham->so_luong -= $item['so_luong'];
                                        $sanPham->save();
                                    }
                                }
                            }

                            $gioHang = GioHang::where('nguoi_dung_id', $embedData['nguoi_dung_id'])->first();
                            if ($gioHang) {
                                $gioHang->chiTietGioHangs()->delete();
                                Log::info("ZaloPay callback - Đã xóa giỏ hàng của người dùng ID: " . $embedData['nguoi_dung_id']);
                            }

                            if (!empty($embedData['voucher_id'])) {
                                $voucher = Voucher::find($embedData['voucher_id']);
                                if ($voucher && $voucher->so_luong > 0) {
                                    $voucher->so_luong -= 1;
                                    $voucher->save();
                                    Log::info("ZaloPay callback - Đã trừ 1 lượt sử dụng của voucher ID: " . $voucher->id);
                                } else {
                                    Log::warning("ZaloPay callback - Voucher không tồn tại hoặc đã hết lượt sử dụng");
                                }
                            }

                            DB::commit();
                            Log::info("ZaloPay callback - Tạo đơn hàng và chi tiết thành công");
                        } catch (Exception $e) {
                            DB::rollBack();
                            Log::error("ZaloPay callback - Lỗi khi tạo đơn hàng", [
                                'message' => $e->getMessage(),
                                'trace' => $e->getTraceAsString()
                            ]);
                            $result["return_code"] = -2;
                            $result["return_message"] = "DB error: " . $e->getMessage();
                            echo json_encode($result);
                            return;
                        }
                    } else {
                        Log::info("ZaloPay callback - Đơn hàng đã tồn tại");

                        if ($donHang->trang_thai_thanh_toan !== 'da_thanh_toan') {
                            $donHang->trang_thai_thanh_toan = 'da_thanh_toan';
                            $donHang->save();
                            Log::info("ZaloPay callback - Cập nhật trạng thái đơn hàng thành công");
                        }
                    }
                } else {
                    Log::warning("ZaloPay callback - Không tìm thấy mã vận đơn trong embed_data");
                }

                $result["return_code"] = 1;
                $result["return_message"] = "success";
            }
        } catch (Exception $e) {
            Log::error("ZaloPay callback - Lỗi ngoài try chính", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $result["return_code"] = 0;
            $result["return_message"] = $e->getMessage();
        }

        echo json_encode($result);
    }

    public function xyLyResult(Request $request)
    {
        $nguoiDungId = $request->input('nguoi_dung_id');

        if (!$nguoiDungId) {
            return redirect()->route('home')->with('error', 'Không tìm thấy thông tin người dùng');
        }

        $this->capNhatCapTheNguoiDung($nguoiDungId);

        return redirect()->route('home')->with('success', 'Đơn hàng của bạn đã được ghi nhận');
    }


    public function apply(Request $request)
    {
        $ma = $request->input('ma_voucher');

        $voucher = Voucher::where('ma', $ma)->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ.']);
        }

        if ($voucher->so_luong <= 0) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá đã hết lượt sử dụng.']);
        }

        if (Carbon::now()->gt(Carbon::parse($voucher->ket_thuc))) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá đã hết hạn.']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã thành công!',
            'gia_tri' => $voucher->gia_tri,
        ]);
    }

    public function apply_point(Request $request)
    {
        /** @var \App\Models\NguoiDung $nguoiDung */
        $nguoiDung = Auth::user();

        $diemCanDung = (int) $request->input('point');

        if ($diemCanDung <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Số điểm phải lớn hơn 0.'
            ]);
        }

        if ($diemCanDung > $nguoiDung->tong_diem) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không đủ điểm để sử dụng.'
            ]);
        }

        $diemCoTheDoi = $diemCanDung;
        $tienGiam = $diemCoTheDoi;

        if ($tienGiam < 1000) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần ít nhất 1000 điểm để sử dụng.'
            ]);
        }

        $nguoiDung->save();

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng điểm thành công!',
            'diem_su_dung' => $diemCoTheDoi,
            'tien_giam' => $tienGiam
        ]);
    }

    private function capNhatCapTheNguoiDung($nguoiDungId)
    {
        $nguoiDung = NguoiDung::find($nguoiDungId);

        $tongChiTieu = DonHang::where('nguoi_dung_id', $nguoiDung->id)
            ->where('trang_thai', 'da_hoan_thanh')
            ->sum('tong_tien');

        $cacCapThe = CapThe::orderByDesc('diem_toi_thieu')->get();

        foreach ($cacCapThe as $capThe) {
            if ($tongChiTieu >= $capThe->diem_toi_thieu) {
                if ($nguoiDung->cap_the_id != $capThe->id) {
                    $nguoiDung->cap_the_id = $capThe->id;
                    $nguoiDung->save();
                }
                break;
            }
        }
    }

    private function capNhatLichSuDiem($nguoiDungId, $soDiemSuDung, $donHangId)
    {
        try {
            if ($soDiemSuDung > 0) {
                $donHang = DonHang::find($donHangId);
                $maVanDon = $donHang?->ma_van_don;

                LichSuDiem::create([
                    'nguoi_dung_id' => $nguoiDungId,
                    'diem' => $soDiemSuDung,
                    'loai' => 'Sử dụng điểm',
                    'mo_ta' => 'Trừ điểm khi thanh toán đơn hàng ' . $maVanDon,
                ]);

                Log::info("Đã lưu lịch sử trừ $soDiemSuDung điểm cho người dùng ID: $nguoiDungId - Đơn hàng: $donHangId");
            }
        } catch (\Exception $e) {
            Log::error("Lỗi khi lưu lịch sử điểm: " . $e->getMessage());
        }
    }
}
