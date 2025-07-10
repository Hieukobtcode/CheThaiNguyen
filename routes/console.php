<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('test:thongbao', function () {
    $this->info('Chạy test command gửi thông báo!');
})->purpose('Test gửi thông báo');
