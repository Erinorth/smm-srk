<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityControl extends Model
{
    protected $fillable=[
        'item_id',
        'QualityControlName',
        'ControlledOperation',
        'ControlledQuality',
        'AcceptanceCriteria',
        'RecordedDocument'
    ];
}
