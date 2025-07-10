<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('san_phams', function (Blueprint $table) {
            $table->string('slug')->unique()->after('ten');
        });
    }

    public function down()
    {
        Schema::table('san_phams', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}; 
