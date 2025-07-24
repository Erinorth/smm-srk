<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanOT extends Model
{
    protected $fillable=[
        'project_id',
        'PlanDate',
        'employee_id',
        'PlanHour',
        'Remark'
    ];
}
