<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LawAssesment extends Model
{
    protected $fillable=[
        'law_id',
        'law_detail_id',
        'department_id',
        'Related',
        'Evident'
    ];
}
