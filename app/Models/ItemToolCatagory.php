<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemToolCatagory extends Model
{
    protected $fillable=[
        'item_id',
        'tool_catagory_id',
        'Quantity',
        'Remark'
    ];
}
