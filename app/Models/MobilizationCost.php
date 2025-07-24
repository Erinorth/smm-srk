<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobilizationCost extends Model
{
    protected $fillable=[
        'cost_rate_id',
        'SupMHNormal',         
        'SupMHOT1',
        'SupMHOT15',
        'SupMHOT2',
        'SupMHOT3',
        'SupMD',
        'ForeMHNormal',
        'ForeMHOT1',
        'ForeMHOT15',
        'ForeMHOT',
        'ForeMHOT3',
        'ForeMD',
        'SkillMHNormal',
        'SkillMHOT1',
        'SkillMHOT15',
        'SkillMHOT2',
        'SkillMHOT3',
        'SkillMD',
        'ExpensiveTool',
        'ExtraWage',
        'Consumabl',
        'Material',
        'SparePart',
        'PublicTransport',
        'VanDay',
        'VanRent',
        'OtherRent',
        'InternalTransportation',
        'Insurance',
        'SubContractor',
        'Other'
    ];
}
