<?php

namespace App\Imports;

use App\Models\Progress;
use App\Models\Job;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ProgressImport implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;
    
    public $id;
    
    public function __construct(int $id) 
    {
        $this->id = $id;
    }

    public function rules(): array
    {   
        $checkjob = Job::where('project_id',$this->id)->pluck('id');
        
        return [
            '*.job_id' => Rule::in($checkjob)
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            Progress::create([
                'job_id' => $row['job_id'],
                'ProgressDate' => $row['progressdate'],
                'Plan' => $row['plan'],
                'Actual' => $row['actual'],
                'Remark' => $row['remark'],
            ]);
        }
    }
}
