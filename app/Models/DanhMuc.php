<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;

    protected $table = 'danh_mucs';

    protected $fillable = [
        'ten',
        'mo_ta',
        'trang_thai',
    ];

    public function sanPhams()
    {
        return $this->hasMany(SanPham::class, 'danh_muc_id');
    }
}
