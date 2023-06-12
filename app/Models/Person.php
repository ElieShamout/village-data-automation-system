<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = "persons";

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'ID_number',
        'birthdate_place',
        'birthdate',
        'gender',
        'marital_status',
        'study_phase',
        'academic_title',
        'work',
        'registration_number',
        'registration_place',
        'immigration',
        'military_service',
        'live_dead',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function family()
    {
        /**
         * there are problem in get family of user
         */
        return $this->hasOne(FamilyPersons::class, 'person_id')->join('families', 'families.id', '=', 'family_persons.family_id');
    }

    public function adjectives()
    {
        return $this->hasMany(FamilyPersons::class, 'person_id', 'id')
            ->select('family_persons.id', 'family_persons.adjective', 'family_persons.person_id', 'family_persons.family_id');
    }

    public function diseases()
    {
        return $this->hasMany(PersonDiseases::class, 'person_id');
    }

    public function baptismal()
    {
        return $this->hasOne(Baptismal::class, 'person_id');
    }

    public function engagment()
    {
        return $this->hasOne(Engagment::class, 'husband_id');
    }
}
