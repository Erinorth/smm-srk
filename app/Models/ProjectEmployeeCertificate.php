<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectEmployeeCertificate extends Model
{
    protected $fillable=[
        'project_id',
        'employee_certificate_id'
    ];

    public function employeecertificate()
    {
        return $this->belongsTo('App\Models\EmployeeCertificate');
    }
}
