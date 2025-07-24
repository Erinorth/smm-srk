<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\WorkPermit;
use App\Models\Employee;
use DB;
use DataTables;
use Validator;

class WorkPermitController extends Controller
{
    public function index(Request $request, $id)
    {
        $project = Project::find($id);
        $employee = Employee::orderBy('ThaiName','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT work_permits.id, work_permits.project_id, work_permits.Date, work_permits.HotWork, work_permits.ConfinedSpace, employees.ThaiName, work_permits.Chemical, work_permits.Lifting, work_permits.Scaffloding, work_permits.Electrical, work_permits.HighVoltage, work_permits.Drilling, work_permits.Radio, work_permits.Diving, work_permits.Other, work_permits.Attachment
                FROM employees
                INNER JOIN work_permits
                ON employees.id = work_permits.Requester
                WHERE work_permits.project_id='.$id.'');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('Date', function($data) {
                    return '<div class="text-center">'.$data->Date.'</div>';
                })
                ->editColumn('CriticalJob', function($data) {
                    return view('workpermits.criticaljob',compact('data'));
                })
                ->editColumn('ThaiName', function($data) {
                    return '<div class="text-center">'.$data->ThaiName.'</div>';
                })
                ->addColumn('action', function($data) {
                    if ( $data->Attachment == "" ) {
                        return '
                        <div class="text-center">
                            <a href = "'.url('work_permit/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            [Attachment<button class="attachment btn btn-xs btn-default text-success mx-1 shadow" name="attachment" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>]
                        </div>';
                    } else {
                        return '
                        <div class="text-center">
                            <a href = "'.url('work_permit/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            [Attachment<a href="'. url('storage/project'.$data->project_id.'/work_permit/'.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                            <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete_attachment btn btn-xs btn-default text-danger mx-1 shadow" name="attachment" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>]
                        </div>';
                    }
                })
                ->rawColumns(['id','Date','CriticalJob','ThaiName','action'])
                ->make(true);
        }

        return view('workpermits.index',compact('project','employee'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'Date'=>'required',
            'Requester'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'Date' => $request->Date,
            'HotWork' => $request->HotWork,
            'ConfinedSpace' => $request->ConfinedSpace,
            'Chemical' => $request->Chemical,
            'Lifting' => $request->Lifting,
            'Scaffloding' => $request->Scaffloding,
            'Electrical' => $request->Electrical,
            'HighVoltage' => $request->HighVoltage,
            'Drilling' => $request->Drilling,
            'Radio' => $request->Radio,
            'Diving' => $request->Diving,
            'Other' => $request->Other,
            'Requester' => $request->Requester
        );

        WorkPermit::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = WorkPermit::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, WorkPermit $id)
    {
        $rules = array(
            'Date'=>'required',
            'Requester'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'Date' => $request->Date,
            'HotWork' => $request->HotWork,
            'ConfinedSpace' => $request->ConfinedSpace,
            'Chemical' => $request->Chemical,
            'Lifting' => $request->Lifting,
            'Scaffloding' => $request->Scaffloding,
            'Electrical' => $request->Electrical,
            'HighVoltage' => $request->HighVoltage,
            'Drilling' => $request->Drilling,
            'Radio' => $request->Radio,
            'Diving' => $request->Diving,
            'Other' => $request->Other,
            'Requester' => $request->Requester
        );

        WorkPermit::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = WorkPermit::findOrFail($id);
        $data->delete();
    }
}
