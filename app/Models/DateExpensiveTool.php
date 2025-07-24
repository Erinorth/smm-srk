<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateExpensiveTool extends Model
{
    protected $fillable=[
        'tool_id',
        'TypeOfUse',
        'HourOfUse',
        'job_date_id'
    ];
}
