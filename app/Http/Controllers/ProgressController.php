<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Project;
use App\Chart;
use DataTables;
use DB;
use Validator;
use App\Imports\ProgressImport;

class ProgressController extends Controller
{
    public function create(Request $request, $id)
    {
        $project = Project::find($id);
        $job = DB::select('SELECT locations.LocationName, machines.MachineName, products.ProductName, systems.SystemName, items.SpecificName, jobs.id, jobs.project_id
            FROM (machines INNER JOIN (locations INNER JOIN (systems INNER JOIN (products INNER JOIN (machine_sets INNER JOIN (item_sets INNER JOIN items ON item_sets.id = items.item_set_id) ON machine_sets.id = items.machine_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) INNER JOIN jobs ON items.id = jobs.item_id
            WHERE (((jobs.project_id)='.$id.'))
            ORDER BY locations.LocationName, machines.MachineName, products.ProductName, systems.SystemName, items.SpecificName');

        if($request->ajax())
        {
            $data = DB::select('SELECT progress.id, progress.job_id, progress.ProgressDate, progress.Plan, progress.Actual, progress.Remark, jobs.project_id
                FROM jobs INNER JOIN progress ON jobs.id = progress.job_id
                WHERE (((jobs.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('ProgressDate', function($data) {
                    return '<div class="text-center">'.$data->ProgressDate.'</div>';
                })
                ->editColumn('job_id', function($data) {
                    return '<div class="text-center">'.$data->job_id.'</div>';
                })
                ->editColumn('Plan', function($data) {
                    return '<div class="text-center">'.$data->Plan.'</div>';
                })
                ->editColumn('Actual', function($data) {
                    return '<div class="text-center">'.$data->Actual.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        @role('."'supervisor|foreman|admin'".')
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        @endrole
                    </div>
                ')
                ->rawColumns(['ProgressDate','job_id','Plan','Actual','action'])
                ->make(true);
        }

        return view('progress.create',compact('project','job'));
    }

    public function progress(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, machines.MachineName, products.ProductName, systems.SystemName, items.SpecificName, scopes.ScopeName, Sum(IFNULL(progress.Plan, 0)) AS SumOfPlan, Sum(IFNULL(progress.Actual,0)) AS SumOfActual, jobs.project_id
                FROM equipment
                INNER JOIN (scopes
                    INNER JOIN (systems
                        INNER JOIN (products
                            INNER JOIN (machines
                                INNER JOIN (locations
                                    INNER JOIN (machine_sets
                                        INNER JOIN (item_sets
                                            INNER JOIN (items
                                                INNER JOIN (jobs
                                                    LEFT JOIN progress
                                                    ON jobs.id = progress.job_id)
                                                ON items.id = jobs.item_id)
                                            ON item_sets.id = items.item_set_id)
                                        ON machine_sets.id = items.machine_set_id)
                                    ON locations.id = machine_sets.location_id)
                                ON machines.id = machine_sets.machine_id)
                            ON products.id = item_sets.product_id)
                        ON systems.id = item_sets.system_id) ON scopes.id = items.scope_id)
                    ON equipment.id = item_sets.equipment_id
                GROUP BY jobs.id, locations.LocationName, machines.MachineName, products.ProductName, systems.SystemName, items.SpecificName, scopes.ScopeName, jobs.project_id
                HAVING (((jobs.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('LocationName', function($data) {
                    return '<div class="text-center">'.$data->LocationName.'</div>';
                })
                ->editColumn('MachineName', function($data) {
                    return '<div class="text-center">'.$data->MachineName.'</div>';
                })
                ->editColumn('ProductName', function($data) {
                    return '<div class="text-center">'.$data->ProductName.'</div>';
                })
                ->editColumn('SystemName', function($data) {
                    return '<div class="text-center">'.$data->SystemName.'</div>';
                })
                ->editColumn('EquipmentName', function($data) {
                    return '<div class="text-center">'.$data->SpecificName.'</div>';
                })
                ->editColumn('ScopeName', function($data) {
                    return '<div class="text-center">'.$data->ScopeName.'</div>';
                })
                ->editColumn('SumOfPlan', function($data) {
                    return '<div class="text-center">'.$data->SumOfPlan.'</div>';
                })
                ->editColumn('SumOfActual', function($data) {
                    return '<div class="text-center">'.$data->SumOfActual.'</div>';
                })
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','SumOfPlan','SumOfActual'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $rules = array(
            'ProgressDate'=>'required',
            'job_id'=>'required',
            'Plan'=>'required',
            'Actual'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ProgressDate' => $request->ProgressDate,
            'job_id' => $request->job_id,
            'Plan' => $request->Plan,
            'Actual' => $request->Actual,
            'Remark' => $request->Remark,
        );

        Progress::create($form_data);

        return response()->json(['success' => 'Man Hour Added successfully.']);
    }

    public function import(Request $request, $id)
    {
        $rules = array(
            'select_file'=>'required|mimes:xls,xlsx'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        try {
            $import = new ProgressImport($id);
            $import->import($request->select_file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            if($failures)
            {
                return response()->json(['failures' => $e->failures()]);
            }
        }

        return response()->json(['success' => 'Progress Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Progress::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request,Progress $id)
    {
        $rules = array(
            'ProgressDate'=>'required',
            'job_id'=>'required',
            'Plan'=>'required',
            'Actual'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ProgressDate' => $request->ProgressDate,
            'job_id' => $request->job_id,
            'Plan' => $request->Plan,
            'Actual' => $request->Actual,
            'Remark' => $request->Remark,
        );

        Progress::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Man Hour is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Progress::findOrFail($id);
        $data->delete();
    }
}
