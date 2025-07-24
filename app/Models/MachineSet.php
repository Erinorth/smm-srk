<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineSet extends Model
{
    protected $fillable=[
        'location_id',
        'machine_id',
        'Remark',
        'SerialNumber',
    ];
}
