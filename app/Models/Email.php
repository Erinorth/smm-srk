<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable=[
        'project_type_id',
        'Responsible1',
        'Responsible2',
        'MilestoneResponsible'
    ];
}
