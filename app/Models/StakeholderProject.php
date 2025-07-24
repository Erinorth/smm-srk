<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StakeholderProject extends Model
{
    protected $fillable=[
        'project_id',
        'stakeholder_id',
        'product_id'
    ];
}
