<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $fillable=[
        'job_id',
        'ProgressDate',
        'Plan',
        'Actual'
    ];
}
