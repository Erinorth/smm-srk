<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable=[
        'item_id',
        'project_id',
        'p_m_order_id',
        'Remark',
        'CheckList',
        'CheckListPath'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class,'equipment_id');
    }

    public function machinesystem()
    {
        return $this->belongsTo(MachineSystem::class);
    }

    public function jobactivity()
    {
        return $this->hasMany(JobActivity::class);
    }

    public function jobdate()
    {
        return $this->hasMany(JobDate::class);
    }
}
