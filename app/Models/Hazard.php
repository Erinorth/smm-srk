<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hazard extends Model
{
    protected $fillable=[
        'HazardName',
        'Type',
        'ManPower',
        'Contact',
        'Procedure',
        'Training',
        'PPE',
        'SafetyEquipment',
        'Verification',
        'SafetySign',
        'Opportunity'
    ];
}
