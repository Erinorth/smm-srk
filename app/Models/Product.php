<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'ProductCode',
        'ProductName',
        'Service',
        'department_id'
    ];
    
    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function project()
    {
        return $this->belongsToMany(Project::class);
    }

    public function projectproduct()
    {
        return $this->hasMany(ProjectProduct::class,'product_id');
    }
}
