<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ThemNgaySinhVaSoDienThoaiVaoBangNguoiDungs extends Migration
{
    public function up(): void
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->date('ngay_sinh')->nullable()->after('hinh_anh');
            $table->string('so_dien_thoai', 20)->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->dropColumn(['ngay_sinh', 'so_dien_thoai']);
        });
    }
}
