<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WFHWFAAssignment extends Model
{
    protected $fillable=[
        'Assignee',
        'Day',
        'Point',
        'KPI',
        'Date'
    ];
}
