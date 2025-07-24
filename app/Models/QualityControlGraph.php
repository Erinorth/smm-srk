<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityControlGraph extends Model
{
    protected $fillable=[
        'T_Duration',
        'P_Duration',
        'A_Duration',
        'T_Rework',
        'Rework',
        'Claim',
        'CostValue',
        'P_Complain',
        'G_Complain',
        'A_Complain',
        'R_Complain'
    ];
}
