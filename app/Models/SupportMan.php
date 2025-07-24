<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMan extends Model
{
    protected $fillable=[
        'support_request_id',
        'employee_id',
        'department_id',
        'StartDate',
        'OT',
        'Remark'
    ];
}
