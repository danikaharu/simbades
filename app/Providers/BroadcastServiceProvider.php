<?php

use App\Events\QrCodeScanned;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('barcode-channel', function ($user) {
    return true; // Aturan akses ke channel
});
