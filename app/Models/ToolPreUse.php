<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolPreUse extends Model
{
    protected $fillable=[
        'tool_id',
        'Activity',
        'Remark'
    ];
}
