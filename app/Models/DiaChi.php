<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaChi extends Model
{
    use HasFactory;

    protected $table = 'dia_chis';

    protected $fillable = [
        'nguoi_dung_id',
        'ho_va_ten',
        'so_dien_thoai',
        'tinh_thanh',
        'mac_dinh',
        'quan_huyen',
        'phuong_xa',
        'dia_chi_cu_the',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'dia_chi_id');
    }
}
