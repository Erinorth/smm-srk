<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpensiveTool extends Model
{
    protected $fillable=[
        'Date',
        'job_id',
        'tool_id',
        'Activity',
        'Hour',
        'Remark'
    ];
}
