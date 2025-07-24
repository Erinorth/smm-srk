<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    protected $fillable=[
        'project_id',
        'department_id',
        'Amount',
        'AtSite',
        'Type',
        'Remark'
    ];
}
