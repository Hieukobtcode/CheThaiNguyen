<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->dropForeign(['vai_tro_id']);
        });
    }

    public function down(): void
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->foreign('vai_tro_id')->references('id')->on('vai_tros')->onDelete('restrict');
        });
    }
};
