<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineSystem extends Model
{
    protected $fillable=[
        'system_id',
        'product_machine_id'
    ];
    
    public function system()
    {
        return $this->belongsTo(System::class,'system_id');
    }

    public function job()
    {
        return $this->hasMany(Job::class);
    }
}
