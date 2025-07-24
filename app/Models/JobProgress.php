<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobProgress extends Model
{
    protected $fillable=[
        'job_date_id',
        'Plan',
        'Actual'
    ];

    public function jobdate()
    {
        return $this->hasOne(JobDate::class);
    }

}
