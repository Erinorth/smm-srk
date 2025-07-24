<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStakeholder extends Model
{
    protected $fillable=[
        'product_id',
        'stakeholder_id'
    ];
}