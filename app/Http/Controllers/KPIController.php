<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Date;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Models\Department;
use App\Models\Semiannual;
use App\Models\Employee;

class KPIController extends Controller
{
    public function index()
    {
        $department = Department::where('Department','=','กฟนม-ธ.')
            ->orderBy('Business','asc')
            ->orderBy('Division','asc')
            ->orderBy('Department','asc')
            ->orderBy('Section','asc')
            ->get();

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE date AS (
                SELECT id, Date, Year, SemiAnnual
                FROM dates
                WHERE dates.Date <= NOW()
                );

            CREATE TEMPORARY TABLE semi_annual AS (
                SELECT start_date.id, date.Year, date.SemiAnnual, start_date.StartDate, end_date.EndDate
                FROM date
                INNER JOIN ( SELECT MIN(id) AS id, Year, SemiAnnual, MIN(Date) AS StartDate
                    FROM date
                    GROUP BY Year, SemiAnnual ) AS start_date
                ON date.Year = start_date.Year AND date.SemiAnnual = start_date.SemiAnnual
                INNER JOIN ( SELECT Year, SemiAnnual, MAX(Date) AS EndDate
                    FROM date
                    GROUP BY Year, SemiAnnual ) AS end_date
                ON date.Year = end_date.Year AND date.SemiAnnual = end_date.SemiAnnual
                GROUP BY start_date.id, date.Year, date.SemiAnnual, start_date.StartDate, end_date.EndDate
                );
            ")
        );

        $period = DB::table('semi_annual')
            ->orderBy('StartDate','desc')->get();

