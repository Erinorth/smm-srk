<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobDate extends Model
{
    protected $fillable=[
        'job_id',
        'Date',
        'Plan',
        'Actual'
    ];

    public function jobprogress()
    {
        return $this->hasOne(JobProgress::class);
    }

}
