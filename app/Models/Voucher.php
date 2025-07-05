<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    public $timestamps = false;

    protected $fillable = [
        'ten_khuyen_mai',
        'ma',
        'gia_tri',
        'so_luong',
        'bat_dau',
        'ket_thuc',
    ];

    protected $dates = [
        'bat_dau',
        'ket_thuc',
    ];

    public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'voucher_id');
    }
}
