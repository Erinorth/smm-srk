<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    protected $fillable=[
        'project_id',
        'Date',
        'job_id',
        'Observer',
        'Attachment',
        'AttachmentPath'
    ];
}
