<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable=[
        'item_id',
        'Order',
        'ActivityName',
        'Detail'
    ];

    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function jobactivity()
    {
        return $this->hasMany(JobActivity::class,'activity_id');
    }
}
