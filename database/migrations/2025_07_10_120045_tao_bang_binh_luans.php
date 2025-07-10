<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('binh_luans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dungs')->onDelete('cascade');
            $table->foreignId('san_pham_id')->constrained('san_phams')->onDelete('cascade');
            $table->text('noi_dung');
            $table->tinyInteger('danh_gia')->nullable()->comment('Số sao đánh giá từ 1 đến 5');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('binh_luans');
    }
};
