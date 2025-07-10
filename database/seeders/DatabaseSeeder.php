<?php

namespace Database\Seeders;

use CapTheSeeder;
use Database\Seeders\CapTheSeeder as SeedersCapTheSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SeedersCapTheSeeder::class,
            DanhMucSeeder::class,
            SanPhamSeeder::class,
            NguoiDungSeeder::class,
        ]);
    }
}
