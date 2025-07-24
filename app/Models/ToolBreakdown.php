<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolBreakdown extends Model
{
    protected $fillable=[
        'tool_id',
        'Report',
        'Cause',
        'Value',
        'Guideline',
        'Operation',
        'Operator',
        'Result',
        'Attachment',
        'AttachmentPath'
    ];
}
