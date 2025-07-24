<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Observation;
use App\Models\Employee;
use DB;
use DataTables;
use Validator;

class ObservationController extends Controller
{
    public function index(Request $request, $id)
    {
        $project = Project::find($id);
        $employee = Employee::orderBy('ThaiName','asc')->get();
        $job = DB::select('SELECT locations.LocationName, machines.MachineName, machine_sets.Remark, products.ProductName, systems.SystemName, items.SpecificName, jobs.id, jobs.project_id, scopes.ScopeName
            FROM scopes INNER JOIN ((machines INNER JOIN (locations INNER JOIN (systems INNER JOIN (products INNER JOIN (machine_sets INNER JOIN (item_sets INNER JOIN items ON item_sets.id = items.item_set_id) ON machine_sets.id = items.machine_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id
            WHERE (((jobs.project_id)='.$id.'))
            ORDER BY locations.LocationName, machines.MachineName, machine_sets.Remark, products.ProductName, systems.SystemName, items.SpecificName');

        if($request->ajax())
        {
            $data = DB::select('SELECT observations.id, observations.job_id, observations.project_id, employees.ThaiName, observations.Date, locations.LocationName, machines.MachineName, machine_sets.Remark, products.ProductName, systems.SystemName, items.SpecificName, scopes.ScopeName, observations.Attachment
                FROM scopes INNER JOIN (systems INNER JOIN (products INNER JOIN (locations INNER JOIN (machines INNER JOIN (machine_sets INNER JOIN (item_sets INNER JOIN (items INNER JOIN (jobs INNER JOIN (employees INNER JOIN observations ON employees.id = observations.Observer) ON jobs.id = observations.job_id) ON items.id = jobs.item_id) ON item_sets.id = items.item_set_id) ON machine_sets.id = items.machine_set_id) ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON scopes.id = items.scope_id
                WHERE (((observations.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('Date', function($data) {
                    return '<div class="text-center">'.$data->Date.'</div>';
                })
                ->editColumn('job', function($data) {
                    return $data->LocationName.'//'.$data->MachineName.'//'.$data->Remark.'//'.$data->ProductName.'//'.$data->SystemName.'//'.$data->SpecificName.'//'.$data->ScopeName.'//'.$data->job_id;
                })
                ->editColumn('ThaiName', function($data) {
                    return '<div class="text-center">'.$data->ThaiName.'</div>';
                })
                ->addColumn('action', function($data) {
                    if ( $data->Attachment == "" ) {
                        return '
                        <div class="text-center">
                            <a href = "'.url('observation/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            [Attachment<button class="attachment btn btn-xs btn-default text-success mx-1 shadow" name="attachment" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>]
                        </div>';
                    } else {
                        return '
                        <div class="text-center">
                            <a href = "'.url('observation/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            [Attachment<a href="'. url('storage/project'.$data->project_id.'/observation/'.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                            <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete_attachment btn btn-xs btn-default text-danger mx-1 shadow" name="attachment" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>]
                        </div>';
                    }
                })
                ->rawColumns(['id','Date','job','ThaiName','action'])
                ->make(true);
        }

        return view('observations.index',compact('project','employee','job'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'Date'=>'required',
            'job_id'=>'required',
            'Observer'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'Date' => $request->Date,
            'job_id' => $request->job_id,
            'Observer' => $request->Observer
        );

        Observation::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Observation::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Observation $id)
    {
        $rules = array(
            'Date'=>'required',
            'job_id'=>'required',
            'Observer'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'Date' => $request->Date,
            'job_id' => $request->job_id,
            'Observer' => $request->Observer
        );

        Observation::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Observation::findOrFail($id);
        $data->delete();
    }
}
