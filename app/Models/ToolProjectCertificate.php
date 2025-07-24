<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolProjectCertificate extends Model
{
    protected $fillable=[
        'project_id',
        'tool_calibrate_id'
    ];
}
