<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStakeholderExpectation extends Model
{
    protected $fillable=[
        'product_id',
        'stakeholder_id',
        'expectation_id',
        'Related',
    ];
}
