<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BaiViet;

class BaiVietController extends Controller
{
    
    public function danhSachBaiViet()
    {
        $baiViets = BaiViet::all();
        return view('client.danh-sach-tin-tuc',compact('baiViets'));
    }

    public function chiTietBaiViet($id){
        $baiViet = BaiViet::findOrFail($id);
        return view('client.chi-tiet-tin-tuc',compact('baiViet'));
    }   

    
}
