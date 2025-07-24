<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=[
        'scope_id',
        'Man',
        'Hour',
        'SpecificName',
        'item_set_id',
        'machine_set_id'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function jobactivity()
    {
        return $this->hasMany(JobActivity::class);
    }

    public function planmanhour()
    {
        return $this->hasOne(PlanManHour::class);
    }
}
