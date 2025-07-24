<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobilizationPlan extends Model
{
    protected $fillable=[
        'employee_id',
        'StartDate',
        'EndDate',
        'Allowance',
        'Remark',
        'project_id'
    ];
}
