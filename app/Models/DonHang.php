<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;

    protected $table = 'don_hangs';

    protected $fillable = [
        'nguoi_dung_id',
        'dia_chi_id',
        'voucher_id',
        'ma_van_don',
        'tong_tien',
        'trang_thai',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function diaChi()
    {
        return $this->belongsTo(DiaChi::class, 'dia_chi_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }

    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
    }
}
