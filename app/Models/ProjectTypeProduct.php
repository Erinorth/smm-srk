<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTypeProduct extends Model
{
    protected $fillable=[
        'project_type_id',
        'product_id'
    ];
}
