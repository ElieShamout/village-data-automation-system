<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marriage extends Model
{
    use HasFactory;

    protected $fillable = [
        'husband_id',
        'wife_id',
        'baptized_father',
        'record_number',
        'registration_date',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
