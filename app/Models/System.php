<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $fillable=[
        'SystemName'
    ];
    
    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function machinesystem()
    {
        return $this->hasMany(MachineSystem::class,'system_id');
    }
}
