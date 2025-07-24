<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Item;
use App\Models\WorkProcedure;
use App\Models\Project;

class WorkProcedureController extends Controller
{
    public function create(Request $request, $id)
    {
        $item = Item::find($id);

        $activity = DB::select('SELECT activities.id, activities.Order, activities.ActivityName
            FROM activities
            WHERE (((activities.item_id)='.$id.'))
            ORDER BY activities.Order');

        if($request->ajax())
        {
            $data = DB::select('SELECT work_procedures.id, activities.Order AS AOrder, activities.ActivityName, activities.Detail, work_procedures.Order AS POrder, work_procedures.Procedure, work_procedures.ControlledPoint, work_procedures.Class, work_procedures.Man, work_procedures.Hour
                FROM activities LEFT JOIN work_procedures ON activities.id = work_procedures.activity_id
                WHERE (((activities.item_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('AOrder', function($data) {
                        return '<div class="text-center">'.$data->AOrder.'</div>';
                    })
                    ->editColumn('POrder', function($data) {
                        return '<div class="text-center">'.$data->POrder.'</div>';
                    })
                    ->editColumn('ControlledPoint',function($data){
                        return nl2br($data->ControlledPoint);
                    })
                    ->editColumn('Class', function($data) {
                        return '<div class="text-center">'.$data->Class.'</div>';
                    })
                    ->editColumn('Man', function($data) {
                        return '<div class="text-center">'.$data->Man.'</div>';
                    })
                    ->editColumn('Hour', function($data) {
                        return '<div class="text-center">'.$data->Hour.'</div>';
                    })
                    ->addColumn('action',function($data) {
                        if ( $data->id == "")
                        return '<div class="text-center">N/A</div>';
                        return
                        '<div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>';
                    })
                    ->rawColumns(['AOrder','POrder','ControlledPoint','Class','Man','Hour','action'])
                    ->make(true);
        }

        return view('workprocedures.create',compact('item','activity'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'activity_id'=>'required',
            'Order'=>'required',
            'Procedure'=>'required',
            'Class'=>'required',
            'Man'=>'required',
            'Hour'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $activityid = $request->activity_id;
        $order = $request->Order;
        $workprocedures = DB::select('SELECT work_procedures.id, work_procedures.activity_id, work_procedures.Order
            FROM work_procedures
            WHERE (((work_procedures.activity_id)='.$activityid.') AND ((work_procedures.Order)>='.$order.'))');

        foreach ($workprocedures as $key => $value) {
            $idx[] = $value->id;
            $orderx[] = $value->Order;
        }

        for ($i=0; $i < count($workprocedures); $i++) {
            $workprocedure = WorkProcedure::find($idx[$i]);
            $workprocedure->Order = $orderx[$i]+1;
            $workprocedure->save();
        }

        $form_data = array(
            'activity_id' => $request->activity_id,
            'Order' => $request->Order,
            'Procedure' => $request->Procedure,
            'ControlledPoint' => $request->ControlledPoint,
            'Class' => $request->Class,
            'Man' => $request->Man,
            'Hour' => $request->Hour
        );

        WorkProcedure::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = WorkProcedure::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, WorkProcedure $workprocedureid)
    {
        $rules = array(
            'activity_id'=>'required',
            'Order'=>'required',
            'Procedure'=>'required',
            'Class'=>'required',
            'Man'=>'required',
            'Hour'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $workprocedure = WorkProcedure::find($request->hidden_id);
        $workprocedure->Order = $request->Order;
        $activityid = $workprocedure->activity_id;
        $order_new = $workprocedure->Order;
        $order_old = $workprocedure->getOriginal('Order');

        if ( $order_new-$order_old < 0 ) {
            $workprocedures = DB::select('SELECT work_procedures.id, work_procedures.activity_id, work_procedures.Order
            FROM work_procedures
            WHERE (((work_procedures.activity_id)='.$activityid.') AND ((work_procedures.Order)>='.$order_new.' And (work_procedures.Order)<'.$order_old.'))');
        } else {
            $workprocedures = DB::select('SELECT work_procedures.id, work_procedures.activity_id, work_procedures.Order
            FROM work_procedures
            WHERE (((work_procedures.activity_id)='.$activityid.') AND ((work_procedures.Order)<='.$order_new.' And (work_procedures.Order)>'.$order_old.'))');
        }

        foreach ($workprocedures as $key => $value) {
            $idx[] = $value->id;
            $orderx[] = $value->Order;
        }

        for ($i=0; $i < count($workprocedures); $i++) {
            $workprocedure = WorkProcedure::find($idx[$i]);
            if ( $order_new-$order_old < 0 )
            {
                $workprocedure->Order = $orderx[$i]+1;
                $workprocedure->save();
            } else {
                $workprocedure->Order = $orderx[$i]-1;
                $workprocedure->save();
            }
        }

        $form_data = array(
            'activity_id' => $request->activity_id,
            'Order' => $request->Order,
            'Procedure' => $request->Procedure,
            'ControlledPoint' => $request->ControlledPoint,
            'Class' => $request->Class,
            'Man' => $request->Man,
            'Hour' => $request->Hour
        );

        WorkProcedure::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = WorkProcedure::findOrFail($id);
        $activityid = $data->activity_id;
        $order = $data->Order;
        $workprocedures = DB::select('SELECT work_procedures.id, work_procedures.activity_id, work_procedures.Order
        FROM work_procedures
        WHERE (((work_procedures.activity_id)='.$activityid.') AND ((work_procedures.Order)>'.$order.'))');

        foreach ($workprocedures as $key => $value) {
            $idx[] = $value->id;
            $orderx[] = $value->Order;
        }

        for ($i=0; $i < count($workprocedures); $i++) {
            $workprocedure = WorkProcedure::find($idx[$i]);
            $workprocedure->Order = $orderx[$i]+1;
            $workprocedure->save();
        }

        $data->delete();
    }

    function fetchactivity(Request $request)
    {
        $activityid = $request->get('activityid');
        $data = DB::select('SELECT work_procedures.id, work_procedures.activity_id, work_procedures.Order
            FROM work_procedures
            WHERE (((work_procedures.activity_id)='.$activityid.'))');
        $output = '<option></option>';
        for ($i=1; $i <= count($data)+1; $i++) {
            $output .= '<option value="'.$i.'">'.$i.'</option>';
        }
        echo $output;
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
                            <a href="'. url('workprocedures2/{{$item_id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        return view('workprocedures.project',compact('project'));
    }

    public function amount(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id, Count(work_procedures.id) AS CountOfid
                FROM ((locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) LEFT JOIN (activities LEFT JOIN work_procedures ON activities.id = work_procedures.activity_id) ON items.id = activities.item_id
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

    public function create2(Request $request, $id)
    {
        $item = Item::find($id);

        $order = WorkProcedure::where('item_id','=',$id)->orderBy('Order2','asc')->get();

        $activity = DB::select('SELECT activities.id, activities.ActivityName
            FROM activities
            WHERE (((activities.item_id)='.$id.'))
            ORDER BY activities.ActivityName');

        if($request->ajax())
        {
            $data = DB::select('SELECT work_procedures.id, work_procedures.Order2, work_procedures.Procedure, work_procedures.ControlledPoint, work_procedures.Class, work_procedures.Man, work_procedures.Hour, activities.ActivityName
                FROM activities RIGHT JOIN work_procedures ON activities.id = work_procedures.activity_id
                WHERE (((work_procedures.item_id)='.$id.'))
                UNION
                SELECT work_procedures.id, work_procedures.Order2, work_procedures.Procedure, work_procedures.ControlledPoint, work_procedures.Class, work_procedures.Man, work_procedures.Hour, activities.ActivityName
                FROM activities LEFT JOIN work_procedures ON activities.id = work_procedures.activity_id
                WHERE (((activities.item_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('Order2', function($data) {
                        return '<div class="text-center">'.$data->Order2.'</div>';
                    })
                    ->editColumn('ControlledPoint',function($data){
                        return nl2br($data->ControlledPoint);
                    })
                    ->editColumn('Class', function($data) {
                        return '<div class="text-center">'.$data->Class.'</div>';
                    })
                    ->editColumn('Man', function($data) {
                        return '<div class="text-center">'.$data->Man.'</div>';
                    })
                    ->editColumn('Hour', function($data) {
                        return '<div class="text-center">'.$data->Hour.'</div>';
                    })
                    ->editColumn('ActivityName', function($data) {
                        return '<div class="text-center">'.$data->ActivityName.'</div>';
                    })
                    ->addColumn('action',function($data) {
                        if ( $data->id == "")
                        return '<div class="text-center">N/A</div>';
                        return
                        '<div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>';
                    })
                    ->rawColumns(['Order2','ControlledPoint','Class','Man','Hour','ActivityName','action'])
                    ->make(true);
        }

        return view('workprocedures.create2',compact('item','order','activity'));
    }

    public function store2(Request $request)
    {
        $rules = array(
            'item_id'=>'required',
            'Order2'=>'required',
            'Procedure'=>'required',
            'Class'=>'required',
            'Man'=>'required',
            'Hour'=>'required',
            'activity_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $itemid = $request->item_id;
        $order = $request->Order2;
        $workprocedures = DB::select('SELECT work_procedures.id, work_procedures.Order2
            FROM work_procedures
            WHERE work_procedures.item_id = '.$itemid.' AND work_procedures.Order2 >= '.$order.'');

        foreach ($workprocedures as $key => $value) {
            $idx[] = $value->id;
            $orderx[] = $value->Order2;
        }

        for ($i=0; $i < count($workprocedures); $i++) {
            $workprocedure = WorkProcedure::find($idx[$i]);
            $workprocedure->Order2 = $orderx[$i]+1;
            $workprocedure->save();
        }

        $form_data = array(
            'item_id' => $request->item_id,
            'Order2' => $request->Order2,
            'Procedure' => $request->Procedure,
            'ControlledPoint' => $request->ControlledPoint,
            'Class' => $request->Class,
            'Man' => $request->Man,
            'Hour' => $request->Hour,
            'activity_id' => $request->activity_id
        );

        WorkProcedure::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit2($id)
    {
        if(request()->ajax())
        {
            $data = WorkProcedure::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update2(Request $request, WorkProcedure $id)
    {
        $rules = array(
            'item_id'=>'required',
            'Order2'=>'required',
            'Procedure'=>'required',
            'Class'=>'required',
            'Man'=>'required',
            'Hour'=>'required',
            'activity_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $workprocedure = WorkProcedure::find($request->hidden_id);
        $workprocedure->Order2 = $request->Order2;
        $itemid = $workprocedure->item_id;
        $order_new = $workprocedure->Order2;
        $order_old = $workprocedure->getOriginal('Order2');

        if ( $order_new-$order_old < 0 ) {
            $workprocedures = DB::select('SELECT work_procedures.id, work_procedures.Order2
            FROM work_procedures
            WHERE (((work_procedures.item_id)='.$itemid.') AND ((work_procedures.Order2)>='.$order_new.' And (work_procedures.Order2)<'.$order_old.'))');
        } else {
            $workprocedures = DB::select('SELECT work_procedures.id, work_procedures.Order2
            FROM work_procedures
            WHERE (((work_procedures.item_id)='.$itemid.') AND ((work_procedures.Order2)<='.$order_new.' And (work_procedures.Order2)>'.$order_old.'))');
        }

        foreach ($workprocedures as $key => $value) {
            $idx[] = $value->id;
            $orderx[] = $value->Order2;
        }

        for ($i=0; $i < count($workprocedures); $i++) {
            $workprocedure = WorkProcedure::find($idx[$i]);
            if ( $order_new-$order_old < 0 )
            {
                $workprocedure->Order2 = $orderx[$i]+1;
                $workprocedure->save();
            } else {
                $workprocedure->Order2 = $orderx[$i]-1;
                $workprocedure->save();
            }
        }

        $form_data = array(
            'item_id' => $request->item_id,
            'Order2' => $request->Order2,
            'Procedure' => $request->Procedure,
            'ControlledPoint' => $request->ControlledPoint,
            'Class' => $request->Class,
            'Man' => $request->Man,
            'Hour' => $request->Hour,
            'activity_id' => $request->activity_id
        );

        WorkProcedure::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy2($id)
    {
        $data = WorkProcedure::findOrFail($id);
        $itemid = $data->item_id;
        $order = $data->Order2;
        $workprocedures = DB::select('SELECT work_procedures.id, work_procedures.Order2
        FROM work_procedures
        WHERE (((work_procedures.item_id) = '.$itemid.') AND ((work_procedures.Order2) > '.$order.'))');

        foreach ($workprocedures as $key => $value) {
            $idx[] = $value->id;
            $orderx[] = $value->Order2;
        }

        for ($i=0; $i < count($workprocedures); $i++) {
            $workprocedure = WorkProcedure::find($idx[$i]);
            $workprocedure->Order2 = $orderx[$i]-1;
            $workprocedure->save();
        }

        $data->delete();
    }

    function fetchcreate(Request $request)
    {
        $itemid = $request->get('itemid');
        $data = DB::select('SELECT work_procedures.id, work_procedures.Order2
            FROM work_procedures
            WHERE (((work_procedures.item_id)='.$itemid.'))');
        $output = '<option></option>';
        for ($i=1; $i <= count($data)+1; $i++) {
            $output .= '<option value="'.$i.'">'.$i.'</option>';
        }
        echo $output;
    }

    function fetchedit(Request $request)
    {
        $itemid = $request->get('itemid');
        $data = DB::select('SELECT work_procedures.id, work_procedures.Order2
            FROM work_procedures
            WHERE (((work_procedures.item_id)='.$itemid.'))');
        $output = '<option></option>';
        for ($i=1; $i <= count($data); $i++) {
            $output .= '<option value="'.$i.'">'.$i.'</option>';
        }
        echo $output;
    }
}
