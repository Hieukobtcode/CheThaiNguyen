<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhanHoi;
use Illuminate\Http\Request;

class PhanHoiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'binh_luan_id' => 'required|exists:binh_luans,id',
            'nguoi_dung_id' => 'required|exists:nguoi_dungs,id',
            'noi_dung' => 'required|string',
        ]);

        PhanHoi::create($request->only('binh_luan_id', 'nguoi_dung_id', 'noi_dung'));

        return back()->with('success', 'Đã gửi phản hồi.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
