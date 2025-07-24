<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Project;
use App\Models\PerformanceEmployee;
use App\Models\PerformanceProject;

class PerformanceController extends Controller
{
    public function employee(Request $request, $id)
    {
        $project = Project::find($id);

        $employee = DB::select('SELECT employees.id, employees.ThaiName
            FROM employees
            ORDER BY employees.ThaiName');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE avr_performance AS (
                SELECT performance_employees.id, (performance_employees.SafetyHealth+performance_employees.Quality+performance_employees.TeamWork+performance_employees.MoralGoodGovernance+performance_employees.Innovation+performance_employees.Planing+performance_employees.Professional+performance_employees.Digital)/8 AS AVR
                FROM performance_employees
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::select('SELECT performance_employees.project_id, performance_employees.id, employees.ThaiName, performance_employees.Day, performance_employees.SafetyHealth, performance_employees.SafetyHealthRemark, performance_employees.Quality, performance_employees.QualityRemark, performance_employees.TeamWork, performance_employees.TeamWorkRemark, performance_employees.Planing, performance_employees.PlaningRemark, performance_employees.MoralGoodGovernance, performance_employees.MoralGoodGovernanceRemark, performance_employees.Professional, performance_employees.ProfessionalRemark, performance_employees.Innovation, performance_employees.InnovationRemark, performance_employees.Digital, performance_employees.DigitalRemark, avr_performance.AVR
                FROM avr_performance INNER JOIN (employees INNER JOIN performance_employees ON employees.id = performance_employees.employee_id) ON avr_performance.id = performance_employees.id
                WHERE (((performance_employees.project_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('ThaiName', function($data) {
                        return '<div style="font-size:80%;">'.$data->ThaiName.'</div>';
                    })
                    ->editColumn('Day', function($data) {
                        return '<div class="text-center" style="font-size:80%;">'.$data->Day.'</div>';
                    })
                    ->editColumn('SafetyHealth', function($data) {
                        return '<div class="text-center" style="font-size:80%;">'.number_format($data->SafetyHealth,2).'</div>';
                    })
                    ->editColumn('Quality', function($data) {
                        return '<div class="text-center" style="font-size:80%;">'.number_format($data->Quality,2).'</div>';
                    })
                    ->editColumn('TeamWork', function($data) {
                        return '<div class="text-center" style="font-size:80%;">'.number_format($data->TeamWork,2).'</div>';
                    })
                    ->editColumn('MoralGoodGovernance', function($data) {
                        return '<div class="text-center" style="font-size:80%;">'.number_format($data->MoralGoodGovernance,2).'</div>';
                    })
                    ->editColumn('Digital', function($data) {
                        return '<div class="text-center" style="font-size:80%;">'.number_format($data->Digital,2).'</div>';
                    })
                    ->editColumn('Innovation', function($data) {
                        return '<div class="text-center" style="font-size:80%;">'.number_format($data->Innovation,2).'</div>';
                    })
                    ->editColumn('Planing', function($data) {
                        return '<div class="text-center" style="font-size:80%;">'.number_format($data->Planing,2).'</div>';
                    })
                    ->editColumn('Professional', function($data) {
                        return '<div class="text-center" style="font-size:80%;">'.number_format($data->Professional,2).'</div>';
                    })
                    ->editColumn('AVR', function($data) {
                        return '<div class="text-center" style="font-size:80%;">'.number_format($data->AVR,2).'</div>';
                    })
                    ->addColumn('action','
                        <div class="text-center" style="font-size:80%;">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>
                    ')
                    ->rawColumns(['ThaiName','Day','SafetyHealth','Quality','TeamWork','MoralGoodGovernance','Digital','Innovation','Planing','Professional','AVR','action'])
                    ->make(true);
        }
        return view('performances.employee',compact('project','employee'));
    }

    public function employeestore(Request $request)
    {
        $rules = array(
            'employee_id'=>'required',
            'Day'=>'required|Integer',
            'SafetyHealth'=>'required|numeric',
            'Quality' => 'required|numeric',
            'TeamWork' => 'required|numeric',
            'MoralGoodGovernance' => 'required|numeric',
            'Digital' => 'required|numeric',
            'Innovation' => 'required|numeric',
            'Planing' => 'required|numeric',
            'Professional' => 'required|numeric'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'employee_id' => $request->employee_id,
            'Day' => $request->Day,
            'SafetyHealth' => $request->SafetyHealth,
            'SafetyHealthRemark' => $request->SafetyHealthRemark,
            'Quality' => $request->Quality,
            'QualityRemark' => $request->QualityRemark,
            'TeamWork' => $request->TeamWork,
            'TeamWorkRemark' => $request->TeamWorkRemark,
            'MoralGoodGovernance' => $request->MoralGoodGovernance,
            'MoralGoodGovernanceRemark' => $request->MoralGoodGovernanceRemark,
            'Digital' => $request->Digital,
            'DigitalRemark' => $request->DigitalRemark,
            'Innovation' => $request->Innovation,
            'InnovationRemark' => $request->InnovationRemark,
            'Planing' => $request->Planing,
            'PlaningRemark' => $request->PlaningRemark,
            'Professional' => $request->Professional,
            'ProfessionalRemark' => $request->ProfessionalRemark
        );

        PerformanceEmployee::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function employeeedit($id)
    {
        if(request()->ajax())
        {
            $data = PerformanceEmployee::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function employeeupdate(Request $request,PerformanceEmployee $id)
    {
        $rules = array(
            'employee_id'=>'required',
            'Day'=>'required|Integer',
            'SafetyHealth'=>'required|numeric',
            'Quality' => 'required|numeric',
            'TeamWork' => 'required|numeric',
            'MoralGoodGovernance' => 'required|numeric',
            'Digital' => 'required|numeric',
            'Innovation' => 'required|numeric',
            'Planing' => 'required|numeric',
            'Professional' => 'required|numeric'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'employee_id' => $request->employee_id,
            'Day' => $request->Day,
            'SafetyHealth' => $request->SafetyHealth,
            'SafetyHealthRemark' => $request->SafetyHealthRemark,
            'Quality' => $request->Quality,
            'QualityRemark' => $request->QualityRemark,
            'TeamWork' => $request->TeamWork,
            'TeamWorkRemark' => $request->TeamWorkRemark,
            'MoralGoodGovernance' => $request->MoralGoodGovernance,
            'MoralGoodGovernanceRemark' => $request->MoralGoodGovernanceRemark,
            'Digital' => $request->Digital,
            'DigitalRemark' => $request->DigitalRemark,
            'Innovation' => $request->Innovation,
            'InnovationRemark' => $request->InnovationRemark,
            'Planing' => $request->Planing,
            'PlaningRemark' => $request->PlaningRemark,
            'Professional' => $request->Professional,
            'ProfessionalRemark' => $request->ProfessionalRemark
        );

        PerformanceEmployee::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function employeedestroy($id)
    {
        $data = PerformanceEmployee::findOrFail($id);
        $data->delete();
    }

    public function project($id)
    {
        $project = Project::find($id);

        $performance = PerformanceProject::where('project_id','=',$id)->get();

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE performance AS (
                SELECT *
                FROM performance_projects
                WHERE project_id = $id
                );
            ")
        );

        //dd($performance);

        return view('performances.project',compact('project','performance'));
    }

    public function projectstore(Request $request)
    {
        $rules = array(
            'ISO' => 'nullable|numeric|between:1,5',
            'KPI' => 'nullable|numeric|between:1,5'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'SafetyHealth' => $request->SafetyHealth,
            'Quality' => $request->Quality,
            'Duration' => $request->Duration,
            'ManHour' => $request->ManHour,
            'WastingTime' => $request->WastingTime,
            'ManHourRatio' => $request->ManHourRatio,
            'MileStone' => $request->MileStone,
            'ISO' => $request->ISO,
            'KPI' => $request->KPI
        );

        PerformanceProject::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function projectedit($id)
    {
        if(request()->ajax())
        {
            $data = PerformanceProject::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function projectupdate(Request $request,PerformanceProject $id)
    {
        $rules = array(
            'ISO' => 'nullable|numeric|between:1,5',
            'KPI' => 'nullable|numeric|between:1,5'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_id' => $request->project_id,
            'SafetyHealth' => $request->SafetyHealth,
            'Quality' => $request->Quality,
            'Duration' => $request->Duration,
            'ManHour' => $request->ManHour,
            'WastingTime' => $request->WastingTime,
            'ManHourRatio' => $request->ManHourRatio,
            'MileStone' => $request->MileStone,
            'ISO' => $request->ISO,
            'KPI' => $request->KPI
        );

        PerformanceProject::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function projectdestroy($id)
    {
        $data = PerformanceProject::findOrFail($id);
        $data->delete();
    }
}
