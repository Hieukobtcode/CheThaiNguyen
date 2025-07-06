<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SanPhamSeeder extends Seeder
{
    public function run(): void
    {
        $sanPhams = [];

        $danhMucs = [
            1 => 'Trà Đinh',
            2 => 'Trà Nõn Tôm',
            3 => 'Trà Móc Câu',
            4 => 'Trà Búp',
            5 => 'Trà Cánh',
            6 => 'Trà Phúc Vân Tiên',
            7 => 'Trà Kim Tuyên',
            8 => 'Trà Bát Tiên',
            9 => 'Trà Tân Cương',
        ];

        foreach ($danhMucs as $id => $tenDanhMuc) {
            for ($i = 1; $i <= 3; $i++) {
                $sanPhams[] = [
                    'ten' => $tenDanhMuc . ' sản phẩm ' . $i,
                    'mo_ta' => "Sản phẩm {$i} thuộc danh mục {$tenDanhMuc}, chất lượng cao, hương vị thơm ngon.",
                    'gia' => rand(100000, 500000),
                    'hinh_anh' => "null",
                    'so_luong' => rand(10, 100),
                    'trang_thai' => 1,
                    'danh_muc_id' => $id,
                ];
            }
        }

        DB::table('san_phams')->insert($sanPhams);
    }
}
