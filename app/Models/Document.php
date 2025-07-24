<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable=[
        'item_id',
        'DocumentName',
        'DocumentCode',
        'Remark',
        'Attachment',
        'AttachmentPath'
    ];
}