        return view('KPIs.index',compact('department','period'));
    }

    public function all(Request $request)
    {
        $departmentid = $request->get('Department');
        $periodid = $request->get('Period');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE date AS (
                SELECT id, Date, Year, Week, SemiAnnual
                FROM dates
                WHERE dates.Date <= NOW()
                );

            CREATE TEMPORARY TABLE semi_annual AS (
                SELECT start_date.id, date.Year, date.SemiAnnual, start_date.StartDate, end_date.EndDate
                FROM date
                INNER JOIN ( SELECT MIN(id) AS id, Year, SemiAnnual, MIN(Date) AS StartDate
                    FROM date
                    GROUP BY Year, SemiAnnual ) AS start_date
                ON date.Year = start_date.Year AND date.SemiAnnual = start_date.SemiAnnual
                INNER JOIN ( SELECT Year, SemiAnnual, MAX(Date) AS EndDate
                    FROM date
                    GROUP BY Year, SemiAnnual ) AS end_date
                ON date.Year = end_date.Year AND date.SemiAnnual = end_date.SemiAnnual
                GROUP BY start_date.id, date.Year, date.SemiAnnual, start_date.StartDate, end_date.EndDate
                HAVING start_date.id = $periodid
                );

            CREATE TEMPORARY TABLE week AS (
                SELECT start_date.id, date.Year, date.Week, start_date.StartDate, end_date.EndDate
                FROM date
                INNER JOIN ( SELECT MIN(id) AS id, Year, Week, MIN(Date) AS StartDate
                    FROM date
                    GROUP BY Year, Week ) AS start_date
                ON date.Year = start_date.Year AND date.Week = start_date.Week
                INNER JOIN ( SELECT Year, Week, MAX(Date) AS EndDate
                    FROM date
                    GROUP BY Year, Week ) AS end_date
                ON date.Year = end_date.Year AND date.Week = end_date.Week
                GROUP BY start_date.id, date.Year, date.Week, start_date.StartDate, end_date.EndDate
                );
            ")
        );

        $semiannual = DB::table('semi_annual')->first();

        $semiannual_start = $semiannual->StartDate;
        $semiannual_end = $semiannual->EndDate;

        //dd($semiannual);

        $kpi = DB::select('SELECT employees.id, employees.WorkID, employees.ThaiName, Query2.Point/Query2.CountOfWorkingDate AS KPI
            FROM employees
                INNER JOIN (SELECT Query1.employee_id, Sum(Query1.CountOfWorkingDate) AS CountOfWorkingDate, SUM(Query1.Point) AS "Point"
                    FROM (SELECT mobilization_plans.project_id, mobilization_plans.employee_id, Sum(DATEDIFF(mobilization_plans.EndDate,mobilization_plans.StartDate)+1) AS CountOfWorkingDate, IF(ISNULL(performance_projects.KPI),1,performance_projects.KPI) AS KPI, Sum(DATEDIFF(mobilization_plans.EndDate,mobilization_plans.StartDate)+1)*IF(ISNULL(performance_projects.KPI),1,performance_projects.KPI) AS "Point"
                        FROM employees
                            INNER JOIN mobilization_plans
                                LEFT JOIN performance_projects
                                ON mobilization_plans.project_id = performance_projects.id
                                INNER JOIN projects
                                ON mobilization_plans.project_id = projects.id
                            ON employees.id = mobilization_plans.employee_id
                        GROUP BY mobilization_plans.project_id, mobilization_plans.employee_id, projects.FinishDate, employees.department_id, KPI
                        HAVING (((projects.FinishDate)>="'.$semiannual_start.'" And (projects.FinishDate)<="'.$semiannual_end.'") AND ((employees.department_id)='.$departmentid.'))
                        UNION ALL
                        SELECT NULL AS project_id, w_f_h_w_f_a_assignments.Assignee AS employee_id, w_f_h_w_f_a_assignments.Day AS CountOfWorkingDate, IF(ISNULL(w_f_h_w_f_a_assignments.KPI),1,w_f_h_w_f_a_assignments.KPI) AS KPI, w_f_h_w_f_a_assignments.Day*IF(ISNULL(w_f_h_w_f_a_assignments.KPI),1,w_f_h_w_f_a_assignments.KPI) AS "Point"
                        FROM employees
                            INNER JOIN week
                                INNER JOIN w_f_h_w_f_a_assignments
                                ON week.id = w_f_h_w_f_a_assignments.date_id
                            ON employees.id = w_f_h_w_f_a_assignments.Assignee
                        WHERE (((week.EndDate)>="'.$semiannual_start.'" And (week.EndDate)<="'.$semiannual_end.'") AND ((employees.department_id)='.$departmentid.'))) AS Query1
                    GROUP BY Query1.employee_id) AS Query2
                ON employees.id = Query2.employee_id
            ORDER BY KPI DESC');

        return view('KPIs.all',compact('kpi','semiannual'));
    }

    public function show(Request $request, $id, $semiannualid)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE date AS (
                SELECT id, Date, Year, Week, SemiAnnual
                FROM dates
                WHERE dates.Date <= NOW()
                );

            CREATE TEMPORARY TABLE semi_annual AS (
                SELECT start_date.id, date.Year, date.SemiAnnual, start_date.StartDate, end_date.EndDate
                FROM date
                INNER JOIN ( SELECT MIN(id) AS id, Year, SemiAnnual, MIN(Date) AS StartDate
                    FROM date
                    GROUP BY Year, SemiAnnual ) AS start_date
                ON date.Year = start_date.Year AND date.SemiAnnual = start_date.SemiAnnual
                INNER JOIN ( SELECT Year, SemiAnnual, MAX(Date) AS EndDate
                    FROM date
                    GROUP BY Year, SemiAnnual ) AS end_date
                ON date.Year = end_date.Year AND date.SemiAnnual = end_date.SemiAnnual
                GROUP BY start_date.id, date.Year, date.SemiAnnual, start_date.StartDate, end_date.EndDate
                HAVING start_date.id = $semiannualid
                );

            CREATE TEMPORARY TABLE week AS (
                SELECT start_date.id, date.Year, date.Week, start_date.StartDate, end_date.EndDate
                FROM date
                INNER JOIN ( SELECT MIN(id) AS id, Year, Week, MIN(Date) AS StartDate
                    FROM date
                    GROUP BY Year, Week ) AS start_date
                ON date.Year = start_date.Year AND date.Week = start_date.Week
                INNER JOIN ( SELECT Year, Week, MAX(Date) AS EndDate
                    FROM date
                    GROUP BY Year, Week ) AS end_date
                ON date.Year = end_date.Year AND date.Week = end_date.Week
                GROUP BY start_date.id, date.Year, date.Week, start_date.StartDate, end_date.EndDate
                );
            ")
        );

        $semiannual = DB::table('semi_annual')->first();

        $semiannual_start = $semiannual->StartDate;
        $semiannual_end = $semiannual->EndDate;
        $employee = Employee::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT kpi.StartDate, kpi.EndDate, kpi.ProjectName, kpi.Duration, kpi.KPI
                FROM (SELECT projects.StartDate, projects.FinishDate AS EndDate, projects.ProjectName, SUM(DATEDIFF(mobilization_plans.EndDate,mobilization_plans.StartDate)+1) AS Duration, performance_projects.KPI
                    FROM projects
                        LEFT JOIN performance_projects
                        ON projects.id = performance_projects.project_id
                        INNER JOIN mobilization_plans
                        ON mobilization_plans.project_id = projects.id
                    WHERE projects.FinishDate>="'.$semiannual_start.'" And projects.FinishDate<="'.$semiannual_end.'" AND mobilization_plans.employee_id='.$id.'
                    GROUP BY projects.StartDate, projects.FinishDate, projects.ProjectName, performance_projects.KPI
                    UNION ALL
                    SELECT week.StartDate, week.EndDate, "Routine" AS ProjectName, w_f_h_w_f_a_assignments.Day AS Duration, w_f_h_w_f_a_assignments.KPI
                    FROM week
                        INNER JOIN w_f_h_w_f_a_assignments
                        ON week.id = w_f_h_w_f_a_assignments.date_id
                WHERE ((week.EndDate>="'.$semiannual_start.'" And week.EndDate<="'.$semiannual_end.'") AND (w_f_h_w_f_a_assignments.Assignee='.$id.'))) AS kpi
                ORDER BY StartDate DESC');
            return DataTables::of($data)
                ->editColumn('StartDate',function($data){
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->editColumn('EndDate',function($data){
                    return '<div class="text-center">'.$data->EndDate.'</div>';
                })
                ->editColumn('Duration',function($data){
                    return '<div class="text-center">'.Number_format($data->Duration,1).'</div>';
                })
                ->editColumn('KPI',function($data){
                    if ( $data->KPI == "" ) {
                        return '<div class="text-center">1.00 (ยังไม่ได้ประเมิน)</div>';
                    } else {
                        return '<div class="text-center">'.Number_format($data->KPI,2).'</div>';
                    }
                })
                ->rawColumns(['StartDate','EndDate','Duration','KPI'])
                ->make(true);
        }

        return view('KPIs.show',compact('employee'));
    }
}
