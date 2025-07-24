<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Project;
use App\Models\Item;
use App\Models\Lifting;

class LiftingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $project = Project::find($id);

        $header = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, employees.ThaiName AS PlannerName, employees_1.ThaiName AS SiteEngineerName, employees_2.ThaiName AS AreaManagerName, projects.Status
            FROM employees AS employees_2 RIGHT JOIN (employees AS employees_1 RIGHT JOIN (employees RIGHT JOIN projects ON employees.id = projects.Planner) ON employees_1.id = projects.SiteEngineer) ON employees_2.id = projects.AreaManager
            WHERE (((projects.id)='.$id.'))');

        if($request->ajax())
        {
            $data = DB::select('SELECT liftings.id, liftings.project_id, liftings.CompanyName, liftings.WorkingArea, liftings.JobName, liftings.Amount, liftings.PlanedDate, liftings.Reference, liftings.Applicant, liftings.Supervisor, liftings.Foreman, liftings.Operator, liftings.created_at, liftings.Attachment
                FROM liftings
                WHERE (((liftings.project_id)='.$id.'))');
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
                    ->addColumn('action', function($data) {
                        if ( $data->Attachment == "" ) {
                            return '
                            <div class="text-center">
                                <a href = "'.url('lifting/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                [Attachment<button class="attachment btn btn-xs btn-default text-success mx-1 shadow" name="attachment" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>]
                            </div>';
                        } else {
                            return '
                            <div class="text-center">
                                <a href = "'.url('lifting/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                [Attachment<a href="'. url('storage/project'.$data->project_id.'/lifting/'.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_attachment btn btn-xs btn-default text-danger mx-1 shadow" name="attachment" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>]
                            </div>';
                        }
                    })
                    ->rawColumns(['created_at','CompanyName','WorkingArea','JobName','Amount','PlanedDate','Reference','Applicant','Supervisor','action'])
                    ->make(true);
        }

        return view('liftings.create',compact('project','header'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'CompanyName'=>'required',
            'WorkingArea'=>'required',
            'JobName'=>'required',
            'Amount'=>'required',
            'PlanedDate'=>'required',
            'Reference'=>'required',
            'Foreman'=>'required',
            'Operator'=>'required',
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
            'Foreman' => $request->Foreman,
            'Operator' => $request->Operator,
            'Applicant' => $request->Applicant,
            'Supervisor' => $request->Supervisor,
            'project_id' => $request->project_id
        );

        Lifting::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Lifting::findOrFail($id);
            return response()->json(['result' => $data]);
        }

        return view('jobs.edit',compact('job','machinesystemdetail','pmorder','cpmorder','work','workdetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lifting $liftingid)
    {
        $rules = array(
            'CompanyName'=>'required',
            'WorkingArea'=>'required',
            'JobName'=>'required',
            'Amount'=>'required',
            'PlanedDate'=>'required',
            'Reference'=>'required',
            'Foreman'=>'required',
            'Operator'=>'required',
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
            'Foreman' => $request->Foreman,
            'Operator' => $request->Operator,
            'Applicant' => $request->Applicant,
            'Supervisor' => $request->Supervisor,
            'project_id' => $request->project_id
        );

        Lifting::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Lifting::findOrFail($id);
        $data->delete();
    }
}
