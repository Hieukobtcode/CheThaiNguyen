<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BinhLuan;
use Illuminate\Http\Request;

class BinhLuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $BinhLuans = BinhLuan::with(['nguoiDung', 'sanPham'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.binh-luan.index', compact('BinhLuans'));
    }

    public function edit($id)
    {
        $binhLuan = BinhLuan::with(['nguoiDung', 'sanPham', 'phanHoi.nguoiDung'])->findOrFail($id);
        return view('admin.binh-luan.show', compact('binhLuan'));
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        $binhLuan = BinhLuan::findOrFail($id);
        $binhLuan->trang_thai = 'an';
        $binhLuan->save();

        return redirect()->back()->with('success', 'Bình luận đã được ẩn thành công.');
    }
}
