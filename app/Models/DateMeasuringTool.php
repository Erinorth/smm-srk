<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateMeasuringTool extends Model
{
    protected $fillable=[
        'tool_id',
        'OtherToolName',
        'OtherSerialNumber',
        'MeasuredObject',
        'User',
        'Remark',
        'job_date_id'
    ];
}
