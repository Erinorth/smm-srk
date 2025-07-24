<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Item;
use App\Models\Hazard;
use App\Models\ActivityHazard;
use App\Models\HazardControl;
use App\Models\Project;

class HazardController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
            {
                $data = Hazard::all();
                return DataTables::of($data)
                    ->editColumn('id',function($data){
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->editColumn('Type',function($data){
                        return '<div class="text-center">'.$data->Type.'</div>';
                    })
                    ->editColumn('ManPower',function($data){
                        return '<div class="text-center">'.$data->ManPower.'</div>';
                    })
                    ->editColumn('Contact',function($data){
                        return '<div class="text-center">'.$data->Contact.'</div>';
                    })
                    ->editColumn('Procedure',function($data){
                        return '<div class="text-center">'.$data->Procedure.'</div>';
                    })
                    ->editColumn('Training',function($data){
                        return '<div class="text-center">'.$data->Training.'</div>';
                    })
                    ->editColumn('PPE',function($data){
                        return '<div class="text-center">'.$data->PPE.'</div>';
                    })
                    ->editColumn('SafetyEquipment',function($data){
                        return '<div class="text-center">'.$data->SafetyEquipment.'</div>';
                    })
                    ->editColumn('Verification',function($data){
                        return '<div class="text-center">'.$data->Verification.'</div>';
                    })
                    ->editColumn('SafetySign',function($data){
                        return '<div class="text-center">'.$data->SafetySign.'</div>';
                    })
                    ->editColumn('Opportunity',function($data){
                        return '<div class="text-center">'.$data->Opportunity.'</div>';
                    })
                    ->addColumn('action','
                    <div class="text-center">
                        <a class="btn btn-info btn-sm" href="'.url('hazard_controls/{{$id}}').'">Control</a>
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>                        </div>
                    </div>
                    ')
                    ->rawColumns(['id','Type','ManPower','Contact','Procedure','Training','PPE','SafetyEquipment','Verification','SafetySign','Opportunity','action'])
                    ->make(true);
            }

        return view('hazards.index');
    }

    public function store(Request $request)
    {
        $rules = array(
            'HazardName'=>'required',
            'Type'=>'required',
            'ManPower'=>'required',
            'Contact'=>'required',
            'Procedure'=>'required',
            'Training'=>'required',
            'PPE'=>'required',
            'SafetyEquipment'=>'required',
            'Verification'=>'required',
            'SafetySign'=>'required',
            'Opportunity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'HazardName' => $request->HazardName,
            'Type'=> $request->Type,
            'ManPower'=> $request->ManPower,
            'Contact'=> $request->Contact,
            'Procedure'=> $request->Procedure,
            'Training'=> $request->Training,
            'PPE'=> $request->PPE,
            'SafetyEquipment'=> $request->SafetyEquipment,
            'Verification'=> $request->Verification,
            'SafetySign'=> $request->SafetySign,
            'Opportunity'=> $request->Opportunity
        );

        Hazard::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Hazard::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request,Hazard $id)
    {
        $rules = array(
            'HazardName'=>'required',
            'Type'=>'required',
            'ManPower'=>'required',
            'Contact'=>'required',
            'Procedure'=>'required',
            'Training'=>'required',
            'PPE'=>'required',
            'SafetyEquipment'=>'required',
            'Verification'=>'required',
            'SafetySign'=>'required',
            'Opportunity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'HazardName' => $request->HazardName,
            'Type'=> $request->Type,
            'ManPower'=> $request->ManPower,
            'Contact'=> $request->Contact,
            'Procedure'=> $request->Procedure,
            'Training'=> $request->Training,
            'PPE'=> $request->PPE,
            'SafetyEquipment'=> $request->SafetyEquipment,
            'Verification'=> $request->Verification,
            'SafetySign'=> $request->SafetySign,
            'Opportunity'=> $request->Opportunity
        );

        Hazard::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Update successfully.']);
    }

    public function destroy($id)
    {
        $data = Hazard::findOrFail($id);
        $data->delete();
    }

    public function item(Request $request, $id)
    {
        $item = Item::find($id);
        $hazard = Hazard::orderBy('HazardName','asc')->get();
        $activity = DB::select('SELECT activities.id, activities.item_id, activities.Order, activities.ActivityName, activities.Detail
            FROM activities
            WHERE (((activities.item_id)='.$id.'))
            ORDER BY activities.Order');

        if($request->ajax())
        {
            $data = DB::select('SELECT activity_hazards.id, activities.Order, activities.ActivityName, hazards.HazardName, activities.item_id
                FROM hazards RIGHT JOIN (activities LEFT JOIN activity_hazards ON activities.id = activity_hazards.activity_id) ON hazards.id = activity_hazards.hazard_id
                WHERE (((activities.item_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('Order', function($data) {
                        return '<div class="text-center">'.$data->Order.'</div>';
                    })
                ->addColumn('action',function($data) {
                    if ( $data->id == ""){
                        return '<div class="text-center">N/A</div>';
                    } else {
                        return
                        '<div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>';
                    }
                })
                ->rawColumns(['Order','action'])
                ->make(true);
        }
        return view('hazards.itemcreate',compact('item','hazard','activity'));
    }

    public function itemstore(Request $request)
    {
        $rules = array(
            'activity_id'=>'required',
            'hazard_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'hazard_id' => $request->hazard_id,
            'activity_id' => $request->activity_id
        );

        ActivityHazard::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function itemedit($id)
    {
        if(request()->ajax())
        {
            $data = ActivityHazard::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function itemupdate(Request $request, ActivityHazard $id)
    {
        $rules = array(
            'activity_id'=>'required',
            'hazard_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'hazard_id' => $request->hazard_id,
            'activity_id' => $request->activity_id,
            'item_id' => $request->item_id
        );

        ActivityHazard::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function itemdestroy($id)
    {
        $data = ActivityHazard::findOrFail($id);
        $data->delete();
    }

    public function controlcreate(Request $request, $id)
    {
        $hazard = Hazard::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT hazard_controls.id, hazard_controls.hazard_id, hazard_controls.KindofHazard, hazard_controls.Effect, hazard_controls.Severity, hazard_controls.HazardControl
                FROM hazard_controls
                WHERE (((hazard_controls.hazard_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('HazardControl',function($data){
                    return nl2br($data->HazardControl);
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['HazardControl','action'])
                ->make(true);
        }
        return view('hazards.control',compact('hazard'));
    }

    public function controlstore(Request $request)
    {
        $rules = array(
            'KindofHazard'=>'required',
            'Severity'=>'required',
            'Effect'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'hazard_id' => $request->hazard_id,
            'KindofHazard' => $request->KindofHazard,
            'Effect' => $request->Effect,
            'Severity' => $request->Severity,
            'HazardControl' => $request->HazardControl
        );

        HazardControl::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function controledit($id)
    {
        if(request()->ajax())
        {
            $data = HazardControl::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function controlupdate(Request $request,HazardControl $id)
    {
        $rules = array(
            'KindofHazard'=>'required',
            'Severity'=>'required',
            'Effect'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'hazard_id' => $request->hazard_id,
            'KindofHazard' => $request->KindofHazard,
            'Effect' => $request->Effect,
            'Severity' => $request->Severity,
            'HazardControl' => $request->HazardControl
        );

        HazardControl::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function controldestroy($id)
    {
        $data = HazardControl::findOrFail($id);
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
                            <a href="'. url('item_hazards/{{$item_id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        return view('hazards.project',compact('project'));
    }

    public function amount(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id, Count(hazards.HazardName) AS CountOfHazardName
                FROM hazards INNER JOIN ((((locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) INNER JOIN activities ON items.id = activities.item_id) INNER JOIN activity_hazards ON activities.id = activity_hazards.activity_id) ON hazards.id = activity_hazards.hazard_id
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
                ->addColumn('CountOfHazardName', function($data) {
                    return '<div class="text-center">'.$data->CountOfHazardName.'</div>';
                })
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','CountOfHazardName'])
                ->make(true);
        }
    }
}
