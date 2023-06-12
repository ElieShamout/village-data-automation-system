<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyPersons extends Model
{
    use HasFactory;

    protected $fillable = ['family_id', 'adjective', 'person_id'];
}
