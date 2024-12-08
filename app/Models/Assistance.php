<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'alias'];

    public function detailAssistance()
    {
        return $this->hasMany(DetailAssistance::class);
    }

    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }
}
