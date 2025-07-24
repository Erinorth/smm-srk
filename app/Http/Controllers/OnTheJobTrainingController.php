<?php

namespace App\Http\Controllers;

use App\Models\Craft;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use Auth;
use App\Models\Project;
use App\Models\Department;
use App\Models\JobPosition;
use App\Models\Employee;
use App\Models\OnTheJobTraining;
use App\Models\Training;
use Illuminate\Support\Facades\DB as FacadesDB;

class OnTheJobTrainingController extends Controller
{
    public function plan(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT Year(projects.StartDate) AS Year, departments.DepartmentName, on_the_job_trainings.department_id
                FROM departments INNER JOIN (projects INNER JOIN on_the_job_trainings ON projects.id = on_the_job_trainings.project_id) ON departments.id = on_the_job_trainings.department_id
                GROUP BY Year(projects.StartDate), departments.DepartmentName, on_the_job_trainings.department_id
                ORDER BY Year(projects.StartDate) DESC , departments.DepartmentName');
            return DataTables::of($data)
                    ->editColumn('Year', function($data) {
                        return '<div class="text-center">'.$data->Year.'</div>';
                    })
                    ->editColumn('DepartmentName', function($data) {
                        return '<div class="text-center">'.$data->DepartmentName.'</div>';
                    })
                    ->addColumn('print','
                        <div class="text-center">
                            <a class="btnprn btn btn-xs btn-default text-info mx-1 shadow" title="Print" href="'. url('OJTplan/{{$department_id}}/{{$Year}}').'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                        </div>
                    ')
                    ->rawColumns(['Year','DepartmentName','print'])
                    ->make(true);
        }

        return view('onthejobtrainings.plan');
    }

    public function project(Request $request, $projectid)
    {
        $project = Project::find($projectid);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE course AS (
                SELECT courses.id, courses.ForDepartment, departments.DepartmentName, courses.ForPosition, job_positions.JobPositionName, courses.CourseName, courses.Type, courses.OnSite
                FROM job_positions INNER JOIN (departments INNER JOIN courses ON departments.id = courses.ForDepartment) ON job_positions.id = courses.ForPosition
                );

            CREATE TEMPORARY TABLE ojt AS (
                SELECT on_the_job_trainings.employee_id, on_the_job_trainings.course_id, on_the_job_trainings.Approver
                FROM on_the_job_trainings
                WHERE (((on_the_job_trainings.employee_id)=7) AND ((on_the_job_trainings.Approver) IS NOT NULL))
                );
            ")
        );

