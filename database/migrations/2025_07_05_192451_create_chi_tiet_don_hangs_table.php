<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('don_hang_id');
            $table->unsignedBigInteger('san_pham_id');
            $table->unsignedInteger('so_luong');
            $table->decimal('don_gia', 12, 2);
            $table->timestamps();

            $table->foreign('don_hang_id')->references('id')->on('don_hangs')->onDelete('cascade');
            $table->foreign('san_pham_id')->references('id')->on('san_phams')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_hangs');
    }
};
