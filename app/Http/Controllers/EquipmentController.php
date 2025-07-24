<?php

namespace App\Http\Controllers;
use App\Models\Equipment;
use DB;
use DataTables;
use Validator;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('equipment')->get();
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->addColumn('action','
                    <td class="text-center">
                        @role('."'admin|head_engineering'".')
                            <div class="text-center">
                                <button class="edit_equipment btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_equipment btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>
                        @else <div class="text-center">N/A</div>
                        @endrole
                    </td>
                ')
                ->rawColumns(['id','action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $rules = array(
            'EquipmentName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'EquipmentName' => $request->EquipmentName
        );

        Equipment::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Equipment::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Equipment $equipment)
    {
        $rules = array(
            'EquipmentName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'EquipmentName' => $request->EquipmentName
        );

        Equipment::whereId($request->hidden_id_equipment)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Equipment::findOrFail($id);
        $data->delete();
    }
}
