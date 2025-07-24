<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    protected $fillable=[
        'StakeholderName',
        'stakeholder_type_id',
        'location_id'
    ];
}
