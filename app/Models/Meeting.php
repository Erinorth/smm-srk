<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable=[
        'project_meeting_id',
        'MainPoint'
    ];
}
