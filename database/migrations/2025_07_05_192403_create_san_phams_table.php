<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->text('mo_ta')->nullable();
            $table->decimal('gia', 12, 2);
            $table->unsignedInteger('so_luong');
            $table->string('hinh_anh')->nullable();
            $table->unsignedBigInteger('danh_muc_id');
            $table->timestamps();

            $table->foreign('danh_muc_id')->references('id')->on('danh_mucs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('san_phams');
    }
};
