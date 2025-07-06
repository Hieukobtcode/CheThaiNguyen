<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->renameColumn('mat_khau', 'password');
        });
    }

    public function down()
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->renameColumn('password', 'mat_khau');
        });
    }
};
