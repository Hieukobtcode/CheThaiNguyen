<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('danh_mucs')->insert([
            [
                'ten' => 'Trà Đinh',
                'mo_ta' => 'Trà cao cấp nhất Thái Nguyên, búp nhỏ như đầu đinh, hương thơm đặc biệt.',
                'trang_thai' => 1,
            ],
            [
                'ten' => 'Trà Nõn Tôm',
                'mo_ta' => 'Trà làm từ 1 tôm 1 lá non, dịu nhẹ, thơm ngon.',
                'trang_thai' => 1,
            ],
            [
                'ten' => 'Trà Móc Câu',
                'mo_ta' => 'Trà có hình móc câu, hương thơm đặc trưng, vị chát nhẹ.',
                'trang_thai' => 1,
            ],
            [
                'ten' => 'Trà Búp',
                'mo_ta' => 'Búp trà to, hương vị đậm hơn so với Nõn Tôm và Móc Câu.',
                'trang_thai' => 1,
            ],
            [
                'ten' => 'Trà Cánh',
                'mo_ta' => 'Giống chè năng suất cao, búp nhỏ, vị dịu nhẹ, dễ uống.',
                'trang_thai' => 1,
            ],
            [
                'ten' => 'Trà Phúc Vân Tiên',
                'mo_ta' => 'Giống lai Trung Hoa, có hương hoa nhài nhẹ nhàng.',
                'trang_thai' => 1,
            ],
            [
                'ten' => 'Trà Kim Tuyên',
                'mo_ta' => 'Giống trà Đài Loan, hương thanh, vị nhẹ nhàng.',
                'trang_thai' => 1,
            ],
            [
                'ten' => 'Trà Bát Tiên',
                'mo_ta' => 'Giống trà quý hiếm, có hương thơm ngọt đặc biệt.',
                'trang_thai' => 1,
            ],
            [
                'ten' => 'Trà Tân Cương',
                'mo_ta' => 'Tập hợp các loại chè ngon vùng đặc sản Tân Cương, Thái Nguyên.',
                'trang_thai' => 1,
            ],
        ]);
    }
}
