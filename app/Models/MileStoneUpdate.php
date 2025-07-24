<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MileStoneUpdate extends Model
{
    protected $fillable=[
        'mile_stone_id',
        'Status',
        'Remark'
    ];
}
