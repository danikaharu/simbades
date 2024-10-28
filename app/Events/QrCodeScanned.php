<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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
        return new Channel('qr-code-status');
    }

    public function broadcastAs()
    {
        return 'qr-code-scanned';
    }
}
