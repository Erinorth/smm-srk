<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class DashboardController extends Controller
{
    public function accident(Request $request)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE date_count AS (
                SELECT dates.Date, dates.Year, dates.Month,
                    IF(safety_health_control_graphs.IncidentMan IS NULL,0,safety_health_control_graphs.IncidentMan) AS IncidentMan,
                    IF(safety_health_control_graphs.IncidentObj IS NULL,0,safety_health_control_graphs.IncidentObj) AS IncidentObj,
                    IF(safety_health_control_graphs.IncidentDiv IS NULL,0,safety_health_control_graphs.IncidentDiv) AS IncidentDiv
                FROM dates
                LEFT JOIN safety_health_control_graphs
                ON dates.Date = safety_health_control_graphs.Month
                WHERE dates.Date BETWEEN CAST('$request->startdate' AS DATE) AND CAST('$request->enddate' AS DATE)
                );
            ")
        );

        $month_accident = array();
		$IncidentMan = array();
        $IncidentObj = array();
        $IncidentDiv = array();
        $cumulative_hydro = array();
        $cumulative_div = array();

        if ( $request->showtype == 1 ) {
            $count_accidentx = DB::select('SELECT date_count.Year, date_count.Month, CONCAT(date_count.Year," - ",date_count.Month) AS YearMonth, SUM(date_count.IncidentMan) AS IncidentMan, SUM(date_count.IncidentObj) AS IncidentObj, SUM(date_count.IncidentDiv) AS IncidentDiv
                FROM date_count
                GROUP BY date_count.Year, date_count.Month, YearMonth
                ORDER BY date_count.Year, date_count.Month');
            if ( ! empty( $count_accidentx ) ) {
                $i = 0;
                $j = 0;
                foreach ( $count_accidentx as $value ){
                    array_push( $month_accident, $value->YearMonth );
                    array_push( $IncidentMan, $value->IncidentMan );
                    array_push( $IncidentObj, $value->IncidentObj );
                    array_push( $IncidentDiv, $value->IncidentDiv );
                    $i = $i + $value->IncidentMan + $value->IncidentObj;
                    array_push( $cumulative_hydro, $i );
                    $j = $j + $value->IncidentDiv;
                    array_push( $cumulative_div, $j );
                }
            }
        } else {
            $count_accidentx = DB::select('SELECT date_count.Year, SUM(date_count.IncidentMan) AS count_accident
                FROM date_count
                GROUP BY date_count.Year
                ORDER BY date_count.Year');
            if ( ! empty( $count_accidentx ) ) {
                foreach ( $count_accidentx as $value ){
                    array_push( $month_accident, $value->Year );
                    array_push( $count_accident, $value->count_accident );
                }
            }
        }

        return response()->json(compact('month_accident','IncidentMan','IncidentObj','IncidentDiv','cumulative_hydro','cumulative_div'));
    }

    public function cost()
    {
        return view('dashboard.cost');
    }

    public function dailyreport(Request $request)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE employees2 AS (
                SELECT employees.id, employees.ThaiName
                FROM employees
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, employees.ThaiName AS AreaManager, employees2.ThaiName AS SiteEngineer, projects.KeyDate, projects.KeyDatePath, projects.DailyReport
                FROM projects
                LEFT JOIN employees
                ON projects.AreaManager = employees.id
                LEFT JOIN employees2
                ON projects.SiteEngineer = employees2.id
                WHERE projects.project_type_id IN (1,2,3,4,5,6) AND NOW() BETWEEN CAST(projects.StartDate AS DATE) AND CAST(projects.FinishDate AS DATE)');
            return DataTables::of($data)
                ->editColumn('StartDate',function($data){
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->editColumn('FinishDate',function($data){
                    return '<div class="text-center">'.$data->FinishDate.'</div>';
                })
                ->editColumn('Responsible', function($data) {
                    if ( $data->AreaManager == $data->SiteEngineer ) {
                        return '<div class="text-center">'.$data->AreaManager.'</div>';
                    } else {
                        return '<div class="text-center">'.$data->AreaManager.'/'.$data->SiteEngineer.'</div>';
                    }
                })
                ->editColumn('KeyDate',function($data){
                    if ( $data->KeyDate != "" ) {
                        return '
                        <div class="text-center">
                            <a href="'. url('storage/'.$data->KeyDatePath.$data->KeyDate.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        </div>';
                    }
                })
                ->editColumn('DailyReport', function($data) {
                    if ( $data->DailyReport != "" ) {
                        return '
                        <div class="text-center">
                            <a href="'.$data->DailyReport.'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Daily Report"><i class="fa fa-lg fa-fw fa-sticky-note"></i></a>
                        </div>';
                    }
                })
                ->rawColumns(['StartDate','FinishDate','Responsible','KeyDate','DailyReport'])
                ->make(true);
        }
        return view('dashboard.dailyreport');
    }

    public function dailyreportoutside(Request $request)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE employees2 AS (
                SELECT employees.id, employees.ThaiName
                FROM employees
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, employees.ThaiName AS AreaManager, employees2.ThaiName AS SiteEngineer, projects.KeyDate, projects.KeyDatePath, projects.DailyReport
                FROM projects
                LEFT JOIN employees
                ON projects.AreaManager = employees.id
                LEFT JOIN employees2
                ON projects.SiteEngineer = employees2.id
                WHERE projects.project_type_id IN (1,2,3,4,5,6) AND NOW() BETWEEN CAST(projects.StartDate AS DATE) AND CAST(projects.FinishDate AS DATE) AND projects.DailyReport IS NOT NULL');
            return DataTables::of($data)
                ->editColumn('StartDate',function($data){
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->editColumn('FinishDate',function($data){
                    return '<div class="text-center">'.$data->FinishDate.'</div>';
                })
                ->editColumn('Responsible', function($data) {
                    if ( $data->AreaManager == $data->SiteEngineer ) {
                        return '<div class="text-center">'.$data->AreaManager.'</div>';
                    } else {
                        return '<div class="text-center">'.$data->AreaManager.'/'.$data->SiteEngineer.'</div>';
                    }
                })
                ->editColumn('KeyDate',function($data){
                    if ( $data->KeyDate != "" ) {
                        return '
                        <div class="text-center">
                            <a href="'. url('storage/'.$data->KeyDatePath.$data->KeyDate.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        </div>';
                    }
                })
                ->editColumn('DailyReport', function($data) {
                    if ( $data->DailyReport != "" ) {
                        return '
                        <div class="text-center">
                            <a href="'.$data->DailyReport.'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Daily Report"><i class="fa fa-lg fa-fw fa-sticky-note"></i></a>
                        </div>';
                    }
                })
                ->rawColumns(['StartDate','FinishDate','Responsible','KeyDate','DailyReport'])
                ->make(true);
        }
        return view('dashboard.dailyreport');
    }

    public function di(Request $request)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE date_count AS (
                SELECT dates.Date, dates.Year, dates.Month, IF(safety_health_control_graphs.IncidentMan IS NULL,0,safety_health_control_graphs.IncidentMan) AS IncidentMan
                FROM dates
                LEFT JOIN safety_health_control_graphs
                ON dates.Date = safety_health_control_graphs.Month
                WHERE dates.Date BETWEEN CAST('$request->startdate' AS DATE) AND CAST('$request->enddate' AS DATE)
                );
            ")
        );

        $month_di = array();
		$count_di = array();

        if ( $request->showtype == 1 ) {
            $count_dix = DB::select('SELECT date_count.Year, date_count.Month, CONCAT(date_count.Year," - ",date_count.Month) AS YearMonth, SUM(date_count.IncidentMan) AS count_accident
                FROM date_count
                GROUP BY date_count.Year, date_count.Month, YearMonth
                ORDER BY date_count.Year, date_count.Month');
            if ( ! empty( $count_dix ) ) {
                foreach ( $count_dix as $value ){
                    array_push( $month_di, $value->YearMonth );
                    array_push( $count_di, $value->count_accident );
                }
            }
        } else {
            $count_dix = DB::select('SELECT date_count.Year, SUM(date_count.IncidentMan) AS count_accident
                FROM date_count
                GROUP BY date_count.Year
                ORDER BY date_count.Year');
            if ( ! empty( $count_dix ) ) {
                foreach ( $count_dix as $value ){
                    array_push( $month_di, $value->Year );
                    array_push( $count_di, $value->count_accident );
                }
            }
        }

        return response()->json(compact('month_di','count_di'));
    }

    public function duration()
    {
        return view('dashboard.duration');
    }

    public function overtime()
    {
        $dayinmonth=cal_days_in_month(CAL_GREGORIAN,DATE("m"),DATE("Y"));

        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS employee;
            DROP TABLE IF EXISTS date;
            DROP TABLE IF EXISTS main;
            DROP TABLE IF EXISTS actual;
            DROP TABLE IF EXISTS maxdateactual;
            DROP TABLE IF EXISTS plan;
            DROP TABLE IF EXISTS frame;
            DROP TABLE IF EXISTS combine;
            DROP TABLE IF EXISTS result;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE employee AS (
                SELECT employee_id
                FROM (SELECT employee_id
                    FROM plan_o_t_s
                    WHERE YEAR(PlanDate) = YEAR(NOW()) AND MONTH(PlanDate) = MONTH(NOW())
                    GROUP BY employee_id
                    UNION
                    SELECT employee_id
                    FROM (SELECT man_hours.employee_id, man_hours.WorkingDate, jobs.project_id
                        FROM man_hours
                        INNER JOIN jobs
                        ON man_hours.job_id = jobs.id) AS man_hour
                    WHERE YEAR(WorkingDate) = YEAR(NOW()) AND MONTH(WorkingDate) = MONTH(NOW())
                    GROUP BY employee_id) AS employee
                GROUP BY employee_id
                );

            CREATE TEMPORARY TABLE date AS (
                SELECT Date
                FROM dates
                WHERE YEAR(Date) = YEAR(NOW()) AND MONTH(Date) = MONTH(NOW())
                );

            CREATE TEMPORARY TABLE main AS (
                SELECT date.Date, employee.employee_id
                FROM date
                CROSS JOIN employee
                );

            CREATE TEMPORARY TABLE actual AS (
                SELECT t.Date, t.employee_id, SUM(t.ActualOT) AS ActualOT, t.project_id
                FROM (SELECT main.Date, main.employee_id, SUM(man_hours.ot1+man_hours.ot15+man_hours.ot2+man_hours.ot3) AS ActualOT, jobs.project_id
                    FROM man_hours
                    RIGHT JOIN main
                    ON man_hours.employee_id = main.employee_id AND man_hours.WorkingDate = main.Date
                    LEFT JOIN jobs
                    ON man_hours.job_id = jobs.id
                    GROUP BY main.Date, main.employee_id, jobs.project_id
                    UNION
                    SELECT Date_ADD(support_men.StartDate, INTERVAL -1 DAY) AS Date, support_men.employee_id, SUM(support_men.OT) AS ActualOT, 0 AS project_id
                    FROM support_men
                    INNER JOIN support_requests
                    ON support_men.support_request_id = support_requests.id
                    GROUP BY Date_ADD(support_men.StartDate, INTERVAL -1 DAY), support_men.employee_id, support_requests.project_id) t
                GROUP BY t.Date, t.employee_id, t.project_id
                );

            CREATE TEMPORARY TABLE maxdateactual AS (
                SELECT t.employee_id, IF(t.MaxActualDate >= t2.MaxWeek,t.MaxActualDate,t2.MaxWeek) AS MaxActualDate
                FROM(SELECT employee_id, MAX(WorkingDate) AS MaxActualDate
                    FROM man_hours
                    WHERE YEAR(NOW()) = Year(WorkingDate) AND MONTH(NOW()) = MONTH(WorkingDate)
                    GROUP BY employee_id) t
                JOIN (SELECT Date AS MaxWeek
                    FROM dates
                    WHERE YEAR(DATE_ADD(NOW(), INTERVAL -1 WEEK)) = Year AND WEEK(DATE_ADD(NOW(), INTERVAL -1 WEEK)) = Week AND DayofWeek = 7 ) t2
                );

            CREATE TEMPORARY TABLE plan AS (
                SELECT main.Date, main.employee_id, SUM(plan_o_t_s.PlanHour) AS PlanOT, plan_o_t_s.project_id, plan_o_t_s.Remark
                FROM plan_o_t_s
                RIGHT JOIN main
                ON plan_o_t_s.employee_id = main.employee_id AND plan_o_t_s.PlanDate = main.Date
                GROUP BY main.Date, main.employee_id, plan_o_t_s.project_id, plan_o_t_s.Remark
                );

            CREATE TEMPORARY TABLE frame AS (
                SELECT o_t_frames.employee_id, o_t_frames.Frame, o_t_frames.updated_at
                FROM o_t_frames
                INNER JOIN employee
                ON o_t_frames.employee_id = employee.employee_id
                WHERE o_t_frames.Month = MONTH(NOW())
                );

            CREATE TEMPORARY TABLE combine AS (
                SELECT main.Date, actual.employee_id, plan.PlanOT, actual.ActualOT, maxdateactual.MaxActualDate, plan.project_id AS PlanProject, actual.project_id AS ActualProject, plan.Remark, frame.Frame, DAY(frame.updated_at) AS UpdateFrame
                FROM main
                LEFT JOIN actual
                ON main.Date = actual.Date AND main.employee_id = actual.employee_id
                LEFT JOIN plan
                ON main.Date = plan.Date AND main.employee_id = plan.employee_id
                LEFT JOIN maxdateactual
                ON main.employee_id = maxdateactual.employee_id
                LEFT JOIN frame
                ON main.employee_id = frame.employee_id
                ORDER BY main.Date, actual.employee_id
                );

            CREATE TEMPORARY TABLE result AS (
                SELECT combine.Date, combine.employee_id, employees.WorkID, employees.ThaiName, combine.MaxActualDate, combine.Frame, combine.UpdateFrame,
                    IF(combine.Date <= combine.MaxActualDate,
                        combine.ActualOT,
                        combine.PlanOT
                    ) AS OT,
                    IF(combine.ActualProject IS NOT NULL,
                        combine.ActualProject,
                        combine.PlanProject
                    ) AS Project
                FROM combine
                    INNER JOIN employees
                    ON combine.employee_id = employees.id
                );
            ")
        );

        $plan = DB::select('SELECT result.WorkID, result.ThaiName, SUM(result.OT) AS TotalOT, result.Frame, result.UpdateFrame, DAY(result.MaxActualDate) AS MaxActualDate, sumactual.SumActual,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 1) THEN result.OT ELSE "0" END) AS Plan1,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 1) THEN result.Project ELSE "-" END) AS Project1,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 2) THEN result.OT ELSE "0" END) AS Plan2,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 2) THEN result.Project ELSE "-" END) AS Project2,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 3) THEN result.OT ELSE "0" END) AS Plan3,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 3) THEN result.Project ELSE "-" END) AS Project3,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 4) THEN result.OT ELSE "0" END) AS Plan4,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 4) THEN result.Project ELSE "-" END) AS Project4,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 5) THEN result.OT ELSE "0" END) AS Plan5,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 5) THEN result.Project ELSE "-" END) AS Project5,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 6) THEN result.OT ELSE "0" END) AS Plan6,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 6) THEN result.Project ELSE "-" END) AS Project6,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 7) THEN result.OT ELSE "0" END) AS Plan7,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 7) THEN result.Project ELSE "-" END) AS Project7,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 8) THEN result.OT ELSE "0" END) AS Plan8,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 8) THEN result.Project ELSE "-" END) AS Project8,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 9) THEN result.OT ELSE "0" END) AS Plan9,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 9) THEN result.Project ELSE "-" END) AS Project9,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 10) THEN result.OT ELSE "0" END) AS Plan10,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 10) THEN result.Project ELSE "-" END) AS Project10,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 11) THEN result.OT ELSE "0" END) AS Plan11,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 11) THEN result.Project ELSE "-" END) AS Project11,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 12) THEN result.OT ELSE "0" END) AS Plan12,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 12) THEN result.Project ELSE "-" END) AS Project12,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 13) THEN result.OT ELSE "0" END) AS Plan13,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 13) THEN result.Project ELSE "-" END) AS Project13,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 14) THEN result.OT ELSE "0" END) AS Plan14,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 14) THEN result.Project ELSE "-" END) AS Project14,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 15) THEN result.OT ELSE "0" END) AS Plan15,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 15) THEN result.Project ELSE "-" END) AS Project15,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 16) THEN result.OT ELSE "0" END) AS Plan16,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 16) THEN result.Project ELSE "-" END) AS Project16,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 17) THEN result.OT ELSE "0" END) AS Plan17,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 17) THEN result.Project ELSE "-" END) AS Project17,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 18) THEN result.OT ELSE "0" END) AS Plan18,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 18) THEN result.Project ELSE "-" END) AS Project18,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 19) THEN result.OT ELSE "0" END) AS Plan19,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 19) THEN result.Project ELSE "-" END) AS Project19,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 20) THEN result.OT ELSE "0" END) AS Plan20,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 20) THEN result.Project ELSE "-" END) AS Project20,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 21) THEN result.OT ELSE "0" END) AS Plan21,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 21) THEN result.Project ELSE "-" END) AS Project21,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 22) THEN result.OT ELSE "0" END) AS Plan22,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 22) THEN result.Project ELSE "-" END) AS Project22,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 23) THEN result.OT ELSE "0" END) AS Plan23,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 23) THEN result.Project ELSE "-" END) AS Project23,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 24) THEN result.OT ELSE "0" END) AS Plan24,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 24) THEN result.Project ELSE "-" END) AS Project24,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 25) THEN result.OT ELSE "0" END) AS Plan25,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 25) THEN result.Project ELSE "-" END) AS Project25,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 26) THEN result.OT ELSE "0" END) AS Plan26,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 26) THEN result.Project ELSE "-" END) AS Project26,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 27) THEN result.OT ELSE "0" END) AS Plan27,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 27) THEN result.Project ELSE "-" END) AS Project27,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 28) THEN result.OT ELSE "0" END) AS Plan28,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 28) THEN result.Project ELSE "-" END) AS Project28,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 29) THEN result.OT ELSE "0" END) AS Plan29,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 29) THEN result.Project ELSE "-" END) AS Project29,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 30) THEN result.OT ELSE "0" END) AS Plan30,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 30) THEN result.Project ELSE "-" END) AS Project30,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 31) THEN result.OT ELSE "0" END) AS Plan31,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 31) THEN result.Project ELSE "-" END) AS Project31
            FROM result
            LEFT JOIN (SELECT employee_id, SUM(OT) AS SumActual
                FROM result
                WHERE Date <= MaxActualDate
                GROUP BY employee_id) AS sumactual
            ON result.employee_id = sumactual.employee_id
            GROUP BY result.WorkID, result.ThaiName, result.Frame, result.UpdateFrame, result.MaxActualDate, sumactual.SumActual');

        $allproject = DB::select('SELECT projects.id, projects.ProjectName
            FROM result
                INNER JOIN projects
                ON result.Project = projects.id
            GROUP BY projects.id, projects.ProjectName');

        /* $test = DB::table('result')->get();
        dd($test); */

        return view('dashboard.overtime',compact('plan','dayinmonth','allproject'));

        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS employee;
            DROP TABLE IF EXISTS date;
            DROP TABLE IF EXISTS main;
            DROP TABLE IF EXISTS actual;
            DROP TABLE IF EXISTS maxdateactual;
            DROP TABLE IF EXISTS plan;
            DROP TABLE IF EXISTS frame;
            DROP TABLE IF EXISTS combine;
            DROP TABLE IF EXISTS result;
            ")
        );
    }

    /* public function project()
    {
        $month_array = array();
		$project_dates = Project::where( 'StartDate','>','2021-12-31')
            ->orderBy( 'StartDate', 'ASC' )
            ->pluck( 'StartDate' );
		$project_dates = json_decode( $project_dates );

		if ( ! empty( $project_dates ) ) {
			foreach ( $project_dates as $unformatted_date ) {
				$date = new \DateTime( $unformatted_date );
				$month_no = $date->format( 'm' );
				$month_name = $date->format( 'M' );
				$month_array[ $month_no ] = $month_name;
			}
		}

        $monthly_project_count_array = array();
		$month_name_array = array();

        if ( ! empty( $month_array ) ) {
			foreach ( $month_array as $month_no => $month_name ){
				$monthly_project_count = Project::where( 'StartDate','>','2021-12-31')
                    ->whereMonth( 'StartDate', $month_no )
                    ->get()->count();
				array_push( $monthly_project_count_array, $monthly_project_count );
				array_push( $month_name_array, $month_name );
			}
		}

        return response()->json(compact('monthly_project_count_array','month_name_array'));
    } */

    public function project2(Request $request)
    {
        $project_type = $request->get('project_type');
        if ( ! empty( $project_type ) ) {
            $project_type = implode(',', $project_type);
        } else {
            $project_type = 0;
        }

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE date_count AS (
                SELECT date_count.id, date_count.Date, COUNT(date_count.Date) AS count_project
                FROM (SELECT dates.id, projects.StartDate, dates.Date, projects.FinishDate, projects.ProjectName
                    FROM dates, projects
                    WHERE dates.Date BETWEEN CAST('$request->startdate' AS DATE) AND CAST('$request->enddate' AS DATE) AND projects.project_type_id IN ($project_type)
                    GROUP BY dates.id, projects.StartDate, dates.Date, projects.FinishDate, projects.ProjectName
                    HAVING dates.Date BETWEEN CAST(projects.StartDate AS DATE) AND CAST(projects.FinishDate AS DATE)) AS date_count
                GROUP BY date_count.id, date_count.Date
                );
            ")
        );

        $date = array();
		$count_project = array();

        if ( $request->showtype == 1 ) {
            $count_projectx = DB::table('date_count')->get();
            if ( ! empty( $count_projectx ) ) {
                foreach ( $count_projectx as $value ){
                    array_push( $date, $value->Date );
                    array_push( $count_project, $value->count_project );
                }
            }
        } elseif ( $request->showtype == 2) {
            $count_projectx = DB::select('SELECT dates.Year, dates.Month, CONCAT(dates.Year," - ",dates.Month) AS YearMonth, AVG(date_count.count_project) AS count_project
                FROM date_count
                INNER JOIN dates
                ON date_count.id = dates.id
                GROUP BY dates.Year, dates.Month, YearMonth
                ORDER BY dates.Year, dates.Month');
            if ( ! empty( $count_projectx ) ) {
                foreach ( $count_projectx as $value ){
                    array_push( $date, $value->YearMonth );
                    array_push( $count_project, $value->count_project );
                }
            }
        } else {
            $count_projectx = DB::select('SELECT dates.Year, AVG(date_count.count_project) AS count_project
                FROM date_count
                INNER JOIN dates
                ON date_count.id = dates.id
                GROUP BY dates.Year
                ORDER BY dates.Year');
            if ( ! empty( $count_projectx ) ) {
                foreach ( $count_projectx as $value ){
                    array_push( $date, $value->Year );
                    array_push( $count_project, $value->count_project );
                }
            }
        }

        return response()->json(compact('date','count_project'));
    }

    public function quality()
    {
        return view('dashboard.quality');
    }

    public function safety()
    {
        return view('dashboard.safety');
    }

    public function tooltimeconfirm(Request $request)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE expensive AS (
                SELECT id
                FROM tools
                WHERE Price > 100000
                );

            CREATE TEMPORARY TABLE toolstatus AS (
                SELECT tool_updates.tool_id, tool_updates.Status
                FROM tool_updates
                INNER JOIN (SELECT tool_id, MAX(updated_at) AS MaxDate
                    FROM tool_updates
                    GROUP BY tool_id) AS max
                ON tool_updates.tool_id = max.tool_id AND tool_updates.updated_at = max.MaxDate
                );

            CREATE TEMPORARY TABLE toollist AS (
                SELECT expensive.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, DATEDIFF(NOW(),tools.RegisterDate)/365 AS Old
                FROM expensive
                    LEFT JOIN toolstatus
                    ON expensive.id = toolstatus.tool_id
                    INNER JOIN tools
                        INNER JOIN tool_catagories
                        ON tools.tool_catagory_id = tool_catagories.id
                    ON expensive.id = tools.id
                WHERE toolstatus.Status NOT IN('Cut Off','Lost')
                );

            CREATE TEMPORARY TABLE time_confirm AS (
                SELECT toollist.id, SUM(IF(expensive_tools.Hour IS NULL,0,expensive_tools.Hour)) AS Hour
                FROM toollist
                LEFT JOIN expensive_tools
                ON toollist.id = expensive_tools.tool_id
                GROUP BY toollist.id
                );
            ")
        );

        /* $test = DB::table('time_confirm')->get();
        dd($test); */

        if($request->ajax())
        {
            $data = DB::select('SELECT toollist.CatagoryName, toollist.RangeCapacity, toollist.Brand, toollist.Model, toollist.SerialNumber, toollist.LocalCode, toollist.DurableSupplieCode, toollist.AssetToolCode, FORMAT(time_confirm.Hour,2) AS Hour, FORMAT(time_confirm.Hour/toollist.old,2) AS UF
                FROM time_confirm
                INNER JOIN toollist
                ON time_confirm.id = toollist.id');
            return DataTables::of($data)
                ->editColumn('Brand',function($data){
                    return '<div class="text-center">'.$data->Brand.'</div>';
                })
                ->editColumn('Model',function($data){
                    return '<div class="text-center">'.$data->Model.'</div>';
                })
                ->editColumn('SerialNumber',function($data){
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->editColumn('LocalCode',function($data){
                    return '<div class="text-center">'.$data->LocalCode.'</div>';
                })
                ->editColumn('DurableSupplieCode',function($data){
                    return '<div class="text-center">'.$data->DurableSupplieCode.'</div>';
                })
                ->editColumn('AssetToolCode',function($data){
                    return '<div class="text-center">'.$data->AssetToolCode.'</div>';
                })
                ->editColumn('UF',function($data){
                    return '<div class="text-center">'.$data->UF.'</div>';
                })
                ->editColumn('Hour',function($data){
                    return '<div class="text-center">'.$data->Hour.'</div>';
                })
                ->rawColumns(['Brand','Model','SerialNumber','LocalCode','DurableSupplieCode','UF','AssetToolCode','Hour'])
                ->make(true);
        }

        return view('dashboard.expensive_tool');
    }
}
