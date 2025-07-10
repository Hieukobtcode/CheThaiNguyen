<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Hash;

class NguoiDungSeeder extends Seeder
{
    public function run(): void
    {
        NguoiDung::insert([
            [
                'ten' => 'Admiin',
                'email' => 'admin@gmail.com',
                'so_dien_thoai' => '0909123456',
                'hinh_anh' => null,
                'ngay_sinh' => '2000-01-01',
                'trang_thai' => 1,
                'password' => Hash::make('12345678'),
                'vai_tro_id' => 0,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'cap_the_id' => 1,
                'tong_diem' => 0,
            ],
        ]);
    }
}
