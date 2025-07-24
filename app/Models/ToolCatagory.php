<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ToolCatagory extends Model
{
    protected $fillable=[
        'CatagoryName',
        'RangeCapacity',
        'Unit',
        'tool_type_id',
        'MeasuringTool',
        'Min',
        'Max'
    ];
}
