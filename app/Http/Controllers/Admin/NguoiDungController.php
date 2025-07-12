<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BinhLuan;
use App\Models\LichSuDiem;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NguoiDungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = NguoiDung::where('id', '!=', Auth::id())->paginate(10);
        return view('admin.nguoi-dung.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = NguoiDung::with('capBac')->findOrFail($id);

        $donHangsHoanThanh = $user->donHangs()
            ->where('trang_thai', 'da_hoan_thanh')
            ->get();

        $tongChiTieu = $donHangsHoanThanh->sum('tong_tien');

        $donHangsHoanThanh = $user->donHangs()
            ->where('trang_thai', 'da_hoan_thanh')
            ->get();

        $lichSuDiem = LichSuDiem::where('nguoi_dung_id', '=', $user->id)->get();

        $binhLuans = BinhLuan::with('sanPham')
            ->where('nguoi_dung_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.nguoi-dung.edit', compact(
            'user',
            'donHangsHoanThanh',
            'tongChiTieu',
            'lichSuDiem',
            'binhLuans'
        ));
    }


    public function toggleTrangThai($id)
    {
        $nguoiDung = NguoiDung::findOrFail($id);
        $nguoiDung->trang_thai = $nguoiDung->trang_thai == 1 ? 0 : 1;
        $nguoiDung->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
