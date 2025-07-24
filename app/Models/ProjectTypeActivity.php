<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTypeActivity extends Model
{
    protected $fillable=[
        'mile_stone_activity_id',
        'project_type_id'
    ];
}
