<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Department;
use App\Models\DepartmentFactor;
use App\Models\QSHSchedule;
use App\Models\Project;
use App\Models\Stakeholder;
use App\Models\Expectation;
use App\Models\ProductStakeholder;
use App\Models\Product;
use App\Models\ProjectType;
use App\Models\StakeholderExpectation;
use App\Models\Factor;
use App\Models\ExpectationFactor;
use App\Models\TypeOfRisk;
use App\Models\Location;
use App\Models\ProductExpectationFactor;
use App\Models\ProductStakeholderExpectation;
use App\Models\ProjectTypeProduct;
use App\Models\StakeholderProject;
use App\Models\StakeholderType;

class QSHController extends Controller
{
    public function department(Request $request)
    {
        if($request->ajax())
        {
            $data = Department::all();
            return DataTables::of($data)
                    ->editColumn('Business', function($data) {
                        return '<div class="text-center">'.$data->Business.'</div>';
                    })
                    ->editColumn('Division', function($data) {
                        return '<div class="text-center">'.$data->Division.'</div>';
                    })
                    ->editColumn('Department', function($data) {
                        return '<div class="text-center">'.$data->Department.'</div>';
                    })
                    ->editColumn('Section', function($data) {
                        return '<div class="text-center">'.$data->Section.'</div>';
                    })
                    ->addColumn('action', function($data) {
                        return '<div class="text-center">
                            <a href="'. url('QSHs_product_stakeholder_expectation/'.$data->id.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        </div>';
                    })
                    ->rawColumns(['Business','Division','Department','Section','action'])
                    ->make(true);
        }

        return view('QSHs.department');
    }

