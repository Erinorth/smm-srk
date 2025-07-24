<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'ProjectName',
        'project_type_id',
        'StartDate',
        'FinishDate',
        'SiteEngineer',
        'AreaManager',
        'Supervisor',
        'Foreman',
        'Skill',
        'Status',
        'color',
        'show',
        'DailyReport',
        'KeyDate',
        'KeyDatePath'
    ];

    protected $casts = [
        'StartDate' => 'date',
        'FinishDate' => 'date',
        'project_type_id' => 'integer',
        'SiteEngineer' => 'integer',
        'AreaManager' => 'integer',
        'Supervisor' => 'integer',
        'Foreman' => 'integer',
        'Skill' => 'integer',
    ];
}
