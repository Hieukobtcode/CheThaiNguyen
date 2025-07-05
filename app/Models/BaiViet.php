<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    use HasFactory;

    protected $table = 'bai_viets';

    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'hinh_anh',
        'trang_thai',
    ];

}
