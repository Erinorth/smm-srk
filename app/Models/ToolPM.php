<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolPM extends Model
{
    protected $fillable=[
        'tool_p_m_interval_id',
        'PMDate',
        'Operator',
        'Cost',
        'Result',
        'Remark'
    ];
}
