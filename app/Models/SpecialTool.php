<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialTool extends Model
{
    protected $fillable=[
        'item_id',
        'SpecialToolName',
        'PartName',
        'DrawingNumber',
        'Remark',
        'Attachment',
        'AttachmentPath'
    ];
}
