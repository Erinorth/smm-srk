<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable=[
        'MachineName'
    ];
    
    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function productmachine()
    {
        return $this->hasMany(ProductMachine::class,'machine_id');
    }
}
