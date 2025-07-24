<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable=[
        'LocationKKS',
        'LocationName',
        'LocationThaiName',
        'Allowance'
    ];

    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
