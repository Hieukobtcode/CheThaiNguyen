<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TaoBangThongBaos extends Migration
{
    public function up()
    {
        Schema::create('thong_baos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->nullable()->constrained('nguoi_dungs')->nullOnDelete();
            $table->string('tieu_de');
            $table->text('noi_dung');
            $table->enum('loai', ['cap_nhat_don_hang', 'khuyen_mai', 'nhac_nho'])->default('cap_nhat_don_hang');
            $table->boolean('da_doc')->default(false);
            $table->timestamp('thoi_gian_gui')->nullable(); // Thời gian gửi thông báo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('thong_baos');
    }
}
