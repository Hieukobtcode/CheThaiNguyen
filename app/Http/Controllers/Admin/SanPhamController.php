<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sanPhams = SanPham::with('danhMuc')->paginate(10);
        $danhMucs = DanhMuc::all();
        return view('admin.san-pham.index', compact('sanPhams', 'danhMucs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $danhMucs = DanhMuc::all();
        return view('admin.san-pham.create', compact('danhMucs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'gia' => 'required|numeric|min:0',
            'so_luong' => 'required|integer|min:0',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'danh_muc_id' => 'required|exists:danh_mucs,id',
            'trang_thai' => 'required|in:0,1', // Thêm validate cho trạng thái
        ]);

        $data = $request->only(['ten', 'mo_ta', 'gia', 'so_luong', 'danh_muc_id', 'trang_thai']);

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('san_pham', $fileName, 'public');
            $data['hinh_anh'] = $filePath;
        }

        SanPham::create($data);

        return redirect()->route('san_pham.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $sanPham = SanPham::findOrFail($id);
        $danhMucs = DanhMuc::all();

        return view('admin.san-pham.edit', compact('sanPham', 'danhMucs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'so_luong' => 'required|integer|min:1',
            'mo_ta' => 'nullable|string',
            'hinh_anh' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'danh_muc_id' => 'required|exists:danh_mucs,id',
            'trang_thai' => 'required|in:0,1',
        ]);

        $sanPham = SanPham::findOrFail($id);

        $sanPham->fill($request->except('hinh_anh'));

        if ($request->hasFile('hinh_anh')) {
            if ($sanPham->hinh_anh && Storage::disk('public')->exists($sanPham->hinh_anh)) {
                Storage::disk('public')->delete($sanPham->hinh_anh);
            }

            $path = $request->file('hinh_anh')->store('san_pham', 'public');
            $sanPham->hinh_anh = $path;
        }

        $sanPham->save();

        return redirect()->route('san_pham.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(string $id)
    {
        $sanPham = SanPham::findOrFail($id);
        $sanPham->delete(); 
        return redirect()->route('san_pham.index')->with('success', 'Sản phẩm đã được xóa tạm thời!');
    }
}
