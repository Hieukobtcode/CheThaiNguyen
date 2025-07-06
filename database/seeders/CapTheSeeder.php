<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CapTheSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('cap_the')->insert([
            ['ten' => 'Đồng', 'diem_toi_thieu' => 0, 'ti_le_tich_diem' => 0.01, 'uu_dai' => 'Tích điểm cơ bản'],
            ['ten' => 'Bạc', 'diem_toi_thieu' => 500, 'ti_le_tich_diem' => 0.02, 'uu_dai' => 'Giảm 5% đơn từ 300k'],
            ['ten' => 'Vàng', 'diem_toi_thieu' => 1500, 'ti_le_tich_diem' => 0.03, 'uu_dai' => 'Freeshp và giảm 10%'],
            ['ten' => 'Kim Cương', 'diem_toi_thieu' => 3000, 'ti_le_tich_diem' => 0.05, 'uu_dai' => 'Freeship + quà tặng'],
        ]);
    }
}
