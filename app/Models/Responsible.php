<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    protected $fillable=[
        'project_id',
        'Duty',
        'Responsible'
    ];
}
