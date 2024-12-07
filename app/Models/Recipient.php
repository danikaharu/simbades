<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = ['person_id', 'assistance_id', 'year', 'status', 'qr_data'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function assistance()
    {
        return $this->belongsTo(Assistance::class);
    }

    public function logs()
    {
        return $this->hasMany(RecipientLog::class, 'recipient_id');
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
