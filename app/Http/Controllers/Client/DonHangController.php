<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonHangController extends Controller
{
    public function index()
    {
        $nguoiDungId = Auth::id();

        $donHangs = DonHang::with(['diaChi', 'voucher']) 
            ->where('nguoi_dung_id', $nguoiDungId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.danh-sach-don-hang', compact('donHangs'));
    }

  

}
