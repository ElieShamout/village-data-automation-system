<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_summary_number',
        'landline_phone_number',
        'phone',
        'current_place_of_residence',
        'accommodation_type',
        'monthly_rent_value',
        'block_number',
        'district_number',
        'notes',
    ];

    public function persons()
    {
        return $this->BelongsToMany(Person::class, 'family_persons');
    }
}

























// return $this->hasManyThrough(Person::class, FamilyPersons::class, 'family_persons.family_id', 'persons.id',)
//     ->select('family_persons.person_id as person_id', 'persons.*');


// return $this->hasMany(
//     Person::class,
//     'family_id',
// )->select('persons.*');



// return $this->hasMany(
//     Person::class,
//     'family_id',
// )
//     ->join('family_persons', 'family_persons.person_id', '=', 'persons.id')
//     ->select('persons.*', 'family_persons.adjective');