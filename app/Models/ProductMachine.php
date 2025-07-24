<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMachine extends Model
{
    protected $fillable=[
        'machine_id',
        'project_product_id',
        'location_product_id'
    ];
    
    public function machine()
    {
        return $this->belongsTo(Machine::class,'machine_id');
    }

    public function machinesystem()
    {
        return $this->hasMany(MachineSystem::class);
    }
}
