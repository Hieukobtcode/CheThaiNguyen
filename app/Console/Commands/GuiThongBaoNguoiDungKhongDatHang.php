<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NguoiDung;
use App\Models\DonHang;
use App\Models\ThongBao;
use Carbon\Carbon;

class GuiThongBaoNguoiDungKhongDatHang extends Command
{
    protected $signature = 'thongbao:nguoidung-khong-dathang';
    protected $description = 'Gửi thông báo cho người dùng không đặt đơn hàng trong vòng 1 tháng';

    public function handle()
    {
        $motThangTruoc = Carbon::now()->subMonth();

        $nguoiDungs = NguoiDung::all();

        foreach ($nguoiDungs as $nguoiDung) {
            $coDonHang = DonHang::where('nguoi_dung_id', $nguoiDung->id)
                ->where('created_at', '>=', $motThangTruoc)
                ->exists();

            if (!$coDonHang) {
                ThongBao::create([
                    'nguoi_dung_id' => $nguoiDung->id,
                    'tieu_de' => 'Bạn đã lâu không mua sắm!',
                    'noi_dung' => 'Đã hơn 1 tháng bạn chưa đặt đơn hàng nào. Quay lại nhận ưu đãi ngay hôm nay!',
                    'loai' => 'nhac_nho',
                    'thoi_gian_gui' => now(),
                ]);
            }
        }

        $this->info('Đã gửi thông báo cho người dùng không đặt hàng trong vòng 1 tháng.');
    }
}
