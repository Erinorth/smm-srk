<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumable extends Model
{
    protected $fillable=[
        'ConsumableName',
        'Unit',
        'Detail',
        'Cost',
        'ConsumableCode',
        'PurchaseCode',
        'Weight',
        'Min',
        'Max'
    ];

    public function consumablesite()
    {
        return $this->hasMany('App\Models\ConsumableSite');
    }
}
