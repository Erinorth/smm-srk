<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectProduct extends Model
{
    protected $fillable=[
        'project_id',
        'product_id'
    ];
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function productmachine()
    {
        return $this->hasMany(ProductMachine::class);
    }
}
