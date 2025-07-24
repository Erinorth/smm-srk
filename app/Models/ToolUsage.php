<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolUsage extends Model
{
    protected $fillable=[
        'project_id',
        'Date',
        'tool_id',
        'TimeOfUse',
        'Remark'
    ];
}
