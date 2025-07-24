<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;
use App\Models\Location;
use App\Models\Machine;
use App\Models\System;
use App\Models\Equipment;
use App\Models\Scope;
use App\Models\Item;
use App\Models\ItemSet;
use App\Models\MachineSet;
use DataTables;
use Validator;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT machine_sets.id, locations.LocationName, machines.MachineName, machine_sets.Remark
                FROM locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id');
            return DataTables::of($data)
                ->editColumn('LocationName', function($data) {
                    return '<div class="text-center">'.$data->LocationName.'</div>';
                })
                ->editColumn('MachineName', function($data) {
                    return '<div class="text-center">'.$data->MachineName.'//'.$data->Remark.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <a href="'. url('items_select/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                    </div>
                ')
                ->rawColumns(['LocationName','MachineName','action'])
                ->make(true);
        }

        $location = Location::orderBy('LocationName','asc')->get();
        $machine = Machine::orderBy('MachineName','asc')->get();

        return view('items.index',compact('location','machine'));
    }

    public function select(Request $request, $id)
    {
        $machineset = MachineSet::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT items.id, products.ProductName, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, items.SpecificName, items.machine_set_id
                FROM scopes INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN items ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON scopes.id = items.scope_id
                WHERE (((items.machine_set_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('id', function($data) {
                        $item = '<div class="d-none">'.$data->id.'</div><div class="text-center"><a href="/items/'.$data->id.'">'.$data->id.'</a></div>';
                        return $item;
                    })
                    ->editColumn('ProductName', function($data) {
                        return '<div class="text-center">'.$data->ProductName.'</div>';
                    })
                    ->editColumn('SystemName', function($data) {
                        return '<div class="text-center">'.$data->SystemName.'</div>';
                    })
                    ->editColumn('EquipmentName', function($data) {
                        return '<div class="text-center">'.$data->EquipmentName.'</div>';
                    })
                    ->editColumn('SpecificName', function($data) {
                        return '<div class="text-center">'.$data->SpecificName.'</div>';
                    })
                    ->editColumn('ScopeName', function($data) {
                        return '<div class="text-center">'.$data->ScopeName.'</div>';
                    })
                    ->addColumn('action','
                        @role('."'admin|head_engineering|planner'".')
                            <div class="text-center">
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>
                        @else <div class="text-center">N/A</div>
                        @endrole
                    ')
                    ->rawColumns(['id','ProductName','SystemName','EquipmentName','SpecificName','ScopeName','action'])
                    ->make(true);
        }

        $product = Product::orderBy('ProductName','asc')->get();
        $system = System::orderBy('SystemName','asc')->get();
        $equipment = Equipment::orderBy('EquipmentName','asc')->get();

        $scope = Scope::orderBy('ScopeName','asc')->get();
        $itemset = DB::select('SELECT item_sets.id, products.ProductName, systems.SystemName, equipment.EquipmentName
            FROM equipment INNER JOIN (systems INNER JOIN (products INNER JOIN item_sets ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id
            GROUP BY item_sets.id, products.ProductName, systems.SystemName, equipment.EquipmentName
            ORDER BY products.ProductName, systems.SystemName, equipment.EquipmentName');

        return view('items.select',compact('product','system','equipment','machineset','itemset','scope'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'machine_set_id'=>'required',
            'item_set_id'=>'required',
            'SpecificName'=>'required',
            'scope_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'machine_set_id' => $request->machine_set_id,
            'item_set_id' => $request->item_set_id,
            'scope_id' => $request->scope_id,
            'SpecificName' => $request->SpecificName
        );

        Item::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function show($itemid)
    {
        $item = Item::find($itemid);
        $activity = DB::select('SELECT activities.id, activities.item_id, activities.Order, activities.ActivityName, activities.Detail
            FROM activities
            WHERE (((activities.item_id)='.$itemid.'))
            ORDER BY activities.Order');

        return view('items.show',compact('item','activity'));
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Item::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Item $item)
    {
        $rules = array(
            'machine_set_id'=>'required',
            'item_set_id'=>'required',
            'SpecificName'=>'required',
            'scope_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'machine_set_id' => $request->machine_set_id,
            'item_set_id' => $request->item_set_id,
            'scope_id' => $request->scope_id,
            'SpecificName' => $request->SpecificName
        );

        Item::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Item::findOrFail($id);
        $data->delete();
    }

    public function set(Request $request)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE itemset AS (
                SELECT item_sets.id, products.ProductName, systems.SystemName, equipment.EquipmentName
                FROM equipment INNER JOIN (systems INNER JOIN (products INNER JOIN item_sets ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::table('itemset')->get();
            $productfilter = $data -> sortby('ProductName') -> pluck('ProductName') -> unique();
            $systemfilter = $data -> sortby('SystemName') -> pluck('SystemName') -> unique();
            $equipmentfilter = $data -> sortby('EquipmentName') -> pluck('EquipmentName') -> unique();
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('ProductName', function($data) {
                    return '<div class="text-center">'.$data->ProductName.'</div>';
                })
                ->editColumn('SystemName', function($data) {
                    return '<div class="text-center">'.$data->SystemName.'</div>';
                })
                ->editColumn('EquipmentName', function($data) {
                    return '<div class="text-center">'.$data->EquipmentName.'</div>';
                })
                ->editColumn('EquipmentName', function($data) {
                    return '<div class="text-center">'.$data->EquipmentName.'</div>';
                })
                ->addColumn('action','
                    <td>
                        @role('."'admin|head_engineering'".')
                            <div class="text-center">
                                <button class="edit_item_set btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_item_set btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>
                        @else <div class="text-center">N/A</div>
                        @endrole
                    </td>
                ')
                ->rawColumns(['id','ProductName','SystemName','EquipmentName','action'])
                ->make(true);
        }
    }

    public function setstore(Request $request)
    {
        $rules = array(
            'product_id'=>'required',
            'system_id'=>'required',
            'equipment_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'product_id' => $request->product_id,
            'system_id' => $request->system_id,
            'equipment_id' => $request->equipment_id
        );

        ItemSet::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function setedit($id)
    {
        if(request()->ajax())
        {
            $data = ItemSet::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function setupdate(Request $request, ItemSet $item)
    {
        $rules = array(
            'product_id'=>'required',
            'system_id'=>'required',
            'equipment_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'product_id' => $request->product_id,
            'system_id' => $request->system_id,
            'equipment_id' => $request->equipment_id
        );

        ItemSet::whereId($request->hidden_id_item_set)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function setdestroy($id)
    {
        $data = ItemSet::findOrFail($id);
        $data->delete();
    }

    /* public function locationmachinestore(Request $request)
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
            'machine_id' => $request->machine_id
        );

        MachineSet::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function locationmachineedit($id)
    {
        if(request()->ajax())
        {
            $data = MachineSet::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function locationmachineupdate(Request $request, MachineSet $locationmachine)
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
            'machine_id' => $request->machine_id
        );

        MachineSet::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function locationmachinedestroy($id)
    {
        $data = MachineSet::findOrFail($id);
        $data->delete();
    } */
}
