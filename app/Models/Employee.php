<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'user_id',
        'WorkID',
        'ThaiName',
        'EnglishName',
        'Position',
        'EGATEmail',
        'department_id',
        'Admin',
        'Telephone'
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    // Relationship กับ User
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * โปรเจคที่เป็น Site Engineer
     */
    public function siteEngineerProjects()
    {
        return $this->hasMany(Project::class, 'SiteEngineer', 'id');
    }

    /**
     * โปรเจคที่เป็น Area Manager
     */
    public function areaManagerProjects()
    {
        return $this->hasMany(Project::class, 'AreaManager', 'id');
    }
}