        $department = Department::orderBy('DepartmentName','asc')->get();
        $location = DB::select('SELECT locations.id, locations.LocationName
            FROM (locations INNER JOIN machine_sets ON locations.id = machine_sets.location_id) INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON machine_sets.id = items.machine_set_id
            GROUP BY locations.id, locations.LocationName, jobs.project_id
            HAVING (((jobs.project_id)='.$projectid.'))');
        $jobposition = JobPosition::orderBy('JobPositionName','asc')->get();
        $employee = Employee::orderBy('ThaiName','asc')->get();
        $course = DB::select('SELECT course.*
            FROM course LEFT JOIN ojt ON course.id = ojt.course_id
            WHERE (((ojt.Approver) IS NULL)) AND (course.OnSite = "Yes")');

        if($request->ajax())
        {
            $data = DB::select('SELECT on_the_job_trainings.id, departments.DepartmentName, job_positions.JobPositionName, employees.ThaiName, courses.Type, courses.CourseName, on_the_job_trainings.project_id, locations.LocationName, on_the_job_trainings.Approver, employees_1.ThaiName AS CoachName, employees_1.user_id AS Coach_id, on_the_job_trainings.Result
                FROM employees AS employees_1 INNER JOIN ((departments INNER JOIN (courses INNER JOIN (employees INNER JOIN (job_positions INNER JOIN on_the_job_trainings ON job_positions.id = on_the_job_trainings.job_position_id) ON employees.id = on_the_job_trainings.employee_id) ON courses.id = on_the_job_trainings.course_id) ON departments.id = on_the_job_trainings.department_id) INNER JOIN locations ON on_the_job_trainings.location_id = locations.id) ON employees_1.id = on_the_job_trainings.coach_id
                WHERE (((on_the_job_trainings.project_id)='.$projectid.'))
                ORDER BY job_positions.JobPositionName, employees.ThaiName, courses.Type, courses.CourseName');
            return DataTables::of($data)
                ->editColumn('DepartmentName', function($data) {
                    return '<div class="text-center">'.$data->DepartmentName.'</div>';
                })
                ->editColumn('LocationName', function($data) {
                    return '<div class="text-center">'.$data->LocationName.'</div>';
                })
                ->editColumn('JobPositionName', function($data) {
                    return '<div class="text-center">'.$data->JobPositionName.'</div>';
                })
                ->editColumn('ThaiName', function($data) {
                    return '<div class="text-center">'.$data->ThaiName.'</div>';
                })
                ->editColumn('Course', function($data) {
                    return '<div class="text-center">'.$data->Type.' / '.$data->CourseName.'</div>';
                })
                ->editColumn('CoachName', function($data) {
                    return '<div class="text-center">'.$data->CoachName.'</div>';
                })
                ->editColumn('Result',function($data) {
                    if ( $data->Result == "" ) {
                        return '<div class="text-center">ยังไม่ได้ประเมิน</div>';
                    } else {
                        return '<div class="text-center">'.$data->Result.'</div>';
                    }
                })
                ->addColumn('action',function($data) {
                    if ( $data->Coach_id == Auth::user()->id ) {
                        if ( $data->Approver == "" ) {
                            return '
                            <div class="text-center">
                                <button class="evaluate btn btn-xs btn-default text-info mx-1 shadow" name="edit" id="'.$data->id.'" title="Evaluate"><i class="fa fa-lg fa-fw fa-ruler-vertical"></i></button>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>';
                        } else {
                            return '<div class="text-center">Approved</div>';
                        }
                    } else {
                        if ( $data->Approver == "" ) {
                            return '
                            <div class="text-center">
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>';
                        } else {
                            return '<div class="text-center">N/A</div>';
                        }
                    }
                })
                ->rawColumns(['DepartmentName','LocationName','JobPositionName','ThaiName','Course','CoachName','Result','action'])
                ->make(true);
        }

        $craft = Craft::all();

        return view('onthejobtrainings.project',compact('project','department','location','jobposition','employee','course','craft'));
    }

    public function projectstore(Request $request)
    {
        $rules = array(
            'department_id'=>'required',
            'location_id'=>'required',
            'job_position_id'=>'required',
            'employee_id'=>'required',
            'course_id' => 'required',
            'coach_id' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'department_id' => $request->department_id,
            'location_id' => $request->location_id,
            'job_position_id' => $request->job_position_id,
            'employee_id' => $request->employee_id,
            'course_id' => $request->course_id,
            'coach_id' => $request->coach_id,
            'project_id' => $request->project_id
        );

        OnTheJobTraining::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function projectedit($id)
    {
        if(request()->ajax())
        {
            $data = OnTheJobTraining::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function projectupdate(Request $request, OnTheJobTraining $id)
    {
        $rules = array(
            'department_id'=>'required',
            'location_id'=>'required',
            'job_position_id'=>'required',
            'employee_id'=>'required',
            'course_id' => 'required',
            'coach_id' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'department_id' => $request->department_id,
            'location_id' => $request->location_id,
            'job_position_id' => $request->job_position_id,
            'employee_id' => $request->employee_id,
            'course_id' => $request->course_id,
            'coach_id' => $request->coach_id,
            'project_id' => $request->project_id,
            'EvaluationDate' => NULL,
            'Result' => NULL
        );

        OnTheJobTraining::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function projectdestroy($id)
    {
        $data = OnTheJobTraining::findOrFail($id);
        $data->delete();
    }

    public function evaluation(Request $request, OnTheJobTraining $id)
    {
        $rules = array(
            'EvaluationDate'=>'required',
            'Result'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'EvaluationDate' => $request->EvaluationDate,
            'Result' => $request->Result
        );

        OnTheJobTraining::whereId($request->hidden_id2)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    function fetchjobposition(Request $request)
    {
        $departmentid = $request->get('departmentid');
        $data = DB::select('SELECT courses.ForDepartment, courses.ForPosition, job_positions.JobPositionName
            FROM job_positions INNER JOIN courses ON job_positions.id = courses.ForPosition
            GROUP BY courses.ForDepartment, courses.ForPosition, job_positions.JobPositionName
            HAVING (((courses.ForDepartment)='.$departmentid.'))');
        $output = '<option value="">Job Position</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->ForPosition.'">'.$row->JobPositionName.'</option>';
        }
        echo $output;
    }

    function fetchcourse(Request $request)
    {
        $departmentid = $request->get('departmentid');
        $jobpositionid = $request->get('jobpositionid');
        $employeeid = $request->get('employeeid');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE course AS (
                SELECT courses.id, courses.ForDepartment, departments.DepartmentName, courses.ForPosition, job_positions.JobPositionName, courses.CourseName, courses.Type
                FROM job_positions INNER JOIN (departments INNER JOIN courses ON departments.id = courses.ForDepartment) ON job_positions.id = courses.ForPosition
                GROUP BY courses.id, courses.ForDepartment, departments.DepartmentName, courses.ForPosition, job_positions.JobPositionName, courses.CourseName, courses.Type
                ORDER BY courses.CourseName
                );

            CREATE TEMPORARY TABLE ojt AS (
                SELECT on_the_job_trainings.employee_id, on_the_job_trainings.course_id, on_the_job_trainings.Approver
                FROM on_the_job_trainings
                WHERE (((on_the_job_trainings.employee_id)=$employeeid) AND ((on_the_job_trainings.Approver) IS NOT NULL))
                );
            ")
        );

        $data = DB::select('SELECT course.*, ojt.Approver, course.ForDepartment, course.ForPosition
            FROM course LEFT JOIN ojt ON course.id = ojt.course_id
            WHERE (((ojt.Approver) Is Null) AND ((course.ForDepartment)='.$departmentid.') AND ((course.ForPosition)='.$jobpositionid.'))');
        $output = '<option value="">Course</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->CourseName.'</option>';
        }
        echo $output;
    }

    public function office(Request $request)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE course AS (
                SELECT courses.id, courses.ForDepartment, departments.DepartmentName, courses.ForPosition, job_positions.JobPositionName, courses.CourseName, courses.Type, courses.OnSite
                FROM job_positions INNER JOIN (departments INNER JOIN courses ON departments.id = courses.ForDepartment) ON job_positions.id = courses.ForPosition
                );

            CREATE TEMPORARY TABLE ojt AS (
                SELECT on_the_job_trainings.employee_id, on_the_job_trainings.course_id, on_the_job_trainings.Approver
                FROM on_the_job_trainings
                WHERE (((on_the_job_trainings.employee_id)=7) AND ((on_the_job_trainings.Approver) IS NOT NULL))
                );
            ")
        );

        $department = Department::orderBy('DepartmentName','asc')->get();
        $jobposition = JobPosition::orderBy('JobPositionName','asc')->get();
        $employee = Employee::orderBy('ThaiName','asc')->get();
        $course = DB::select('SELECT course.*
            FROM course LEFT JOIN ojt ON course.id = ojt.course_id
            WHERE (((ojt.Approver) IS NULL)) AND (course.OnSite = "No")');
        $craft = Craft::all();

        if($request->ajax())
        {
            $data = DB::select('SELECT on_the_job_trainings.id, departments.DepartmentName, job_positions.JobPositionName, employees.ThaiName, courses.Type, courses.CourseName, on_the_job_trainings.project_id, on_the_job_trainings.Approver, employees_1.ThaiName AS CoachName, employees_1.user_id AS Coach_id
                FROM employees AS employees_1 INNER JOIN (departments INNER JOIN (courses INNER JOIN (employees INNER JOIN (job_positions INNER JOIN on_the_job_trainings ON job_positions.id = on_the_job_trainings.job_position_id) ON employees.id = on_the_job_trainings.employee_id) ON courses.id = on_the_job_trainings.course_id) ON departments.id = on_the_job_trainings.department_id) ON employees_1.id = on_the_job_trainings.coach_id
                WHERE (((on_the_job_trainings.project_id) Is Null))
                ORDER BY job_positions.JobPositionName, employees.ThaiName, courses.Type, courses.CourseName');
            return DataTables::of($data)
                ->editColumn('DepartmentName', function($data) {
                    return '<div class="text-center">'.$data->DepartmentName.'</div>';
                })
                ->editColumn('JobPositionName', function($data) {
                    return '<div class="text-center">'.$data->JobPositionName.'</div>';
                })
                ->editColumn('ThaiName', function($data) {
                    return '<div class="text-center">'.$data->ThaiName.'</div>';
                })
                ->editColumn('Course', function($data) {
                    return '<div class="text-center">'.$data->Type.' / '.$data->CourseName.'</div>';
                })
                ->editColumn('CoachName', function($data) {
                    return '<div class="text-center">'.$data->CoachName.'</div>';
                })
                ->addColumn('action',function($data) {
                    if ( $data->Coach_id == Auth::user()->id ) {
                        if ( $data->Approver == "" ) {
                            return '
                            <div class="text-center">
                                <button class="evaluate btn btn-xs btn-default text-info mx-1 shadow" name="edit" id="'.$data->id.'" title="Evaluate"><i class="fa fa-lg fa-fw fa-ruler-vertical"></i></button>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>';
                        } else {
                            return '<div class="text-center">Approved</div>';
                        }
                    } else {
                        if ( $data->Approver == "" ) {
                            return '
                            <div class="text-center">
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>';
                        } else {
                            return '<div class="text-center">N/A</div>';
                        }
                    }
                })
                ->rawColumns(['DepartmentName','LocationName','JobPositionName','ThaiName','Course','CoachName','action'])
                ->make(true);
        }

        return view('onthejobtrainings.office',compact('department','jobposition','employee','course','craft'));
    }
    public function officestore(Request $request)
    {
        $rules = array(
            'department_id'=>'required',
            'job_position_id'=>'required',
            'employee_id'=>'required',
            'course_id' => 'required',
            'coach_id' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'department_id' => $request->department_id,
            'job_position_id' => $request->job_position_id,
            'employee_id' => $request->employee_id,
            'course_id' => $request->course_id,
            'coach_id' => $request->coach_id,
        );

        OnTheJobTraining::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function officeedit($id)
    {
        if(request()->ajax())
        {
            $data = OnTheJobTraining::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function officeupdate(Request $request, OnTheJobTraining $id)
    {
        $rules = array(
            'department_id'=>'required',
            'job_position_id'=>'required',
            'employee_id'=>'required',
            'course_id' => 'required',
            'coach_id' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'department_id' => $request->department_id,
            'job_position_id' => $request->job_position_id,
            'employee_id' => $request->employee_id,
            'course_id' => $request->course_id,
            'coach_id' => $request->coach_id,
            'EvaluationDate' => NULL,
            'Result' => NULL
        );

        OnTheJobTraining::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function officedestroy($id)
    {
        $data = OnTheJobTraining::findOrFail($id);
        $data->delete();
    }

    public function approved(Request $request)
    {
        $auth = Employee::where('user_id','=',Auth::user()->id)->first();

        if($request->ajax())
        {
            $data = DB::select('SELECT on_the_job_trainings.id, courses.CourseName, projects.ProjectName, locations.LocationThaiName, employees_2.ThaiName AS Trainee, employees.ThaiName AS Coach, on_the_job_trainings.EvaluationDate, on_the_job_trainings.Result, employees_1.ThaiName AS Approver, on_the_job_trainings.ApprovedDate, employees_2.department_id AS TraineeDepartment, employees.department_id AS CoachDepartment, '.$auth->department_id.' AS ApproverDepartment
                FROM employees AS employees_2 INNER JOIN (employees AS employees_1 RIGHT JOIN (employees INNER JOIN (locations RIGHT JOIN (projects RIGHT JOIN (courses INNER JOIN on_the_job_trainings ON courses.id = on_the_job_trainings.course_id) ON projects.id = on_the_job_trainings.project_id) ON locations.id = on_the_job_trainings.location_id) ON employees.id = on_the_job_trainings.coach_id) ON employees_1.id = on_the_job_trainings.Approver) ON employees_2.id = on_the_job_trainings.employee_id
                WHERE (((employees_2.department_id)='.$auth->department_id.')) OR (((employees.department_id)='.$auth->department_id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('ProjectName', function($data) {
                    if ( $data->ProjectName == "" ) {
                        return '<div class="text-center">N/A</div>';
                    } else {
                        return '<div class="text-center">'.$data->ProjectName.'</div>';
                    }
                })
                ->editColumn('LocationThaiName', function($data) {
                    if ( $data->ProjectName == "" ) {
                        return '<div class="text-center">Office</div>';
                    } else {
                        return '<div class="text-center">'.$data->LocationThaiName.'</div>';
                    }
                })
                ->editColumn('Trainee', function($data) {
                    return '<div class="text-center">'.$data->Trainee.'</div>';
                })
                ->editColumn('Coach', function($data) {
                    return '<div class="text-center">'.$data->Coach.'</div>';
                })
                ->editColumn('result', function($data) {
                    if ( $data->Result == "" ) {
                        return '<div class="text-center">ยังไม่ได้ประเมิน</div>';
                    } else {
                        return '<div class="text-center">'.$data->Result.'</div>';
                    }
                })
                ->editColumn('approve', function($data) {
                    if ( $data->Approver == "" ) {
                        return '<div class="text-center">ยังไม่ได้รับรอง</div>';
                    } else {
                        return '<div class="text-center">'.$data->Approver.'/'.$data->ApprovedDate.'</div>';
                    }
                })
                ->addColumn('action', function($data) {
                    if ( $data->Result == 'ผ่าน' ) {
                        if ( $data->CoachDepartment == $data->ApproverDepartment ) {
                            return view('onthejobtrainings.approvedaction',compact('data'));
                        } else {
                            if ( $data->ProjectName == "" ) {
                                return '
                                    <div class="text-center">
                                        <a class="btnprn btn btn-xs btn-default text-info mx-1 shadow" title="Print" href="'.url('OJTevaluation_office/'.$data->id).'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                    </div>
                                ';
                            } else {
                                return '
                                    <div class="text-center">
                                        <a class="btnprn btn btn-xs btn-default text-info mx-1 shadow" title="Print" href="'.url('OJTevaluation/'.$data->id).'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                    </div>
                                ';
                            }
                        }
                    } else {
                        if ( $data->ProjectName == "" ) {
                            return '
                                <div class="text-center">
                                    <a class="btnprn btn btn-xs btn-default text-info mx-1 shadow" title="Print" href="'.url('OJTevaluation_office/'.$data->id).'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                </div>
                            ';
                        } else {
                            return '
                                <div class="text-center">
                                    <a class="btnprn btn btn-xs btn-default text-info mx-1 shadow" title="Print" href="'.url('OJTevaluation/'.$data->id).'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                </div>
                            ';
                        }
                    }
                })
                ->rawColumns(['id','ProjectName','LocationThaiName','Trainee','Coach','result','approve','action'])
                ->make(true);
        }

        $employee = Employee::orderBy('Thainame','asc')->get();

        return view('onthejobtrainings.approved',compact('auth','employee'));
    }

    public function approvededit($id)
    {
        if(request()->ajax())
        {
            $data = OnTheJobTraining::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function approvedupdate(Request $request, OnTheJobTraining $id)
    {
        $approver = Employee::where('user_id','=',Auth::user()->id)->first();

        $rules = array(
            'ApprovedDate'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Approver' => $approver->id,
            'ApprovedDate' => $request->ApprovedDate
        );

        OnTheJobTraining::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function record(Request $request)
    {
        if($request->ajax())
        {
            $data = Employee::all();
            return DataTables::of($data)
                    ->editColumn('WorkID', function($data) {
                        return '<div class="text-center">'.$data->WorkID.'</div>';
                    })
                    ->addColumn('Detail', function($data) {
                        return '<div class="text-center">
                                    <a href="'.url('OJTrecord/'.$data->id.'').'" class="btn btn-info btn-sm btnprn">OJT Record</a>
                                    <a href="'.url('OJTotherrecord/'.$data->id.'').'" class="btn btn-info btn-sm btnprn">OJT and Others Record</a>
                                </div>';
                    })
                    ->rawColumns(['WorkID','Detail'])
                    ->make(true);
        }

        return view('onthejobtrainings.record');
    }

    public function training(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT trainings.id, employees.ThaiName, trainings.Course, Recorder.ThaiName AS Recorder, Approver.ThaiName AS Approver, trainings.ApprovedDate
                FROM trainings
                INNER JOIN employees
                ON trainings.employee_id = employees.id
                INNER JOIN employees AS Recorder
                ON trainings.Recorder = Recorder.id
                INNER JOIN employees AS Approver
                ON trainings.Approver = Approver.id');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('ApprovedDate', function($data) {
                    return '<div class="text-center">'.$data->ApprovedDate.'</div>';
                })
                ->addColumn('action',function($data) {
                    return '
                    <div class="text-center">
                        <button class="edit_training btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete_training btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>';
                })
                ->rawColumns(['id','ApprovedDate','action'])
                ->make(true);
        }
    }

    public function trainingstore(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        $department = Department::find($employee->department_id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE recorder AS (
                SELECT allemployee.id
                FROM (SELECT employees.id, employees.user_id
                    FROM employees
                    WHERE employees.department_id = $employee->department_id) AS allemployee
                INNER JOIN model_has_roles
                ON allemployee.user_id = model_has_roles.model_id
                WHERE model_has_roles.role_id = 15
                );

            CREATE TEMPORARY TABLE approver AS (
                SELECT allemployee2.id
                FROM (SELECT employees.id, employees.user_id
                    FROM employees
                    WHERE employees.department_id = $department->department_id) AS allemployee2
                INNER JOIN model_has_roles
                ON allemployee2.user_id = model_has_roles.model_id
                WHERE model_has_roles.role_id = 16
                );
            ")
        );

        $recorder = DB::table('recorder')->first();
        $approver = DB::table('approver')->first();

        $rules = array(
            'employee_id'=>'required',
            'Course'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id,
            'Course' => $request->Course,
            'Recorder' => $recorder->id,
            'Approver' => $approver->id,
            'ApprovedDate' => date_format(now(),'Y-m-d')
        );

        Training::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function trainingedit($id)
    {
        if(request()->ajax())
        {
            $data = Training::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function trainingupdate(Request $request, Training $id)
    {
        $rules = array(
            'employee_id'=>'required',
            'Course'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'employee_id' => $request->employee_id,
            'Course' => $request->Course
        );

        Training::whereId($request->hidden_id_training)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function trainingdestroy($id)
    {
        $data = Training::findOrFail($id);
        $data->delete();
    }
}
