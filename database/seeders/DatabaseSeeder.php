<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {

        $this->call(
            [
                BaiVietSeeder::class,
                CapTheSeeder::class,
                NguoiDungSeeder::class,
                DanhMucSeeder::class,
                SanPhamSeeder::class,
            ]
        );
    }
}
