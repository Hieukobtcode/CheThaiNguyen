<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de')->nullable()->comment('Tiêu đề hiển thị trên banner');
            $table->string('hinh_anh')->comment('Đường dẫn hình ảnh banner');
            $table->boolean('trang_thai')->default(true)->comment('true = hiển thị, false = ẩn');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
