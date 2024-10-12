<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'village_id',
        'family_card',
        'identification_number',
        'name',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'kinship',
        'father_name',
        'mother_name',
        'last_education',
        'work_id',
        'income_month'
    ];

    public function gender()
    {
        if ($this->gender == 1) {
            return 'Laki - Laki';
        } else {
            return 'Perempuan';
        }
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
