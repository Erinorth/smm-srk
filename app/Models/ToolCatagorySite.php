<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolCatagorySite extends Model
{
    protected $fillable=[
        'project_id',
        'tool_catagory_id',
        'PickQuantity',
        'Group',
        'Remark'
    ];

    public function toolupdate()
    {
        return $this->hasMany('App\Models\ToolUpdate');
    }
}
