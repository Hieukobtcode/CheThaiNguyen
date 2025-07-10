<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuDiem extends Model
{
    use HasFactory;

    protected $table = 'lich_su_diem';

    protected $fillable = [
        'nguoi_dung_id',
        'diem',
        'loai',
        'mo_ta',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}
