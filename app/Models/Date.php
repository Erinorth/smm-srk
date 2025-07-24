<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $fillable=[
        'Date',
        'Day',
        'Month',
        'Year',
        'SemiAnnual',
        'Quarter',
        'Week',
        'DayofWeek',
        'DayofYear'
    ];
}
