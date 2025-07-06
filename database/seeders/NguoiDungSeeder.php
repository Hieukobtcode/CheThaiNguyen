<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NguoiDungSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('nguoi_dungs')->insert([
            [
                'ten' => 'Quản trị viên',
                'email' => 'admin@chethainguyen.vn',
                'mat_khau' => Hash::make('matkhauadmin'),
                'vai_tro_id' => 0,
                'cap_the_id' => 1,
                'tong_diem' => 0,
            ],
            
        ]);
    }
}
