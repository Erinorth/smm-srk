<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MileStone extends Model
{
    protected $fillable=[
        'project_id',
        'office_id',
        'mile_stone_activity_id'
    ];
}
