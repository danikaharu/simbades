<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class QrCodeScanned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function broadcastOn()
    {
        return new Channel('barcode-channel');
    }

    public function broadcastAs()
    {
        return 'QrCodeScanned';
    }
}
