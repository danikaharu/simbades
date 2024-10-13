<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseCondition extends Model
{
    use HasFactory;

    protected $table = 'house_conditions'; // Tabel yang digunakan
    protected $fillable = [
        'person_id',
        'building_area',
        'floor_material',
        'wall_material',
        'electricity_source',
        'electricity_capacity',
        'water_source',
        'cooking_fuel',
        'sanitation_facility',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
