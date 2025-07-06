<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CapThe;
use Illuminate\Http\Request;

class CapTheController extends Controller
{
    public function index()
    {
        $capThes = CapThe::all();
        return view('admin.the-thanh-vien.index', compact('capThes'));
    }

    public function create()
    {
        return view('admin.the-thanh-vien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'diem_toi_thieu' => 'required|numeric|min:0',
            'ti_le_tich_diem' => 'required|numeric|min:0',
            'uu_dai' => 'nullable|string',
        ]);

        CapThe::create([
            'ten' => $request->ten,
            'diem_toi_thieu' => $request->diem_toi_thieu,
            'ti_le_tich_diem' => $request->ti_le_tich_diem,
            'uu_dai' => $request->uu_dai,
        ]);

        return redirect()->route('cap_bac.index')->with('success', 'Thêm cấp bậc thành công!');
    }

    public function edit($id)
    {
        $capBac = CapThe::findOrFail($id);
        return view('admin.the-thanh-vien.edit', compact('capBac'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'diem_toi_thieu' => 'required|numeric|min:0',
            'ti_le_tich_diem' => 'required|numeric|min:0',
            'uu_dai' => 'nullable|string',
        ]);

        $capBac = CapThe::findOrFail($id);
        $capBac->update($request->only(['ten', 'diem_toi_thieu', 'ti_le_tich_diem', 'uu_dai']));

        return redirect()->route('cap_bac.index')->with('success', 'Cập nhật cấp bậc thành công.');
    }


    public function destroy($id)
    {
        $capBac = CapThe::findOrFail($id);
        $capBac->delete();
        return redirect()->route('cap_bac.index')->with('success', 'Xóa cấp bậc thành công!');
    }
}
