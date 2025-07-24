<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\MileStoneActivity;
use App\Models\Project;
use App\Models\MileStone;
use App\Models\MileStoneUpdate;
use App\Models\MilestoneOffice;
use App\Models\ProjectType;
use App\Models\ProjectTypeActivity;
use Illuminate\Support\Facades\DB as FacadesDB;

class MilestoneController extends Controller
{
    public function activity(Request $request)
    {
        $responsible = DB::select('SELECT job_positions.id, job_positions.JobPositionName
            FROM job_positions
            ORDER BY job_positions.JobPositionName');

        $list = ProjectType::orderBy('id','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT mile_stone_activities.id, mile_stone_activities.Activity, mile_stone_activities.BeforeStart, mile_stone_activities.AfterStart, mile_stone_activities.BeforeFinish, mile_stone_activities.AfterFinish, mile_stone_activities.Document, mile_stone_activities.Link, job_positions.JobPositionName, mile_stone_activities.Folder, mile_stone_activities.Dynamic
                FROM job_positions INNER JOIN mile_stone_activities ON job_positions.id = mile_stone_activities.Responsible');
            return DataTables::of($data)
                ->editColumn('BeforeStart', function($data) {
                    return '<div class="text-center">'.$data->BeforeStart.'</div>';
                })
                ->editColumn('AfterStart', function($data) {
                    return '<div class="text-center">'.$data->AfterStart.'</div>';
                })
                ->editColumn('BeforeFinish', function($data) {
                    return '<div class="text-center">'.$data->BeforeFinish.'</div>';
                })
                ->editColumn('AfterFinish', function($data) {
                    return '<div class="text-center">'.$data->AfterFinish.'</div>';
                })
                ->editColumn('Dynamic', function($data) {
                    return '<div class="text-center">'.$data->Dynamic.'</div>';
                })
                ->addColumn('action','
                    @role('."'admin|head_engineering|head_operation'".')
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    @else <div class="text-center">N/A</div>
                    @endrole
                ')
                ->rawColumns(['BeforeStart','AfterStart','BeforeFinish','AfterFinish','Dynamic','action'])
                ->make(true);
        }

        return view('milestones.activity',compact('responsible','list'));
    }

    public function activitystore(Request $request)
    {
        $rules = array(
            'Activity' =>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Activity' => $request->Activity,
            'BeforeStart' => $request->BeforeStart,
            'AfterStart' => $request->AfterStart,
            'BeforeFinish' => $request->BeforeFinish,
            'AfterFinish' => $request->AfterFinish,
            'Document' => $request->Document,
            'Folder' => $request->Folder,
            'Link' => $request->Link,
            'Dynamic' => $request->Dynamic,
            'Responsible' => $request->Responsible
        );

        MileStoneActivity::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function activityedit($id)
    {
        if(request()->ajax())
        {
            $data = MileStoneActivity::findOrFail($id);

            return response()->json(['result' => $data]);
        }
    }

    public function activityupdate(Request $request,MileStoneActivity $id)
    {
        $rules = array(
            'Activity' =>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Activity' => $request->Activity,
            'BeforeStart' => $request->BeforeStart,
            'AfterStart' => $request->AfterStart,
            'BeforeFinish' => $request->BeforeFinish,
            'AfterFinish' => $request->AfterFinish,
            'Document' => $request->Document,
            'Folder' => $request->Folder,
            'Link' => $request->Link,
            'Dynamic' => $request->Dynamic,
            'Responsible' => $request->Responsible
        );

        MileStoneActivity::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function all(Request $request)
    {
        $responsible = Employee::orderBy('ThaiName','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT milestone_offices.id AS office_id, "" AS project_id, milestone_offices.JobName, milestone_offices.StartDate, milestone_offices.DueDate, milestone_offices.Type, milestone_offices.Remark, employees.ThaiName AS Responsible
                FROM milestone_offices
                    INNER JOIN employees
                    ON milestone_offices.Responsible = employees.id
                UNION
                SELECT "" AS office_id, mile_stones.project_id, projects.ProjectName AS JobName, projects.StartDate, projects.FinishDate AS DueDate, "Maintenance Project" AS "Type", "" AS Remark, CONCAT(employees.ThaiName,", ",employees1.ThaiName) AS Responsible
                FROM projects
                    INNER JOIN mile_stones
                    ON projects.id = mile_stones.project_id
                    INNER JOIN employees
                    ON projects.AreaManager = employees.id
                    INNER JOIN (SELECT employees.id, employees.ThaiName
                        FROM employees) AS employees1
                    ON projects.SiteEngineer = employees1.id
                GROUP BY "", mile_stones.project_id, projects.ProjectName, projects.StartDate, projects.FinishDate, "Project", "", Responsible');
            return DataTables::of($data)
                    ->editColumn('Type', function($data) {
                        return '<div class="text-center">'.$data->Type.'</div>';
                    })
                    ->editColumn('StartDate', function($data) {
                        return '<div class="text-center">'.$data->StartDate.'</div>';
                    })
                    ->addColumn('DueDate', function($data) {
                        return '<div class="text-center">'.$data->DueDate.'</div>';
                    })
                    ->addColumn('Responsible', function($data) {
                        return '<div class="text-center">'.$data->Responsible.'</div>';
                    })
                    ->addColumn('action', function($data) {
                        if ( $data->office_id == "" ) {
                            return '
                                <div class="text-center">
                                    <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Mile Stone" href="'. url('projects_milestone/'.$data->project_id).'"><i class="fa fa-lg fa-fw fa-tasks"></i></a>
                                </div>';
                        } else {
                            return '
                                <div class="text-center">
                                    <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Mile Stone" href="'. url('milestone_offices/'.$data->office_id.'/'.$data->Type).'"><i class="fa fa-lg fa-fw fa-tasks"></i></a>
                                    <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->office_id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                    <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->office_id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                </div>';
                        }
                    })
                    ->rawColumns(['Type','StartDate','DueDate','Responsible','action'])
                    ->make(true);
        }

        //$test = DB::table('mile_stone_lastest')->get();
        //dd($test);

        return view('milestones.all',compact('responsible'));
    }

    public function allstore(Request $request)
    {
        $rules = array(
            'JobName' =>'required',
            'Type'=>'required',
            'StartDate'=>'required',
            'DueDate'=>'required',
            'Responsible'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'JobName' => $request->JobName,
            'Type' => $request->Type,
            'StartDate' => $request->StartDate,
            'DueDate' => $request->DueDate,
            'Remark' => $request->Remark,
            'Responsible' => $request->Responsible
        );

        MilestoneOffice::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function alledit($id)
    {
        if(request()->ajax())
        {
            $data = MilestoneOffice::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function allupdate(Request $request,MilestoneOffice $id)
    {
        $rules = array(
            'JobName' =>'required',
            'Type'=>'required',
            'StartDate'=>'required',
            'DueDate'=>'required',
            'Responsible'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'JobName' => $request->JobName,
            'Type' => $request->Type,
            'StartDate' => $request->StartDate,
            'DueDate' => $request->DueDate,
            'Remark' => $request->Remark,
            'Responsible' => $request->Responsible
        );

        MilestoneOffice::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function alldestroy($id)
    {
        $data = MilestoneOffice::findOrFail($id);
        $data->delete();
    }

    public function maintenance(Request $request, $projectid)
    {
        $project = Project::find($projectid);

        if ( NOW() <= $project->FinishDate AND $project->Status == 'Confirmed' ) {
            $milestonestandard = DB::select('SELECT project_type_activities.mile_stone_activity_id
                FROM projects
                INNER JOIN project_type_activities
                ON projects.project_type_id = project_type_activities.project_type_id
                WHERE projects.id='.$project->id.'');

            foreach ($milestonestandard as $value) {
                $count = MileStone::where('project_id','=',$project->id)
                    ->where('mile_stone_activity_id','=',$value->mile_stone_activity_id)
                    ->count();

                if($count == 0){
                    $milestone = new MileStone();
                    $milestone->project_id = $project->id;
                    $milestone->mile_stone_activity_id = $value->mile_stone_activity_id;
                    $milestone->save();
                }
            }

            $currentmilestone = MileStone::where('project_id','=',$project->id)->get();

            foreach ($currentmilestone as $key => $value) {
                $currentstandard = DB::select('SELECT project_type_activities.id
                    FROM projects INNER JOIN project_type_activities ON projects.project_type_id = project_type_activities.project_type_id
                    WHERE (((projects.id)='.$project->id.') AND ((project_type_activities.mile_stone_activity_id)='.$value->mile_stone_activity_id.'))');

                if(count($currentstandard) == 0){
                    $milestone2 = Milestone::findOrFail($value->id);
                    $milestone2->delete();
                }
            }
        }

        if($request->ajax())
        {
            $data = DB::select('SELECT mile_stones.id, mile_stones.project_id, mile_stone_activities.Activity,
                    IF(mile_stone_activities.BeforeStart IS NOT NULL,
                        DATE_ADD(projects.StartDate, INTERVAL -mile_stone_activities.BeforeStart DAY),
                        IF(mile_stone_activities.AfterStart IS NOT NULL,
                            DATE_ADD(projects.StartDate, INTERVAL mile_stone_activities.AfterStart DAY),
                            IF(mile_stone_activities.BeforeFinish IS NOT NULL,
                                DATE_ADD(projects.FinishDate, INTERVAL -mile_stone_activities.BeforeFinish DAY),
                                IF(mile_stone_activities.AfterFinish IS NOT NULL,
                                    DATE_ADD(projects.FinishDate, INTERVAL mile_stone_activities.AfterFinish DAY),
                                    CONCAT(projects.StartDate," to ",projects.FinishDate)
                                )
                            )
                        )
                    ) AS MileStoneDate
                    , mile_stone_activities.Document, mile_stone_activities.Link, mile_stone_activities.Folder, mile_stone_update.Status, mile_stone_update.Remark, DATE_FORMAT(mile_stone_update.updated_at,"%Y-%m-%d") AS updated_at,
                    IF(mile_stone_activities.BeforeStart IS NOT NULL,
                        DateDiff(DATE_ADD(projects.StartDate, INTERVAL -mile_stone_activities.BeforeStart DAY),NOW()),
                        IF(mile_stone_activities.AfterStart IS NOT NULL,
                            DateDiff(DATE_ADD(projects.StartDate, INTERVAL mile_stone_activities.AfterStart DAY),NOW()),
                            IF(mile_stone_activities.BeforeFinish IS NOT NULL,
                                DateDiff(DATE_ADD(projects.FinishDate, INTERVAL -mile_stone_activities.BeforeFinish DAY),NOW()),
                                IF(mile_stone_activities.AfterFinish IS NOT NULL,
                                    DateDiff(DATE_ADD(projects.FinishDate, INTERVAL mile_stone_activities.AfterFinish DAY),NOW()),
                                    0
                                )
                            )
                        )
                    ) AS MileStoneDateDiff
                    , mile_stone_activities.Dynamic, job_positions.JobPositionName
                    , IF((mile_stone_activities.BeforeStart IS NULL) AND (mile_stone_activities.AfterStart IS NULL) AND (mile_stone_activities.BeforeFinish IS NULL) AND (mile_stone_activities.AfterFinish IS NULL)
                        ,"Yes"
                        ,"No"
                    )
                    AS During
                    , projects.FinishDate
                FROM job_positions
                    INNER JOIN ((((SELECT t.mile_stone_id, t.Status, t.Remark, t.updated_at
                        FROM mile_stones
                            INNER JOIN (mile_stone_updates AS t
                                INNER JOIN (SELECT mile_stone_id, max(updated_at) AS MaxDate
                                FROM mile_stone_updates
                                GROUP BY mile_stone_id )  AS tm ON (t.updated_at = tm.MaxDate) AND (t.mile_stone_id = tm.mile_stone_id)) ON mile_stones.id = t.mile_stone_id
                                WHERE (((mile_stones.project_id)='.$projectid.'))) AS mile_stone_update
                        RIGHT JOIN mile_stones
                        ON mile_stone_update.mile_stone_id = mile_stones.id)
                        INNER JOIN mile_stone_activities
                        ON mile_stones.mile_stone_activity_id = mile_stone_activities.id)
                        INNER JOIN projects
                        ON mile_stones.project_id = projects.id)
                    ON job_positions.id = mile_stone_activities.Responsible
                WHERE (((mile_stones.project_id)='.$projectid.'))');
            return DataTables::of($data)
                ->editColumn('MileStoneDate', function($data) {
                    if ( $data->During == "Yes") {
                        if ( now() > $data->FinishDate ) {
                            return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center text-success">'.$data->MileStoneDate.'</div>';
                        } else {
                            return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center">'.$data->MileStoneDate.'</div>';
                        }
                    } else {
                        if ($data->Status == "Completed"){
                            return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center text-success">'.$data->MileStoneDate.'</div>';
                        } elseif ($data->Status == "Not Relevant") {
                            return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center text-success">'.$data->MileStoneDate.'</div>';
                        } elseif ($data->MileStoneDateDiff < 0) {
                            return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center text-danger">'.$data->MileStoneDate.'</div>';
                        } elseif ($data->MileStoneDateDiff <= 7) {
                            return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center text-warning">'.$data->MileStoneDate.'</div>';
                        } return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center ">'.$data->MileStoneDate.'</div>';
                    }
                })
                ->editColumn('Activity', function($data) {
                    if ( $data->During == "Yes" ) {
                        if ( now() > $data->FinishDate ) {
                            return '<div class="text-success">'.$data->Activity.'</div>';
                        } else {
                            return '<div>'.$data->Activity.'</div>';
                        }
                    } else {
                        if ($data->Status == "Completed"){
                            return '<div class="text-success">'.$data->Activity.'</div>';
                        } elseif ($data->Status == "Not Relevant") {
                            return '<div class="text-success">'.$data->Activity.'</div>';
                        } elseif ($data->MileStoneDateDiff < 0) {
                            return '<div class="text-danger">'.$data->Activity.'</div>';
                        } elseif ($data->MileStoneDateDiff <= 7) {
                            return '<div class="text-warning">'.$data->Activity.'</div>';
                        } return '<div>'.$data->Activity.'</div>';
                    }
                })
                ->editColumn('Document', function($data) {
                    if ( $data->During == "Yes" ) {
                        if ( now() > $data->FinishDate ) {
                            return '<div class="text-center text-success">'.$data->Document.'</div>';
                        } else {
                            return '<div class="text-center ">'.$data->Document.'</div>';
                        }
                    } else {
                        if ( $data->Document == "" ) {
                            return '';
                        } else {
                            if ($data->Status == "Completed"){
                                return '<div class="text-center text-success">'.$data->Document.'</div>';
                            } elseif ($data->Status == "Not Relevant") {
                                return '<div class="text-center text-success">'.$data->Document.'</div>';
                            } elseif ($data->MileStoneDateDiff < 0) {
                                return '<div class="text-center text-danger">'.$data->Document.'</div>';
                            } elseif ($data->MileStoneDateDiff <= 7) {
                                return '<div class="text-center text-warning">'.$data->Document.'</div>';
                            } return '<div class="text-center ">'.$data->Document.'</div>';
                        }
                    }
                })
                ->editColumn('Link', function($data) {
                    if ( $data->Link == "" ) {
                        return '';
                    } else {
                        if ( $data->Dynamic == "Yes" ) {
                            return '<div class="text-center "><a href="'.url($data->Link.'/'.$data->project_id).'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Link"><i class="fa fa-lg fa-fw fa-file"></i></a></div>';
                        } else {
                            return '<div class="text-center "><a href="'.url($data->Link).'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Link"><i class="fa fa-lg fa-fw fa-file"></i></a></div>';
                        }
                    }
                })
                ->editColumn('Folder', function($data) {
                    if ( $data->During == "Yes" ) {
                        if ( now() > $data->FinishDate ) {
                            return '<div class="text-center text-success">'.$data->Folder.'</div>';
                        } else {
                            return '<div class="text-center ">'.$data->Folder.'</div>';
                        }
                    } else {
                        if ($data->Status == "Completed"){
                            return '<div class="text-center text-success">'.$data->Folder.'</div>';
                        } elseif ($data->Status == "Not Relevant") {
                            return '<div class="text-center text-success">'.$data->Folder.'</div>';
                        } elseif ($data->MileStoneDateDiff < 0) {
                            return '<div class="text-center text-danger">'.$data->Folder.'</div>';
                        } elseif ($data->MileStoneDateDiff <= 7) {
                            return '<div class="text-center text-warning">'.$data->Folder.'</div>';
                        } return '<div class="text-center ">'.$data->Folder.'</div>';
                    }
                })
                ->editColumn('JobPositionName', function($data) {
                    if ( $data->During == "Yes" ) {
                        if ( now() > $data->FinishDate ) {
                            return '<div class="text-success">'.$data->JobPositionName.'</div>';
                        } else {
                            return '<div>'.$data->JobPositionName.'</div>';
                        }
                    } else {
                        if ($data->Status == "Completed"){
                            return '<div class="text-success">'.$data->JobPositionName.'</div>';
                        } elseif ($data->Status == "Not Relevant") {
                            return '<div class="text-success">'.$data->JobPositionName.'</div>';
                        } elseif ($data->MileStoneDateDiff < 0) {
                            return '<div class="text-danger">'.$data->JobPositionName.'</div>';
                        } elseif ($data->MileStoneDateDiff <= 7) {
                            return '<div class="text-warning">'.$data->JobPositionName.'</div>';
                        } return '<div>'.$data->JobPositionName.'</div>';
                    }
                })
                ->editColumn('StatusDate', function($data) {
                    if ( $data->During == "Yes" ) {
                        if ( now() > $data->FinishDate ) {
                            return '</div><div class="text-center text-success">N/A</div>';
                        } else {
                            return '<div class="text-center">N/A</div>';
                        }
                    } else {
                        if ($data->Status == ""){
                            if ($data->Status == "Completed"){
                                return '<div class="text-center text-success">Not Start</div>';
                            } elseif ($data->Status == "Not Relevant") {
                                return '<div class="text-center text-success">Not Start</div>';
                            } elseif ($data->MileStoneDateDiff < 0) {
                                return '<div class="text-center text-danger">Not Start</div>';
                            } elseif ($data->MileStoneDateDiff <= 7) {
                                return '<div class="text-center text-warning">Not Start</div>';
                            } return '<div class="text-center ">Not Start</div>';
                        } else {
                            if ($data->Status == "Completed"){
                                return '<div class="text-center text-success">'.$data->Status.'/'.date('Y-m-d', strtotime($data->updated_at)).'</div>';
                            } elseif ($data->Status == "Not Relevant") {
                                return '<div class="text-center text-success">'.$data->Status.'/'.date('Y-m-d', strtotime($data->updated_at)).'</div>';
                            } elseif ($data->MileStoneDateDiff < 0) {
                                return '<div class="text-center text-danger">'.$data->Status.'/'.date('Y-m-d', strtotime($data->updated_at)).'</div>';
                            } elseif ($data->MileStoneDateDiff <= 7) {
                                return '<div class="text-center text-warning">'.$data->Status.'/'.date('Y-m-d', strtotime($data->updated_at)).'</div>';
                            } return '<div class="text-center ">'.$data->Status.'/'.date('Y-m-d', strtotime($data->updated_at)).'</div>';
                        }
                    }
                })
                ->editColumn('KPI', function($data) {
                    if ( $data->During == "Yes" ) {
                        if ( now() > $data->FinishDate ) {
                            return '<div class="text-center text-success">N/A</div>';
                        } else {
                            return '<div class="text-center">N/A</div>';
                        }
                    } else {
                        if ($data->Status == "" ){
                            return '<div class="text-center text-success"></div>';
                        } elseif ($data->Status == "Not Relevant" ){
                            return '<div class="text-center text-success">0</div>';
                        } elseif ($data->Status == "Completed" ){
                            if ($data->updated_at > $data->MileStoneDate) {
                                return '<div class="text-center text-success">1</div>';
                            } else {
                                return '<div class="text-center text-success">2</div>';
                            }
                        } else {
                            if ($data->MileStoneDateDiff < 0) {
                                return '<div class="text-center text-danger">0</div>';
                            } elseif ($data->MileStoneDateDiff <= 7) {
                                return '<div class="text-center text-warning">0</div>';
                            } return '<div class="text-center ">0</div>';
                        }
                    }
                })
                ->addColumn('action',function($data) {
                    if ( $data->During == "Yes" ) {
                        if ( now() > $data->FinishDate ) {
                            return '<div class="text-center text-success">N/A</div>';
                        } else {
                            return '<div class="text-center">N/A</div>';
                        }
                    } else {
                        return '
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="history btn btn-xs btn-default text-info mx-1 shadow" name="show" id="'.$data->id.'" title="Show"><i class="fa fa-lg fa-fw fa-eye"></i></button>
                        </div>
                    ';}
                })
                ->rawColumns(['MileStoneDate','Activity','Document','Link','Folder','JobPositionName','StatusDate','KPI','action'])
                ->make(true);
        }

        return view('milestones.maintenance',compact('project'));
    }

    public function maintenanceedit($id)
    {
        if(request()->ajax())
        {
            $data = MileStone::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function maintenanceupdate(Request $request)
    {
        $rules = array(
            'Status'=>'required',
            'hidden_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'mile_stone_id' => $request->hidden_id,
            'Remark' => $request->Remark,
            'Status' => $request->Status
        );

        MileStoneUpdate::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    /* public function office(Request $request, $id, $type)
    {
        $office = MilestoneOffice::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE mile_stone_update AS (
                SELECT t.mile_stone_id, t.Status, t.Remark, t.updated_at, mile_stones.office_id
                FROM mile_stones INNER JOIN (mile_stone_updates AS t INNER JOIN (SELECT mile_stone_id, max(updated_at) AS MaxDate
                FROM mile_stone_updates
                GROUP BY mile_stone_id )  AS tm ON (t.updated_at = tm.MaxDate) AND (t.mile_stone_id = tm.mile_stone_id)) ON mile_stones.id = t.mile_stone_id
                WHERE (((mile_stones.office_id)=$id))
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::select('SELECT mile_stones.id, mile_stones.office_id, mile_stone_activities.Activity, mile_stone_activities.Document, mile_stone_activities.Link, mile_stone_activities.Folder, mile_stone_update.Status, mile_stone_update.Remark, DATE_FORMAT(mile_stone_update.updated_at,"%Y-%m-%d") AS updated_at, DateDiff(DATE_ADD(milestone_offices.StartDate, INTERVAL mile_stone_activities.AfterFinish DAY),NOW()) AS MileStoneDateDiff, mile_stone_activities.Dynamic, job_positions.JobPositionName,
                    IF(mile_stone_activities.BeforeStart IS NOT NULL,
                        DATE_ADD(milestone_offices.StartDate, INTERVAL -mile_stone_activities.BeforeStart DAY),
                        IF(mile_stone_activities.AfterStart IS NOT NULL,
                            DATE_ADD(milestone_offices.StartDate, INTERVAL mile_stone_activities.AfterStart DAY),
                            IF(mile_stone_activities.BeforeFinish IS NOT NULL,
                                DATE_ADD(milestone_offices.DueDate, INTERVAL -mile_stone_activities.BeforeFinish DAY),
                                IF(mile_stone_activities.AfterFinish IS NOT NULL,
                                    DATE_ADD(milestone_offices.DueDate, INTERVAL mile_stone_activities.AfterFinish DAY),
                                    DATE_FORMAT(NOW(), "%Y-%m-%d")
                                )
                            )
                        )
                    ) AS MileStoneDate
                FROM milestone_offices
                    INNER JOIN (job_positions
                        INNER JOIN ((mile_stone_update
                            RIGHT JOIN mile_stones
                            ON mile_stone_update.mile_stone_id = mile_stones.id)
                        INNER JOIN mile_stone_activities
                        ON mile_stones.mile_stone_activity_id = mile_stone_activities.id)
                    ON job_positions.id = mile_stone_activities.Responsible)
                ON milestone_offices.id = mile_stones.office_id
                WHERE (((mile_stones.office_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('MileStoneDate', function($data) {
                    if ($data->Status == "Completed"){
                        return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center text-success">'.$data->MileStoneDate.'</div>';
                    } elseif ($data->Status == "Not Relevant") {
                        return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center text-success">'.$data->MileStoneDate.'</div>';
                    } elseif ($data->MileStoneDateDiff < 0) {
                        return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center text-danger">'.$data->MileStoneDate.'</div>';
                    } elseif ($data->MileStoneDateDiff <= 7) {
                        return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center text-warning">'.$data->MileStoneDate.'</div>';
                    } return '<div class="d-none">'.$data->MileStoneDate.'</div><div class="text-center ">'.$data->MileStoneDate.'</div>';
                })
                ->editColumn('Activity', function($data) {
                    if ($data->Status == "Completed"){
                        return '<div class="text-success">'.$data->Activity.'</div>';
                    } elseif ($data->Status == "Not Relevant") {
                        return '<div class="text-success">'.$data->Activity.'</div>';
                    } elseif ($data->MileStoneDateDiff < 0) {
                        return '<div class="text-danger">'.$data->Activity.'</div>';
                    } elseif ($data->MileStoneDateDiff <= 7) {
                        return '<div class="text-warning">'.$data->Activity.'</div>';
                    } return '<div>'.$data->Activity.'</div>';
                })
                ->editColumn('Document', function($data) {
                    if ( $data->Document == "" ) {
                        return '';
                    } else {
                        if ($data->Status == "Completed"){
                            return '<div class="text-center text-success">'.$data->Document.'</div>';
                        } elseif ($data->Status == "Not Relevant") {
                            return '<div class="text-center text-success">'.$data->Document.'</div>';
                        } elseif ($data->MileStoneDateDiff < 0) {
                            return '<div class="text-center text-danger">'.$data->Document.'</div>';
                        } elseif ($data->MileStoneDateDiff <= 7) {
                            return '<div class="text-center text-warning">'.$data->Document.'</div>';
                        } return '<div class="text-center ">'.$data->Document.'</div>';
                    }
                })
                ->editColumn('Link', function($data) {
                    if ( $data->Link == "" ) {
                        return '';
                    } else {
                        if ( $data->Dynamic == "Yes" ) {
                            return '<div class="text-center "><a href="'.url($data->Link.'/'.$data->project_id).'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Link"><i class="fa fa-lg fa-fw fa-file"></i></a></div>';
                        } else {
                            return '<div class="text-center "><a href="'.url($data->Link).'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Link"><i class="fa fa-lg fa-fw fa-file"></i></a></div>';
                        }
                    }
                })
                ->editColumn('Folder', function($data) {
                    if ($data->Status == "Completed"){
                        return '<div class="text-center text-success">'.$data->Folder.'</div>';
                    } elseif ($data->Status == "Not Relevant") {
                        return '<div class="text-center text-success">'.$data->Folder.'</div>';
                    } elseif ($data->MileStoneDateDiff < 0) {
                        return '<div class="text-center text-danger">'.$data->Folder.'</div>';
                    } elseif ($data->MileStoneDateDiff <= 7) {
                        return '<div class="text-center text-warning">'.$data->Folder.'</div>';
                    } return '<div class="text-center ">'.$data->Folder.'</div>';
                })
                ->editColumn('JobPositionName', function($data) {
                    if ($data->Status == "Completed"){
                        return '<div class="text-success">'.$data->JobPositionName.'</div>';
                    } elseif ($data->Status == "Not Relevant") {
                        return '<div class="text-success">'.$data->JobPositionName.'</div>';
                    } elseif ($data->MileStoneDateDiff < 0) {
                        return '<div class="text-danger">'.$data->JobPositionName.'</div>';
                    } elseif ($data->MileStoneDateDiff <= 7) {
                        return '<div class="text-warning">'.$data->JobPositionName.'</div>';
                    } return '<div>'.$data->JobPositionName.'</div>';
                })
                ->editColumn('StatusDate', function($data) {
                    if ($data->Status == ""){
                        if ($data->Status == "Completed"){
                            return '<div class="text-center text-success">Not Start</div>';
                        } elseif ($data->Status == "Not Relevant") {
                            return '<div class="text-center text-success">Not Start</div>';
                        } elseif ($data->MileStoneDateDiff < 0) {
                            return '<div class="text-center text-danger">Not Start</div>';
                        } elseif ($data->MileStoneDateDiff <= 7) {
                            return '<div class="text-center text-warning">Not Start</div>';
                        } return '<div class="text-center ">Not Start</div>';
                    } else {
                        if ($data->Status == "Completed"){
                            return '<div class="text-center text-success">'.$data->Status.'/'.date('Y-m-d', strtotime($data->updated_at)).'</div>';
                        } elseif ($data->Status == "Not Relevant") {
                            return '<div class="text-center text-success">'.$data->Status.'/'.date('Y-m-d', strtotime($data->updated_at)).'</div>';
                        } elseif ($data->MileStoneDateDiff < 0) {
                            return '<div class="text-center text-danger">'.$data->Status.'/'.date('Y-m-d', strtotime($data->updated_at)).'</div>';
                        } elseif ($data->MileStoneDateDiff <= 7) {
                            return '<div class="text-center text-warning">'.$data->Status.'/'.date('Y-m-d', strtotime($data->updated_at)).'</div>';
                        } return '<div class="text-center ">'.$data->Status.'/'.date('Y-m-d', strtotime($data->updated_at)).'</div>';
                    }
                })
                ->editColumn('KPI', function($data) {
                    if ($data->Status == "" ){
                        return '<div class="text-center text-success"></div>';
                    } elseif ($data->Status == "Not Relevant" ){
                        return '<div class="text-center text-success">0</div>';
                    } elseif ($data->Status == "Completed" ){
                        if ($data->updated_at > $data->MileStoneDate) {
                            return '<div class="text-center text-success">1</div>';
                        } else {
                            return '<div class="text-center text-success">2</div>';
                        }
                    } else {
                        if ($data->MileStoneDateDiff < 0) {
                            return '<div class="text-center text-danger">0</div>';
                        } elseif ($data->MileStoneDateDiff <= 7) {
                            return '<div class="text-center text-warning">0</div>';
                        } return '<div class="text-center ">0</div>';
                    }
                })
                ->addColumn('action', function($data) {
                    return '
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="history btn btn-xs btn-default text-info mx-1 shadow" name="show" id="'.$data->id.'" title="Show"><i class="fa fa-lg fa-fw fa-eye"></i></button>
                    </div>';
                })
                ->rawColumns(['MileStoneDate','Activity','Document','Link','Folder','JobPositionName','StatusDate','KPI','action'])
                ->make(true);
        }

        $milestone = DB::select('SELECT mile_stones.id, mile_stones.office_id
            FROM mile_stones
            WHERE (((mile_stones.office_id)='.$id.'))');

        $milestonestandard = DB::select('SELECT mile_stone_activities.id, mile_stone_activities.List
            FROM mile_stone_activities
            WHERE (((mile_stone_activities.List)="'.$type.'"))');

        return view('milestones.office',compact('office','milestone','milestonestandard'));
    }

    public function officestore(Request $request)
    {
        $officeid = $request->office_id;
        $milestoneactivityid = $request->mile_stone_activity_id;
        $count = count($milestoneactivityid);

        for ($i = 0; $i < $count; $i++){
            $milestone = new MileStone();
            $milestone->office_id = $officeid[$i];
            $milestone->mile_stone_activity_id = $milestoneactivityid[$i];
            $milestone->save();
        }

        return back()->with('message','Successfully created Mile Stone!');
    }

    public function officeedit($id)
    {
        if(request()->ajax())
        {
            $data = Milestone::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function officeupdate(Request $request,MileStoneUpdate $id)
    {
        $rules = array(
            'Status'=>'required',
            'hidden_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'mile_stone_id' => $request->hidden_id,
            'Remark' => $request->Remark,
            'Status' => $request->Status
        );

        MileStoneUpdate::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    } */

    public function record(Request $request, $id)
    {
        $history = MileStoneUpdate::where('mile_stone_id','=',$id)->orderBy('created_at','desc')->get();
        return json_encode(array('data'=>$history));
    }

    public function standard(Request $request)
    {
        $type = ProjectType::orderBy('TypeName','asc')->get();

        $activity = MileStoneActivity::orderBy('Activity','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT project_type_activities.id, project_types.TypeName, mile_stone_activities.Activity
                FROM project_type_activities
                    INNER JOIN project_types
                    ON project_type_activities.project_type_id = project_types.id
                    INNER JOIN mile_stone_activities
                    ON project_type_activities.mile_stone_activity_id = mile_stone_activities.id');
            return DataTables::of($data)
                ->editColumn('TypeName', function($data) {
                    return '<div class="text-center">'.$data->TypeName.'</div>';
                })
                ->addColumn('action','
                    @role('."'admin|head_engineering|head_operation'".')
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    @else <div class="text-center">N/A</div>
                    @endrole
                ')
                ->rawColumns(['TypeName','action'])
                ->make(true);
        }

        return view('milestones.standard',compact('type','activity'));
    }

    public function standardstore(Request $request)
    {
        $rules = array(
            'project_type_id' =>'required',
            'mile_stone_activity_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_type_id' => $request->project_type_id,
            'mile_stone_activity_id' => $request->mile_stone_activity_id
        );

        ProjectTypeActivity::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function standardedit($id)
    {
        if(request()->ajax())
        {
            $data = ProjectTypeActivity::findOrFail($id);

            return response()->json(['result' => $data]);
        }
    }

    public function standardupdate(Request $request,ProjectTypeActivity $id)
    {
        $rules = array(
            'project_type_id' =>'required',
            'mile_stone_activity_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'project_type_id' => $request->project_type_id,
            'mile_stone_activity_id' => $request->mile_stone_activity_id
        );

        ProjectTypeActivity::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }
}
