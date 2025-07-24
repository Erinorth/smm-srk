<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutineJob extends Model
{
    protected $fillable=[
        'RoutineJobName',
        'KPI',
        'Point'
    ];
}
