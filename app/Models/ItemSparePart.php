<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSparePart extends Model
{
    protected $fillable=[
        'item_id',
        'spare_part_id',
        'Quantity'
    ];
}
