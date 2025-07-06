<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->string('hinh_anh')->nullable()->after('email'); // hoặc sau avatar nếu có
            $table->boolean('trang_thai')->default(1)->after('hinh_anh'); // 1 = hoạt động, 0 = tạm khóa
        });
    }

    public function down(): void
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->dropColumn(['hinh_anh', 'trang_thai']);
        });
    }
};
