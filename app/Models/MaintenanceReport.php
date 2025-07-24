<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceReport extends Model
{
    protected $fillable=[
        'job_id',
        'activity_id',
        'Done',
        'Condition',
        'Countermeasure',
        'Remark'
    ];
}
