<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectLocation extends Model
{
    protected $fillable=[
        'project_id',
        'location_id'
    ];
}
