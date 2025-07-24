<?php

namespace App\Imports;

use App\Models\ManHour;
use App\Models\Job;
use App\Models\MobilizationPlan;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ManHourImport implements ToCollection, WithHeadingRow, WithValidation
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function rules(): array
    {
        $checkjob = Job::where('project_id',$this->id)->pluck('id');

        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS mobilization_plan ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE mobilization_plan AS (
                SELECT CONCAT(YEAR(dates.Date),'-',MONTH(dates.Date),'-',DAY(dates.Date),'_',mobilization_plans.employee_id) AS mobilization_plan
                FROM mobilization_plans
                JOIN dates
                WHERE mobilization_plans.project_id = $this->id AND (dates.Date BETWEEN mobilization_plans.StartDate AND mobilization_plans.EndDate)
                );
            ")
        );

        $checkmobilization = DB::table('mobilization_plan')->pluck('mobilization_plan');
        //dd($checkmobilization);

        return [
            '*.job_id' => Rule::in($checkjob),
            '*.mobilization_plan' => Rule::in($checkmobilization)
        ];

        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS mobilization_plan ;
            ")
        );
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            ManHour::create([
                'WorkingDate' => $row['workingdate'],
                'job_id' => $row['job_id'],
                'p_m_order_id' => $row['p_m_order_id'],
                'employee_id' => $row['employee_id'],
                'job_position_id' => $row['job_position_id'],
                'Normal' => $row['normal'],
                'OTfrom' => $row['otfrom'],
                'OTto' => $row['otto'],
                'OT1' => $row['ot1'],
                'OT15' => $row['ot15'],
                'OT2' => $row['ot2'],
                'OT3' => $row['ot3'],
                'Remark' => $row['remark'],
            ]);
        }
    }
}
