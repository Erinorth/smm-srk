<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Participation;
use App\Models\Employee;
use DB;
use DataTables;
use Validator;

class ParticipationController extends Controller
{
    public function index(Request $request, $id)
    {
        $project = Project::find($id);

        $employee = Employee::orderBy('ThaiName','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT participations.id, participations.project_id, participations.Date, participations.Form, employees.ThaiName, participations.Attachment
                FROM employees INNER JOIN participations ON employees.id = participations.Foreman
                WHERE (((participations.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('Date', function($data) {
                    return '<div class="text-center">'.$data->Date.'</div>';
                })
                ->editColumn('ThaiName', function($data) {
                    return '<div class="text-center">'.$data->ThaiName.'</div>';
                })
                ->addColumn('action', function($data) {
                    if ( $data->Form == "แบบฟอร์มการลงชื่อรับทราบ" ) {
                        if ( $data->Attachment == "" ) {
                            return '<div class="text-center">
                                <a href = "'.url('participation1/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                [Attachment<button class="attachment btn btn-xs btn-default text-success mx-1 shadow" name="attachment" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>]
                            </div>';
                        } else {
                            return '
                            <div class="text-center">
                                <a href = "'.url('participation1/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                [Attachment<a href="'. url('storage/project'.$data->project_id.'/participation/'.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_attachment btn btn-xs btn-default text-danger mx-1 shadow" name="attachment" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>]
                            </div>';
                        }
                    } else {
                        if ( $data->Attachment == "" ) {
                            return '<div class="text-center">
                                <a href= "'.url('participation2/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                [Attachment<button class="attachment btn btn-xs btn-default text-success mx-1 shadow" name="attachment" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>]
                            </div>';
                        } else {
                            return '
                            <div class="text-center">
                                <a href= "'.url('participation2/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                [Attachment<a href="'. url('storage/project'.$data->project_id.'/participation/'.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_attachment btn btn-xs btn-default text-danger mx-1 shadow" name="attachment" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>]
                            </div>';
                        }
                    }
                })
                ->rawColumns(['id','Date','ThaiName','action'])
                ->make(true);
        }

        return view('participations.index',compact('project','employee'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'Date'=>'required',
            'Form'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'Date' => $request->Date,
            'Form' => $request->Form,
            'Foreman' => $request->Foreman
        );

        Participation::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Participation::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Participation $id)
    {
        $rules = array(
            'Date'=>'required',
            'Form'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'Date' => $request->Date,
            'Form' => $request->Form,
            'Foreman' => $request->Foreman
        );

        Participation::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Participation::findOrFail($id);
        $data->delete();
    }
}
