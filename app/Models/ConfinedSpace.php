<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfinedSpace extends Model
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
        'Warrantor',
        'Foreman',
        'Applicant',
        'Supervisor',
        'Attachment',
        'AttachmentPath'
    ];
}
