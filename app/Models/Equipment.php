<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable=[
        'EquipmentName',
    ];
    
    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function systemjob()
    {
        return $this->hasMany(SystemJob::class,'equipment_id');
    }
}
