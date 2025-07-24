<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityHazard extends Model
{
    protected $fillable=[
        'activity_id',
        'hazard_id',
        'item_id'
    ];
}
