<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolPMInterval extends Model
{
    protected $fillable=[
        'tool_id',
        'Activity',
        'Interval',
        'Remark'
    ];
}
