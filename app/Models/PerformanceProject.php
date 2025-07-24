<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceProject extends Model
{
    protected $fillable=[
        'project_id',
        'SafetyHealth',
        'Quality',
        'Duration',
        'ManHour',
        'WastingTime',
        'ManHourRatio',
        'MileStone',
        'ISO',
        'KPI'
    ];
}
