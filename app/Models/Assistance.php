<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'additional_data'];

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
