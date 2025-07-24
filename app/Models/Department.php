<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable=[
        'Code',
        'DepartmentName', 
        'Section',
        'Department',
        'Division',
        'Business'
    ];
    
    // เพิ่ม relationship กับ Employee ถ้ายังไม่มี
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
