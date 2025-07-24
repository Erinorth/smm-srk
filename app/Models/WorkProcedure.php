<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkProcedure extends Model
{
    protected $fillable=[
        'activity_id',
        'activity_standard_id',
        'item_id',
        'Order',
        'Order2',
        'Procedure',
        'ControlledPoint',
        'Class',
        'Man',
        'Hour'
    ];
}
