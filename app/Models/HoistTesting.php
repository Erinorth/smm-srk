<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoistTesting extends Model
{
    protected $fillable=[
        'project_id',
        'hoist_list_id',
        'tool_id',
        'TestDate',
        'TopHook',
        'BottomHook',
        'SafetyLatch',
        'Condition',
        'Pin',
        'Testing',
        'Remark',
        'LoadP',
        'LoadD',
        'Load10Link',
        'LoadTesting',
        'Twist',
        'HookTop',
        'HookBottom',
        'Result',
        'Note',
        'Attachment',
        'AttachmentPath'
    ];
}
