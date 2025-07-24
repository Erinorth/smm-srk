<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkAtHightWind extends Model
{
    protected $fillable=[
        'job_id',
        'CompanyName',
        'WorkingArea',
        'JobName',
        'Amount',
        'PlanedDate',
        'Reference',
        'Applicant',
        'project_id',
        'Supervisor',
        'Attachment',
        'AttachmentPath'
    ];
}
