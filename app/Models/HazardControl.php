<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HazardControl extends Model
{
    protected $fillable=[
        'hazard_id',
        'KindofHazard',
        'Effect',
        'HazardControl',
        'Severity'
    ];
}