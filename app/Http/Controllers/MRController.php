<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Job;
use App\Models\MaintenanceReport;
use App\Models\MRCondition;
use App\Models\MRCountermeasure;
use App\Models\Project;

class MRController extends Controller
{
    public function create(Request $request, $id)
    {
        $job = Job::find($id);
        $activity = DB::select('SELECT activities.id, activities.Order, activities.ActivityName, jobs.id AS job_id
            FROM activities INNER JOIN jobs ON activities.item_id = jobs.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY activities.Order');

        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id AS job_id, activities.Order, activities.ActivityName, activities.Detail, maintenance_reports.id, maintenance_reports.Done, maintenance_reports.Condition, maintenance_reports.Countermeasure, maintenance_reports.Remark
                FROM jobs INNER JOIN (activities INNER JOIN maintenance_reports ON activities.id = maintenance_reports.activity_id) ON jobs.item_id = activities.item_id
                WHERE (((jobs.id)='.$id.'))
                ORDER BY activities.Order');
            return DataTables::of($data)
                ->editColumn('Done','
                    <div class="text-center">    
                        <input data-id="{{$id}}" class="toggle-class" type="checkbox" data-on-color="success" data-off-color="danger" data-toggle="toggle" data-on-text="Yes" data-off-text="No" {{ $Done == "Yes" ? '."'checked'".' : '."''".' }}>
                    </div>
                ')
                ->editColumn('Order',function($data){
                    return '<div class="text-center">'.$data->Order.'</div>';                   
                })
                ->editColumn('Condition',function($data){
                    return nl2br($data->Condition);                   
                })
                ->editColumn('Countermeasure',function($data){
                    return nl2br($data->Countermeasure);                   
                })
                ->addColumn('action',function($data){
                    return '
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        </div>
                    ';                   
                })
                ->rawColumns(['Done','Order','Condition','Countermeasure','action'])
                ->make(true);
        }
        return view('MRs.create',compact('job','activity'));
    }

    public function storecreate(Request $request)
    {
        $jobid = $request->job_id;
        $Done = $request->Done;
        $activityid = $request->activity_id;
        $countall = count($activityid);

        for ($i = 0; $i < $countall; $i++){
            
            $count = MaintenanceReport::where('job_id', $jobid[$i])
                ->where('activity_id',  $activityid[$i])
                ->count();
            
            if($count == 0){
                $maintenancereport = new MaintenanceReport();
                $maintenancereport->job_id = $jobid[$i];
                $maintenancereport->activity_id = $activityid[$i];
                $maintenancereport->Done = $Done[$i];
                $maintenancereport->save();
            }
        }

        return back()->with('message','Successfully created Maintenance Report!');
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = MaintenanceReport::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, MaintenanceReport $mrconditionid)
    {
        $rules = array(
            'Condition'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Condition' => $request->Condition,
            'Countermeasure' => $request->Countermeasure,
            'Remark' => $request->Remark
        );

        MaintenanceReport::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function done(Request $request)
    {
        $mr = MaintenanceReport::find($request->maintenance_report_id);
        $mr->Done = $request->Done;
        $mr->save();
  
        return response()->json(['success'=>'Done change successfully.']);
    }
    
    public function conditioncreate(Request $request, $id)
    {
        $mr = MaintenanceReport::find($id);
        
        if($request->ajax())
        {
            $data = DB::select('SELECT m_r_conditions.id, activities.Order, activities.ActivityName, maintenance_reports.Done, m_r_conditions.Condition, m_r_countermeasures.Countermeasure, maintenance_reports.id AS mr_id
                FROM ((activities INNER JOIN maintenance_reports ON activities.id = maintenance_reports.activity_id) INNER JOIN m_r_conditions ON maintenance_reports.id = m_r_conditions.maintenance_report_id) LEFT JOIN m_r_countermeasures ON m_r_conditions.id = m_r_countermeasures.m_r_condition_id
                WHERE (((maintenance_reports.id)='.$id.'))
                ORDER BY activities.Order');
            return DataTables::of($data)
                ->editColumn('Done','
                    <div class="text-center">    
                        {{$Done}}
                    </div>
                ')
                ->addColumn('action',function($data){
                    if ( $data->Countermeasure == Null ) {
                        return '
                        <div class="text-center">
                            <a href="'.url('MR_countermeasure/'.$data->id).'" class="btn btn-info btn-sm">Add Countermeasure</a>
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>
                    ';} else {
                        return '
                        <div class="text-center">
                            <a href="'.url('MR_countermeasure/'.$data->id).'" class="btn btn-info btn-sm">Add Countermeasure</a>
                        </div>  
                    ';}
                    
                })
                ->rawColumns(['Done','action'])
                ->make(true);
        }
        return view('MRs.conditioncreate',compact('mr'));
    }

    public function conditionstore(Request $request)
    {
        $rules = array(
            'Condition'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'maintenance_report_id' => $request->maintenance_report_id,
            'Condition' => $request->Condition
        );

        MRCondition::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function conditionedit($id)
    {
        if(request()->ajax())
        {
            $data = MRCondition::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function conditionupdate(Request $request, MRCondition $mrconditionid)
    {
        $rules = array(
            'Condition'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'maintenance_report_id' => $request->maintenance_report_id,
            'Condition' => $request->Condition
        );

        MRCondition::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function conditiondestroy($id)
    {
        $data = MRCondition::findOrFail($id);
        $data->delete();
    }

    public function countermeasurecreate(Request $request, $id)
    {
        $mrcondition = MRCondition::find($id);
        
        if($request->ajax())
        {
            $data = DB::select('SELECT m_r_countermeasures.id, maintenance_reports.Done, activities.ActivityName, m_r_conditions.Condition, m_r_countermeasures.Countermeasure, m_r_countermeasures.m_r_condition_id
                FROM activities INNER JOIN (maintenance_reports INNER JOIN (m_r_conditions INNER JOIN m_r_countermeasures ON m_r_conditions.id = m_r_countermeasures.m_r_condition_id) ON maintenance_reports.id = m_r_conditions.maintenance_report_id) ON activities.id = maintenance_reports.activity_id
                WHERE (((m_r_countermeasures.m_r_condition_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('Done','
                    <div class="text-center">    
                        {{$Done}}
                    </div>
                ')
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>  
                ')
                ->rawColumns(['Done','action'])
                ->make(true);
        }
        return view('MRs.countermeasurecreate',compact('mrcondition','countermeasure'));
    }

    public function countermeasurestore(Request $request)
    {
        $rules = array(
            'Countermeasure'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Countermeasure' => $request->Countermeasure,
            'Remark' => $request->Remark,
            'm_r_condition_id' => $request->m_r_condition_id
        );

        MRCountermeasure::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function countermeasureedit($id)
    {
        if(request()->ajax())
        {
            $data = MRCountermeasure::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function countermeasureupdate(Request $request, MRCountermeasure $mrcountermeasureid)
    {
        $rules = array(
            'Countermeasure'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Countermeasure' => $request->Countermeasure,
            'Remark' => $request->Remark,
            'm_r_condition_id' => $request->m_r_condition_id
        );

        MRCountermeasure::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function countermeasuredestroy($id)
    {
        $data = MRCountermeasure::findOrFail($id);
        $data->delete();
    }

    public function report(Request $request, $id)
    {
        $project = Project::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MRemark, systems.SystemName, equipment.EquipmentName, items.SpecificName, activities.Order, activities.ActivityName, activities.Detail, maintenance_reports.Done, maintenance_reports.Condition, maintenance_reports.Countermeasure, maintenance_reports.Remark
                FROM machines INNER JOIN (locations INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (machine_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN (jobs INNER JOIN (activities INNER JOIN maintenance_reports ON activities.id = maintenance_reports.activity_id) ON jobs.id = maintenance_reports.job_id) ON (items.id = jobs.item_id) AND (items.id = activities.item_id)) ON scopes.id = items.scope_id) ON machine_sets.id = items.machine_set_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id
                WHERE (((jobs.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('MachineName',function($data){
                    if ( $data->MRemark == Null ) {
                        return $data->MachineName;
                    } else {
                        return $data->MachineName.'//'.$data->MRemark;
                    }                    
                })
                ->editColumn('EquipmentName',function($data){
                    if ( $data->EquipmentName == $data->SpecificName ) {
                        return $data->EquipmentName;
                    } else {
                        return $data->EquipmentName.'//'.$data->SpecificName;
                    }                    
                })
                ->rawColumns(['MachineName','EquipmentName'])
                ->make(true);
        }
        return view('MRs.report',compact('project'));
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
                            <a href="'. url('maintenance_reports/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        return view('MRs.project',compact('project'));
    }

    public function amount(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id, Count(maintenance_reports.id) AS CountOfid
                FROM ((locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) LEFT JOIN maintenance_reports ON jobs.id = maintenance_reports.job_id
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
