<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMeeting extends Model
{
    protected $fillable=[
        'project_id',
        'MeetingDate',
        'Subject'
    ];
}
