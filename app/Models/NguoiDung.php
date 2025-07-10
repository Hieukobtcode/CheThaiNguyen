<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NguoiDung extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'nguoi_dungs';

    protected $fillable = [
        'ten',
        'email',
        'hinh_anh',
        'trang_thai',
        'password',
        'vai_tro_id',
        'cap_the_id',
        'tong_diem'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function vaiTro()
    {
        return $this->belongsTo(VaiTro::class, 'vai_tro_id');
    }

    public function capBac()
    {
        return $this->belongsTo(CapThe::class, 'cap_the_id');
    }

    public function lichSuDiems()
    {
        return $this->hasMany(LichSuDiem::class, 'nguoi_dung_id');
    }

    public function diaChis()
    {
        return $this->hasMany(DiaChi::class, 'nguoi_dung_id');
    }

    public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'nguoi_dung_id');
    }

    public function gioHang()
    {
        return $this->hasOne(GioHang::class, 'nguoi_dung_id');
    }

    public function binhLuans()
    {
        return $this->hasMany(BinhLuan::class, 'nguoi_dung_id');
    }

    public function phanHois()
    {
        return $this->hasMany(PhanHoi::class, 'nguoi_dung_id');
    }

}
