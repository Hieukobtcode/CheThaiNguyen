<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CapThe;

class CapTheSeeder extends Seeder
{
    public function run(): void
    {
        CapThe::insert([
            [
                'ten' => 'Đồng',
                'diem_toi_thieu' => 5000000,
                'ti_le_tich_diem' => 1,
                'uu_dai' => 'Tỷ lệ tích điểm 1%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Bạc',
                'diem_toi_thieu' => 10000000,
                'ti_le_tich_diem' => 3,
                'uu_dai' => 'Tỷ lệ tích điểm 3%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Vàng',
                'diem_toi_thieu' => 20000000,
                'ti_le_tich_diem' => 5,
                'uu_dai' => 'Tỷ lệ tích điểm 5%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
