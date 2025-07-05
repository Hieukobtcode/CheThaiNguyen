<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;

    protected $table = 'san_phams';

    protected $fillable = [
        'ten',
        'mo_ta',
        'gia',
        'hinh_anh',
        'so_luong_ton',
        'trang_thai',
        'danh_muc_id',
    ];

    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }

    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'san_pham_id');
    }

    public function chiTietGioHangs()
    {
        return $this->hasMany(ChiTietGioHang::class, 'san_pham_id');
    }

}
