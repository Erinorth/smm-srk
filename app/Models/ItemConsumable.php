<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemConsumable extends Model
{
    protected $fillable=[
        'item_id',
        'consumable_id',
        'Quantity',
        'Remark'
    ];
}
