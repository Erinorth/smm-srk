<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManHour extends Model
{
    protected $fillable=[
        'employee_id',
        'job_position_id',
        'Normal',
        'OTfrom',
        'OTto',
        'OT1',
        'OT15',
        'OT2',
        'OT3',
        'Remark',
        'job_id',
        'p_m_order_id',
        'WorkingDate'
    ];
}