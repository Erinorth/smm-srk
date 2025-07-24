<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentFactor extends Model
{
    protected $fillable=[
        'department_id',
        'factor_id',
        'Related'
    ];
}
