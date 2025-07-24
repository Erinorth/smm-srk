<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Project;
use App\Models\JobPosition;
use App\Models\MobilizationPlan;
use App\Models\Department;

class MobilizationPlanController extends Controller
{
    public function index(Request $request)
    {
        $employee = DB::select('SELECT employees.id, employees.ThaiName
            FROM departments INNER JOIN employees ON departments.id = employees.department_id
            WHERE (((departments.Department)="กฟนม-ธ."))
            ORDER BY employees.ThaiName');

        if($request->ajax())
        {
            $data = DB::select('SELECT mobilization_plans.id, employees.ThaiName, mobilization_plans.StartDate, mobilization_plans.EndDate, mobilization_plans.Remark
                FROM employees INNER JOIN mobilization_plans ON employees.id = mobilization_plans.employee_id
                WHERE ((ISNULL(mobilization_plans.project_id)))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('StartDate', function($data) {
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->editColumn('EndDate', function($data) {
                    return '<div class="text-center">'.$data->EndDate.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['id','StartDate','EndDate','action'])
                ->make(true);
        }

        return view('mobilizationplans.index',compact('employee'));
    }

    public function project(Request $request, $id)
    {
        $project = Project::find($id);
        $employee = DB::select('SELECT t.id, t.ThaiName
            FROM (SELECT employees.id, employees.ThaiName
                FROM departments
                INNER JOIN employees
                ON departments.id = employees.department_id
                WHERE departments.id IN (1,2,3,4)
                UNION
                SELECT employees.id, employees.ThaiName
                FROM employees
                INNER JOIN support_men
                    INNER JOIN support_requests
                    ON support_men.support_request_id = support_requests.id
                ON employees.id = support_men.employee_id
                WHERE support_requests.project_id = '.$id.') t
            ORDER BY t.ThaiName');
        $pmorder = DB::select('SELECT p_m_orders.id, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.project_id
            FROM p_m_orders
            WHERE (((p_m_orders.project_id)='.$id.'))');
        $department = Department::all();

        if($request->ajax())
        {
            $data = DB::select('SELECT mobilization_plans.id, employees.ThaiName, mobilization_plans.StartDate, mobilization_plans.EndDate, mobilization_plans.Allowance, mobilization_plans.Remark
                FROM employees INNER JOIN mobilization_plans ON employees.id = mobilization_plans.employee_id
                WHERE (((mobilization_plans.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('StartDate', function($data) {
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->editColumn('EndDate', function($data) {
                    return '<div class="text-center">'.$data->EndDate.'</div>';
                })
                ->editColumn('Allowance', function($data) {
                    return '<div class="text-center">'.$data->Allowance.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['id','StartDate','EndDate','Allowance','action'])
                ->make(true);
        }

        $report = DB::select('SELECT mobilization_plans.id, mobilization_plans.project_id, employees.ThaiName, mobilization_plans.StartDate, mobilization_plans.EndDate, mobilization_plans.Remark
            FROM employees INNER JOIN mobilization_plans ON employees.id = mobilization_plans.employee_id
            WHERE (((mobilization_plans.project_id)='.$id.'))
            ORDER BY employees.ThaiName, mobilization_plans.StartDate, mobilization_plans.EndDate');

        return view('mobilizationplans.project',compact('project','pmorder','department','employee','report'));
    }

    public function projectstore(Request $request)
    {
        $rules = array(
            'employee_id'=>'required',
            'StartDate'=>'required',
            'EndDate'=>'required|after_or_equal:StartDate'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id,
            'project_id' => $request->project_id,
            'StartDate' => $request->StartDate,
            'EndDate' => $request->EndDate,
            'Allowance' => $request->Allowance,
            'Remark' => $request->Remark
        );

        MobilizationPlan::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function projectedit($id)
    {
        if(request()->ajax())
        {
            $data = MobilizationPlan::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function projectupdate(Request $request, MobilizationPlan $id)
    {
        $rules = array(
            'employee_id'=>'required',
            'StartDate'=>'required',
            'EndDate'=>'required|after_or_equal:StartDate'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id,
            'project_id' => $request->project_id,
            'StartDate' => $request->StartDate,
            'EndDate' => $request->EndDate,
            'Allowance' => $request->Allowance,
            'Remark' => $request->Remark
        );

        MobilizationPlan::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function projectdestroy($id)
    {
        $data = MobilizationPlan::findOrFail($id);
        $data->delete();
    }

    public function resource(Request $request)
    {
        if($request->ajax())
    	{
            $data = DB::select('SELECT employees.id, departments.Section, Concat(employees.WorkId," - ",employees.ThaiName) AS title
                FROM departments INNER JOIN employees ON departments.id = employees.department_id
                WHERE (((departments.Department)="กฟนม-ธ."))
                ORDER BY departments.Section, Concat(employees.WorkId," - ",employees.ThaiName)');

            return response()->json($data);
    	}
    }

    public function report(Request $request)
    {
        $startdate = $request->get('startDate');
        $enddate = $request->get('endDate');

        $data = DB::select('SELECT Query5.WorkID, Query5.ThaiName, Query5.Not, Query5.Domestic, Query5.DomesticPlus, Query5.Foreign, Query5.StandBy, Query5.Not+Query5.Domestic+Query5.DomesticPlus+Query5.Foreign+Query5.StandBy AS "Sum"
            FROM (SELECT Query4.id, Query4.WorkID, Query4.ThaiName,
                    MAX(CASE WHEN (Query4.Allowance = "ไม่ได้เบี้ยเลี้ยง") THEN Query4.CountOfDate ELSE 0 END) AS "Not",
                    MAX(CASE WHEN (Query4.Allowance = "เบี้ยเลี้ยงปกติ") THEN Query4.CountOfDate ELSE 0 END) AS "Domestic",
                    MAX(CASE WHEN (Query4.Allowance = "เบี้ยเลี้ยงเหมาจ่าย") THEN Query4.CountOfDate ELSE 0 END) AS "DomesticPlus",
                    MAX(CASE WHEN (Query4.Allowance = "เบี้ยเลี้ยงต่างประเทศ") THEN Query4.CountOfDate ELSE 0 END) AS "Foreign",
                    MAX(CASE WHEN (Query4.Allowance = "Stand By") THEN Query4.CountOfDate ELSE 0 END) AS "StandBy"
                FROM (SELECT Query1.id, Query1.WorkID, Query1.ThaiName, "ไม่ได้เบี้ยเลี้ยง" AS Allowance, IF(ISNULL(Query2.CountOfDate),0,Query2.CountOfDate) AS CountOfDate
                    FROM (SELECT employees.id, employees.WorkID, employees.ThaiName, employees.department_id
                        FROM employees
                        WHERE (((employees.department_id)=1 Or (employees.department_id)=2 Or (employees.department_id)=3 Or (employees.department_id)=4))) Query1
                        LEFT JOIN (SELECT mobilization_plans.employee_id, mobilization_plans.Allowance,
                                Sum(DATEDIFF(
                                    IF(mobilization_plans.EndDate > CAST("'.$enddate.'" AS DATE),
                                        CAST("'.$enddate.'" AS DATE),
                                        mobilization_plans.EndDate
                                    ),
                                    IF(mobilization_plans.StartDate < CAST("'.$startdate.'" AS DATE),
                                        CAST("'.$startdate.'" AS DATE),
                                        mobilization_plans.StartDate
                                    )
                                )+1) AS CountOfDate
                            FROM mobilization_plans
                            GROUP BY mobilization_plans.employee_id, mobilization_plans.Allowance, mobilization_plans.StartDate, mobilization_plans.EndDate
                            HAVING mobilization_plans.Allowance="ไม่ได้เบี้ยเลี้ยง" AND ((mobilization_plans.StartDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE)) OR ((mobilization_plans.EndDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE))))) Query2
                        ON Query1.id = Query2.employee_id
                    UNION
                    SELECT Query1.id, Query1.WorkID, Query1.ThaiName, "เบี้ยเลี้ยงปกติ" AS Allowance, IF(ISNULL(Query2.CountOfDate),0,Query2.CountOfDate) AS CountOfDate
                    FROM (SELECT employees.id, employees.WorkID, employees.ThaiName, employees.department_id
                        FROM employees
                        WHERE (((employees.department_id)=1 Or (employees.department_id)=2 Or (employees.department_id)=3 Or (employees.department_id)=4))) Query1
                        LEFT JOIN (SELECT mobilization_plans.employee_id, mobilization_plans.Allowance,
                                Sum(DATEDIFF(
                                    IF(mobilization_plans.EndDate > CAST("'.$enddate.'" AS DATE),
                                        CAST("'.$enddate.'" AS DATE),
                                        mobilization_plans.EndDate
                                    ),
                                    IF(mobilization_plans.StartDate < CAST("'.$startdate.'" AS DATE),
                                        CAST("'.$startdate.'" AS DATE),
                                        mobilization_plans.StartDate
                                    )
                                )+1) AS CountOfDate
                            FROM mobilization_plans
                            GROUP BY mobilization_plans.employee_id, mobilization_plans.Allowance, mobilization_plans.StartDate, mobilization_plans.EndDate
                            HAVING mobilization_plans.Allowance="เบี้ยเลี้ยงปกติ" AND ((mobilization_plans.StartDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE)) OR ((mobilization_plans.EndDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE))))) Query2
                        ON Query1.id = Query2.employee_id
                    UNION
                    SELECT Query1.id, Query1.WorkID, Query1.ThaiName, "เบี้ยเลี้ยงเหมาจ่าย" AS Allowance, IF(ISNULL(Query2.CountOfDate),0,Query2.CountOfDate) AS CountOfDate
                    FROM (SELECT employees.id, employees.WorkID, employees.ThaiName, employees.department_id
                        FROM employees
                        WHERE (((employees.department_id)=1 Or (employees.department_id)=2 Or (employees.department_id)=3 Or (employees.department_id)=4))) Query1
                        LEFT JOIN (SELECT mobilization_plans.employee_id, mobilization_plans.Allowance,
                                Sum(DATEDIFF(
                                    IF(mobilization_plans.EndDate > CAST("'.$enddate.'" AS DATE),
                                        CAST("'.$enddate.'" AS DATE),
                                        mobilization_plans.EndDate
                                    ),
                                    IF(mobilization_plans.StartDate < CAST("'.$startdate.'" AS DATE),
                                        CAST("'.$startdate.'" AS DATE),
                                        mobilization_plans.StartDate
                                    )
                                )+1) AS CountOfDate
                            FROM mobilization_plans
                            GROUP BY mobilization_plans.employee_id, mobilization_plans.Allowance, mobilization_plans.StartDate, mobilization_plans.EndDate
                            HAVING mobilization_plans.Allowance="เบี้ยเลี้ยงเหมาจ่าย" AND ((mobilization_plans.StartDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE)) OR ((mobilization_plans.EndDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE))))) Query2
                        ON Query1.id = Query2.employee_id
                    UNION
                    SELECT Query1.id, Query1.WorkID, Query1.ThaiName, "เบี้ยเลี้ยงต่างประเทศ" AS Allowance, IF(ISNULL(Query2.CountOfDate),0,Query2.CountOfDate) AS CountOfDate
                    FROM (SELECT employees.id, employees.WorkID, employees.ThaiName, employees.department_id
                        FROM employees
                        WHERE (((employees.department_id)=1 Or (employees.department_id)=2 Or (employees.department_id)=3 Or (employees.department_id)=4))) Query1
                        LEFT JOIN (SELECT mobilization_plans.employee_id, mobilization_plans.Allowance,
                                Sum(DATEDIFF(
                                    IF(mobilization_plans.EndDate > CAST("'.$enddate.'" AS DATE),
                                        CAST("'.$enddate.'" AS DATE),
                                        mobilization_plans.EndDate
                                    ),
                                    IF(mobilization_plans.StartDate < CAST("'.$startdate.'" AS DATE),
                                        CAST("'.$startdate.'" AS DATE),
                                        mobilization_plans.StartDate
                                    )
                                )+1) AS CountOfDate
                            FROM mobilization_plans
                            GROUP BY mobilization_plans.employee_id, mobilization_plans.Allowance, mobilization_plans.StartDate, mobilization_plans.EndDate
                            HAVING mobilization_plans.Allowance="เบี้ยเลี้ยงต่างประเทศ" AND ((mobilization_plans.StartDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE)) OR ((mobilization_plans.EndDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE))))) Query2
                        ON Query1.id = Query2.employee_id
                    UNION
                    SELECT Query1.id, Query1.WorkID, Query1.ThaiName, "Stand By" AS Allowance, IF(ISNULL(Query3.CountOfDate),0,Query3.CountOfDate) AS CountOfDate
                    FROM (SELECT employees.id, employees.WorkID, employees.ThaiName, employees.department_id
                        FROM employees
                        WHERE (((employees.department_id)=1 Or (employees.department_id)=2 Or (employees.department_id)=3 Or (employees.department_id)=4))) Query1
                        LEFT JOIN (SELECT mobilization_plans.employee_id, "Stand By" AS Allowance,
                                Sum(DATEDIFF(
                                    IF(mobilization_plans.EndDate > CAST("'.$enddate.'" AS DATE),
                                        CAST("'.$enddate.'" AS DATE),
                                        mobilization_plans.EndDate
                                    ),
                                    IF(mobilization_plans.StartDate < CAST("'.$startdate.'" AS DATE),
                                        CAST("'.$startdate.'" AS DATE),
                                        mobilization_plans.StartDate
                                    )
                                )+1) AS CountOfDate
                            FROM mobilization_plans
                            GROUP BY mobilization_plans.employee_id, mobilization_plans.StartDate, mobilization_plans.EndDate, mobilization_plans.project_id, mobilization_plans.Remark
                            HAVING (mobilization_plans.StartDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE) OR mobilization_plans.EndDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE)) AND ISNULL(mobilization_plans.project_id) AND mobilization_plans.Remark="Stand By") AS Query3
                        ON Query1.id = Query3.employee_id) AS Query4
                GROUP BY Query4.id, Query4.WorkID, Query4.ThaiName) AS Query5
            ORDER BY Query5.Not+Query5.Domestic+Query5.DomesticPlus+Query5.Foreign+Query5.StandBy DESC');

        /*$test = DB::select('SELECT mobilization_plans.employee_id, "Stand By" AS Allowance,
                Sum(DATEDIFF(
                    IF(mobilization_plans.EndDate > CAST("'.$enddate.'" AS DATE),
                        CAST("'.$enddate.'" AS DATE),
                        mobilization_plans.EndDate
                    ),
                    IF(mobilization_plans.StartDate < CAST("'.$startdate.'" AS DATE),
                        CAST("'.$startdate.'" AS DATE),
                        mobilization_plans.StartDate
                    )
                )+1) AS CountOfDate
            FROM mobilization_plans
            WHERE (mobilization_plans.StartDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE) OR mobilization_plans.EndDate BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE)) AND ISNULL(mobilization_plans.project_id) AND mobilization_plans.Remark="Stand By"
            GROUP BY employee_id, Allowance');
        dd($test);*/

        return view('mobilizationplans.report',compact('data','startdate','enddate'));
    }

    public function calendar(Request $request)
    {
        if($request->ajax())
    	{
            $data = DB::select('SELECT mobilization_plans.employee_id AS resourceId, mobilization_plans.StartDate AS "start", DATE_ADD(mobilization_plans.EndDate, INTERVAL 1 DAY) AS "end", projects.ProjectName AS title, projects.color, CONCAT("ID ",mobilization_plans.id,IF(ISNULL(mobilization_plans.Remark),"",CONCAT(" - ",mobilization_plans.Remark))) AS "description"
                FROM projects INNER JOIN mobilization_plans ON projects.id = mobilization_plans.project_id
                WHERE (((projects.show)="Yes"))
                UNION
                SELECT mobilization_plans.employee_id AS resourceId, mobilization_plans.StartDate AS "start", DATE_ADD(mobilization_plans.EndDate, INTERVAL 1 DAY) AS "end", mobilization_plans.Remark AS title, "" AS color, CONCAT("ID ",mobilization_plans.id," - ",mobilization_plans.Remark) AS "description"
                FROM mobilization_plans
                WHERE (ISNULL(mobilization_plans.project_id))');

            return response()->json($data);
    	}
    }
}
