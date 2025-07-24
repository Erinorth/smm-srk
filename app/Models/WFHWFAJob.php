<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WFHWFAJob extends Model
{
    protected $fillable=[
        'assignment_id',
        'Assignor',
        'routine_job_id',
        'Detail',
        'TargetPoint',
        'AcceptPoint'
    ];
}
