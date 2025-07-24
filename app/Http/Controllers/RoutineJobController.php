<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoutineJob;
use Auth;
use DB;
use DataTables;
use Validator;

class RoutineJobController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = RoutineJob::all();
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('KPI', function($data) {
                    return '<div class="text-center">'.$data->KPI.'</div>';
                })
                ->editColumn('Point', function($data) {
                    return '<div class="text-center">'.$data->Point.'</div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <button class="edit_routine btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    <button class="delete_routine btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                </div>'
                )
                ->rawColumns(['id','KPI','Point','action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $rules = array(
            'RoutineJobName'=>'required',
            'KPI'=>'required',
            'Point'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'RoutineJobName' => $request->RoutineJobName,
            'KPI' => $request->KPI,
            'Point' => $request->Point,
        );

        RoutineJob::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = RoutineJob::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request,RoutineJob $toolid)
    {
        $rules = array(
            'RoutineJobName'=>'required',
            'KPI'=>'required',
            'Point'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'RoutineJobName' => $request->RoutineJobName,
            'KPI' => $request->KPI,
            'Point' => $request->Point
        );

        RoutineJob::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function destroy($id)
    {
        $data = RoutineJob::findOrFail($id);
        $data->delete();
    }
}
