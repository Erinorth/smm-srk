<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeCertificate extends Model
{
    protected $fillable=[
        'employee_id',
        'certificate_type_id',
        'EffectiveDate',
        'Attachment',
        'AttachmentPath',
        'Remark'
    ];

    public function projectemployeecertificate()
    {
        return $this->hasMany('App\Models\ProjectEmployeeCertificate');
    }
}
