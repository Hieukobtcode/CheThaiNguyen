<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanHoi extends Model
{
    use HasFactory;

    protected $table = 'phan_hois';

    protected $fillable = [
        'binh_luan_id',
        'nguoi_dung_id',
        'noi_dung',
    ];

    public function binhLuan()
    {
        return $this->belongsTo(BinhLuan::class, 'binh_luan_id');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}
