<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PMOrder extends Model
{
    protected $table = 'p_m_orders';
    
    protected $fillable = [
        'project_id',
        'SupPMOrder',
        'PMOrder',
        'PMOrderName',
        'Status',
        'Remark'
    ];

    protected $casts = [
        'project_id' => 'integer',
        'SupPMOrder' => 'integer',
    ];
}
