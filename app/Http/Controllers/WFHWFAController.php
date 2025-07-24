<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WFHWFAAssignment;
use App\Models\WFHWFAJob;
use App\Models\Employee;
use App\Models\RoutineJob;
use App\Models\Date;
use Auth;
use DB;
use DataTables;
use Validator;

class WFHWFAController extends Controller
{
    public function week(Request $request)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE date AS (
                SELECT id, Date,
                    IF( dates.Week >= 52 AND dates.DayofYear < 7, dates.Year-1 ,
                        IF( dates.Week = 1 AND dates.DayofYear > 358, dates.Year+1 ,
                        dates.Year))
                    AS Year, Week
                FROM dates
                WHERE dates.Date <= NOW()
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::select('SELECT start_date.id, date.Year, date.Week, start_date.StartDate, end_date.EndDate
                FROM date
                INNER JOIN ( SELECT MIN(id) AS id, Year, Week, MIN(Date) AS StartDate
                    FROM date
                    GROUP BY Year, Week ) AS start_date
                ON date.Year = start_date.Year AND date.Week = start_date.Week
                INNER JOIN ( SELECT Year, Week, MAX(Date) AS EndDate
                    FROM date
                    GROUP BY Year, Week ) AS end_date
                ON date.Year = end_date.Year AND date.Week = end_date.Week
                GROUP BY start_date.id, date.Year, date.Week, start_date.StartDate, end_date.EndDate');
            return DataTables::of($data)
                ->editColumn('Year', function($data) {
                    return '<div class="text-center">'.$data->Year.'</div>';
                })
                ->editColumn('Week', function($data) {
                    return '<div class="text-center">'.$data->Week.'</div>';
                })
                ->editColumn('StartDate', function($data) {
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->editColumn('EndDate', function($data) {
                    return '<div class="text-center">'.$data->EndDate.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <a href="'. url('WFH_WFA_assignments/{{$StartDate}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                    </div>'
                )
                ->rawColumns(['Year','Week','StartDate','EndDate','action'])
                ->make(true);
        }

        return view('WFHWFA.week');
    }

    public function assignment(Request $request, $StartDate)
    {
        $date = Date::where('Date', $StartDate)->firstOrFail();

        DB::statement("
            CREATE TEMPORARY TABLE week AS (
                SELECT MAX(Date) AS EndofWeek
                FROM dates
                WHERE Year = ? AND Week = ?
            )
        ", [$date->Year, $date->Week]);

        $endofweek = DB::table('week')->first();

        $employee = Employee::orderBy('ThaiName','asc')->get();

        /* $report = DB::select('SELECT employees.WorkID, employees.ThaiName
            FROM employees INNER JOIN w_f_h_w_f_a_assignments ON employees.id = w_f_h_w_f_a_assignments.Assignee
            WHERE (((w_f_h_w_f_a_assignments.week_id)='.$id.'))
            ORDER BY employees.WorkID'); */

        if($request->ajax())
        {
            $data = DB::select('WITH point_result AS (
                    SELECT employees.WorkID, 
                        SUM(IFNULL(w_f_h_w_f_a_jobs.AcceptPoint, 0)) AS AssigneeResult,
                        0 AS AssignorResult
                    FROM employees
                    INNER JOIN w_f_h_w_f_a_assignments ON employees.id = w_f_h_w_f_a_assignments.Assignee
                    LEFT JOIN w_f_h_w_f_a_jobs ON w_f_h_w_f_a_assignments.id = w_f_h_w_f_a_jobs.assignment_id
                    WHERE w_f_h_w_f_a_assignments.Date = ?
                    GROUP BY employees.WorkID
                    
                    UNION
                    
                    SELECT employees.WorkID,
                        0 AS AssigneeResult,
                        SUM(IFNULL(w_f_h_w_f_a_jobs.AcceptPoint, 0) / 2) AS AssignorResult
                    FROM employees
                    INNER JOIN w_f_h_w_f_a_jobs ON employees.id = w_f_h_w_f_a_jobs.Assignor
                    INNER JOIN w_f_h_w_f_a_assignments ON w_f_h_w_f_a_assignments.id = w_f_h_w_f_a_jobs.assignment_id
                    WHERE w_f_h_w_f_a_assignments.Date = ?
                    GROUP BY employees.WorkID
                ),
                point_week AS (
                    SELECT WorkID, FORMAT(SUM(AssigneeResult + AssignorResult), 2) AS WeekPoint
                    FROM point_result
                    GROUP BY WorkID
                ),
                point_accept AS (
                    SELECT w_f_h_w_f_a_jobs.assignment_id, 
                        SUM(w_f_h_w_f_a_jobs.AcceptPoint) AS SumOfAcceptPoint
                    FROM w_f_h_w_f_a_assignments 
                    INNER JOIN w_f_h_w_f_a_jobs ON w_f_h_w_f_a_assignments.id = w_f_h_w_f_a_jobs.assignment_id
                    WHERE w_f_h_w_f_a_assignments.Date = ?
                    GROUP BY w_f_h_w_f_a_jobs.assignment_id
                )

                SELECT DISTINCT
                    a.id,
                    a.Date,
                    e1.ThaiName AS Assignor,
                    e2.ThaiName AS Assignee,
                    a.Day,
                    a.Point,
                    pa.SumOfAcceptPoint,
                    w.EndOfWeek,
                    a.KPI,
                    pw.WeekPoint
                FROM w_f_h_w_f_a_assignments a
                INNER JOIN employees e1 ON e1.id = a.Assignee
                LEFT JOIN employees e2 ON e2.id = (SELECT Assignor FROM w_f_h_w_f_a_jobs WHERE assignment_id = a.id LIMIT 1)
                LEFT JOIN point_accept pa ON pa.assignment_id = a.id
                INNER JOIN (
                    SELECT MIN(Date) AS Date, Year, Week, MAX(Date) AS EndOfWeek
                    FROM dates
                    GROUP BY Year, Week
                ) w ON w.Date = a.Date
                LEFT JOIN point_week pw ON pw.WorkID = e1.WorkID
                WHERE a.Date = ?
            ', [$date->Date, $date->Date, $date->Date, $date->Date]);

            return DataTables::of($data)
                ->editColumn('Assignor', function($data) {
                    return '<div class="text-center">'.$data->Assignor.'</div>';
                })
                ->editColumn('Assignee', function($data) {
                    return '<div class="text-center">'.$data->Assignee.'</div>';
                })
                ->editColumn('Day', function($data) {
                    return '<div class="text-center">'.$data->Day.'</div>';
                })
                ->editColumn('Point', function($data) {
                    return '<div class="text-center">'.number_format($data->Point,2).'</div>';
                })
                ->editColumn('SumOfAcceptPoint', function($data) {
                    return '<div class="text-center">'.number_format($data->SumOfAcceptPoint,2).'</div>';
                })
                ->editColumn('KPI', function($data) {
                    if ( $data->Point == 0 ) {
                        return 'N/A';
                    } else {
                        if ( $data->WeekPoint/$data->Point > 2 ) {
                            return '<div class="text-center">'.number_format($data->KPI,2).'(5.00)</div>';
                        } else {
                            $grade = 1+2*($data->WeekPoint/$data->Point);
                            return '<div class="text-center">'.number_format($data->KPI,2).'('.number_format($grade,2).')</div>';
                        }
                    }
                })
                ->addColumn('action',function($data) {
                    $n = date('Y-m-d', strtotime( $data->EndOfWeek . "+1 days"));
                    if ( $n > NOW() ) {
                        return '
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            <a href="'.url('WFH_WFA_jobs/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
                    } else {
                        return view('WFHWFA.assignmentaction',compact('data'));
                    }
                })
                ->rawColumns(['Assignor','Assignee','Day','Point','SumOfAcceptPoint','KPI','action'])
                ->make(true);
        }

        return view('WFHWFA.assignment',compact('date','endofweek','employee'));
    }

    public function assignmentstore(Request $request)
    {
        $rules = array(
            'Assignee'=>'required',
            'Day'=>'required',
            'Point'=>'required',
            'Date'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Assignee' => $request->Assignee,
            'Day' => $request->Day,
            'Point' => $request->Point,
            'KPI' => 1,
            'Date' => $request->Date
        );

        WFHWFAAssignment::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function assignmentedit($id)
    {
        if(request()->ajax())
        {
            $data = WFHWFAAssignment::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function assignmentupdate(Request $request,WFHWFAAssignment $toolid)
    {
        $rules = array(
            'Assignee'=>'required',
            'Day'=>'required',
            'Point'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Assignee' => $request->Assignee,
            'Day' => $request->Day,
            'Point' => $request->Point,
            'KPI' => $request->KPI
        );

        WFHWFAAssignment::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function assignmentdestroy($id)
    {
        $data = WFHWFAAssignment::findOrFail($id);
        $data->delete();
    }

    public function job(Request $request, $id)
    {
        $assignment = WFHWFAAssignment::find($id);

        $employee = Employee::whereNotIn('user_id', [Auth::user()->id] )->orderBy('ThaiName','asc')->get();

        $job = RoutineJob::orderBy('RoutineJobName','asc')->get();

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE date AS (
                SELECT Date,
                    IF( dates.Week >= 52 AND dates.DayofYear < 7, dates.Year-1 ,
                        IF( dates.Week = 1 AND dates.DayofYear > 358, dates.Year+1 ,
                        dates.Year))
                    AS Year, Week
                FROM dates
                WHERE dates.Date <= NOW()
                );
            ")
        );

        $enddate = DB::select('SELECT Year, Week, MAX(Date) AS EndDate
            FROM date
            GROUP BY Year, Week');

        $data = DB::select('SELECT w_f_h_w_f_a_jobs.id, routine_jobs.RoutineJobName, routine_jobs.KPI, routine_jobs.Point, w_f_h_w_f_a_jobs.Detail, w_f_h_w_f_a_jobs.TargetPoint, w_f_h_w_f_a_jobs.AcceptPoint, employees.ThaiName AS Assignor, employees.user_id, week.EndDate
            FROM w_f_h_w_f_a_assignments
            INNER JOIN (employees
                INNER JOIN (routine_jobs
                    INNER JOIN w_f_h_w_f_a_jobs
                    ON routine_jobs.id = w_f_h_w_f_a_jobs.routine_job_id)
                ON employees.id = w_f_h_w_f_a_jobs.Assignor)
            ON w_f_h_w_f_a_assignments.id = w_f_h_w_f_a_jobs.assignment_id
            INNER JOIN (SELECT date.Year, date.Week, start_date.StartDate, end_date.EndDate
                FROM date
                INNER JOIN ( SELECT Year, Week, MIN(Date) AS StartDate
                    FROM date
                    GROUP BY Year, Week ) AS start_date
                ON date.Year = start_date.Year AND date.Week = start_date.Week
                INNER JOIN ( SELECT Year, Week, MAX(Date) AS EndDate
                    FROM date
                    GROUP BY Year, Week ) AS end_date
                ON date.Year = end_date.Year AND date.Week = end_date.Week
                GROUP BY date.Year, date.Week, start_date.StartDate, end_date.EndDate) AS week
            ON w_f_h_w_f_a_assignments.Date = week.StartDate
            WHERE (((w_f_h_w_f_a_jobs.assignment_id)='.$id.'))');

        //dd($data);

        if($request->ajax())
        {
            $data = DB::select('SELECT w_f_h_w_f_a_jobs.id, routine_jobs.RoutineJobName, routine_jobs.KPI, routine_jobs.Point, w_f_h_w_f_a_jobs.Detail, w_f_h_w_f_a_jobs.TargetPoint, w_f_h_w_f_a_jobs.AcceptPoint, employees.ThaiName AS Assignor, employees.user_id, week.EndDate
                FROM w_f_h_w_f_a_assignments
                INNER JOIN (employees
                    INNER JOIN (routine_jobs
                        INNER JOIN w_f_h_w_f_a_jobs
                        ON routine_jobs.id = w_f_h_w_f_a_jobs.routine_job_id)
                    ON employees.id = w_f_h_w_f_a_jobs.Assignor)
                ON w_f_h_w_f_a_assignments.id = w_f_h_w_f_a_jobs.assignment_id
                INNER JOIN (SELECT date.Year, date.Week, start_date.StartDate, end_date.EndDate
                    FROM date
                    INNER JOIN ( SELECT Year, Week, MIN(Date) AS StartDate
                        FROM date
                        GROUP BY Year, Week ) AS start_date
                    ON date.Year = start_date.Year AND date.Week = start_date.Week
                    INNER JOIN ( SELECT Year, Week, MAX(Date) AS EndDate
                        FROM date
                        GROUP BY Year, Week ) AS end_date
                    ON date.Year = end_date.Year AND date.Week = end_date.Week
                    GROUP BY date.Year, date.Week, start_date.StartDate, end_date.EndDate) AS week
                ON w_f_h_w_f_a_assignments.Date = week.StartDate
                WHERE (((w_f_h_w_f_a_jobs.assignment_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('Point', function($data) {
                    return '<div class="text-center">'.$data->Point.'</div>';
                })
                ->editColumn('Detail',function($data){
                    return nl2br($data->Detail);
                })
                ->editColumn('TargetPoint', function($data) {
                    return '<div class="text-center">'.$data->TargetPoint.'</div>';
                })
                ->editColumn('AcceptPoint', function($data) {
                    return '<div class="text-center">'.$data->AcceptPoint.'</div>';
                })
                ->editColumn('Assignor', function($data) {
                    return '<div class="text-center">'.$data->Assignor.'</div>';
                })
                ->addColumn('action',function($data){
                    $n = date('Y-m-d', strtotime( $data->EndDate . "+1 days"));
                    if ( $n > NOW() ) {
                        if ( $data->user_id == Auth::user()->id ) {
                            return '
                            <div class="text-center">
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                <button class="evaluate btn btn-xs btn-default text-info mx-1 shadow" name="edit" id="'.$data->id.'" title="Evaluate"><i class="fa fa-lg fa-fw fa-ruler-vertical"></i></button>
                            </div>';
                        } else {
                            return view('WFHWFA.jobaction1',compact('data'));
                        }
                    } else {
                        return view('WFHWFA.jobaction2',compact('data'));
                    }
                })
                ->rawColumns(['id','Point','Detail','TargetPoint','AcceptPoint','Assignor','action'])
                ->make(true);
        }
        return view('WFHWFA.job',compact('assignment','employee','job','enddate'));
    }

    public function jobstore(Request $request)
    {
        $rules = array(
            'assignment_id'=>'required',
            'Assignor'=>'required',
            'routine_job_id'=>'required',
            'Detail'=>'required',
            'TargetPoint'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'assignment_id' => $request->assignment_id,
            'Assignor' => $request->Assignor,
            'routine_job_id' => $request->routine_job_id,
            'Detail' => $request->Detail,
            'TargetPoint' => $request->TargetPoint,
            'AcceptPoint' => 0
        );

        WFHWFAJob::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function jobedit($id)
    {
        if(request()->ajax())
        {
            $data = WFHWFAJob::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function jobupdate(Request $request,WFHWFAJob $toolid)
    {
        $rules = array(
            'assignment_id'=>'required',
            'routine_job_id'=>'required',
            'Detail'=>'required',
            'Assignor'=>'required',
            'TargetPoint'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'assignment_id' => $request->assignment_id,
            'routine_job_id' => $request->routine_job_id,
            'Detail' => $request->Detail,
            'Assignor' => $request->Assignor,
            'TargetPoint' => $request->TargetPoint,
            'AcceptPoint' => 0
        );

        WFHWFAJob::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function jobdestroy($id)
    {
        $data = WFHWFAJob::findOrFail($id);
        $data->delete();
    }

    public function evaluate(Request $request,WFHWFAJob $id)
    {
        $rules = array(
            'AcceptPoint'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'AcceptPoint' => $request->AcceptPoint
        );

        WFHWFAJob::whereId($request->hidden_id2)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }
}
