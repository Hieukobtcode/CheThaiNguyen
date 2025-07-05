<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('ma')->unique();
            $table->decimal('gia_tri', 8, 2);
            $table->unsignedInteger('so_luong')->default(1);
            $table->dateTime('bat_dau')->nullable();
            $table->dateTime('ket_thuc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
