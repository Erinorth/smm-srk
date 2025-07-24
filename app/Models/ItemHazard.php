<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemHazard extends Model
{
    protected $fillable=[
        'item_id',
        'hazard_id'
    ];
}
