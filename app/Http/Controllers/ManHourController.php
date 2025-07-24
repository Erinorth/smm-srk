<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ManHour;
use App\Models\Employee;
use App\Models\JobPosition;
use App\Chart;
use DataTables;
use DB;
use Validator;
use App\Imports\SelectManHourImport;
use App\Imports\SelectPlanOTImport;
use App\Models\Craft;
use App\Models\Date;
use App\Models\OTFrame;
use App\Models\PlanOT;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ManHourController extends Controller
{
    public function create(Request $request, $id)
    {
        $project = Project::find($id);
        $employee = Employee::orderBy('ThaiName','asc')->get();
        $job = DB::select('SELECT locations.LocationName, machines.MachineName, machine_sets.Remark, products.ProductName, systems.SystemName, items.SpecificName, jobs.id, jobs.project_id
            FROM (machines INNER JOIN (locations INNER JOIN (systems INNER JOIN (products INNER JOIN (machine_sets INNER JOIN (item_sets INNER JOIN items ON item_sets.id = items.item_set_id) ON machine_sets.id = items.machine_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) INNER JOIN jobs ON items.id = jobs.item_id
            WHERE (((jobs.project_id)='.$id.'))
            ORDER BY locations.LocationName, machines.MachineName, machine_sets.Remark, products.ProductName, systems.SystemName, items.SpecificName');
        $pmorder = DB::select('SELECT p_m_orders.id, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.Remark, p_m_orders.project_id
            FROM p_m_orders
            WHERE (((p_m_orders.project_id)='.$id.'))
            ORDER BY p_m_orders.PMOrder');
        $jobposition = JobPosition::all();

        if($request->ajax())
        {
            $data = DB::select('SELECT man_hours.id, man_hours.WorkingDate, man_hours.job_id, p_m_orders.PMOrder, employees.ThaiName, employees.WorkID, job_positions.JobPositionName, man_hours.Normal, man_hours.OTfrom, man_hours.OTto, man_hours.OT1, man_hours.OT15, man_hours.OT2, man_hours.OT3, man_hours.Remark, jobs.project_id
                FROM jobs INNER JOIN (p_m_orders RIGHT JOIN (job_positions INNER JOIN (employees INNER JOIN man_hours ON employees.id = man_hours.employee_id) ON job_positions.id = man_hours.job_position_id) ON p_m_orders.id = man_hours.p_m_order_id) ON jobs.id = man_hours.job_id
                WHERE (((jobs.project_id = '.$id.')))');
            return DataTables::of($data)
                ->editColumn('JobPositionName', function($data) {
                    return '<div class="text-center">'.$data->JobPositionName.'</div>';
                })
                ->editColumn('job_id', function($data) {
                    return '<div class="text-center">'.$data->job_id.'</div>';
                })
                ->editColumn('PMOrder', function($data) {
                    return '<div class="text-center">'.$data->PMOrder.'</div>';
                })
                ->editColumn('WorkingDate', function($data) {
                    return '<div class="text-center">'.$data->WorkingDate.'</div>';
                })
                ->editColumn('Normal', function($data) {
                    return '<div class="text-center">'.$data->Normal.'</div>';
                })
                ->editColumn('OTfrom', function($data) {
                    return '<div class="text-center">'.$data->OTfrom.'</div>';
                })
                ->editColumn('OTto', function($data) {
                    return '<div class="text-center">'.$data->OTto.'</div>';
                })
                ->editColumn('OT1', function($data) {
                    return '<div class="text-center">'.$data->OT1.'</div>';
                })
                ->editColumn('OT15', function($data) {
                    return '<div class="text-center">'.$data->OT15.'</div>';
                })
                ->editColumn('OT2', function($data) {
                    return '<div class="text-center">'.$data->OT2.'</div>';
                })
                ->editColumn('OT3', function($data) {
                    return '<div class="text-center">'.$data->OT3.'</div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                </div>
                ')
                ->rawColumns(['job_id','PMOrder','WorkingDate','JobPositionName','Normal','OTfrom','OTto','OT1','OT15','OT2','OT3','action'])
                ->make(true);
        }

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE projectplan AS (
                SELECT jobs.project_id, Sum(work_procedures.Man*work_procedures.Hour) AS Plan
                FROM jobs INNER JOIN (activities INNER JOIN work_procedures ON activities.id = work_procedures.activity_id) ON jobs.item_id = activities.item_id
                GROUP BY jobs.project_id
                HAVING (((jobs.project_id)=$id))
                );

            CREATE TEMPORARY TABLE manhourdata AS (
                SELECT man_hours.WorkingDate, man_hours.job_position_id, jobs.project_id, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS ManHour, projectplan.Plan
                FROM (projectplan INNER JOIN jobs ON projectplan.project_id = jobs.project_id) INNER JOIN man_hours ON jobs.id = man_hours.job_id
                GROUP BY man_hours.WorkingDate, man_hours.job_position_id, jobs.project_id, projectplan.Plan
                HAVING (((man_hours.job_position_id)=4) AND ((jobs.project_id)=$id))
                );

            CREATE TEMPORARY TABLE otherdata AS (
                SELECT job_positions.JobPositionName, jobs.project_id, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS ManHour
                FROM job_positions INNER JOIN (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) ON job_positions.id = man_hours.job_position_id
                GROUP BY job_positions.JobPositionName, jobs.project_id
                HAVING (((jobs.project_id)=$id))
                );
            ")
        );

        $manhourdata = DB::table('manhourdata')->get();

        if ( count($manhourdata) != 0 ) {
            for ($i=0, $x=0; $i<count($manhourdata); $i++) {
                $colours[] = 'rgba(255, 99, 132, 1)';
                $csum[] = $manhourdata[$i]->ManHour+$x;
                $x = $csum[$i];
            }

            $plan = DB::table('manhourdata')->orderBy('WorkingDate')->get()->toArray();
            $plan = array_column($plan,'Plan');

            $date = DB::table('manhourdata')->orderBy('WorkingDate')->get()->toArray();
            $date = array_column($date,'WorkingDate');

            $manhour = DB::table('manhourdata')->orderBy('WorkingDate')->get()->toArray();
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

        $otherdata = DB::table('otherdata')->get();

        if ( count($otherdata) != 0 ) {
            for ($i=0; $i<count($otherdata); $i++) {
                $colours2[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
            }

            $other = DB::table('otherdata')->orderBy('JobPositionName')->get()->toArray();
            $other = array_column($other,'ManHour');

            $jobpo = DB::table('otherdata')->orderBy('JobPositionName')->get()->toArray();
            $jobpo = array_column($jobpo,'JobPositionName');

            $otherchart = new Chart;
            $otherchart->labels = $jobpo;
            $otherchart->manhour = $other;
            $otherchart->colours = $colours2;
        } else {
            $otherchart = new Chart;
            $otherchart->labels = 'N/A';
            $otherchart->manhour = 0;
            $otherchart->colours2 = 'rgba(255, 99, 132, 1)';
        }

        $report = DB::select('SELECT employees.WorkID, employees.ThaiName, jobs.project_id
            FROM employees INNER JOIN (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) ON employees.id = man_hours.employee_id
            GROUP BY employees.WorkID, employees.ThaiName, jobs.project_id
            HAVING (((jobs.project_id)='.$id.'))');

        $craft = Craft::all();

        //$test = DB::table('otherdata')->get();
        //dd($otherchart);

        return view('manhours.create',compact('project','employee','job','pmorder','jobposition','manhourchart','otherchart','report','manhourdata','craft'));
    }

    function fetchcreate(Request $request)
    {
        $workingdate = $request->get('workingdate');
        $projectid = $request->get('project_id');
        $data = DB::select('SELECT employees.id, employees.WorkID, employees.ThaiName
            FROM employees
            INNER JOIN mobilization_plans
            ON employees.id = mobilization_plans.employee_id
            WHERE mobilization_plans.project_id = '.$projectid.' AND ('.$workingdate.' BETWEEN CAST("mobilization_plans.StartDate" AS DATE) AND CAST("mobilization_plans.EndDate" AS DATE))
            GROUP BY employees.id, employees.WorkID, employees.ThaiName
            ORDER BY employees.ThaiName');
        $output = '<option></option>';
        foreach ($data as $value) {
            $output .= '<option value="'.$value->id.'">'.$value->WorkID.'-'.$value->ThaiName.'</option>';
        }
        echo $output;
    }

    public function store(Request $request)
    {
        $rules = array(
            'employee_id'=>'required',
            'job_position_id'=>'required',
            'OTfrom'=>'required',
            'job_id'=>'required',
            'OTto'=>'required',
            'Normal'=>'required|numeric',
            'OT1'=>'required|numeric',
            'OT15'=>'required|numeric',
            'OT2'=>'required|numeric',
            'OT3'=>'required|numeric',
            'WorkingDate'=>'required|date'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id,
            'job_position_id' => $request->job_position_id,
            'Normal' => $request->Normal,
            'OTfrom' => $request->OTfrom,
            'OTto' => $request->OTto,
            'OT1' => $request->OT1,
            'OT15' => $request->OT15,
            'OT2' => $request->OT2,
            'OT3' => $request->OT3,
            'Remark' => $request->Remark,
            'job_id' => $request->job_id,
            'p_m_order_id' => $request->p_m_order_id,
            'WorkingDate' => $request->WorkingDate
        );

        ManHour::create($form_data);

        return response()->json(['success' => 'Man Hour Added successfully.']);
    }

    public function import(Request $request, $id)
    {
        $rules = array(
            'select_file'=>'required|mimes:xls,xlsx'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        try {
            /* $import = new SelectManHourImport($id);
            $import->import($request->select_file); */
            Excel::import(new SelectManHourImport($id), request()->file('select_file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            if($failures)
            {
                return response()->json(['failures' => $e->failures()]);
            }
        }

        return response()->json(['success' => 'Man Hour Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = ManHour::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request,ManHour $id)
    {
        $rules = array(
            'employee_id'=>'required',
            'job_position_id'=>'required',
            'OTfrom'=>'required',
            'job_id'=>'required',
            'OTto'=>'required',
            'Normal'=>'required|numeric',
            'OT1'=>'required|numeric',
            'OT15'=>'required|numeric',
            'OT2'=>'required|numeric',
            'OT3'=>'required|numeric',
            'WorkingDate'=>'required|date'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id,
            'job_position_id' => $request->job_position_id,
            'Normal' => $request->Normal,
            'OTfrom' => $request->OTfrom,
            'OTto' => $request->OTto,
            'OT1' => $request->OT1,
            'OT15' => $request->OT15,
            'OT2' => $request->OT2,
            'OT3' => $request->OT3,
            'Remark' => $request->Remark,
            'job_id' => $request->job_id,
            'p_m_order_id' => $request->p_m_order_id,
            'WorkingDate' => $request->WorkingDate
        );

        ManHour::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Man Hour is successfully updated']);
    }

    public function destroy($id)
    {
        $data = ManHour::findOrFail($id);
        $data->delete();
    }

    public function timeconfirmed(Request $request)
    {
        $employee = Employee::orderBy('ThaiName','asc')->get();

        return view('manhours.timeconfirmed',compact('employee'));
    }

    public function otframe(Request $request)
    {
        $employee = Employee::orderBy('ThaiName')->get();
        $yearnumber = Date::select('Year')->groupBy('Year')->orderBy('Year','desc')->get();
        $monthnumber = Date::select('Month')->groupBy('Month')->orderBy('Month')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT o_t_frames.id, employees.WorkID, employees.ThaiName, o_t_frames.Year, o_t_frames.Month, o_t_frames.Frame, o_t_frames.Remark
                FROM o_t_frames
                INNER JOIN employees
                ON o_t_frames.employee_id = employees.id');
            return DataTables::of($data)
                ->editColumn('WorkID', function($data) {
                    return '<div class="text-center">'.$data->WorkID.'</div>';
                })
                ->editColumn('Year', function($data) {
                    return '<div class="text-center">'.$data->Year.'</div>';
                })
                ->editColumn('Month', function($data) {
                    return '<div class="text-center">'.$data->Month.'</div>';
                })
                ->editColumn('Frame', function($data) {
                    return '<div class="text-center">'.$data->Frame.'</div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                </div>
                ')
                ->rawColumns(['WorkID','Year','Month','Frame','action'])
                ->make(true);
        }

        return view('manhours.otframe',compact('employee','yearnumber','monthnumber'));
    }

    public function otframeproject(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT o_t_frames.id, o_t_frames.employee_id, employees.WorkID, employees.ThaiName, o_t_frames.Year, o_t_frames.Month, o_t_frames.Frame, o_t_frames.Remark
                FROM o_t_frames
                    INNER JOIN employees
                    ON o_t_frames.employee_id = employees.id
                    INNER JOIN (SELECT employee_id, Year, Month
                        FROM (SELECT employee_id, YEAR(PlanDate) AS Year, MONTH(PlanDate) AS Month
                            FROM plan_o_t_s
                            WHERE project_id = '.$request->project_id.'
                            GROUP BY employee_id, YEAR(PlanDate), MONTH(PlanDate)
                            UNION
                            SELECT employee_id, YEAR(WorkingDate) AS Year, MONTH(WorkingDate) AS Month
                            FROM (SELECT man_hours.employee_id, man_hours.WorkingDate, jobs.project_id
                                FROM man_hours
                                INNER JOIN jobs
                                ON man_hours.job_id = jobs.id
                                WHERE jobs.project_id = '.$request->project_id.') AS man_hour
                            GROUP BY employee_id, YEAR(WorkingDate), MONTH(WorkingDate)) AS employee
                        GROUP BY employee_id, Year, Month) AS employee
                    ON o_t_frames.employee_id = employee.employee_id AND o_t_frames.Year = employee.Year AND o_t_frames.Month = employee.Month');
            return DataTables::of($data)
                ->editColumn('WorkID', function($data) {
                    return '<div class="text-center">'.$data->WorkID.'</div>';
                })
                ->editColumn('Year', function($data) {
                    return '<div class="text-center">'.$data->Year.'</div>';
                })
                ->editColumn('Month', function($data) {
                    return '<div class="text-center">'.$data->Month.'</div>';
                })
                ->editColumn('Frame', function($data) {
                    return '<div class="text-center">'.$data->Frame.'</div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <button class="edit_otframe btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" employee_id="{{$employee_id}}" Year="{{$Year}}" Month="{{$Month}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                </div>
                ')
                ->rawColumns(['WorkID','Year','Month','Frame','action'])
                ->make(true);
        }
    }

    public function otframestore(Request $request)
    {
        $rules = array(
            'employee_id'=>'required',
            'Year'=>'required',
            'Month'=>'required',
            'Frame' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id,
            'Year' => $request->Year,
            'Month' => $request->Month,
            'Frame' => $request->Frame,
            'Remark' => $request->Remark2
        );

        OTFrame::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function otframeprojectstore(Request $request)
    {
        $projectid = $request->project_id;

        $currentotframe = DB::select('SELECT employee_id, YEAR(PlanDate) AS Year, MONTH(PlanDate) AS Month
            FROM plan_o_t_s
            WHERE project_id = '.$projectid.'
            GROUP BY employee_id, YEAR(PlanDate), MONTH(PlanDate)');

        //dd($currentotframe);

        foreach ($currentotframe as $key => $value) {
            $count = OTFrame::where('employee_id','=',$value->employee_id)
                ->where('Year','=',$value->Year)
                ->where('Month','=',$value->Month)
                ->count();

            if($count == 0){
                $otframe = new OTFrame();
                $otframe->employee_id = $value->employee_id;
                $otframe->Year = $value->Year;
                $otframe->Month = $value->Month;
                $otframe->Frame = 0;
                $otframe->save();
            }
        }

        return back()->with('message','Successfully created Overtime Frame!');
    }

    public function otframeedit($id)
    {
        if(request()->ajax())
        {
            $data = OTFrame::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function otframeupdate(Request $request,OTFrame $id)
    {
        $rules = array(
            'employee_id'=>'required',
            'Year'=>'required',
            'Month'=>'required',
            'Frame' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id,
            'Year' => $request->Year,
            'Month' => $request->Month,
            'Frame' => $request->Frame,
            'Remark' => $request->Remark
        );

        OTFrame::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Overtime Frame is successfully updated']);
    }

    public function otframeprojectupdate(Request $request,OTFrame $id)
    {
        $rules = array(
            'employee_id2'=>'required',
            'Year'=>'required',
            'Month'=>'required',
            'Frame' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id2,
            'Year' => $request->Year,
            'Month' => $request->Month,
            'Frame' => $request->Frame,
            'Remark' => $request->Remark2
        );

        OTFrame::whereId($request->hidden_id_otframe)->update($form_data);

        return response()->json(['success' => 'Overtime Frame is successfully updated']);
    }

    public function otframedestroy($id)
    {
        $data = OTFrame::findOrFail($id);
        $data->delete();
    }

    public function planot(Request $request, $id)
    {
        $project = Project::find($id);

        $employee = Employee::orderBy('ThaiName','asc')->get();

        $employee_16 = DB::select('SELECT employees.id, employees.WorkID, employees.ThaiName
            FROM support_men
            INNER JOIN employees
                INNER JOIN departments
                ON employees.department_id = departments.id
            ON support_men.employee_id = employees.id
            INNER JOIN support_requests
            ON support_men.support_request_id = support_requests.id
            WHERE support_requests.project_id = '.$id.' AND support_requests.Type = "ไม่ฝากสายบังคับบัญชา"
            GROUP BY employees.id, employees.WorkID, employees.ThaiName
            ORDER BY employees.ThaiName');

        if($request->ajax())
        {
            $data = DB::select('SELECT plan_o_t_s.id, plan_o_t_s.PlanDate, employees.ThaiName, plan_o_t_s.PlanHour, plan_o_t_s.Remark
                FROM plan_o_t_s
                    INNER JOIN employees
                    ON employees.id = plan_o_t_s.employee_id
                WHERE plan_o_t_s.project_id = '.$id.'');
            return DataTables::of($data)
                ->editColumn('PlanDate', function($data) {
                    return '<div class="text-center">'.$data->PlanDate.'</div>';
                })
                ->editColumn('ThaiName', function($data) {
                    return '<div class="text-center">'.$data->ThaiName.'</div>';
                })
                ->editColumn('PlanHour', function($data) {
                    return '<div class="text-center">'.$data->PlanHour.'</div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <button class="edit_planot btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    <button class="delete_planot btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                </div>
                ')
                ->rawColumns(['PlanDate','ThaiName','PlanHour','action'])
                ->make(true);
        }

        $monthnumber = DB::select('SELECT MONTH(PlanDate) AS MonthNumber
            FROM plan_o_t_s
            WHERE project_id = '.$id.'
            GROUP BY month(PlanDate)');

        $yearnumber = DB::select('SELECT YEAR(PlanDate) AS YearNumber
            FROM plan_o_t_s
            WHERE project_id = '.$id.'
            GROUP BY YEAR(PlanDate)');

        //dd($yearnumber);

        return view('manhours.plan_ot',compact('project','employee','employee_16','monthnumber','yearnumber'));
    }

    public function planotstore(Request $request)
    {
        $rules = array(
            'project_id'=>'required',
            'PlanDate'=>'required',
            'employee_id' => ['required',Rule::unique('plan_o_t_s')->where(function ($query) use ($request) {
                    return $query->where('PlanDate', $request->PlanDate);
                })],
            'PlanHour'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'PlanDate' => $request->PlanDate,
            'employee_id' => $request->employee_id,
            'PlanHour' => $request->PlanHour,
            'Remark' => $request->Remark
        );

        PlanOT::create($form_data);

        $currentotframe = DB::select('SELECT employee_id, YEAR(PlanDate) AS Year, MONTH(PlanDate) AS Month
            FROM plan_o_t_s
            WHERE project_id = '.$request->project_id.'
            GROUP BY employee_id, YEAR(PlanDate), MONTH(PlanDate)');

        foreach ($currentotframe as $key => $value) {
            $count = OTFrame::where('employee_id','=',$value->employee_id)
                ->where('Year','=',$value->Year)
                ->where('Month','=',$value->Month)
                ->count();

            if($count == 0){
                $otframe = new OTFrame();
                $otframe->employee_id = $value->employee_id;
                $otframe->Year = $value->Year;
                $otframe->Month = $value->Month;
                $otframe->Frame = 0;
                $otframe->save();
            }
        }

        return response()->json(['success' => 'Man Hour Added successfully.']);
    }

    public function planotimport(Request $request, $id)
    {
        $rules = array(
            'select_file'=>'required|mimes:xls,xlsx'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        try {
            $import = new SelectPlanOTImport($id);
            $import->import($request->select_file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            if($failures)
            {
                return response()->json(['failures' => $e->failures()]);
            }
        }

        $currentotframe = DB::select('SELECT employee_id, YEAR(PlanDate) AS Year, MONTH(PlanDate) AS Month
            FROM plan_o_t_s
            WHERE project_id = '.$id.'
            GROUP BY employee_id, YEAR(PlanDate), MONTH(PlanDate)');

        foreach ($currentotframe as $value) {
            $count = OTFrame::where('employee_id','=',$value->employee_id)
                ->where('Year','=',$value->Year)
                ->where('Month','=',$value->Month)
                ->count();

            if($count == 0){
                $otframe = new OTFrame();
                $otframe->employee_id = $value->employee_id;
                $otframe->Year = $value->Year;
                $otframe->Month = $value->Month;
                $otframe->Frame = 0;
                $otframe->save();
            }
        }

        return response()->json(['success' => 'Plan OT Added successfully.']);
    }

    public function planotedit($id)
    {
        if(request()->ajax())
        {
            $data = PlanOT::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function planotupdate(Request $request,PlanOT $id)
    {
        $rules = array(
            'project_id'=>'required',
            'PlanDate'=>'required',
            'employee_id'=>'required',
            'PlanHour'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'PlanDate' => $request->PlanDate,
            'employee_id' => $request->employee_id,
            'PlanHour' => $request->PlanHour,
            'Remark' => $request->Remark
        );

        PlanOT::whereId($request->hidden_id_planot)->update($form_data);

        return response()->json(['success' => 'Plan Overtime is successfully updated']);
    }

    public function planotdestroy($id)
    {
        $data = PlanOT::findOrFail($id);
        $data->delete();
    }
}
