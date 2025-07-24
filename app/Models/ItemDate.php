<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemDate extends Model
{
    protected $fillable=[
        'job_id',
        'item_id',
        'Date'
    ];
}
