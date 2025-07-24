<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MileStoneActivity extends Model
{
    protected $fillable=[
        'Activity',
        'BeforeStart',
        'AfterStart',
        'BeforeFinish',
        'AfterFinish',
        'Document',
        'Folder',
        'Link',
        'Responsible',
        'Dynamic'
    ];
}
