<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $table = 'binh_luans';

    protected $fillable = [
        'nguoi_dung_id',
        'san_pham_id',
        'noi_dung',
        'trang_thai',
        'danh_gia',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }

    public function phanHoi ()
    {
        return $this->hasOne(PhanHoi::class, 'binh_luan_id');
    }
}
