<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('dia_chis', function (Blueprint $table) {
            $table->dropForeign(['nguoi_dung_id']);

         
            $table->dropColumn('nguoi_dung_id');

            $table->string('ho_va_ten')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('dia_chis', function (Blueprint $table) {
            $table->unsignedBigInteger('nguoi_dung_id')->after('id');
            $table->foreign('nguoi_dung_id')->references('id')->on('nguoi_dungs')->onDelete('cascade');

            $table->dropColumn('ho_va_ten');
        });
    }
};
