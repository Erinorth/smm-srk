<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolUpdate extends Model
{
    protected $fillable=[
        'tool_catagory_site_id',
        'tool_id',
        'Status',
        'Remark',
        'Packing'
    ];

    public function toolcatagorysite()
    {
        return $this->belongsTo('App\Models\ToolCatagorySite');
    }
}
