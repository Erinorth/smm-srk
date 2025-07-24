<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationProduct extends Model
{
    protected $fillable=[
        'project_location_id',
        'product_id'
    ];
}
