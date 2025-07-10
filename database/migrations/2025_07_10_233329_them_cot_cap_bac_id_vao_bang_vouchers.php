<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->unsignedBigInteger('cap_bac_id')->nullable()->after('id');

            // Nếu có quan hệ khóa ngoại:
            $table->foreign('cap_bac_id')->references('id')->on('cap_the')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropForeign(['cap_bac_id']);
            $table->dropColumn('cap_bac_id');
        });
    }
};
