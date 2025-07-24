<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceEmployee extends Model
{
    protected $fillable=[
        'project_id',
        'employee_id',
        'Day',
        'SafetyHealth',
        'SafetyHealthRemark',
        'Quality',
        'QualityRemark',
        'TeamWork',
        'TeamWorkRemark',
        'MoralGoodGovernance',
        'MoralGoodGovernanceRemark',
        'Digital',
        'DigitalRemark',
        'Innovation',
        'InnovationRemark',
        'Planing',
        'PlaningRemark',
        'Professional',
        'ProfessionalRemark'
    ];
}
