<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CraneCertificate extends Model
{
    protected $fillable=[
        'machine_set_id',
        'TestDate',
        'Result',
        'Attachment',
        'AttachmentPath'
    ];
}
