<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('binh_luans', function (Blueprint $table) {
            $table->string('trang_thai')->default('hien')->after('noi_dung'); // hoặc sau cột phù hợp
        });
    }

    public function down(): void
    {
        Schema::table('binh_luans', function (Blueprint $table) {
            $table->dropColumn('trang_thai');
        });
    }
};
