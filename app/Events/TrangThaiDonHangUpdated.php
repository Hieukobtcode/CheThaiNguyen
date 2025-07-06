<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TrangThaiDonHangUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $donHang;

    public function __construct($donHang)
    {
        $this->donHang = $donHang;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('donhang.' . $this->donHang->nguoi_dung_id);
    }

    public function broadcastAs(): string
    {
        return 'DonHangCapNhatTrangThai';
    }
}
