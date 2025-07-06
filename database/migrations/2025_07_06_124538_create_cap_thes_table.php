<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cap_the', function (Blueprint $table) {
            $table->id();
            $table->string('ten'); 
            $table->integer('diem_toi_thieu'); 
            $table->float('ti_le_tich_diem')->default(0.01); 
            $table->text('uu_dai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cap_thes');
    }
};
