<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSet extends Model
{
    protected $fillable=[
        'product_id',
        'system_id',
        'equipment_id'
    ];
}
