<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DanhMuc;

class DanhMucSeeder extends Seeder
{
    public function run(): void
    {
        DanhMuc::insert([
            ['ten' => 'Chè Thái Nguyên', 'created_at' => now(), 'updated_at' => now()],
            ['ten' => 'Chè Shan Tuyết', 'created_at' => now(), 'updated_at' => now()],
            ['ten' => 'Chè Ô Long', 'created_at' => now(), 'updated_at' => now()],
            ['ten' => 'Chè Lài', 'created_at' => now(), 'updated_at' => now()],
            ['ten' => 'Chè Xanh Hữu Cơ', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
