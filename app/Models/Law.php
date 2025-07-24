<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Law extends Model
{
    protected $fillable=[
        'LawName',
        'AnnouncementDate',
        'NumberOfPages',
        'Regulator'
    ];
}
