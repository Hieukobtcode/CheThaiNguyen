<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('q');

    $danhMucs = DanhMuc::all();
    $sanPhams = SanPham::query();

    if ($query) {
        $sanPhams = $sanPhams->where('ten', 'like', '%' . $query . '%');
    }

    $sanPhams = $sanPhams->paginate(12); 

    return view('client.danh-sach-san-pham', compact('sanPhams', 'query', 'danhMucs'));
}


    //Lọc thep danh mục
    public function locTheoDanhMuc($id)
    {
        $danhMucs = DanhMuc::all(); 
        $sanPhams = SanPham::where('danh_muc_id', $id)->paginate(6);

        return view('client.danh-sach-san-pham', compact('sanPhams', 'danhMucs'));
    }
}
