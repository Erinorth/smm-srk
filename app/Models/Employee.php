<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
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
}
