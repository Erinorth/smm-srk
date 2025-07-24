<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable=[
        'tool_catagory_id',
        'Brand',
        'Model',
        'SerialNumber',
        'LocalCode',
        'DurableSupplieCode',
        'AssetToolCode',
        'Weight',
        'Price',
        'LifeTime',
        'CalibrateInterval',
        'RegisterDate',
        'Responsible',
        'Accepted',
        'AcceptedPath'
    ];
}
