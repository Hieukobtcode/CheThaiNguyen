<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    protected $table = 'thong_baos';

    protected $fillable = [
        'nguoi_dung_id',
        'tieu_de',
        'noi_dung',
        'loai',
        'da_doc',
        'thoi_gian_gui',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}
