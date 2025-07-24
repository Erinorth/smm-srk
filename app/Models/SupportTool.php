<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTool extends Model
{
    protected $fillable=[
        'project_id',
        'ToolName',
        'Type',
        'Detail',
        'UseDate',
        'Remark',
        'Attachment',
        'AttachmentPath'
    ];
}
