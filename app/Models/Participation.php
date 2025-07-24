<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable=[
        'project_id',
        'Date',
        'Form',
        'Foreman',
        'Attachment',
        'AttachmentPath'
    ];
}
