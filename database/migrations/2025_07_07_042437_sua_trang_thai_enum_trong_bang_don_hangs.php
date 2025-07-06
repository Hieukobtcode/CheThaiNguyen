<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SuaTrangThaiEnumTrongBangDonHangs extends Migration
{
    
    public function up(): void
    {
        Schema::table('don_hangs', function (Blueprint $table) {
            $table->enum('trang_thai', [
                'cho_xac_nhan',
                'da_xac_nhan',
                'dang_giao',
                'da_giao',
                'da_hoan_thanh',
                'da_huy',
                'that_bai',
            ])->default('cho_xac_nhan')->change();

            $table->enum('trang_thai_thanh_toan', [
                'chua_thanh_toan',
                'da_thanh_toan',
            ])->default('chua_thanh_toan')->after('trang_thai');
        });
    }

    
    public function down(): void
    {
        Schema::table('don_hangs', function (Blueprint $table) {
            $table->string('trang_thai')->change();

            $table->dropColumn('trang_thai_thanh_toan');
        });
    }
}
