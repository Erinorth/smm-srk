<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\OTFrame;
use DB;
use DataTables;
use Validator;
use App\Models\Project;
use App\Models\SupportMan;
use App\Models\SupportRequest;
use Illuminate\Http\Request;

class SupportRequestController extends Controller
{
    public function man(Request $request, $id)
    {
        $support_request = SupportRequest::find($id);
        $department = Department::orderBy('Business','asc')
            ->orderBy('Division','asc')
            ->orderBy('Department','asc')
            ->orderBy('Section','asc')
            ->get();

        $employee = DB::select('SELECT employees.id, employees.ThaiName
            FROM employees
            JOIN support_requests
            WHERE employees.department_id = support_requests.department_id AND support_requests.id = '.$id.'
            ORDER BY employees.ThaiName');

        if($request->ajax())
        {
            $data = DB::select('SELECT support_men.id, employees.ThaiName, support_men.OT, support_men.StartDate, support_men.Remark
                FROM support_men
                INNER JOIN employees
                ON support_men.employee_id = employees.id
                WHERE support_men.support_request_id = '.$id.'');
            return DataTables::of($data)
                ->editColumn('OT', function($data) {
                    return '<div class="text-center">'.$data->OT.'</div>';
                })
                ->editColumn('StartDate', function($data) {
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['OT','StartDate','action'])
                ->make(true);
        }

        return view('supports.man',compact('support_request','employee','department'));
    }

    public function manstore(Request $request)
    {
        $rules = array(
            'employee_id'=>'required',
            'OT'=>'required',
            'StartDate'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id,
            'department_id' => $request->department_id2,
            'OT' => $request->OT,
            'StartDate' => $request->StartDate,
            'support_request_id' => $request->support_request_id,
            'Remark' => $request->Remark,
        );

        SupportMan::create($form_data);

        $projectid = $request->project_id;

        $currentotframe = DB::select('SELECT employee_id, YEAR(PlanDate) AS Year, MONTH(PlanDate) AS Month
            FROM plan_o_t_s
            WHERE project_id = '.$projectid.'
            GROUP BY employee_id, YEAR(PlanDate), MONTH(PlanDate)');

        foreach ($currentotframe as $key => $value) {
            $count = OTFrame::where('employee_id','=',$value->employee_id)
                ->where('Year','=',$value->Year)
                ->where('Month','=',$value->Month)
                ->count();

            if($count == 0){
                $otframe = new OTFrame();
                $otframe->employee_id = $value->employee_id;
                $otframe->Year = $value->Year;
                $otframe->Month = $value->Month;
                $otframe->Frame = 0;
                $otframe->save();
            }
        }

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function manedit($id)
    {
        if(request()->ajax())
        {
            $data = SupportMan::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function manupdate(Request $request)
    {
        $rules = array(
            'employee_id'=>'required',
            'OT'=>'required',
            'StartDate'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id,
            'department_id' => $request->department_id2,
            'OT' => $request->OT,
            'StartDate' => $request->StartDate,
            'support_request_id' => $request->support_request_id,
            'Remark' => $request->Remark,
        );

        SupportMan::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function mandestroy($id)
    {
        $data = SupportMan::findOrFail($id);
        $data->delete();
    }

    public function manemployee(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT employees.id, employees.WorkID, employees.ThaiName, departments.DepartmentName
                FROM departments INNER JOIN employees ON departments.id = employees.department_id');
            return DataTables::of($data)
                ->editColumn('WorkID', function($data) {
                    return '<div class="text-center">'.$data->WorkID.'</div>';
                })
                ->editColumn('DepartmentName', function($data) {
                    return '<div class="text-center">'.$data->DepartmentName.'</div>';
                })
                ->addColumn('action',function($data){
                    return '
                    <div class="text-center">
                        <button class="edit_employee btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    </div>';
                })
                ->rawColumns(['id','WorkID','Position','EGATEmail','DepartmentName','Admin','Telephone','action'])
                ->make(true);
        }
    }

    public function manemployeeupdate(Request $request)
    {
        $rules = array(
            'department_id'=>'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'department_id' => $request->department_id
        );

        Employee::whereId($request->hidden_id_employee)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function request(Request $request, $id)
    {
        $project = Project::find($id);
        $department = Department::orderBy('DepartmentName')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT support_requests.id, support_requests.AtSite, support_requests.Amount, support_requests.Type, support_requests.Remark, departments.DepartmentName, IFNULL(t.CountMen,0) AS CountMen
                FROM support_requests
                INNER JOIN departments
                ON support_requests.department_id = departments.id
                LEFT JOIN (SELECT support_request_id, COUNT(support_request_id) AS CountMen
                    FROM support_men
                    GROUP BY support_request_id) t
                ON support_requests.id = t.support_request_id
                WHERE support_requests.project_id = '.$id.'');
            return DataTables::of($data)
                ->editColumn('AtSite', function($data) {
                    return '<div class="text-center">'.$data->AtSite.'</div>';
                })
                ->editColumn('DepartmentName', function($data) {
                    return '<div class="text-center">'.$data->DepartmentName.'</div>';
                })
                ->editColumn('Amount', function($data) {
                    return '<div class="text-center">'.$data->Amount.'</div>';
                })
                ->editColumn('Type', function($data) {
                    return '<div class="text-center">'.$data->Type.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <a class="btn btn-info btn-sm" href="'. url('support_man/{{$id}}').'">Confirmed ( {{$CountMen}} )</a>
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['AtSite','DepartmentName','Amount','Type','action'])
                ->make(true);
        }

        return view('supports.request',compact('project','department'));
    }

    public function requeststore(Request $request)
    {
        $rules = array(
            'AtSite'=>'required',
            'department_id'=>'required',
            'Amount'=>'required',
            'Type'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'AtSite' => $request->AtSite,
            'department_id' => $request->department_id,
            'Amount' => $request->Amount,
            'Type' => $request->Type,
            'project_id' => $request->project_id,
            'Remark' => $request->Remark,
        );

        SupportRequest::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function requestedit($id)
    {
        if(request()->ajax())
        {
            $data = SupportRequest::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function requestupdate(Request $request)
    {
        $rules = array(
            'AtSite'=>'required',
            'department_id'=>'required',
            'Amount'=>'required',
            'Type'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'AtSite' => $request->AtSite,
            'department_id' => $request->department_id,
            'Amount' => $request->Amount,
            'Type' => $request->Type,
            'project_id' => $request->project_id,
            'Remark' => $request->Remark,
        );

        SupportRequest::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function requestdestroy($id)
    {
        $data = SupportRequest::findOrFail($id);
        $data->delete();
    }
}
