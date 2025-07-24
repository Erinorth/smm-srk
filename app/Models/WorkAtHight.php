<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkAtHight extends Model
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
        'Supervisor',
        'Attachment',
        'AttachmentPath'
    ];
}
