<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QSHSchedule extends Model
{
    protected $fillable=[
        'project_id',
        'Date',
        'Activity',
        'TypeOfRisk',
        'Effect',
        'CounterMeasure'
    ];
}
