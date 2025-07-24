<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StakeholderExpectation extends Model
{
    protected $fillable=[
        'expectation_id',
        'stakeholder_id'
    ];
}