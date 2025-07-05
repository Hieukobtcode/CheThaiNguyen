<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KhuyenMaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vouchers = Voucher::paginate(5);
        return view('admin.voucher.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ten_khuyen_mai' => 'required|string|max:255',
            'ma' => 'required|string|max:50|unique:vouchers,ma',
            'gia_tri' => 'required|numeric|min:0',
            'so_luong' => 'required|integer|min:1',
            'bat_dau' => 'nullable|date|after_or_equal:today',
            'ket_thuc' => 'nullable|date|after:bat_dau',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $batDau = $request->bat_dau ? Carbon::parse($request->bat_dau) : null;
        $ketThuc = $request->ket_thuc ? Carbon::parse($request->ket_thuc) : null;

        if ($batDau && $ketThuc && $ketThuc->lessThanOrEqualTo($batDau)) {
            return redirect()->back()
                ->withErrors(['ket_thuc' => 'Thời gian kết thúc phải sau thời gian bắt đầu.'])
                ->withInput();
        }

        Voucher::create([
            'ten_khuyen_mai' => $request->ten_khuyen_mai,
            'ma' => $request->ma,
            'gia_tri' => $request->gia_tri,
            'so_luong' => $request->so_luong,
            'bat_dau' => $batDau,
            'ket_thuc' => $ketThuc,
        ]);

        return redirect()->route('voucher.index')->with('success', 'Thêm khuyến mãi thành công!');
    }

    public function edit(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.edit', compact('voucher'));
    }

    public function update(Request $request, string $id)
    {
        $voucher = Voucher::findOrFail($id);

        $validatedData = $request->validate([
            'ten_khuyen_mai' => 'required|string|max:255',
            'ma' => 'required|string|max:50|unique:vouchers,ma,' . $voucher->id,
            'gia_tri' => 'required|numeric|min:0',
            'so_luong' => 'required|integer|min:1',
            'bat_dau' => 'nullable|date',
            'ket_thuc' => 'nullable|date|after_or_equal:bat_dau',
        ]);

        $voucher->update($validatedData);

        return redirect()->route('voucher.index')->with('success', 'Cập nhật khuyến mãi thành công!');
    }

    public function destroy(string $id)
    {
        $voucher = Voucher::findOrFail($id);

        $voucher->delete();

        return redirect()->route('voucher.index')->with('success', 'Xóa khuyến mãi thành công!');
    }
}
