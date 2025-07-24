<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductExpectationFactor extends Model
{
    protected $fillable=[
        'product_id',
        'stakeholder_id',
        'factor_id',
        'Related',
    ];
}
