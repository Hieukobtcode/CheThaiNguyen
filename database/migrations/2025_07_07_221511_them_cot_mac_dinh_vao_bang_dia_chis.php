<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ThemCotMacDinhVaoBangDiaChis extends Migration
{
    /**
     * Thêm cột mac_dinh vào bảng dia_chis.
     */
    public function up(): void
    {
        Schema::table('dia_chis', function (Blueprint $table) {
            $table->boolean('mac_dinh')->default(false)->after('tinh_thanh')->comment('Địa chỉ mặc định');
        });
    }

    /**
     * Xóa cột mac_dinh khi rollback.
     */
    public function down(): void
    {
        Schema::table('dia_chis', function (Blueprint $table) {
            $table->dropColumn('mac_dinh');
        });
    }
}
