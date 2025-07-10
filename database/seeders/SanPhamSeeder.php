<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\DanhMuc;

class SanPhamSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Chè Thái Nguyên' => [
                'Chè Tân Cương Đặc Biệt',
                'Chè Tân Cương Thượng Hạng',
                'Chè Thái Nguyên ướp hoa nhài',
                'Chè Thái Nguyên sợi nhỏ',
                'Chè Móc Câu Thái Nguyên',
            ],
            'Chè Shan Tuyết' => [
                'Chè Shan Tuyết Hà Giang',
                'Chè Shan Tuyết cổ thụ',
                'Chè Shan Tuyết Suối Giàng',
                'Chè Shan Tuyết sợi to',
                'Chè Shan Tuyết ướp hoa',
            ],
            'Chè Ô Long' => [
                'Chè Ô Long Đài Loan',
                'Chè Ô Long sữa',
                'Chè Ô Long ủ lên men nhẹ',
                'Chè Ô Long truyền thống',
                'Chè Ô Long thượng hạng',
            ],
            'Chè Lài' => [
                'Chè Lài truyền thống',
                'Chè Lài ướp hoa thật',
                'Chè Lài sợi nhỏ',
                'Chè Lài Thái Nguyên',
                'Chè Lài cao cấp',
            ],
            'Chè Xanh Hữu Cơ' => [
                'Chè Xanh hữu cơ Thanh Hương',
                'Chè Xanh Organic Tân Cương',
                'Chè Xanh Hữu Cơ sạch',
                'Chè Xanh Lá tươi hữu cơ',
                'Chè Xanh Hữu Cơ túi lọc',
            ],
        ];

        foreach ($data as $tenDanhMuc => $sanPhams) {
            $danhMuc = DanhMuc::where('ten', $tenDanhMuc)->first();
            if (!$danhMuc) continue;

            foreach ($sanPhams as $ten) {
                DB::table('san_phams')->insert([
                    'ten' => $ten,
                    'slug' => Str::slug($ten),
                    'mo_ta' => 'Mô tả cho sản phẩm ' . $ten,
                    'gia' => rand(30000, 200000),
                    'so_luong' => rand(20, 200),
                    'hinh_anh' => null,
                    'danh_muc_id' => $danhMuc->id,
                    'trang_thai' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
