<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BaiVietController extends Controller
{

    public function index()
    {
        $baiViets = BaiViet::paginate(5);
        return view('admin.bai-viet.index', compact('baiViets'));
    }

    public function create()
    {
        return view('admin.bai-viet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'required|string',
            'hinh_anh' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $baiViet = new BaiViet();
        $baiViet->tieu_de = $request->tieu_de;
        $baiViet->noi_dung = $request->noi_dung;

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $path = $file->store('bai_viets', 'public');
            $baiViet->hinh_anh = $path;
        }

        $baiViet->trang_thai = $request->status === 'published' ? 'Xuất bản' : 'Nháp';

        $baiViet->save();

        return redirect()->route('bai_viet.index')->with('success', 'Thêm bài viết thành công!');
    }

    public function edit(string $id)
    {
        $baiViet = BaiViet::findOrFail($id);
        return view('admin.bai-viet.edit', compact('baiViet'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'required|string',
            'hinh_anh' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $baiViet = BaiViet::findOrFail($id);

        $baiViet->tieu_de = $request->tieu_de;
        $baiViet->noi_dung = $request->noi_dung;

        if ($request->hasFile('hinh_anh')) {
            if ($baiViet->hinh_anh && Storage::disk('public')->exists($baiViet->hinh_anh)) {
                Storage::disk('public')->delete($baiViet->hinh_anh);
            }

            $path = $request->file('hinh_anh')->store('bai_viets', 'public');
            $baiViet->hinh_anh = $path;
        }

        $baiViet->trang_thai = $request->status === 'published' ? 'Xuất bản' : 'Nháp';

        $baiViet->save();

        return redirect()->route('bai_viet.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy(string $id)
    {
        $baiViet = BaiViet::findOrFail($id);

        if ($baiViet->hinh_anh && Storage::disk('public')->exists($baiViet->hinh_anh)) {
            Storage::disk('public')->delete($baiViet->hinh_anh);
        }

        $baiViet->delete();

        return redirect()->route('bai_viet.index')->with('success', 'Xóa bài viết thành công!');
    }
}
