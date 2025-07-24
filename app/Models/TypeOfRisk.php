<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeOfRisk extends Model
{
    protected $fillable=[
        'factor_id',
        'TypeofRisk',
        'Effect',
        'EffectValue',
        'Measure',
        'Followup'
    ];
}
