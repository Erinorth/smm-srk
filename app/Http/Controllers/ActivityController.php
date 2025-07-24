<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Item;
use App\Models\Activity;
use App\Models\Scope;
use App\Models\ScopeActivityStandard;
use DataTables;
use Validator;

class ActivityController extends Controller
{
    public function create($itemid)
    {
        $item = Item::find($itemid);

        $activity = DB::select('SELECT
            activities.id,
            activities.ActivityName,
            activities.item_id,
            activities.Detail
            FROM
            activities
            WHERE
            (((activities.item_id = '.$itemid.')))
            ');

        return view('activities.create',compact('item','activity'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'ActivityName' => 'required'
        ]);

        $activity = new Activity;
        $activity->ActivityName = $request->input('ActivityName');
        $activity->Detail = $request->input('Detail');
        $activity->item_id = $request->input('item_id');

        $activity->save();

        return back()->with('message','Successfully created Activity!');
    }

    public function update(Request $request, $activityid)
    {
        $this->validate($request, [
            'ActivityName' => 'required'
        ]);

        // store
        $activity = Activity::findOrFail($activityid);
        $activity->ActivityName = $request->input('ActivityName');
        $activity->Detail = $request->input('Detail');
        $activity->item_id = $request->input('item_id');
        $activity->save();

        // redirect
        return back()->with('message','Successfully updated Activity!');
    }

    public function destroy($activityid)
    {
        $activity = Activity::findOrFail($activityid);
        $activity->delete();

        return back()->with('message','Successfully deleted the Activity!');
    }

    public function item(Request $request, $id)
    {
        $item = Item::find($id);

        $activity = DB::select('SELECT activities.id, activities.Order
            FROM activities
            WHERE (((activities.item_id = '.$id.')))');
        $standardactivity = DB::select('SELECT items.id, scope_activity_standards.Order, scope_activity_standards.ActivityName
            FROM items INNER JOIN scope_activity_standards ON items.scope_id = scope_activity_standards.scope_id
            WHERE (((items.id)='.$id.'))');

        if($request->ajax())
        {
            $data = DB::select('SELECT activities.id, activities.item_id, activities.Order, activities.ActivityName, activities.Detail
                FROM activities
                WHERE (((activities.item_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('Order', function($data) {
                        return '<div class="text-center">'.$data->Order.'</div>';
                    })
                    ->addColumn('action',function($data){
                        if ( $data->id <> "" )
                        return '<div class="text-center">
                                    <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                    <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                </div>';
                        return '<div class="text-center">Standard</div>';
                    })
                    ->rawColumns(['Order','action'])
                    ->make(true);
        }
        return view('activities.item',compact('item','activity','standardactivity'));
    }

    public function itemstore(Request $request)
    {
        $rules = array(
            'Order'=>'required',
            'ActivityName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $order = $request->Order;
        $orderx = $request->Orderx;
        $idx = $request->idx;
        $count = count($idx);

        for ($i=0; $i < $count; $i++) {
            $activity = Activity::find($idx[$i]);
            if ( $activity->Order >= $order )
            {
                $activity->Order = $orderx[$i]+1;
                $activity->save();
            } else {
                $activity->Order = $orderx[$i];
                $activity->save();
            }
        }

        $form_data = array(
            'Order' => $request->Order,
            'ActivityName' => $request->ActivityName,
            'Detail' => $request->Detail,
            'item_id' => $request->item_id
        );

        Activity::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function itemedit($id)
    {
        if(request()->ajax())
        {
            $data = Activity::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function itemupdate(Request $request, Activity $activityid)
    {
        $rules = array(
            'Order'=>'required',
            'ActivityName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $activity = Activity::find($request->hidden_id);
        $activity->Order = $request->Order;
        $itemid = $activity->item_id;
        $order_new = $activity->Order;
        $order_old = $activity->getOriginal('Order');

        if ( $order_new-$order_old < 0 ) {
            $activities = DB::select('SELECT activities.id, activities.item_id, activities.Order
            FROM activities
            WHERE (((activities.item_id)='.$itemid.') AND ((activities.Order)>='.$order_new.' And (activities.Order)<'.$order_old.'))');
        } else {
            $activities = DB::select('SELECT activities.id, activities.item_id, activities.Order
            FROM activities
            WHERE (((activities.item_id)='.$itemid.') AND ((activities.Order)<='.$order_new.' And (activities.Order)>'.$order_old.'))');
        }
        $count = count($activities);

        foreach ($activities as $key => $value) {
            $idx[] = $value->id;
            $orderx[] = $value->Order;
        }

        for ($i=0; $i < $count; $i++) {
            $activity = Activity::find($idx[$i]);
            if ( $order_new-$order_old < 0 )
            {
                $activity->Order = $orderx[$i]+1;
                $activity->save();
            } else {
                $activity->Order = $orderx[$i]-1;
                $activity->save();
            }
        }

        $form_data = array(
            'Order' => $request->Order,
            'ActivityName' => $request->ActivityName,
            'Detail' => $request->Detail,
            'item_id' => $request->item_id
        );

        Activity::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function itemdestroy($id)
    {
        $data = Activity::findOrFail($id);
        $itemid = $data->item_id;
        $activities = DB::select('SELECT activities.id, activities.item_id, activities.Order
            FROM activities
            WHERE (((activities.item_id)='.$itemid.'))');
        $count = count($activities);

        foreach ($activities as $key => $value) {
            $idx[] = $value->id;
            $orderx[] = $value->Order;
        }

        $order = $data->Order;
        for ($i=0; $i < $count; $i++) {
            $activity = Activity::find($idx[$i]);
            if ( $activity->Order >= $order )
            {
                $activity->Order = $orderx[$i]-1;
                $activity->save();
            } else {
                $activity->Order = $orderx[$i];
                $activity->save();
            }
        }

        $data->delete();
    }

    public function standard(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT scope_activity_standards.id, scopes.ScopeName, scope_activity_standards.Order, scope_activity_standards.ActivityName
                FROM scopes INNER JOIN scope_activity_standards ON scopes.id = scope_activity_standards.scope_id');
            return DataTables::of($data)
                    ->editColumn('Order', function($data) {
                        return '<div class="text-center">'.$data->Order.'</div>';
                    })
                    ->editColumn('ActivityName', function($data) {
                        return '<div class="text-center">'.$data->ActivityName.'</div>';
                    })
                    ->editColumn('ScopeName', function($data) {
                        return '<div class="text-center">'.$data->ScopeName.'</div>';
                    })
                    ->addColumn('action','
                        <td class="text-center">
                            @role('."'admin|head_engineering'".')
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            @else <div class="text-center">N/A</div>
                            @endrole
                        </td>
                    ')
                    ->rawColumns(['Order','ActivityName','ScopeName','action'])
                    ->make(true);
        }

        $scope = Scope::orderBy('ScopeName','asc')->get();

        return view('activities.standard',compact('scope'));
    }

    public function standardstore(Request $request)
    {
        $rules = array(
            'scope_id' =>'required',
            'Order'=>'required',
            'ActivityName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Order' => $request->Order,
            'ActivityName' => $request->ActivityName,
            'scope_id' => $request->scope_id
        );

        ScopeActivityStandard::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function standardedit($id)
    {
        if(request()->ajax())
        {
            $data = ScopeActivityStandard::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function standardupdate(Request $request,ScopeActivityStandard $id)
    {
        $rules = array(
            'scope_id' =>'required',
            'Order'=>'required',
            'ActivityName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Order' => $request->Order,
            'ActivityName' => $request->ActivityName,
            'scope_id' => $request->scope_id
        );

        ScopeActivityStandard::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function standarddestroy($id)
    {
        $data = ScopeActivityStandard::findOrFail($id);
        $data->delete();
    }

    public function itemstandardstore(Request $request)
    {
        $Order = $request->Orders;
        $ActivityName = $request->ActivityName;
        $Detail = $request->Detail;
        $item_id = $request->item_id;
        $count = count($item_id);

        for ($i = 0; $i < $count; $i++){
            $activity = new Activity();
            $activity->Order = $Order[$i];
            $activity->ActivityName = $ActivityName[$i];
            $activity->Detail = $Detail[$i];
            $activity->item_id = $item_id[$i];
            $activity->save();
        }

        return back()->with('message','Successfully created Mile Stone!');
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
                            <a href="'. url('item_hazards/{{$item_id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        return view('consumables.project',compact('project'));
    }

    public function amount(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id, Count(item_hazards.hazard_id) AS CountOfhazard_id
                FROM ((locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) LEFT JOIN item_hazards ON items.id = item_hazards.item_id
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
                ->editColumn('CountOfhazard_id', function($data) {
                    return '<div class="text-center">'.$data->CountOfconsumable_id.'</div>';
                })
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','CountOfhazard_id'])
                ->make(true);
        }
    }
}
