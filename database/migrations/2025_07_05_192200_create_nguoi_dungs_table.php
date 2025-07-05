<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nguoi_dungs', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->string('email')->unique();
            $table->string('mat_khau');
            $table->unsignedBigInteger('vai_tro_id')->default(1);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('vai_tro_id')->references('id')->on('vai_tros')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nguoi_dungs');
    }
};
