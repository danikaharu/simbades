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
        'work',
        'income_month'
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function houseCondition()
    {
        return $this->hasOne(HouseCondition::class, 'person_id');
    }

    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }

    public function gender()
    {
        if ($this->gender == 1) {
            return 'Laki - Laki';
        } else {
            return 'Perempuan';
        }
    }

    public function kinship()
    {
        if ($this->kinship == 1) {
            return 'Kepala Keluarga';
        } elseif ($this->kinship == 2) {
            return 'Istri';
        } elseif ($this->kinship == 3) {
            return 'Anak';
        } elseif ($this->kinship == 4) {
            return 'Kakek';
        } elseif ($this->kinship == 5) {
            return 'Nenek';
        } else {
            return 'Famili Lain';
        }
    }

    public function religion()
    {
        if ($this->religion == 1) {
            return 'Islam';
        } elseif ($this->religion == 2) {
            return 'Kristen';
        } elseif ($this->religion == 3) {
            return 'Hindu';
        } elseif ($this->religion == 4) {
            return 'Budha';
        } else {
            return 'Konghucu';
        }
    }

    public function last_education()
    {
        if ($this->last_education == 1) {
            return 'Tidak Sekolah';
        } elseif ($this->last_education == 2) {
            return 'Tidak Tamat SD';
        } elseif ($this->last_education == 3) {
            return 'SD dan Sederajat';
        } elseif ($this->last_education == 4) {
            return 'SMP dan Sederajat';
        } elseif ($this->last_education == 5) {
            return 'SMA dan Sederajat';
        } elseif ($this->last_education == 6) {
            return 'Diploma 1 - 3';
        } elseif ($this->last_education == 7) {
            return 'S1 dan Sederajat';
        } elseif ($this->last_education == 8) {
            return 'S2 dan Sederajat';
        } else {
            return 'S3 dan Sederajat';
        }
    }
}
