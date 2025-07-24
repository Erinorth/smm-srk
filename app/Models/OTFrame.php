<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTFrame extends Model
{
    protected $fillable=[
        'employee_id',
        'Year',
        'Month',
        'Frame',
        'Remark'
    ];
}
