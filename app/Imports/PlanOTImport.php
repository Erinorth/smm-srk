<?php

namespace App\Imports;

use App\Models\PlanOT;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PlanOTImport implements ToCollection, WithHeadingRow, WithValidation
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function rules(): array
    {
        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS check_duplicate ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE check_duplicate AS (
                SELECT CONCAT(PlanDate,'_',employee_id) AS check_duplicate
                FROM plan_o_t_s
                );
            ")
        );

        $check_duplicate = DB::table('check_duplicate')->pluck('check_duplicate');
        //dd($check_duplicate);

        return [
            '*.check_duplicate' => Rule::notIn($check_duplicate)
        ];

        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS check_duplicate ;
            ")
        );
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            PlanOT::create([
                'project_id' => $this->id,
                'PlanDate' => $row['plandate'],
                'employee_id' => $row['employee_id'],
                'PlanHour' => $row['planhour'],
                'Remark' => $row['remark'],
            ]);
        }
    }
}
