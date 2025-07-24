<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolCalibrate extends Model
{
    protected $fillable=[
        'tool_id',
        'CalibrateDate',
        'Calibrator',
        'Result',
        'Certificate',
        'Accuracy',
        'AcceptError',
        'ExpireDate',
        'Cost',
        'Remark',
        'Responsible',
        'Attachment',
        'AttachmentPath'
    ];
}
