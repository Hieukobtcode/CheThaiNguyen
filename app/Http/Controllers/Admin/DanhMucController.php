<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $danhMucs = DanhMuc::paginate(5);
        return view('admin.danh-muc.index', compact('danhMucs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.danh-muc.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten' => 'required|string|max:255|unique:danh_mucs,ten',
        ]);

        DanhMuc::create([
            'ten' => $validated['ten'],
        ]);

        return redirect()->route('danh_muc.index')->with('success', 'Thêm danh mục thành công.');
    }

    public function edit(string $id)
    {
        $danhMuc = DanhMuc::findOrFail($id);
        return view('admin.danh-muc.edit', compact('danhMuc'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
        ]);

        $danhMuc = DanhMuc::findOrFail($id);
        $danhMuc->ten = $request->ten;
        $danhMuc->save();

        return redirect()->route('danh_muc.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(string $id)
    {
        $danhMuc = DanhMuc::findOrFail($id);
        $danhMuc->delete();

        return redirect()->route('danh_muc.index')->with('success', 'Xóa danh mục thành công!');
    }
}
