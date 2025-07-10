<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::paginate(10);
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tieu_de' => 'required|string|max:255',
            'hinh_anh' => 'required|image|mimes:jpeg,png,jpg',
            'trang_thai' => 'required|in:1,0',
        ]);

        $hinhAnh = $request->file('hinh_anh')->store('banners', 'public');

        Banner::create([
            'tieu_de' => $request->tieu_de,
            'hinh_anh' => $hinhAnh,
            'trang_thai' => $request->trang_thai,
        ]);

        return redirect()->route('banner.index')->with('success', 'Thêm banner thành công');
    }


    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tieu_de' => 'required|string|max:255',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg',
            'trang_thai' => 'required|in:1,0',
        ]);

        $banner = Banner::findOrFail($id);

        if ($request->hasFile('hinh_anh')) {
            // Xoá ảnh cũ nếu có
            if ($banner->hinh_anh && Storage::disk('public')->exists($banner->hinh_anh)) {
                Storage::disk('public')->delete($banner->hinh_anh);
            }

            $hinhAnh = $request->file('hinh_anh')->store('banners', 'public');
            $banner->hinh_anh = $hinhAnh;
        }

        $banner->tieu_de = $request->tieu_de;
        $banner->trang_thai = $request->trang_thai;
        $banner->save();

        return redirect()->route('banner.index')->with('success', 'Cập nhật banner thành công');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('banner.index')->with('success', 'Xoá banner thành công');
    }
}
