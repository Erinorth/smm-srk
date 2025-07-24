<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Machine;
use App\Models\MachineSet;
use DB;
use DataTables;
use Validator;

class MachineController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('machines')->get();
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        @role('."'admin|head_engineering'".')
                            <button class="edit_machine btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete_machine btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
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
            'MachineName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'MachineName' => $request->MachineName
        );

        Machine::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Machine::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Machine $machine)
    {
        $rules = array(
            'MachineName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'MachineName' => $request->MachineName
        );

        Machine::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Machine::findOrFail($id);
        $data->delete();
    }

    public function set(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT machine_sets.id, locations.LocationKKS, locations.LocationName, locations.LocationThaiName, machines.MachineName, machine_sets.Remark, machine_sets.SerialNumber
                FROM machines INNER JOIN (locations INNER JOIN machine_sets ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id');
            return DataTables::of($data)
                    ->editColumn('id', function($data) {
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->editColumn('LocationKKS', function($data) {
                        return '<div class="text-center">'.$data->LocationKKS.'</div>';
                    })
                    ->editColumn('LocationName', function($data) {
                        return '<div class="text-center">'.$data->LocationName.'</div>';
                    })
                    ->editColumn('LocationThaiName', function($data) {
                        return '<div class="text-center">'.$data->LocationThaiName.'</div>';
                    })
                    ->editColumn('MachineName', function($data) {
                        return '<div class="text-center">'.$data->MachineName.'</div>';
                    })
                    ->editColumn('SerialNumber', function($data) {
                        return '<div class="text-center">'.$data->SerialNumber.'</div>';
                    })
                    ->addColumn('action','
                        <td class="text-center">
                            @role('."'admin|head_engineering'".')
                                <button class="edit_machine_set btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_machine_set btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            @else <div class="text-center">N/A</div>
                            @endrole
                        </td>
                    ')
                    ->rawColumns(['id','LocationKKS','LocationName','LocationThaiName','SerialNumber','MachineName','action'])
                    ->make(true);
        }
    }

    public function setstore(Request $request)
    {
        $rules = array(
            'location_id'=>'required',
            'machine_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'location_id' => $request->location_id,
            'machine_id' => $request->machine_id,
            'Remark' => $request->Remark,
            'SerialNumber' => $request->SerialNumber
        );

        MachineSet::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function setedit($id)
    {
        if(request()->ajax())
        {
            $data = MachineSet::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function setupdate(Request $request, MachineSet $item)
    {
        $rules = array(
            'location_id'=>'required',
            'machine_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'location_id' => $request->location_id,
            'machine_id' => $request->machine_id,
            'Remark' => $request->Remark,
            'SerialNumber' => $request->SerialNumber
        );

        MachineSet::whereId($request->hidden_id_machine_set)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function setdestroy($id)
    {
        $data = MachineSet::findOrFail($id);
        $data->delete();
    }
}
