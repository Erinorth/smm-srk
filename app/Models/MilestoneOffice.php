<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilestoneOffice extends Model
{
    protected $fillable=[
        'JobName',
        'Type',
        'StartDate',
        'DueDate',
        'KPI',
        'Remark',
        'Responsible'
    ];
}
