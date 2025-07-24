<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoistList extends Model
{
    protected $fillable=[
        'Customer',
        'Brand',
        'Capacity',
        'Model',
        'SerialNumber',
        'LocalCode',
        'DurableSupplieCode',
        'AssetToolCode',
        'RegisterDate',
        'StaandardP',
        'LStaandardD',
        'Staandard10Link'
    ];
}