    public function product_stakeholder_expectation(Request $request, $id)
    {
        $departmentid = $id;

        if($request->ajax())
        {
            $data = DB::select('SELECT product_stakeholder_expectations.id, products.ProductCode, products.ProductName, products.Service, stakeholders.StakeholderName, stakeholder_types.TypeName, expectations.Expectation, product_stakeholder_expectations.Related
                FROM product_stakeholder_expectations
                INNER JOIN products
                ON product_stakeholder_expectations.product_id = products.id
                INNER JOIN stakeholders
                    INNER JOIN stakeholder_types
                    ON stakeholders.stakeholder_type_id = stakeholder_types.id
                ON product_stakeholder_expectations.stakeholder_id = stakeholders.id
                INNER JOIN expectations
                ON product_stakeholder_expectations.expectation_id = expectations.id
                WHERE products.department_id = '.$departmentid.'');
            return DataTables::of($data)
                    ->editColumn('ProductCode', function($data) {
                        return '<div class="text-center">'.$data->ProductCode.'</div>';
                    })
                    ->editColumn('ProductName', function($data) {
                        return '<div class="text-center">'.$data->ProductName.'/'.$data->Service.'</div>';
                    })
                    ->editColumn('StakeholderName', function($data) {
                        return '<div class="text-center">'.$data->TypeName.' - '.$data->StakeholderName.'</div>';
                    })
                    ->editColumn('Expectation', function($data) {
                        return '<div class="text-center">'.$data->Expectation.'</div>';
                    })
                    ->editColumn('Related','
                        <div class="text-center">
                            <input data-id="{{$id}}" class="toggle-class" type="checkbox" data-on-color="success" data-off-color="danger" data-toggle="toggle" data-on-text="Yes" data-off-text="No" {{ $Related == "Yes" ? '."'checked'".' : '."''".' }}>
                        </div>
                    ')
                    ->rawColumns(['ProductCode','ProductName','Expectation','StakeholderName','Related'])
                    ->make(true);
        }

        return view('QSHs.product',compact('departmentid'));
    }

    public function update_product_stakeholder_expectation(Request $request)
    {
        $departmentid = $request->department_id_update;

        $product_stakeholder_expectation_standard = DB::select('SELECT product_stakeholders.product_id, product_stakeholders.stakeholder_id, stakeholder_expectations.expectation_id
            FROM product_stakeholders
            INNER JOIN products
            ON product_stakeholders.product_id = products.id
            INNER JOIN stakeholder_expectations
            ON product_stakeholders.stakeholder_id = stakeholder_expectations.stakeholder_id
            WHERE products.department_id='.$departmentid.'');

        foreach ($product_stakeholder_expectation_standard as $key => $value) {
            $count = ProductStakeholderExpectation::where('product_id','=',$value->product_id)
                ->where('stakeholder_id','=',$value->stakeholder_id)
                ->where('expectation_id','=',$value->expectation_id)
                ->count();

            if($count == 0){
                $product_stakeholder_expectation = new ProductStakeholderExpectation();
                $product_stakeholder_expectation->product_id = $value->product_id;
                $product_stakeholder_expectation->stakeholder_id = $value->stakeholder_id;
                $product_stakeholder_expectation->expectation_id = $value->expectation_id;
                $product_stakeholder_expectation->Related = "No";
                $product_stakeholder_expectation->save();
            }
        }

        $current_product_stakeholder_expectation = ProductStakeholderExpectation::join('products','product_stakeholder_expectations.product_id','=','products.id')
            ->where('products.department_id','=',$departmentid)
            ->get();

        foreach ($current_product_stakeholder_expectation as $key => $value) {
            $currentstandard = DB::select('SELECT product_stakeholder_expectations.id
                FROM product_stakeholder_expectations
                INNER JOIN products
                ON product_stakeholder_expectations.product_id = products.id
                WHERE products.department_id ='.$departmentid.' AND product_stakeholder_expectations.product_id ='.$value->product_id.' AND product_stakeholder_expectations.stakeholder_id ='.$value->stakeholder_id.' AND product_stakeholder_expectations.expectation_id ='.$value->expectation_id.'');

            if(count($currentstandard) == 0){
                $product_stakeholder_expectation2 = ProductStakeholderExpectation::findOrFail($value->id);
                $product_stakeholder_expectation2->delete();
            }
        }

        return back()->with('message','Successfully created Mile Stone!');
    }

    public function product_stakeholder_expectation_related(Request $request)
    {
        $product_stakeholder_expectation = ProductStakeholderExpectation::find($request->product_stakeholder_expectation_id);
        $product_stakeholder_expectation->Related = $request->Related;
        $product_stakeholder_expectation->save();

        return response()->json(['success'=>'Done change successfully.']);
    }

    public function product_expectation_factor(Request $request, $departmentid)
    {
        $department = Department::find($departmentid);

        if($request->ajax())
        {
            $data = DB::select('SELECT product_expectation_factors.id, products.ProductCode, products.ProductName, products.Service, expectations.Expectation, factors.Factor, product_expectation_factors.Related
                FROM product_expectation_factors
                INNER JOIN products
                ON product_expectation_factors.product_id = products.id
                INNER JOIN expectations
                ON product_expectation_factors.expectation_id = expectations.id
                INNER JOIN factors
                ON product_expectation_factors.factor_id = factors.id
                WHERE products.department_id = '.$departmentid.'');
            return DataTables::of($data)
                    ->editColumn('ProductCode', function($data) {
                        return '<div class="text-center">'.$data->ProductCode.'</div>';
                    })
                    ->editColumn('ProductName', function($data) {
                        return '<div class="text-center">'.$data->ProductName.'/'.$data->Service.'</div>';
                    })
                    ->editColumn('Expectation', function($data) {
                        return '<div class="text-center">'.$data->Expectation.'</div>';
                    })
                    ->editColumn('Factor', function($data) {
                        return '<div class="text-center">'.$data->Factor.'</div>';
                    })
                    ->editColumn('Related','
                        <div class="text-center">
                            <input data-id="{{$id}}" class="toggle-class" type="checkbox" data-on-color="success" data-off-color="danger" data-toggle="toggle" data-on-text="Yes" data-off-text="No" {{ $Related == "Yes" ? '."'checked'".' : '."''".' }}>
                        </div>
                    ')
                    ->rawColumns(['ProductCode','ProductName','Expectation','Factor','Related'])
                    ->make(true);
        }

        return view('QSHs.factor',compact('departmentid','department'));
    }

    public function update_product_expectation_factor(Request $request)
    {
        $departmentid = $request->department_id_update;

        $product_expectation_factor_standard = DB::select('SELECT product_stakeholder_expectations.product_id, product_stakeholder_expectations.expectation_id, expectation_factors.factor_id
            FROM product_stakeholder_expectations
            INNER JOIN products
            ON product_stakeholder_expectations.product_id = products.id
            INNER JOIN expectation_factors
            ON product_stakeholder_expectations.expectation_id = expectation_factors.id
            WHERE products.department_id = '.$departmentid.' AND product_stakeholder_expectations.Related = "Yes"');

        foreach ($product_expectation_factor_standard as $key => $value) {
            $count = ProductExpectationFactor::where('product_id','=',$value->product_id)
                ->where('expectation_id','=',$value->expectation_id)
                ->where('factor_id','=',$value->factor_id)
                ->count();

            if($count == 0){
                $product_expectation_factor = new ProductExpectationFactor();
                $product_expectation_factor->product_id = $value->product_id;
                $product_expectation_factor->expectation_id = $value->expectation_id;
                $product_expectation_factor->factor_id = $value->factor_id;
                $product_expectation_factor->Related = "No";
                $product_expectation_factor->save();
            }
        }

        $current_product_expectation_factor = DB::select('SELECT *
            FROM product_expectation_factors
            INNER JOIN products
            ON product_expectation_factors.product_id = products.id
            WHERE products.department_id = '.$departmentid.'');

        foreach ($current_product_expectation_factor as $key => $value) {
            $currentstandard = DB::select('SELECT product_expectation_factors.id
                FROM product_expectation_factors
                INNER JOIN products
                ON product_expectation_factors.product_id = products.id
                WHERE products.department_id ='.$departmentid.' AND product_expectation_factors.product_id ='.$value->product_id.' AND product_expectation_factors.expectation_id ='.$value->expectation_id.' AND product_expectation_factors.factor_id ='.$value->factor_id.'');

            if(count($currentstandard) == 0){
                $product_expectation_factor2 = ProductExpectationFactor::findOrFail($value->id);
                $product_expectation_factor2->delete();
            }
        }

        return back()->with('message','Successfully created Mile Stone!');
    }

    public function product_expectation_factor_related(Request $request)
    {
        $product_expectation_factor = ProductExpectationFactor::find($request->product_expectation_factor_id);
        $product_expectation_factor->Related = $request->Related;
        $product_expectation_factor->save();

        return response()->json(['success'=>'Done change successfully.']);
    }

    public function assesment(Request $request, $departmentid)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT department_factors.id, factors.Factor, department_factors.Related
                FROM department_factors
                INNER JOIN factors
                ON department_factors.factor_id = factors.id
                WHERE department_factors.department_id = '.$departmentid.'');
            return DataTables::of($data)
                ->editColumn('Factor',function($data){
                    return '<div class="text-center">'.$data->Factor.'</div>';
                })
                ->editColumn('Related','
                    <div class="text-center">
                        <input data-id="{{$id}}" class="toggle-class" type="checkbox" data-on-color="success" data-off-color="danger" data-toggle="toggle" data-on-text="Yes" data-off-text="No" {{ $Related == "Yes" ? '."'checked'".' : '."''".' }}>
                    </div>
                ')
                ->rawColumns(['Factor','Related'])
                ->make(true);
        }

        $factor = Factor::orderBy('Factor','asc')->get();

        return view('QSHs.assesment',compact('departmentid','factor'));
    }

    public function update_assesment(Request $request)
    {
        $departmentid = $request->department_id_update;

        $department_factor_standard = DB::select('SELECT product_expectation_factors.factor_id
            FROM product_expectation_factors
                INNER JOIN products
                ON product_expectation_factors.product_id = products.id
            WHERE products.department_id = '.$departmentid.' AND product_expectation_factors.Related = "Yes"
            GROUP BY product_expectation_factors.factor_id');

        foreach ($department_factor_standard as $key => $value) {
            $count = DepartmentFactor::where('department_id','=',$departmentid)
                ->where('factor_id','=',$value->factor_id)
                ->count();

            if($count == 0){
                $department_factor = new DepartmentFactor();
                $department_factor->department_id = $departmentid;
                $department_factor->factor_id = $value->factor_id;
                $department_factor->Related = "No";
                $department_factor->save();
            }
        }

        $current_department_factor = DB::select('SELECT *
            FROM department_factors
            WHERE department_factors.department_id = '.$departmentid.'');

        foreach ($current_department_factor as $key => $value) {
            $currentstandard = DB::select('SELECT product_expectation_factors.id
                FROM product_expectation_factors
                INNER JOIN products
                ON product_expectation_factors.product_id = products.id
                WHERE products.department_id ='.$departmentid.' AND product_expectation_factors.factor_id ='.$value->factor_id.'');

            if(count($currentstandard) == 0){
                $department_factor2 = DepartmentFactor::findOrFail($value->id);
                $department_factor2->delete();
            }
        }

        //dd($current_department_factor);

        return back()->with('message','Successfully created Mile Stone!');
    }

    public function assesment_related(Request $request)
    {
        $assesment = DepartmentFactor::find($request->department_factor_id);
        $assesment->Related = $request->Related;
        $assesment->save();

        return response()->json(['success'=>'Done change successfully.']);
    }

    public function schedule(Request $request)
    {
        $yesterday = DB::select('SELECT risk_schedule_all.ProjectName, risk_schedule_all.Activity, risk_schedule_all.TypeOfRisk, risk_schedule_all.Effect, risk_schedule_all.CounterMeasure, risk_schedule_all.Date
            FROM (SELECT projects.ProjectName, q_s_h_schedules.Activity, q_s_h_schedules.TypeOfRisk, q_s_h_schedules.Effect, q_s_h_schedules.CounterMeasure, q_s_h_schedules.Date, projects.color
                FROM projects INNER JOIN q_s_h_schedules ON projects.id = q_s_h_schedules.project_id
                UNION
                SELECT projects.ProjectName, "Confined Space" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, confined_spaces.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN confined_spaces ON projects.id = confined_spaces.project_id
                UNION
                SELECT projects.ProjectName, "Hot Work" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, hot_works.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN hot_works ON projects.id = hot_works.project_id
                UNION
                SELECT projects.ProjectName, "Lifting" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, liftings.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN liftings ON projects.id = liftings.project_id
                UNION
                SELECT projects.ProjectName, "Work at Hight(Scaffold)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, work_at_hights.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN work_at_hights ON projects.id = work_at_hights.project_id
                UNION
                SELECT projects.ProjectName, "Work at Hight(Wind Turbine)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, work_at_hight_winds.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN work_at_hight_winds ON projects.id = work_at_hight_winds.project_id
                UNION
                SELECT projects.ProjectName, "Dangerous Zone(3 จังหวัดชายแดนภาคใต้)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, dangerous_zones.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN dangerous_zones ON projects.id = dangerous_zones.project_id
                UNION
                SELECT projects.ProjectName, "Work Permit" AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, work_permits.Date, projects.color
                FROM projects INNER JOIN work_permits ON projects.id = work_permits.project_id
                UNION
                SELECT projects.ProjectName, participations.Form AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, participations.Date, projects.color
                FROM projects INNER JOIN participations ON projects.id = participations.project_id
                UNION
                SELECT projects.ProjectName, "สังเกตการทำงาน" AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, observations.Date, projects.color
                FROM projects INNER JOIN observations ON projects.id = observations.project_id) AS risk_schedule_all
            WHERE (((risk_schedule_all.Date)=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 DAY),"%Y-%m-%d")))');
        $today = DB::select('SELECT risk_schedule_all.ProjectName, risk_schedule_all.Activity, risk_schedule_all.TypeOfRisk, risk_schedule_all.Effect, risk_schedule_all.CounterMeasure, risk_schedule_all.Date
            FROM (SELECT projects.ProjectName, q_s_h_schedules.Activity, q_s_h_schedules.TypeOfRisk, q_s_h_schedules.Effect, q_s_h_schedules.CounterMeasure, q_s_h_schedules.Date, projects.color
                FROM projects INNER JOIN q_s_h_schedules ON projects.id = q_s_h_schedules.project_id
                UNION
                SELECT projects.ProjectName, "Confined Space" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, confined_spaces.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN confined_spaces ON projects.id = confined_spaces.project_id
                UNION
                SELECT projects.ProjectName, "Hot Work" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, hot_works.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN hot_works ON projects.id = hot_works.project_id
                UNION
                SELECT projects.ProjectName, "Lifting" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, liftings.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN liftings ON projects.id = liftings.project_id
                UNION
                SELECT projects.ProjectName, "Work at Hight(Scaffold)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, work_at_hights.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN work_at_hights ON projects.id = work_at_hights.project_id
                UNION
                SELECT projects.ProjectName, "Work at Hight(Wind Turbine)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, work_at_hight_winds.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN work_at_hight_winds ON projects.id = work_at_hight_winds.project_id
                UNION
                SELECT projects.ProjectName, "Dangerous Zone(3 จังหวัดชายแดนภาคใต้)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, dangerous_zones.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN dangerous_zones ON projects.id = dangerous_zones.project_id
                UNION
                SELECT projects.ProjectName, "Work Permit" AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, work_permits.Date, projects.color
                FROM projects INNER JOIN work_permits ON projects.id = work_permits.project_id
                UNION
                SELECT projects.ProjectName, participations.Form AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, participations.Date, projects.color
                FROM projects INNER JOIN participations ON projects.id = participations.project_id
                UNION
                SELECT projects.ProjectName, "สังเกตการทำงาน" AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, observations.Date, projects.color
                FROM projects INNER JOIN observations ON projects.id = observations.project_id) AS risk_schedule_all
            WHERE (((risk_schedule_all.Date)=DATE_FORMAT(Now(),"%Y-%m-%d")))');
        $tomorrow = DB::select('SELECT risk_schedule_all.ProjectName, risk_schedule_all.Activity, risk_schedule_all.TypeOfRisk, risk_schedule_all.Effect, risk_schedule_all.CounterMeasure, risk_schedule_all.Date
            FROM (SELECT projects.ProjectName, q_s_h_schedules.Activity, q_s_h_schedules.TypeOfRisk, q_s_h_schedules.Effect, q_s_h_schedules.CounterMeasure, q_s_h_schedules.Date, projects.color
                FROM projects INNER JOIN q_s_h_schedules ON projects.id = q_s_h_schedules.project_id
                UNION
                SELECT projects.ProjectName, "Confined Space" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, confined_spaces.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN confined_spaces ON projects.id = confined_spaces.project_id
                UNION
                SELECT projects.ProjectName, "Hot Work" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, hot_works.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN hot_works ON projects.id = hot_works.project_id
                UNION
                SELECT projects.ProjectName, "Lifting" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, liftings.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN liftings ON projects.id = liftings.project_id
                UNION
                SELECT projects.ProjectName, "Work at Hight(Scaffold)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, work_at_hights.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN work_at_hights ON projects.id = work_at_hights.project_id
                UNION
                SELECT projects.ProjectName, "Work at Hight(Wind Turbine)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, work_at_hight_winds.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN work_at_hight_winds ON projects.id = work_at_hight_winds.project_id
                UNION
                SELECT projects.ProjectName, "Dangerous Zone(3 จังหวัดชายแดนภาคใต้)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, dangerous_zones.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN dangerous_zones ON projects.id = dangerous_zones.project_id
                UNION
                SELECT projects.ProjectName, "Work Permit" AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, work_permits.Date, projects.color
                FROM projects INNER JOIN work_permits ON projects.id = work_permits.project_id
                UNION
                SELECT projects.ProjectName, participations.Form AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, participations.Date, projects.color
                FROM projects INNER JOIN participations ON projects.id = participations.project_id
                UNION
                SELECT projects.ProjectName, "สังเกตการทำงาน" AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, observations.Date, projects.color
                FROM projects INNER JOIN observations ON projects.id = observations.project_id) AS risk_schedule_all
            WHERE (((risk_schedule_all.Date)=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 1 DAY),"%Y-%m-%d")))');

        if($request->ajax())
        {
            $data = DB::select('SELECT CONCAT(risk_schedule_all.Activity," - ",risk_schedule_all.ProjectName) AS "description", risk_schedule_all.Activity AS title, risk_schedule_all.Date AS "start", risk_schedule_all.Date AS "end", risk_schedule_all.color
                FROM (SELECT projects.ProjectName, q_s_h_schedules.Activity, q_s_h_schedules.TypeOfRisk, q_s_h_schedules.Effect, q_s_h_schedules.CounterMeasure, q_s_h_schedules.Date, projects.color
                FROM projects INNER JOIN q_s_h_schedules ON projects.id = q_s_h_schedules.project_id
                UNION
                SELECT projects.ProjectName, "Confined Space" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, confined_spaces.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN confined_spaces ON projects.id = confined_spaces.project_id
                UNION
                SELECT projects.ProjectName, "Hot Work" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, hot_works.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN hot_works ON projects.id = hot_works.project_id
                UNION
                SELECT projects.ProjectName, "Lifting" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, liftings.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN liftings ON projects.id = liftings.project_id
                UNION
                SELECT projects.ProjectName, "Work at Hight(Scaffold)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, work_at_hights.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN work_at_hights ON projects.id = work_at_hights.project_id
                UNION
                SELECT projects.ProjectName, "Work at Hight(Wind Turbine)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, work_at_hight_winds.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN work_at_hight_winds ON projects.id = work_at_hight_winds.project_id
                UNION
                SELECT projects.ProjectName, "Dangerous Zone(3 จังหวัดชายแดนภาคใต้)" AS Activity, Null AS TypeOfRisk, Null AS Effect, "ปฏิบัติตามมาตรการควบคุม" AS CounterMeasure, dangerous_zones.PlanedDate AS "Date", projects.color
                FROM projects INNER JOIN dangerous_zones ON projects.id = dangerous_zones.project_id
                UNION
                SELECT projects.ProjectName, "Work Permit" AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, work_permits.Date, projects.color
                FROM projects INNER JOIN work_permits ON projects.id = work_permits.project_id
                UNION
                SELECT projects.ProjectName, participations.Form AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, participations.Date, projects.color
                FROM projects INNER JOIN participations ON projects.id = participations.project_id
                UNION
                SELECT projects.ProjectName, "สังเกตการทำงาน" AS Activity, Null AS TypeOfRisk, Null AS Effect, Null AS CounterMeasure, observations.Date, projects.color
                FROM projects INNER JOIN observations ON projects.id = observations.project_id) AS risk_schedule_all
                WHERE risk_schedule_all.Date>="'.$request->start.'" AND risk_schedule_all.Date<="'.$request->end.'"');

            return response()->json($data);
        }

        return view('QSHs.schedule',compact('yesterday','today','tomorrow'));
    }

    public function schedulecreate(Request $request, $id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE jobx AS (
                SELECT jobs.id, products.ProductName, locations.LocationName, machines.MachineName, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, jobs.project_id, p_m_orders.PMOrder, p_m_orders.PMOrderName, jobs.Remark
                FROM equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (p_m_orders RIGHT JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON p_m_orders.id = jobs.p_m_order_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id
                WHERE (((jobs.project_id)=$id))
                );
            ")
        );

        $projectdetail = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, employees.ThaiName AS PlannerName, employees_1.ThaiName AS SiteEngineerName, employees_2.ThaiName AS AreaManagerName, projects.Status
            FROM employees AS employees_2 RIGHT JOIN (employees AS employees_1 RIGHT JOIN (employees RIGHT JOIN projects ON employees.id = projects.Planner) ON employees_1.id = projects.SiteEngineer) ON employees_2.id = projects.AreaManager
            WHERE (((projects.id)='.$id.'))');

        if($request->ajax())
        {
            $data = DB::select('SELECT q_s_h_schedules.id, q_s_h_schedules.project_id, q_s_h_schedules.Date, q_s_h_schedules.Activity, q_s_h_schedules.TypeOfRisk, q_s_h_schedules.Effect, q_s_h_schedules.CounterMeasure, q_s_h_schedules.created_at
                FROM q_s_h_schedules
                WHERE (((q_s_h_schedules.project_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('created_at',function($data){
                        if ( $data->created_at > $data->Date)
                        return '<div class="text-center text-danger">'.$data->created_at.'</div>';
                        return '<div class="text-center">'.$data->created_at.'</div>';
                    })
                    ->editColumn('Date',function($data){
                        if ( $data->created_at > $data->Date)
                        return '<div class="text-center text-danger">'.$data->Date.'</div>';
                        return '<div class="text-center">'.$data->Date.'</div>';
                    })
                    ->editColumn('Activity',function($data){
                        if ( $data->created_at > $data->Date)
                        return '<div class="text-danger">'.$data->Activity.'</div>';
                        return $data->Activity;
                    })
                    ->editColumn('TypeOfRisk',function($data){
                        if ( $data->created_at > $data->Date)
                        return '<div class="text-danger">'.$data->TypeOfRisk.'</div>';
                        return $data->TypeOfRisk;
                    })
                    ->editColumn('Effect',function($data){
                        if ( $data->created_at > $data->Date)
                        return '<div class="text-danger">'.$data->Effect.'</div>';
                        return $data->Effect;
                    })
                    ->editColumn('CounterMeasure',function($data){
                        if ( $data->created_at > $data->Date)
                        return '<div class="text-danger">'.$data->CounterMeasure.'</div>';
                        return $data->CounterMeasure;
                    })
                    ->addColumn('action','
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    ')
                    ->rawColumns(['created_at','Date','Activity','TypeOfRisk','Effect','CounterMeasure','action'])
                    ->make(true);
        }

        return view('QSHs.schedulecreate',compact('project','projectdetail'));
    }

    public function schedulestore(Request $request)
    {
        $rules = array(
            'Date'=>'required',
            'Activity'=>'required|max:255',
            'TypeOfRisk'=>'required|max:255',
            'Effect'=>'required|max:255',
            'CounterMeasure'=>'required|max:255'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Date' => $request->Date,
            'project_id' => $request->project_id,
            'Activity' => $request->Activity,
            'TypeOfRisk' => $request->TypeOfRisk,
            'Effect' => $request->Effect,
            'CounterMeasure' => $request->CounterMeasure
        );

        QSHSchedule::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function scheduleedit($id)
    {
        if(request()->ajax())
        {
            $data = QSHSchedule::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function scheduleupdate(Request $request, QSHSchedule $id)
    {
        $rules = array(
            'Date'=>'required',
            'Activity'=>'required|max:255',
            'TypeOfRisk'=>'required|max:255',
            'Effect'=>'required|max:255',
            'CounterMeasure'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Date' => $request->Date,
            'project_id' => $request->project_id,
            'Activity' => $request->Activity,
            'TypeOfRisk' => $request->TypeOfRisk,
            'Effect' => $request->Effect,
            'CounterMeasure' => $request->CounterMeasure
        );

        QSHSchedule::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function scheduledestroy($id)
    {
        $data = QSHSchedule::findOrFail($id);
        $data->delete();
    }

    public function stakeholder(Request $request)
    {
        if($request->ajax())
        {
            $data = Stakeholder::leftJoin('locations','stakeholders.location_id','=','locations.id')
                ->join('stakeholder_types','stakeholders.stakeholder_type_id','=','stakeholder_types.id')
                ->select('stakeholders.id','stakeholders.StakeholderName','stakeholder_types.TypeName','locations.LocationThaiName')
                ->get();
            if ( $request->table == 2 ) {
                return DataTables::of($data)
                ->editColumn('id',function($data){
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('LocationThaiName',function($data){
                    return '<div class="text-center">'.$data->LocationThaiName.'</div>';
                })
                ->addColumn('action',function($data){
                    return
                    '<div class="text-center">
                        <button class="edit_stakeholder2 btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete_stakeholder2 btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>';
                })
                ->rawColumns(['id','LocationThaiName','action'])
                ->make(true);
            } else {
                return DataTables::of($data)
                ->editColumn('id',function($data){
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('LocationThaiName',function($data){
                    return '<div class="text-center">'.$data->LocationThaiName.'</div>';
                })
                ->addColumn('action',function($data){
                    return
                    '<div class="text-center">
                        <button class="edit_stakeholder btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete_stakeholder btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>';
                })
                ->rawColumns(['id','LocationThaiName','action'])
                ->make(true);
            }
        }
    }

    public function stakeholderstore(Request $request)
    {
        if ( $request->table_number == 1 ) {
            $rules = array(
                'StakeholderName'=>'required',
                'stakeholder_type_id'=>'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $form_data = array(
                'StakeholderName' => $request->StakeholderName,
                'stakeholder_type_id' => $request->stakeholder_type_id,
                'location_id' => $request->location_id
            );
        } else {
            $rules = array(
                'StakeholderName2'=>'required',
                'stakeholder_type_id2'=>'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $form_data = array(
                'StakeholderName' => $request->StakeholderName2,
                'stakeholder_type_id' => $request->stakeholder_type_id2,
                'location_id' => $request->location_id2
            );
        }

        Stakeholder::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function stakeholderedit($id)
    {
        if(request()->ajax())
        {
            $data = Stakeholder::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function stakeholderupdate(Request $request, Stakeholder $id)
    {
        if ( $request->table_number == 1 ) {
            $rules = array(
                'StakeholderName'=>'required',
                'stakeholder_type_id'=>'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $form_data = array(
                'StakeholderName' => $request->StakeholderName,
                'stakeholder_type_id' => $request->stakeholder_type_id,
                'location_id' => $request->location_id
            );

            Stakeholder::whereId($request->hidden_id_stakeholder)->update($form_data);
        } else {
            $rules = array(
                'StakeholderName2'=>'required',
                'stakeholder_type_id2'=>'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $form_data = array(
                'StakeholderName' => $request->StakeholderName2,
                'stakeholder_type_id' => $request->stakeholder_type_id2,
                'location_id' => $request->location_id2
            );

            Stakeholder::whereId($request->hidden_id_stakeholder2)->update($form_data);
        }

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function stakeholderdestroy($id)
    {
        $data = Stakeholder::findOrFail($id);
        $data->delete();
    }

    public function expectation(Request $request)
    {
        if($request->ajax())
        {
            $data = Expectation::all();
            return DataTables::of($data)
                    ->editColumn('id',function($data){
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->editColumn('MoreDetail',function($data){
                        return nl2br($data->MoreDetail);
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            <button class="edit_expectation btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete_expectation btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>
                    ')
                    ->rawColumns(['id','MoreDetail','action'])
                    ->make(true);
        }
    }

    public function expectationstore(Request $request)
    {
        $rules = array(
            'Expectation'=>'required',
            'MoreDetail'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Expectation' => $request->Expectation,
            'MoreDetail' => $request->MoreDetail
        );

        Expectation::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function expectationedit($id)
    {
        if(request()->ajax())
        {
            $data = Expectation::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function expectationupdate(Request $request, Expectation $id)
    {
        $rules = array(
            'Expectation'=>'required',
            'MoreDetail'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Expectation' => $request->Expectation,
            'MoreDetail' => $request->MoreDetail
        );

        Expectation::whereId($request->hidden_id_expectation)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function expectationdestroy($id)
    {
        $data = Expectation::findOrFail($id);
        $data->delete();
    }

    public function factorcreate(Request $request)
    {
        if($request->ajax())
        {
            $data = Factor::all();
            return DataTables::of($data)
                ->editColumn('id',function($data){
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit_factor btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete_factor btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['id','action'])
                ->make(true);
        }
    }

    public function factorstore(Request $request)
    {
        $rules = array(
            'Factor'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Factor' => $request->Factor
        );

        Factor::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function factoredit($id)
    {
        if(request()->ajax())
        {
            $data = Factor::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function factorupdate(Request $request, Factor $id)
    {
        $rules = array(
            'Factor'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Factor' => $request->Factor
        );

        Factor::whereId($request->hidden_id_factor)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function factordestroy($id)
    {
        $data = Factor::findOrFail($id);
        $data->delete();
    }

    public function projecttypeproduct(Request $request)
    {
        $product = Product::orderBy('ProductName','asc')->get();

        $projecttype = ProjectType::orderBy('TypeName','asc')->get();

        if($request->ajax())
        {
            $data = ProjectTypeProduct::join('project_types','project_type_products.project_type_id','=','project_types.id')
                ->join('products','project_type_products.product_id','=','products.id')
                ->select('project_type_products.id','project_types.TypeName','products.ProductName')
                ->get();
            return DataTables::of($data)
                    ->editColumn('id',function($data){
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->editColumn('TypeName',function($data){
                        return '<div class="text-center">'.$data->TypeName.'</div>';
                    })
                    ->editColumn('ProductName',function($data){
                        return '<div class="text-center">'.$data->ProductName.'</div>';
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>
                    ')
                    ->rawColumns(['id','TypeName','ProductName','action'])
                    ->make(true);
        }

        return view('QSHs.projecttypeproduct',compact('product','projecttype'));
    }

    public function projecttypeproductstore(Request $request)
    {
        $rules = array(
            'project_type_id'=>'required',
            'product_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_type_id' => $request->project_type_id,
            'product_id' => $request->product_id
        );

        ProjectTypeProduct::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function projecttypeproductedit($id)
    {
        if(request()->ajax())
        {
            $data = ProjectTypeProduct::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function projecttypeproductupdate(Request $request, ProjectTypeProduct $id)
    {
        $rules = array(
            'project_type_id'=>'required',
            'product_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_type_id' => $request->project_type_id,
            'product_id' => $request->product_id
        );

        ProjectTypeProduct::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function projecttypeproductdestroy($id)
    {
        $data = ProjectTypeProduct::findOrFail($id);
        $data->delete();
    }

    public function productstakeholder(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT product_stakeholders.id, products.ProductName, stakeholders.StakeholderName
                FROM stakeholders INNER JOIN (products INNER JOIN product_stakeholders ON products.id = product_stakeholders.product_id) ON stakeholders.id = product_stakeholders.stakeholder_id');
            return DataTables::of($data)
                    ->editColumn('id',function($data){
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            <button class="edit_product_stakeholder btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete_product_stakeholder btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>
                    ')
                    ->rawColumns(['id','action'])
                    ->make(true);
        }

        $product = Product::orderBy('ProductName','asc')->get();
        $stakeholder = Stakeholder::orderBy('StakeholderName','asc')->get();

        return view('QSHs.productstakeholder',compact('product','stakeholder'));
    }

    public function productstakeholderstore(Request $request)
    {
        $rules = array(
            'product_id'=>'required',
            'stakeholder_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'product_id' => $request->product_id,
            'stakeholder_id' => $request->stakeholder_id
        );

        ProductStakeholder::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function productstakeholderedit($id)
    {
        if(request()->ajax())
        {
            $data = ProductStakeholder::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function productstakeholderupdate(Request $request, ProductStakeholder $id)
    {
        $rules = array(
            'product_id'=>'required',
            'stakeholder_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'product_id' => $request->product_id,
            'stakeholder_id' => $request->stakeholder_id
        );

        ProductStakeholder::whereId($request->hidden_id_product_stakeholder)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function productstakeholderdestroy($id)
    {
        $data = ProductStakeholder::findOrFail($id);
        $data->delete();
    }

    public function stakeholderexpectation(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT stakeholder_expectations.id, stakeholders.StakeholderName, expectations.Expectation
                FROM stakeholders INNER JOIN (expectations INNER JOIN stakeholder_expectations ON expectations.id = stakeholder_expectations.expectation_id) ON stakeholders.id = stakeholder_expectations.stakeholder_id');
            return DataTables::of($data)
                    ->editColumn('id',function($data){
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            <button class="edit_stakeholder_expectation btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete_stakeholder_expectation btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>
                    ')
                    ->rawColumns(['id','action'])
                    ->make(true);
        }
    }

    public function stakeholderexpectationstore(Request $request)
    {
        $rules = array(
            'stakeholder_id3'=>'required',
            'expectation_id'=>'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'expectation_id' => $request->expectation_id,
            'stakeholder_id' => $request->stakeholder_id3
        );

        StakeholderExpectation::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function stakeholderexpectationedit($id)
    {
        if(request()->ajax())
        {
            $data = StakeholderExpectation::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function stakeholderexpectationupdate(Request $request, StakeholderExpectation $id)
    {
        $rules = array(
            'expectation_id'=>'required',
            'stakeholder_id3'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'expectation_id' => $request->expectation_id,
            'stakeholder_id' => $request->stakeholder_id3
        );

        StakeholderExpectation::whereId($request->hidden_id_stakeholder_expectation)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function stakeholderexpectationdestroy($id)
    {
        $data = StakeholderExpectation::findOrFail($id);
        $data->delete();
    }

    public function stakeholderproject(Request $request, $id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE product_location AS (
                SELECT products.id, products.ProductCode, products.ProductName, machine_sets.location_id AS location_id
                FROM products
                INNER JOIN item_sets
                    INNER JOIN items
                        INNER JOIN jobs
                        ON items.id = jobs.item_id
                        INNER JOIN machine_sets
                        ON items.machine_set_id = machine_sets.id
                    ON item_sets.id = items.item_set_id
                ON products.id = item_sets.product_id
                WHERE jobs.project_id = $id
                GROUP BY products.id, products.ProductCode, products.ProductName, products.Service, machine_sets.location_id
                );
            ")
        );

        $product = DB::table('product_location')
            ->select('id','ProductCode','ProductName')
            ->groupBy('id','ProductCode','ProductName')
            ->orderBy('ProductCode','asc')->get();

        $stakeholder = Stakeholder::where('stakeholder_type_id','=',2)
            ->orderBy('StakeholderName','asc')
            ->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT stakeholder_projects.id, products.ProductName, stakeholders.StakeholderName, stakeholder_types.TypeName, "Yes" AS "Action"
                FROM stakeholder_types
                INNER JOIN stakeholders
                    INNER JOIN stakeholder_projects
                        INNER JOIN products
                        ON stakeholder_projects.product_id = products.id
                    ON stakeholders.id = stakeholder_projects.stakeholder_id
                ON stakeholder_types.id = stakeholders.stakeholder_type_id
                WHERE stakeholder_projects.project_id = '.$id.'
                UNION
                SELECT "" AS id, product.ProductName, stakeholders.StakeholderName, stakeholder_types.TypeName, "No" AS "Action"
                FROM (SELECT id, ProductName
                    FROM product_location
                    GROUP BY id, ProductName) AS product
                INNER JOIN product_stakeholder_expectations
                    INNER JOIN stakeholders
                        INNER JOIN stakeholder_types
                        ON stakeholders.stakeholder_type_id = stakeholder_types.id
                    ON product_stakeholder_expectations.stakeholder_id =stakeholders.id
                    INNER JOIN expectations
                    ON product_stakeholder_expectations.expectation_id = expectations.id
                ON product.id = product_stakeholder_expectations.product_id
                WHERE product_stakeholder_expectations.Related = "Yes" AND stakeholders.stakeholder_type_id In (1,6)
                UNION
                SELECT "" AS id, product_location.ProductName, stakeholders.StakeholderName, stakeholder_types.TypeName, "No" AS "Action"
                FROM product_location
                INNER JOIN product_stakeholder_expectations
                    INNER JOIN stakeholders
                        INNER JOIN stakeholder_types
                        ON stakeholders.stakeholder_type_id = stakeholder_types.id
                    ON product_stakeholder_expectations.stakeholder_id =stakeholders.id
                    INNER JOIN expectations
                    ON product_stakeholder_expectations.expectation_id = expectations.id
                ON product_location.id = product_stakeholder_expectations.product_id
                WHERE product_stakeholder_expectations.Related = "Yes" AND stakeholders.stakeholder_type_id In (3,4) AND product_location.location_id = stakeholders.location_id');
            return DataTables::of($data)
                ->editColumn('TypeName',function($data){
                    return '<div class="text-center">'.$data->TypeName.'</div>';
                })
                ->addColumn('action', function($data) {
                    if ($data->Action == "Yes")
                    return '<div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>';
                    return '<div class="text-center">N/A</div>';
                })
                ->rawColumns(['TypeName','action'])
                ->make(true);
        }

        return view('QSHs.stakeholderproject',compact('project','product','stakeholder'));
    }

    public function stakeholderprojectstore(Request $request)
    {
        $rules = array(
            'stakeholder_id'=>'required',
            'product_id'=>'required',
            'project_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'stakeholder_id' => $request->stakeholder_id,
            'product_id' => $request->product_id,
            'project_id' => $request->project_id
        );

        StakeholderProject::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function stakeholderprojectedit($id)
    {
        if(request()->ajax())
        {
            $data = StakeholderProject::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function stakeholderprojectupdate(Request $request, StakeholderProject $id)
    {
        $rules = array(
            'stakeholder_id'=>'required',
            'product_id'=>'required',
            'project_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'stakeholder_id' => $request->stakeholder_id,
            'product_id' => $request->stakeholder_id,
            'project_id' => $request->project_id
        );

        StakeholderProject::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function stakeholderprojectdestroy($id)
    {
        $data = StakeholderProject::findOrFail($id);
        $data->delete();
    }

    public function expectationfactor(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT expectation_factors.id, expectations.Expectation, factors.Factor
                FROM factors
                INNER JOIN (expectations
                    INNER JOIN expectation_factors
                    ON expectations.id = expectation_factors.expectation_id)
                ON factors.id = expectation_factors.factor_id');
            return DataTables::of($data)
                ->editColumn('id',function($data){
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit_expectation_factor btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete_expectation_factor btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['id','action'])
                ->make(true);
        }
    }

    public function expectationfactorstore(Request $request)
    {
        $rules = array(
            'factor_id'=>'required',
            'expectation_id'=>'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'expectation_id' => $request->expectation_id,
            'factor_id' => $request->factor_id
        );

        ExpectationFactor::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function expectationfactoredit($id)
    {
        if(request()->ajax())
        {
            $data = ExpectationFactor::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function expectationfactorupdate(Request $request, ExpectationFactor $id)
    {
        $rules = array(
            'expectation_id'=>'required',
            'factor_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'expectation_id' => $request->expectation_id,
            'factor_id' => $request->factor_id
        );

        ExpectationFactor::whereId($request->hidden_id_expectation_factor)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function expectationfactordestroy($id)
    {
        $data = ExpectationFactor::findOrFail($id);
        $data->delete();
    }

    public function typeofrisk(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT type_of_risks.id, factors.Factor, type_of_risks.TypeofRisk, type_of_risks.Effect, type_of_risks.EffectValue, type_of_risks.Measure, type_of_risks.Followup
                FROM factors INNER JOIN type_of_risks ON factors.id = type_of_risks.factor_id');
            return DataTables::of($data)
                ->editColumn('EffectValue',function($data){
                    return '<div class="text-center">'.$data->EffectValue.'</div>';
                })
                ->editColumn('Measure',function($data){
                    return nl2br($data->Measure);
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit_type_of_risk btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete_type_of_risk btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['EffectValue','Measure','action'])
                ->make(true);
        }
    }

    public function typeofriskstore(Request $request)
    {
        $rules = array(
            'factor_id'=>'required',
            'TypeofRisk'=>'required',
            'Effect'=>'required',
            'EffectValue'=>'required',
            'Measure'=>'required',
            'Followup'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'TypeofRisk' => $request->TypeofRisk,
            'factor_id' => $request->factor_id,
            'Effect' => $request->Effect,
            'EffectValue' => $request->EffectValue,
            'Measure' => $request->Measure,
            'Followup' => $request->Followup
        );

        TypeOfRisk::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function typeofriskedit($id)
    {
        if(request()->ajax())
        {
            $data = TypeOfRisk::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function typeofriskupdate(Request $request, TypeOfRisk $id)
    {
        $rules = array(
            'factor_id'=>'required',
            'TypeofRisk'=>'required',
            'Effect'=>'required',
            'EffectValue'=>'required',
            'Measure'=>'required',
            'Followup'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'TypeofRisk' => $request->TypeofRisk,
            'factor_id' => $request->factor_id,
            'Effect' => $request->Effect,
            'EffectValue' => $request->EffectValue,
            'Measure' => $request->Measure,
            'Followup' => $request->Followup
        );

        TypeOfRisk::whereId($request->hidden_id_type_of_risk)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function typeofriskdestroy($id)
    {
        $data = TypeOfRisk::findOrFail($id);
        $data->delete();
    }
}
