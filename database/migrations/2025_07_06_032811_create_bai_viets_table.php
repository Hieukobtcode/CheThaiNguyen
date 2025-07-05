<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('bai_viets', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');
            $table->text('noi_dung');
            $table->string('hinh_anh')->nullable();
            $table->enum('trang_thai', ['Nháp', 'Xuất bản'])->default('Xuất bản');
            $table->timestamps();

        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('bai_viets');
    }
};
