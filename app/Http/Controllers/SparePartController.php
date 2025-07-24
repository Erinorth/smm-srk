<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparePart;
use DB;
use DataTables;
use Validator;
use App\Models\Item;
use App\Models\ItemSparePart;
use App\Models\Project;

class SparePartController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax())
        {
            $data = SparePart::orderBy('SparePartName','asc')->get();
            return DataTables::of($data)
                    ->editColumn('Unit', function($data) {
                        return '<div class="text-center">'.$data->Unit.'</div>';
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            @role('."'admin|head_engineering|planner|site_engineer'".')
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            @else <div class="text-center">N/A</div>
                            @endrole
                        </div>
                    ')
                    ->rawColumns(['Unit','action'])
                    ->make(true);
        }

        return view('spareparts.index');
    }

    public function create()
    {
        return view('spareparts.create');
    }

    public function store(Request $request)
    {
        $rules = array(
            'SparePartName'=>'required',
            'Unit'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'SparePartName' => $request->SparePartName,
            'Detail' => $request->Detail,
            'Unit' => $request->Unit,
        );

        SparePart::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = SparePart::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, SparePart $sparepartid)
    {
        $rules = array(
            'SparePartName'=>'required',
            'Unit'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'SparePartName' => $request->SparePartName,
            'Detail' => $request->Detail,
            'Unit' => $request->Unit,
        );

        SparePart::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function destroy($id)
    {
        $data = SparePart::findOrFail($id);
        $data->delete();
    }

    public function itemcreate(Request $request, $id)
    {
        $item = Item::find($id);

        $sparepart = SparePart::orderBy('SparePartName','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT item_spare_parts.id, item_spare_parts.item_id, spare_parts.SparePartName, spare_parts.Detail, item_spare_parts.Quantity, spare_parts.Unit
                FROM item_spare_parts INNER JOIN spare_parts ON item_spare_parts.spare_part_id = spare_parts.id
                WHERE (((item_spare_parts.item_id)='.$id.'))
                ORDER BY spare_parts.SparePartName');
            return DataTables::of($data)
                ->editColumn('Quantity', function($data) {
                    return '<div class="text-center">'.$data->Quantity.'</div>';
                })
                ->editColumn('Unit', function($data) {
                    return '<div class="text-center">'.$data->Unit.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['Quantity','Unit','action'])
                ->make(true);
        }
        return view('spareparts.itemcreate',compact('item','sparepart'));
    }

    public function itemstore(Request $request)
    {
        $rules = array(
            'spare_part_id'=>'required',
            'Quantity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'spare_part_id' => $request->spare_part_id,
            'Quantity' => $request->Quantity,
            'item_id' => $request->item_id
        );

        ItemSparePart::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function itemedit($id)
    {
        if(request()->ajax())
        {
            $data = ItemSparePart::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function itemupdate(Request $request, ItemSparePart $itemsparepartid)
    {
        $rules = array(
            'spare_part_id'=>'required',
            'Quantity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'spare_part_id' => $request->spare_part_id,
            'Quantity' => $request->Quantity,
            'item_id' => $request->item_id
        );

        ItemSparePart::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function itemdestroy($id)
    {
        $data = ItemSparePart::findOrFail($id);
        $data->delete();
    }

    public function project(Request $request, $id)
    {
        $project = Project::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, jobs.item_id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id
                FROM (locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id
                WHERE (((jobs.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('LocationName', function($data) {
                    return '<div class="text-center">'.$data->LocationName.'</div>';
                })
                ->editColumn('ProductName', function($data) {
                    return '<div class="text-center">'.$data->ProductName.'</div>';
                })
                ->editColumn('MachineName', function($data) {
                    if ( $data->MachineNameDetail == "" ) {
                        return '<div class="text-center">'.$data->MachineName.'</div>';
                    } else {
                        return '<div class="text-center">'.$data->MachineName.'//'.$data->MachineNameDetail.'</div>';
                    }
                })
                ->editColumn('SystemName', function($data) {
                    return '<div class="text-center">'.$data->SystemName.'</div>';
                })
                ->editColumn('EquipmentName', function($data) {
                    return '<div class="text-center">'.$data->EquipmentName.'('.$data->SpecificName.')</div>';
                })
                ->editColumn('ScopeName', function($data) {
                    return '<div class="text-center">'.$data->ScopeName.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        @role('."'admin|head_engineering|head_operation|supervisor|foreman|skill|site_engineer'".')
                            <a href="'. url('item_spareparts/{{$item_id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        return view('spareparts.project',compact('project'));
    }

    public function amount(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id, Count(item_spare_parts.id) AS CountOfid
                FROM ((locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) LEFT JOIN item_spare_parts ON items.id = item_spare_parts.item_id
                GROUP BY jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id
                HAVING (((jobs.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('LocationName', function($data) {
                    return '<div class="text-center">'.$data->LocationName.'</div>';
                })
                ->editColumn('ProductName', function($data) {
                    return '<div class="text-center">'.$data->ProductName.'</div>';
                })
                ->editColumn('MachineName', function($data) {
                    if ( $data->MachineNameDetail == "" ) {
                        return '<div class="text-center">'.$data->MachineName.'</div>';
                    } else {
                        return '<div class="text-center">'.$data->MachineName.'//'.$data->MachineNameDetail.'</div>';
                    }
                })
                ->editColumn('SystemName', function($data) {
                    return '<div class="text-center">'.$data->SystemName.'</div>';
                })
                ->editColumn('EquipmentName', function($data) {
                    return '<div class="text-center">'.$data->EquipmentName.'('.$data->SpecificName.')</div>';
                })
                ->editColumn('ScopeName', function($data) {
                    return '<div class="text-center">'.$data->ScopeName.'</div>';
                })
                ->editColumn('CountOfid', function($data) {
                    return '<div class="text-center">'.$data->CountOfid.'</div>';
                })
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','CountOfid'])
                ->make(true);
        }
    }
}
