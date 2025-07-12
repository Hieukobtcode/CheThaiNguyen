<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function xuLyDangNhap(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Kiểm tra vai trò
            if ($user->vai_tro_id == 0) {
                return response()->json([
                    'message' => 'Đăng nhập thành công với quyền Admin!',
                    'redirect' => route('admin.dashboard') 
                ]);
            }

            return response()->json([
                'message' => 'Đăng nhập thành công!',
                'redirect' => route('home') 
            ]);
        }

        return response()->json([
            'message' => 'Email hoặc mật khẩu không chính xác.'
        ], 401);
    }


    public function xuLyDangKy(Request $request)
    {
        $validated = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|unique:nguoi_dungs,email',
            'mat_khau' => 'required|string|min:6|confirmed',
        ]);

        $nguoiDung = new NguoiDung();
        $nguoiDung->ten = $request->ho_ten;
        $nguoiDung->email = $request->email;
        $nguoiDung->password = Hash::make($request->mat_khau);
        $nguoiDung->cap_the_id = 1;
        $nguoiDung->save();

        return response()->json([
            'message' => 'Đăng ký thành công. Hãy đăng nhập!'
        ], 200);
    }

    public function dangXuat()
    {
        session()->forget('nguoi_dung');
        return redirect()->route('dang-nhap');
    }

    public function hienThiQuenMatKhau()
    {
        return view('client.auth.quen-mat-khau');
    }

    public function xuLyQuenMatKhau(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $nguoiDung = NguoiDung::where('email', $request->email)->first();
        if (!$nguoiDung) {
            return back()->withErrors(['email' => 'Không tìm thấy người dùng']);
        }

        // Tạo mật khẩu mới đơn giản
        $matKhauMoi = Str::random(8);
        $nguoiDung->mat_khau = Hash::make($matKhauMoi);
        $nguoiDung->save();

        // Gửi email
        Mail::raw("Mật khẩu mới của bạn là: $matKhauMoi", function ($message) use ($nguoiDung) {
            $message->to($nguoiDung->email)
                ->subject('Mật khẩu mới');
        });

        return redirect()->route('dang-nhap')->with('success', 'Mật khẩu mới đã được gửi đến email của bạn');
    }
}
