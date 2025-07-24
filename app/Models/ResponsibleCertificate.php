<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsibleCertificate extends Model
{
    protected $fillable=[
        'responsible_id',
        'certificate_type_id'
    ];
}
