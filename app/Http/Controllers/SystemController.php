<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\System;
use DB;
use DataTables;
use Validator;

class SystemController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('systems')->get();
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        @role('."'admin|head_engineering'".')
                            <button class="edit_system btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete_system btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        @else <div class="text-center">N/A</div>
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $rules = array(
            'SystemName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'SystemName' => $request->SystemName
        );

        System::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = System::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, System $system)
    {
        $rules = array(
            'SystemName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'SystemName' => $request->SystemName
        );

        System::whereId($request->hidden_id_system)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = System::findOrFail($id);
        $data->delete();
    }
}
