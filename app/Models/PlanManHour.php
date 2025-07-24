<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanManHour extends Model
{
    protected $fillable=[
        'item_id',
        'Man',
        'Hour'
    ];
}
