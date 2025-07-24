<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkPermit extends Model
{
    protected $fillable=[
        'project_id',
        'Date',
        'HotWork',
        'ConfinedSpace',
        'Chemical',
        'Lifting',
        'Scaffloding',
        'Electrical',
        'HighVoltage',
        'Drilling',
        'Radio',
        'Diving',
        'Other',
        'Requester',
        'Attachment',
        'AttachmentPath'
    ];
}
