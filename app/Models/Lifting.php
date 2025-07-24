<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lifting extends Model
{
    protected $fillable=[
        'job_id',
        'project_id',
        'CompanyName',
        'WorkingArea',
        'JobName',
        'Amount',
        'PlanedDate',
        'Reference',
        'Applicant',
        'Foreman',
        'Operator',
        'Supervisor',
        'Attachment',
        'AttachmentPath'
    ];
}
