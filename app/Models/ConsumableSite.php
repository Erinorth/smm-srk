<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumableSite extends Model
{
    protected $fillable=[
        'project_id',
        'p_m_order_id',
        'consumable_id',
        'Pick',
        'Group',
        'Return',
        'Remark',
        'Confirmed',
        'Packing',
        'Status'
    ];

    public function consumable()
    {
        return $this->belongsTo('App\Models\Consumable');
    }
}
