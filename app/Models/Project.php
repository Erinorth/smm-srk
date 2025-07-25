<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Project extends Model
{
    // กำหนด table name
    protected $table = 'projects';
    
    // กำหนดฟิลด์ที่สามารถ mass assignment ได้
    protected $fillable = [
        'ProjectName',
        'project_type_id', 
        'StartDate',
        'FinishDate',
        'SiteEngineer',
        'AreaManager',
        'Supervisor',
        'Foreman',
        'Skill',
        'Status',
        'color',
        'show',
        'DailyReport',
        'KeyDate',
        'KeyDatePath'
    ];

    // กำหนด date fields ที่ต้อง cast เป็น Carbon instances
    protected $dates = [
        'StartDate',
        'FinishDate',
        'created_at',
        'updated_at'
    ];

    // กำหนด casts สำหรับ attribute types
    protected $casts = [
        'StartDate' => 'date:Y-m-d',      // แปลงเป็นรูปแบบ Y-m-d เท่านั้น
        'FinishDate' => 'date:Y-m-d',     // แปลงเป็นรูปแบบ Y-m-d เท่านั้น
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Mutator สำหรับ StartDate - แปลงรูปแบบวันที่ก่อนบันทึก
     */
    public function setStartDateAttribute($value)
    {
        if ($value) {
            try {
                // แปลงค่าที่ได้รับเป็น Carbon และ format เป็น Y-m-d
                $this->attributes['StartDate'] = Carbon::parse($value)->format('Y-m-d');
                Log::info('Project StartDate converted', [
                    'original' => $value,
                    'converted' => $this->attributes['StartDate']
                ]);
            } catch (\Exception $e) {
                Log::error('Error parsing StartDate', [
                    'value' => $value,
                    'error' => $e->getMessage()
                ]);
                // ถ้าแปลงไม่ได้ให้ใช้ค่าเดิม
                $this->attributes['StartDate'] = $value;
            }
        }
    }

    /**
     * Mutator สำหรับ FinishDate - แปลงรูปแบบวันที่ก่อนบันทึก
     */
    public function setFinishDateAttribute($value)
    {
        if ($value) {
            try {
                // แปลงค่าที่ได้รับเป็น Carbon และ format เป็น Y-m-d
                $this->attributes['FinishDate'] = Carbon::parse($value)->format('Y-m-d');
                Log::info('Project FinishDate converted', [
                    'original' => $value,
                    'converted' => $this->attributes['FinishDate']
                ]);
            } catch (\Exception $e) {
                Log::error('Error parsing FinishDate', [
                    'value' => $value,
                    'error' => $e->getMessage()
                ]);
                // ถ้าแปลงไม่ได้ให้ใช้ค่าเดิม
                $this->attributes['FinishDate'] = $value;
            }
        }
    }

    // Relations
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
    
    public function siteEngineer()
    {
        return $this->belongsTo(Employee::class, 'SiteEngineer', 'id');
    }
    
    public function areaManager()
    {
        return $this->belongsTo(Employee::class, 'AreaManager', 'id');
    }

    public static function getProjectDetails($projectId)
    {
        try {
            Log::info('ดึงข้อมูลโปรเจค ID: ' . $projectId);
            
            $project = self::with(['planner', 'siteEngineer', 'areaManager'])
                          ->find($projectId);
            
            if ($project) {
                Log::info('พบข้อมูลโปรเจค: ' . $project->ProjectName);
            } else {
                Log::warning('ไม่พบข้อมูลโปรเจค ID: ' . $projectId);
            }
            
            return $project;
        } catch (\Exception $e) {
            Log::error('เกิดข้อผิดพลาดในการดึงข้อมูลโปรเจค: ' . $e->getMessage());
            return null;
        }
    }
}
