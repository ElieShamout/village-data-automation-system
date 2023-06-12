<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baptismal extends Model
{
    use HasFactory;

    protected $fillable = [
        'godfather_id',
        'family_id',
        'baptismal_place',
        'baptismal_date',
        'baptismal_record_number',
        'page_number',
        'baptized_father',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
