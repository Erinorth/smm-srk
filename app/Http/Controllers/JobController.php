<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Project;
use App\Models\Item;
use App\Models\MachineSet;
use App\Chart;
use DB;
use DataTables;
use Validator;

class JobController extends Controller
{
    public function locationmachine(Request $request, $id)
    {
        $project = Project::find($id);

        $pmorder = DB::select('SELECT p_m_orders.id, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.project_id
            FROM p_m_orders
            WHERE (((p_m_orders.project_id)='.$id.'))
            ORDER BY p_m_orders.PMOrder');

        if($request->ajax())
        {
            $data = DB::select('SELECT machine_sets.id, locations.LocationName, machines.MachineName, machine_sets.Remark
                FROM locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id');
            return DataTables::of($data)
                    ->editColumn('LocationName', function($data) {
                        return '<div class="text-center">'.$data->LocationName.'</div>';
                    })
                    ->editColumn('MachineName', function($data) {
                        if ( $data->Remark == "" ) {
                            return '<div class="text-center">'.$data->MachineName.'</div>';
                        } else {
                            return '<div class="text-center">'.$data->MachineName.'//'.$data->Remark.'</div>';
                        }
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            <a href="'. url('jobs_create/'.$project->id.'/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        </div>
                    ')
                    ->rawColumns(['LocationName','MachineName','action'])
                    ->make(true);
        }

        return view('jobs.location_machine',compact('project','pmorder'));
    }

    public function locationmachineselect(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, products.ProductName, locations.LocationName, machines.MachineName, machine_sets.Remark AS MachineName2, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id, p_m_orders.PMOrder, p_m_orders.PMOrderName, jobs.Remark, jobs.created_at
                FROM machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (p_m_orders RIGHT JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON p_m_orders.id = jobs.p_m_order_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id
                WHERE (((jobs.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('LocationName', function($data) {
                    return '<div class="text-center">'.$data->LocationName.'</div>';
                })
                ->editColumn('ProductName', function($data) {
                    return '<div class="text-center">'.$data->ProductName.'</div>';
                })
                ->editColumn('MachineName', function($data) {
                    if ( $data->MachineName2 == "" ) {
                        return '<div class="text-center">'.$data->MachineName.'</div>';
                    } else {
                        return '<div class="text-center">'.$data->MachineName.'//'.$data->MachineName2.'</div>';
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
                ->editColumn('PMOrder', function($data) {
                    return '<div class="text-center">'.$data->PMOrder.'/'.$data->PMOrderName.'</div>';
                })
                ->editColumn('Remark', function($data) {
                    return '<div class="text-center">'.$data->Remark.'</div>';
                })
                ->rawColumns(['LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','PMOrder','Remark'])
                ->make(true);
        }
    }

    public function create(Request $request, $projectid, $id)
    {
        $project = Project::find($projectid);
        $machineset = MachineSet::find($id);
        $item = DB::select('SELECT items.id, products.ProductName, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, items.machine_set_id
            FROM equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN items ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id
            WHERE (((items.machine_set_id)='.$id.'))');
        $pmorder = DB::select('SELECT p_m_orders.id, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.project_id
            FROM p_m_orders
            WHERE (((p_m_orders.project_id)='.$projectid.'))
            ORDER BY p_m_orders.PMOrder');

        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, products.ProductName, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, p_m_orders.PMOrder, p_m_orders.PMOrderName, jobs.Remark, jobs.created_at, jobs.project_id
                FROM products INNER JOIN (equipment INNER JOIN (systems INNER JOIN (item_sets INNER JOIN (p_m_orders RIGHT JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON p_m_orders.id = jobs.p_m_order_id) ON item_sets.id = items.item_set_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON products.id = item_sets.product_id
                WHERE (((items.machine_set_id)='.$id.') AND ((jobs.project_id)='.$projectid.'))
                ORDER BY jobs.created_at DESC');
            return DataTables::of($data)
                ->editColumn('ProductName', function($data) {
                    return '<div class="text-center">'.$data->ProductName.'</div>';
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
                ->editColumn('PMOrder', function($data) {
                    return '<div class="text-center">'.$data->PMOrder.'/'.$data->PMOrderName.'</div>';
                })
                ->editColumn('Remark', function($data) {
                    return '<div class="text-center">'.$data->Remark.'</div>';
                })
                ->addColumn('action','
                    <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                ')
                ->rawColumns(['ProductName','SystemName','EquipmentName','ScopeName','PMOrder','Remark','action'])
                ->make(true);
        }

        return view('jobs.create',compact('project','machineset','item','pmorder'));
    }

    public function itemcreate(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT items.id, products.ProductName, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, items.machine_set_id, items.SpecificName
                FROM systems INNER JOIN (products INNER JOIN (equipment INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN items ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON equipment.id = item_sets.equipment_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id
                WHERE (((items.machine_set_id)='.$id.'))');
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
                    if ( $data->SpecificName == '' )
                    return '<div class="text-center">'.$data->EquipmentName.'</div>';
                    return '<div class="text-center">'.$data->EquipmentName.'('.$data->SpecificName.')</div>';
                })
                ->editColumn('ScopeName', function($data) {
                    return '<div class="text-center">'.$data->ScopeName.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button name="create_record" id="{{$id}}" class="create_record btn text-success btn-sx"><i class="fa fa-lg fa-fw fa-plus-square"></i></button>
                    </div>
                ')
                ->rawColumns(['id','ProductName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }
    }

    public function addtojob($id)
    {
        if(request()->ajax())
        {
            $data = Item::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function store(Request $request)
    {
        $rules = array(
            'project_id'=>'required',
            'p_m_order_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'item_id' => $request->item_id,
            'project_id' => $request->project_id,
            'p_m_order_id' => $request->p_m_order_id,
            'Remark' => $request->Remark
        );

        Job::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function show(Request $request, $id)
    {
        $job = Job::find($id);
        $activity = DB::select('SELECT jobs.id, activities.ActivityName, activities.Detail
            FROM jobs INNER JOIN activities ON jobs.item_id = activities.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY activities.Order');
        $item = DB::select('SELECT jobs.id, jobs.item_id, item_sets.product_id, machine_sets.location_id, machine_sets.machine_id, item_sets.system_id, item_sets.equipment_id
            FROM item_sets INNER JOIN (machine_sets INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON machine_sets.id = items.machine_set_id) ON item_sets.id = items.item_set_id
            WHERE (((jobs.id)='.$id.'))');

        if($request->ajax())
            {
                $data = DB::select('SELECT job_dates.id, job_dates.job_id, job_dates.Date, job_dates.Plan, job_dates.Actual
                    FROM job_dates
                    WHERE (((job_dates.job_id)='.$id.'))');
                return DataTables::of($data)
                    ->editColumn('Date', function($data) {
                        return '<div class="text-center">'.date('d-m-Y', strtotime($data->Date)).'</div>';
                    })
                    ->editColumn('Plan', function($data) {
                        return '<div class="text-center">'.$data->Plan.'</div>';
                    })
                    ->editColumn('Actual', function($data) {
                        return '<div class="text-center">'.$data->Actual.'</div>';
                    })
                    ->addColumn('action','
                    <div class="text-center">
                        @role('."'supervisor|foreman|admin'".')
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        @else N/A
                        @endrole
                    </div>
                    ')
                    ->rawColumns(['Date','Plan','Actual','Menu','action'])
                    ->make(true);
            }

        $createTempTables = DB::unprepared(DB::raw("
        CREATE TEMPORARY TABLE manhour_plan AS (
            SELECT Sum(work_procedures.Man*work_procedures.Hour) AS Plan, jobs.id
            FROM jobs INNER JOIN (activities INNER JOIN work_procedures ON activities.id = work_procedures.activity_id) ON jobs.item_id = activities.item_id
            GROUP BY jobs.id
            HAVING (((jobs.id)=$id))
            );

            CREATE TEMPORARY TABLE manhour AS (
                SELECT man_hours.WorkingDate, man_hours.job_position_id, Sum(Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS ManHour, man_hours.job_id, manhour_plan.Plan
                FROM (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) INNER JOIN manhour_plan ON jobs.id = manhour_plan.id
                GROUP BY man_hours.WorkingDate, man_hours.job_position_id, man_hours.job_id, manhour_plan.Plan
                HAVING (((man_hours.job_position_id)=4) AND ((man_hours.job_id)=$id))
                ORDER BY man_hours.WorkingDate
                );

            CREATE TEMPORARY TABLE progress AS (
                SELECT progress.ProgressDate, Sum(progress.Plan) AS Plan, Sum(progress.Actual) AS Actual, progress.job_id
                FROM progress
                GROUP BY progress.ProgressDate, progress.job_id
                HAVING (((progress.job_id)=$id))
                );
            ")
        );

        $progressgdata = DB::table('progress')->get();

        if ( count($progressgdata) != 0 ) {
            for ($i=0, $x=0, $y=0; $i<count($progressgdata); $i++) {
                $colours[] = 'rgba(255, 99, 132, 1)';
                $colours2[] = 'rgba(54, 162, 235, 1)';
                $colours3[] = 'rgba(255, 206, 86, 1)';
                $colours4[] = 'rgba(60, 179, 113, 1)';
                $colours5[] = 'rgba(0, 0, 0, 0)';
                $csumplan[] = $progressgdata[$i]->Plan+$x;
                $csumactual[] = $progressgdata[$i]->Actual+$y;
                $x = $csumplan[$i];
                $y = $csumactual[$i];
            }

            $date = DB::table('progress')->orderBy('ProgressDate')->get()->toArray();
            $date = array_column($date,'ProgressDate');

            $plan = DB::table('progress')->orderBy('ProgressDate')->get()->toArray();
            $plan = array_column($plan,'Plan');

            $actual = DB::table('progress')->orderBy('ProgressDate')->get()->toArray();
            $actual = array_column($actual,'Actual');

            $progresschart = new Chart;
            $progresschart->labels = $date;
            $progresschart->colours = $colours;
            $progresschart->colours2 = $colours2;
            $progresschart->colours3 = $colours3;
            $progresschart->colours4 = $colours4;
            $progresschart->colours5 = $colours5;
            $progresschart->plan = $plan;
            $progresschart->actual = $actual;
            $progresschart->csumplan = $csumplan;
            $progresschart->csumactual = $csumactual;
        } else {
            $progresschart = new Chart;
            $progresschart->labels = 'N/A';
            $progresschart->colours = 'rgba(255, 99, 132, 1)';
            $progresschart->colours2 = 'rgba(54, 162, 235, 1)';
            $progresschart->colours3 = 'rgba(255, 206, 86, 1)';
            $progresschart->colours4 = 'rgba(60, 179, 113, 1)';
            $progresschart->colours5 = 'rgba(0, 0, 0, 0)';
            $progresschart->plan = 0;
            $progresschart->actual = 0;
            $progresschart->csumplan = 0;
            $progresschart->csumactual = 0;
        }

        $manhourdata = DB::table('manhour')->get();

        if ( count($manhourdata) != 0 ) {
            for ($i=0, $x=0; $i<count($manhourdata); $i++) {
                $colours[] = 'rgba(255, 99, 132, 1)';
                $csum[] = $manhourdata[$i]->ManHour+$x;
                $x = $csum[$i];
            }

            $plan = DB::table('manhour')->orderBy('WorkingDate')->get()->toArray();
            $plan = array_column($plan,'Plan');

            $date = DB::table('manhour')->orderBy('WorkingDate')->get()->toArray();
            $date = array_column($date,'WorkingDate');

            $manhour = DB::table('manhour')->orderBy('WorkingDate')->get()->toArray();
            $manhour = array_column($manhour,'ManHour');

            $manhourchart = new Chart;
            $manhourchart->labels = $date;
            $manhourchart->manhour = $manhour;
            $manhourchart->colours = $colours;
            $manhourchart->plan = $plan;
            $manhourchart->csum = $csum;
        } else {
            $manhourchart = new Chart;
            $manhourchart->labels = 'N/A';
            $manhourchart->manhour = 0;
            $manhourchart->colours = 'rgba(255, 99, 132, 1)';
            $manhourchart->plan = 0;
            $manhourchart->csum = 0;
        }

        //$test = DB::table('manhour')->get();
        //dd($test);

        return view('jobs.show',compact('job','activity','item','progressgdata','progresschart','manhourdata','manhourchart'));
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Job::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Job $jobid)
    {
        $rules = array(
            'project_id'=>'required',
            'p_m_order_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'p_m_order_id' => $request->p_m_order_id,
            'Remark' => $request->Remark
        );

        Job::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Job::findOrFail($id);
        $data->delete();
    }
}
