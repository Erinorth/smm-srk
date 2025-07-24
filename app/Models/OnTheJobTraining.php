<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnTheJobTraining extends Model
{
    protected $fillable=[
        'job_position_id',
        'department_id',
        'location_id',
        'employee_id',
        'course_id',
        'coach_id',
        'project_id',
        'EvaluationDate',
        'Result',
        'Recorder',
        'Approver',
        'ApprovedDate'
    ];
}
