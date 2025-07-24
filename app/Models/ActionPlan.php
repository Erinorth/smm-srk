<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionPlan extends Model
{
    protected $fillable=[
        'Activity',
        'Responsible',
        'DeadLine',
        'Status',
        'meeting_id'
    ];
}
