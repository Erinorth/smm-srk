<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    protected $fillable=[
        'SparePartName',
        'Detail',
        'Unit'
    ];
}
