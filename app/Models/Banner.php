<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'tieu_de',
        'hinh_anh',
        'trang_thai',
    ];
}
