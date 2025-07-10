<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('phan_hois', function (Blueprint $table) {
            $table->id();
            $table->foreignId('binh_luan_id')->constrained('binh_luans')->onDelete('cascade');
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dungs')->onDelete('cascade');
            $table->text('noi_dung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phan_hois');
    }
};
