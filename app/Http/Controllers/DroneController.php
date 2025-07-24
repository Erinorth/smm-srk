<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Project;
use App\Models\Drone;

class DroneController extends Controller
{
    public function create(Request $request, $id)
    {
        $project = Project::find($id);

        $header = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, employees.ThaiName AS PlannerName, employees_1.ThaiName AS SiteEngineerName, employees_2.ThaiName AS AreaManagerName, projects.Status
            FROM employees AS employees_2 RIGHT JOIN (employees AS employees_1 RIGHT JOIN (employees RIGHT JOIN projects ON employees.id = projects.Planner) ON employees_1.id = projects.SiteEngineer) ON employees_2.id = projects.AreaManager
            WHERE (((projects.id)='.$id.'))');

        if($request->ajax())
        {
            $data = DB::select('SELECT drones.id, drones.project_id, drones.CompanyName, drones.WorkingArea, drones.JobName, drones.Amount, drones.PlanedDate, drones.Reference, drones.Applicant, drones.Supervisor, drones.created_at
                FROM drones
                WHERE (((drones.project_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('created_at',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->created_at.'</div>';
                        return '<div class="text-center">'.$data->created_at.'</div>';
                    })
                    ->editColumn('CompanyName',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->CompanyName.'</div>';
                        return '<div class="text-center">'.$data->CompanyName.'</div>';
                    })
                    ->editColumn('WorkingArea',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-danger">'.$data->WorkingArea.'</div>';
                        return $data->WorkingArea;
                    })
                    ->editColumn('JobName',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-danger">'.$data->JobName.'</div>';
                        return $data->JobName;
                    })
                    ->editColumn('Amount',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->Amount.'</div>';
                        return '<div class="text-center">'.$data->Amount.'</div>';
                    })
                    ->editColumn('PlanedDate',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->PlanedDate.'</div>';
                        return '<div class="text-center">'.$data->PlanedDate.'</div>';
                    })
                    ->editColumn('Reference',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-danger">'.$data->Reference.'</div>';
                        return $data->Reference;
                    })
                    ->editColumn('Applicant',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->Applicant.'</div>';
                        return '<div class="text-center">'.$data->Applicant.'</div>';
                    })
                    ->editColumn('Supervisor',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->Supervisor.'</div>';
                        return '<div class="text-center">'.$data->Supervisor.'</div>';
                    })
                    ->addColumn('action','
                        <a class="btnprn btn btn-info btn-sm" href="'.url('drone/{{$id}}').'" >Print</a>
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    ')
                    ->rawColumns(['created_at','CompanyName','WorkingArea','JobName','Amount','PlanedDate','Reference','Applicant','Supervisor','action'])
                    ->make(true);
        }

        return view('drones.create',compact('project','header'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'CompanyName'=>'required',
            'WorkingArea'=>'required',
            'JobName'=>'required',
            'Amount'=>'required',
            'PlanedDate'=>'required',
            'Reference'=>'required',
            'Applicant'=>'required',
            'Supervisor'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'CompanyName' => $request->CompanyName,
            'WorkingArea' => $request->WorkingArea,
            'JobName' => $request->JobName,
            'Amount' => $request->Amount,
            'PlanedDate' => $request->PlanedDate,
            'Reference' => $request->Reference,
            'Applicant' => $request->Applicant,
            'Supervisor' => $request->Supervisor,
            'project_id' => $request->project_id
        );

        Drone::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Drone::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Drone $droneid)
    {
        $rules = array(
            'CompanyName'=>'required',
            'WorkingArea'=>'required',
            'JobName'=>'required',
            'Amount'=>'required',
            'PlanedDate'=>'required',
            'Reference'=>'required',
            'Applicant'=>'required',
            'Supervisor'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'CompanyName' => $request->CompanyName,
            'WorkingArea' => $request->WorkingArea,
            'JobName' => $request->JobName,
            'Amount' => $request->Amount,
            'PlanedDate' => $request->PlanedDate,
            'Reference' => $request->Reference,
            'Applicant' => $request->Applicant,
            'Supervisor' => $request->Supervisor,
            'project_id' => $request->project_id
        );

        Drone::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Drone::findOrFail($id);
        $data->delete();
    }
}
