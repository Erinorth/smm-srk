<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCrane extends Model
{
    protected $fillable=[
        'project_id',
        'machine_set_id',
        'MaxUseLoad',
        'UseDate',
        'Remark',
        'crane_certificate_id'
    ];
}
