<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('dia_chis', function (Blueprint $table) {
            $table->string('so_dien_thoai', 20)->after('ho_va_ten');
        });
    }

    public function down(): void
    {
        Schema::table('dia_chis', function (Blueprint $table) {
            $table->dropColumn('so_dien_thoai');
        });
    }
};
