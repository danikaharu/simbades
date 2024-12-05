<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipientLog extends Model
{
    use HasFactory;

    protected $fillable = ['recipient_id', 'status', 'log_date'];

    public function recipient()
    {
        return $this->belongsTo(Recipient::class, 'recipient_id');
    }

    public function status()
    {
        if ($this->status == 0) {
            return 'Belum Diterima';
        } else {
            return 'Sudah Diterima';
        }
    }
}
