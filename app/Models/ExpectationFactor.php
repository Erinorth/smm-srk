<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpectationFactor extends Model
{
    protected $fillable=[
        'expectation_id',
        'factor_id'
    ];
}