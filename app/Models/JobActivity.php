<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobActivity extends Model
{
    protected $fillable=[
        'item_id',
        'job_id'
    ];
    
    public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
