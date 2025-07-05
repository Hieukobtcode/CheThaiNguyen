<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('don_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nguoi_dung_id');
            $table->unsignedBigInteger('dia_chi_id');
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->decimal('tong_tien', 12, 2);
            $table->string('trang_thai')->default('cho_xac_nhan');
            $table->string('ma_van_don')->nullable();
            $table->timestamps();

            $table->foreign('nguoi_dung_id')->references('id')->on('nguoi_dungs');
            $table->foreign('dia_chi_id')->references('id')->on('dia_chis');
            $table->foreign('voucher_id')->references('id')->on('vouchers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('don_hangs');
    }
};
