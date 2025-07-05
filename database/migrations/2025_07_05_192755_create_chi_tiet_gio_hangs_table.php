<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('chi_tiet_gio_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gio_hang_id');
            $table->unsignedBigInteger('san_pham_id');
            $table->unsignedInteger('so_luong')->default(1);
            $table->timestamps();

            $table->foreign('gio_hang_id')->references('id')->on('gio_hangs')->onDelete('cascade');
            $table->foreign('san_pham_id')->references('id')->on('san_phams')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_gio_hangs');
    }
};
