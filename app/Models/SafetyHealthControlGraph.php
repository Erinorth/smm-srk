<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafetyHealthControlGraph extends Model
{
    protected $fillable=[
        'Month',
        'T_TIFR',
        'Incident',
        'Man',
        'Day',
        'T_DI',
        'DI',
        'LossDay',
        'T_TotalLoss',
        'TotalLoss',
        'T_Examination',
        'Examination',
        'T_Disease',
        'Disease'
    ];
}
