<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumableStore extends Model
{
    protected $fillable=[
        'consumable_id',
        'InOut',
        'Quantity',
        'Remark'
    ];
}
