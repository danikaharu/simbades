<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAssistance extends Model
{
    use HasFactory;

    protected $fillable = ['assistance_id', 'input_date', 'type', 'additional_data'];

    public function assistance()
    {
        return $this->belongsTo(Assistance::class, 'assistance_id');
    }

    public function recipient()
    {
        return $this->hasMany(Recipient::class);
    }

    public function type()
    {
        if ($this->type == 1) {
            return 'Tunai';
        } else {
            return 'Non Tunai';
        }
    }
}
