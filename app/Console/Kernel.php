<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Đăng ký các command.
     */
    protected $commands = [
        \App\Console\Commands\GuiThongBaoNguoiDungKhongDatHang::class,
    ];

    /**
     * Lên lịch chạy các command.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('thongbao:nguoidung-khong-dathang')->daily();
    }

    /**
     * Đăng ký các command thông qua file.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
