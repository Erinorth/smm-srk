<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DangerousZone extends Model
{
    protected $fillable=[
        'CompanyName',
        'WorkingArea',
        'JobName',
        'Amount',
        'PlanedDate',
        'Reference',
        'Applicant',
        'project_id',
        'Supervisor'
    ];
}
