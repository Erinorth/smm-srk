<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Chart;
use App\Models\ProjectType;
use DB;
use DataTables;
use Validator;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $siteengineer = DB::select('SELECT employees.id, employees.ThaiName
            FROM employees
            ORDER BY employees.ThaiName');
        $areamanager = DB::select('SELECT employees.id, employees.ThaiName
            FROM employees
            ORDER BY employees.ThaiName');

        $type = ProjectType::orderBy('TypeName')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT projects.id, projects.ProjectName, project_types.TypeName, projects.StartDate, projects.FinishDate, projects.Status, DateDiff(projects.StartDate,NOW()) AS StartDiff, DateDiff(projects.FinishDate,NOW()) AS FinishDiff, employees.ThaiName AS AreaManager, employees2.ThaiName AS SiteEngineer
                FROM projects
                    LEFT JOIN project_types
                    ON projects.project_type_id = project_types.id
                    LEFT JOIN employees
                    ON projects.AreaManager = employees.id
                    LEFT JOIN (SELECT employees.id, employees.ThaiName
                        FROM employees) AS employees2
                    ON projects.SiteEngineer = employees2.id
                WHERE projects.Status="Not Confirmed"
                ORDER BY projects.StartDate');
            return DataTables::of($data)
                ->editColumn('ProjectName', function($data) {
                    if ($data->StartDiff > 60)
                    return '<div class="text-success">'.$data->ProjectName.'</div>';
                    if ($data->StartDiff > 30)
                    return '<div class="text-warning">'.$data->ProjectName.'</div>';
                    return '<div class="text-danger">'.$data->ProjectName.'</div>';
                })
                ->editColumn('TypeName', function($data) {
                    return '<div class="text-center">'.$data->TypeName.'</div>';
                })
                ->editColumn('StartDate', function($data) {
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->editColumn('FinishDate', function($data) {
                    return '<div class="text-center">'.$data->FinishDate.'</div>';
                })
                ->editColumn('Responsible', function($data) {
                    if ( $data->AreaManager == "" ) {
                        $areamanager = "ยังไม่ได้กำหนด";
                    } else {
                        $areamanager = $data->AreaManager;
                    }
                    if ( $data->SiteEngineer == "" ) {
                        $siteengineer = "ยังไม่ได้กำหนด";
                    } else {
                        $siteengineer = $data->SiteEngineer;
                    }
                    if ( $areamanager == $siteengineer ) {
                        return '<div class="text-center">'.$areamanager.'</div>';
                    } else {
                        return '<div class="text-center">'.$areamanager.'/'.$siteengineer.'</div>';
                    }
                })
                ->addColumn('action','
                <div class="text-center">
                    <a href="'. url('projects/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                    @role('."'planner|admin|head_engineering'".')
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        @role('."'admin|head_engineering'".')
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        @endrole
                    @endrole
                </div>
                ')
                ->rawColumns(['ProjectName','TypeName','StartDate','FinishDate','Responsible','action'])
                ->make(true);
        }

        return View('projects.index',compact('siteengineer','areamanager','type'));
    }

    public function prepare(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT projects.id, projects.ProjectName, project_types.TypeName, projects.StartDate, projects.FinishDate, projects.Status, DateDiff(projects.StartDate,NOW()) AS StartDiff, DateDiff(projects.FinishDate,NOW()) AS FinishDiff, employees.ThaiName AS AreaManager, employees2.ThaiName AS SiteEngineer, projects.KeyDate, projects.KeyDatePath
                FROM projects
                    LEFT JOIN project_types
                    ON projects.project_type_id = project_types.id
                    LEFT JOIN employees
                    ON projects.AreaManager = employees.id
                    LEFT JOIN (SELECT employees.id, employees.ThaiName
                        FROM employees) AS employees2
                    ON projects.SiteEngineer = employees2.id
                    LEFT JOIN (SELECT project_id, COUNT(project_id) AS count_project_id
                        FROM mile_stones
                        GROUP BY project_id) AS mile_stone
                    ON projects.id = mile_stone.project_id
                WHERE projects.Status="Confirmed" AND DateDiff(projects.FinishDate,NOW())>0 AND (DateDiff(projects.StartDate,NOW())>0 OR ISNULL(mile_stone.count_project_id))');
            return DataTables::of($data)
                ->editColumn('ProjectName', function($data) {
                    if ($data->StartDiff > 60)
                    return '<div class="text-success">'.$data->ProjectName.'</div>';
                    if ($data->StartDiff > 30)
                    return '<div class="text-warning">'.$data->ProjectName.'</div>';
                    return '<div class="text-danger">'.$data->ProjectName.'</div>';
                })
                ->editColumn('TypeName', function($data) {
                    return '<div class="text-center">'.$data->TypeName.'</div>';
                })
                ->editColumn('StartDate', function($data) {
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->editColumn('FinishDate', function($data) {
                    return '<div class="text-center">'.$data->FinishDate.'</div>';
                })
                ->editColumn('Responsible', function($data) {
                    if ( $data->AreaManager == "" ) {
                        $areamanager = "ยังไม่ได้กำหนด";
                    } else {
                        $areamanager = $data->AreaManager;
                    }
                    if ( $data->SiteEngineer == "" ) {
                        $siteengineer = "ยังไม่ได้กำหนด";
                    } else {
                        $siteengineer = $data->SiteEngineer;
                    }
                    if ( $areamanager == $siteengineer ) {
                        return '<div class="text-center">'.$areamanager.'</div>';
                    } else {
                        return '<div class="text-center">'.$areamanager.'/'.$siteengineer.'</div>';
                    }
                })
                ->editColumn('KeyDate', function($data) {
                    if ( in_array($data->TypeName,array("บำรุงรักษาพลังน้ำในประเทศ","บำรุงรักษาพลังน้ำต่างประเทศ","บำรุงรักษาพลังลมในประเทศ","บำรุงรักษาเครนในประเทศ","บำรุงรักษาใต้น้ำ","Governor Performance Test")) ) {
                        if ( $data->KeyDate == "" ) {
                            return '
                            <div class="text-center">
                                <button class="keydate btn btn-xs btn-default text-success mx-1 shadow" name="attachment" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>
                            </div>';
                        } else {
                            return '
                            <div class="text-center">
                                <a href="'. url('storage/'.$data->KeyDatePath.$data->KeyDate.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                <button class="edit_keydate btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_keydate btn btn-xs btn-default text-danger mx-1 shadow" name="attachment" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>';
                        }
                    }
                })
                ->addColumn('MileStone', function($data) {
                    return '
                    <div class="text-center">
                        <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Mile Stone" href="'. url('projects_milestone/'.$data->id).'"><i class="fa fa-lg fa-fw fa-tasks"></i></a>
                    </div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <a href="'. url('projects/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                    @role('."'planner|admin|head_engineering'".')
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        @role('."'admin|head_engineering'".')
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        @endrole
                    @endrole
                </div>
                ')
                ->rawColumns(['ProjectName','TypeName','StartDate','FinishDate','Responsible','KeyDate','MileStone','action'])
                ->make(true);


        }
        $data2 = DB::select('SELECT projects.id, projects.ProjectName, project_types.TypeName, projects.StartDate, projects.FinishDate, projects.Status, DateDiff(projects.StartDate,NOW()) AS StartDiff, DateDiff(projects.FinishDate,NOW()) AS FinishDiff, employees.ThaiName AS AreaManager, employees2.ThaiName AS SiteEngineer
                FROM projects
                    LEFT JOIN project_types
                    ON projects.project_type_id = project_types.id
                    LEFT JOIN employees
                    ON projects.AreaManager = employees.id
                    LEFT JOIN (SELECT employees.id, employees.ThaiName
                        FROM employees) AS employees2
                    ON projects.SiteEngineer = employees2.id
                    LEFT JOIN (SELECT project_id, COUNT(project_id) AS count_project_id
                        FROM mile_stones
                        GROUP BY project_id) AS mile_stone
                    ON projects.id = mile_stone.project_id
                WHERE projects.Status="Confirmed" AND mile_stone.count_project_id=0');
            dd($data2);
    }

    public function inprogress(Request $request)
    {
        $dropTempTables = DB::unprepared(
            DB::raw("
                DROP TABLE IF EXISTS max_status ;
                DROP TABLE IF EXISTS inprogress_milestone ;
                DROP TABLE IF EXISTS employees2 ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE max_status AS (
                SELECT mile_stone_updates.mile_stone_id, Max( mile_stone_updates.created_at ) AS MaxOfcreated_at
                FROM mile_stone_updates
                GROUP BY mile_stone_updates.mile_stone_id
                );

            CREATE TEMPORARY TABLE inprogress_milestone AS (
                SELECT projects.id, SUM(IF(mile_stone_updates.`Status` NOT IN ('Completed', 'Not Relevant') OR IsNull(mile_stone_updates.`Status`), 1, 0 )) AS 'SumofStatus'
                FROM projects
                LEFT JOIN mile_stones
                    LEFT JOIN mile_stone_updates
                        INNER JOIN max_status
                        ON mile_stone_updates.mile_stone_id = max_status.mile_stone_id AND mile_stone_updates.created_at = max_status.MaxOfcreated_at
                    ON mile_stones.id = mile_stone_updates.mile_stone_id
                ON projects.id = mile_stones.project_id
                GROUP BY projects.id
                HAVING SumofStatus > 0
                );

            CREATE TEMPORARY TABLE employees2 AS (
                SELECT employees.id, employees.ThaiName
                FROM employees
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::select('SELECT projects.id, projects.ProjectName, project_types.TypeName, projects.StartDate, projects.FinishDate, projects.Status, DateDiff(projects.StartDate,NOW()) AS StartDiff, DateDiff(projects.FinishDate,NOW()) AS FinishDiff, employees.ThaiName AS AreaManager, employees2.ThaiName AS SiteEngineer, projects.DailyReport, projects.KeyDate, projects.KeyDatePath
                FROM projects
                    LEFT JOIN project_types
                    ON projects.project_type_id = project_types.id
                    LEFT JOIN employees
                    ON projects.AreaManager = employees.id
                    LEFT JOIN employees2
                    ON projects.SiteEngineer = employees2.id
                    INNER JOIN inprogress_milestone
                    ON projects.id = inprogress_milestone.id
                WHERE projects.Status="Confirmed" AND DateDiff(projects.StartDate,NOW())<=0 AND DateDiff(projects.FinishDate,NOW())>=0
                GROUP BY projects.id, projects.ProjectName, project_types.TypeName, projects.StartDate, projects.FinishDate, projects.Status, DateDiff(projects.StartDate,NOW()), DateDiff(projects.FinishDate,NOW()), employees.ThaiName, employees2.ThaiName, projects.DailyReport, projects.KeyDate, projects.KeyDatePath');
            return DataTables::of($data)
                ->editColumn('TypeName', function($data) {
                    return '<div class="text-center">'.$data->TypeName.'</div>';
                })
                ->editColumn('StartDate', function($data) {
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->editColumn('FinishDate', function($data) {
                    return '<div class="text-center">'.$data->FinishDate.'</div>';
                })
                ->editColumn('Responsible', function($data) {
                    if ( $data->AreaManager == "" ) {
                        $areamanager = "ยังไม่ได้กำหนด";
                    } else {
                        $areamanager = $data->AreaManager;
                    }
                    if ( $data->SiteEngineer == "" ) {
                        $siteengineer = "ยังไม่ได้กำหนด";
                    } else {
                        $siteengineer = $data->SiteEngineer;
                    }
                    if ( $areamanager == $siteengineer ) {
                        return '<div class="text-center">'.$areamanager.'</div>';
                    } else {
                        return '<div class="text-center">'.$areamanager.'/'.$siteengineer.'</div>';
                    }
                })
                ->editColumn('KeyDate', function($data) {
                    if ( in_array($data->TypeName,array("บำรุงรักษาพลังน้ำในประเทศ","บำรุงรักษาพลังน้ำต่างประเทศ","บำรุงรักษาพลังลมในประเทศ","บำรุงรักษาเครนในประเทศ","บำรุงรักษาใต้น้ำ","Governor Performance Test")) ) {
                        if ( $data->KeyDate == "" ) {
                            return '
                            <div class="text-center">
                                <button class="keydate btn btn-xs btn-default text-success mx-1 shadow" name="attachment" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>
                            </div>';
                        } else {
                            return '
                            <div class="text-center">
                                <a href="'. url('storage/'.$data->KeyDatePath.$data->KeyDate.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                <button class="edit_keydate btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_keydate btn btn-xs btn-default text-danger mx-1 shadow" name="attachment" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>';
                        }
                    }
                })
                ->editColumn('DailyReport', function($data) {
                    if ( in_array($data->TypeName,array("บำรุงรักษาพลังน้ำในประเทศ","บำรุงรักษาพลังน้ำต่างประเทศ","บำรุงรักษาพลังลมในประเทศ","บำรุงรักษาเครนในประเทศ","บำรุงรักษาใต้น้ำ","Governor Performance Test")) ) {
                        if ( $data->DailyReport != "" ) {
                            return '
                            <div class="text-center">
                                <a href="'.$data->DailyReport.'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Daily Report"><i class="fa fa-lg fa-fw fa-sticky-note"></i></a>
                            </div>';
                        }
                    }
                })
                ->addColumn('MileStone', function($data) {
                    return '
                    <div class="text-center">
                        <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Mile Stone" href="'. url('projects_milestone/'.$data->id).'"><i class="fa fa-lg fa-fw fa-tasks"></i></a>
                    </div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <a href="'. url('projects/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                    @role('."'planner|admin|head_operation'".')
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    @endrole
                </div>
                ')
                ->rawColumns(['StartDate','TypeName','FinishDate','Responsible','DailyReport','KeyDate','MileStone','action'])
                ->make(true);
        }

        $dropTempTables = DB::unprepared(
            DB::raw("
                DROP TABLE IF EXISTS max_status ;
                DROP TABLE IF EXISTS inprogress_milestone ;
                DROP TABLE IF EXISTS employees2 ;
            ")
        );
    }

    public function finish(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT finish_project.id, finish_project.ProjectName, finish_project.TypeName, finish_project.StartDate, finish_project.FinishDate, finish_project.Status, finish_project.StartDiff, finish_project.FinishDiff, finish_project.AreaManager, finish_project.SiteEngineer
                FROM (SELECT projects.id, projects.ProjectName, project_types.TypeName, projects.StartDate, projects.FinishDate, projects.Status, DateDiff(projects.StartDate,NOW()) AS StartDiff, DateDiff(projects.FinishDate,NOW()) AS FinishDiff, employees.ThaiName AS AreaManager, employees2.ThaiName AS SiteEngineer
                    FROM projects
                        LEFT JOIN project_types
                        ON projects.project_type_id = project_types.id
                        LEFT JOIN employees
                        ON projects.AreaManager = employees.id
                        LEFT JOIN (SELECT employees.id, employees.ThaiName
                            FROM employees) AS employees2
                        ON projects.SiteEngineer = employees2.id
                    WHERE (((projects.Status)="Confirmed") AND ((DateDiff(projects.StartDate,NOW()))<0) AND ((DateDiff(projects.FinishDate,NOW()))<0))
                    UNION
                    SELECT finish_milestone.id, finish_milestone.ProjectName, finish_milestone.TypeName, finish_milestone.StartDate, finish_milestone.FinishDate, finish_milestone.Status, finish_milestone.StartDiff, finish_milestone.FinishDiff, finish_milestone.AreaManager, finish_milestone.SiteEngineer
                    FROM (SELECT projects.id, SUM(IF(mile_stone_updates.Status NOT IN ("Completed","Not Relevant") OR IsNull(mile_stone_updates.Status),1,0)) AS SumofStatus, projects.ProjectName, project_types.TypeName, projects.StartDate, projects.FinishDate, projects.Status, "" AS StartDiff, "" AS FinishDiff, employees.ThaiName AS AreaManager, employees_1.ThaiName AS SiteEngineer
                        FROM employees AS employees_1
                        INNER JOIN (employees
                            INNER JOIN (project_types
                                INNER JOIN (projects
                                    INNER JOIN (mile_stones
                                        LEFT JOIN (mile_stone_updates
                                            INNER JOIN (SELECT mile_stone_updates.mile_stone_id, Max(mile_stone_updates.created_at) AS MaxOfcreated_at
                                                FROM mile_stone_updates
                                                GROUP BY mile_stone_updates.mile_stone_id) as max_status
                                            ON (mile_stone_updates.mile_stone_id = max_status.mile_stone_id) AND (mile_stone_updates.created_at = max_status.MaxOfcreated_at))
                                        ON mile_stones.id = mile_stone_updates.mile_stone_id)
                                    ON projects.id = mile_stones.project_id)
                                ON project_types.id = projects.project_type_id)
                            ON employees.id = projects.AreaManager)
                        ON employees_1.id = projects.SiteEngineer
                        GROUP BY projects.id, projects.ProjectName, project_types.TypeName, projects.StartDate, projects.FinishDate, projects.Status, StartDiff, FinishDiff, employees.ThaiName, employees_1.ThaiName) AS finish_milestone
                    WHERE finish_milestone.SumofStatus = 0) AS finish_project
                GROUP BY finish_project.id, finish_project.ProjectName, finish_project.TypeName, finish_project.StartDate, finish_project.FinishDate, finish_project.Status, finish_project.StartDiff, finish_project.FinishDiff, finish_project.AreaManager, finish_project.SiteEngineer');
            return DataTables::of($data)
                ->editColumn('TypeName', function($data) {
                    return '<div class="text-center">'.$data->TypeName.'</div>';
                })
                ->editColumn('StartDate', function($data) {
                    return '<div class="text-center">'.$data->StartDate.'</div>';
                })
                ->editColumn('FinishDate', function($data) {
                    return '<div class="text-center">'.$data->FinishDate.'</div>';
                })
                ->editColumn('Responsible', function($data) {
                    if ( $data->AreaManager == "" ) {
                        $areamanager = "ยังไม่ได้กำหนด";
                    } else {
                        $areamanager = $data->AreaManager;
                    }
                    if ( $data->SiteEngineer == "" ) {
                        $siteengineer = "ยังไม่ได้กำหนด";
                    } else {
                        $siteengineer = $data->SiteEngineer;
                    }
                    if ( $areamanager == $siteengineer ) {
                        return '<div class="text-center">'.$areamanager.'</div>';
                    } else {
                        return '<div class="text-center">'.$areamanager.'/'.$siteengineer.'</div>';
                    }
                })
                ->addColumn('MileStone', function($data) {
                    return '
                    <div class="text-center">
                        <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Mile Stone" href="'. url('projects_milestone/'.$data->id).'"><i class="fa fa-lg fa-fw fa-tasks"></i></a>
                    </div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <a href="'. url('projects/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                </div>
                ')
                ->rawColumns(['StartDate','TypeName','FinishDate','Responsible','MileStone','action'])
                ->make(true);
        }
    }

    public function calendar(Request $request)
    {
        if($request->ajax())
    	{
            $data = DB::select('SELECT projects.id, projects.ProjectName AS title, projects.StartDate AS "start", DATE_ADD(projects.FinishDate, INTERVAL 1 DAY) AS "end", projects.color
                FROM projects
                WHERE ((projects.StartDate<="'.$request->start.'" AND projects.FinishDate>="'.$request->end.'") OR (projects.StartDate>="'.$request->start.'" AND projects.StartDate<="'.$request->end.'") OR (projects.FinishDate>="'.$request->start.'" AND projects.FinishDate<="'.$request->end.'")) AND projects.Status="Confirmed" AND projects.show="Yes"');

            return response()->json($data);
    	}
    }

    public function store(Request $request)
    {
        $rules = array(
            'ProjectName'=>'required',
            'project_type_id'=>'required',
            'StartDate'=>'required',
            'FinishDate'=>'required|after_or_equal:StartDate',
            'Status'=>'required',
            'SiteEngineer'=>'required',
            'AreaManager'=>'required',
            'Supervisor'=>'required',
            'Foreman'=>'required',
            'Skill'=>'required',
            'show'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ProjectName' => $request->ProjectName,
            'project_type_id' => $request->project_type_id,
            'StartDate' => $request->StartDate,
            'FinishDate' => $request->FinishDate,
            'SiteEngineer' => $request->SiteEngineer,
            'AreaManager' => $request->AreaManager,
            'Supervisor' => $request->Supervisor,
            'Foreman' => $request->Foreman,
            'Skill' => $request->Skill,
            'Status' => $request->Status,
            'color' => '#'.substr(str_shuffle('ABCDEF0123456789'), 0, 6),
            'show' => $request->show,
            'DailyReport' => $request->DailyReport
        );

        Project::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function show(Request $request, $id)
    {
        $project = Project::find($id);

        $progress = DB::select('SELECT locations.LocationName, machines.MachineName, products.ProductName, systems.SystemName, items.SpecificName, scopes.ScopeName, Sum(IFNULL(progress.Plan, 0)) AS SumOfPlan, Sum(IFNULL(progress.Actual,0)) AS SumOfActual, jobs.project_id
            FROM equipment INNER JOIN (scopes INNER JOIN (systems INNER JOIN (products INNER JOIN (machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (item_sets INNER JOIN (items INNER JOIN (jobs LEFT JOIN progress ON jobs.id = progress.job_id) ON items.id = jobs.item_id) ON item_sets.id = items.item_set_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON scopes.id = items.scope_id) ON equipment.id = item_sets.equipment_id
            GROUP BY locations.LocationName, machines.MachineName, products.ProductName, systems.SystemName, items.SpecificName, scopes.ScopeName, jobs.project_id
            HAVING (((jobs.project_id)='.$id.'))');

        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id
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
                            <a href="'. url('jobs/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE total_mh AS (
                SELECT jobs.project_id, Sum(work_procedures.Man*work_procedures.Hour) AS TotalMH
                FROM jobs INNER JOIN (activities INNER JOIN work_procedures ON activities.id = work_procedures.activity_id) ON jobs.item_id = activities.item_id
                GROUP BY jobs.project_id
                HAVING (((jobs.project_id)=$id))
                );

            CREATE TEMPORARY TABLE progress_job AS (
                SELECT progress.ProgressDate, Sum((progress.Plan/100)*work_procedures.Man*work_procedures.Hour) AS Plan, Sum((progress.Actual/100)*work_procedures.Man*work_procedures.Hour) AS Actual, jobs.project_id
                FROM (activities INNER JOIN (jobs INNER JOIN progress ON jobs.id = progress.job_id) ON activities.item_id = jobs.item_id) INNER JOIN work_procedures ON activities.id = work_procedures.activity_id
                GROUP BY progress.ProgressDate, jobs.project_id
                HAVING (((jobs.project_id)=$id))
                );

            CREATE TEMPORARY TABLE progress AS (
                SELECT progress_job.ProgressDate, 100*progress_job.Plan/total_mh.TotalMH AS Plan, 100*progress_job.Actual/total_mh.TotalMH AS Actual
                FROM total_mh INNER JOIN progress_job ON total_mh.project_id = progress_job.project_id
                GROUP BY progress_job.ProgressDate, 100*progress_job.Plan/total_mh.TotalMH, 100*progress_job.Actual/total_mh.TotalMH
                ORDER BY progress_job.ProgressDate
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

        //$test = DB::table('progress_job')->get();
        //dd($test);

        return view('projects.show',compact('project','progressgdata','progresschart'));
    }

    public function checklist(Request $request, $id)
    {
        $project = Project::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id, jobs.CheckList
                FROM locations
                INNER JOIN machines
                    INNER JOIN machine_sets
                    ON machines.id = machine_sets.machine_id
                ON locations.id = machine_sets.location_id
                INNER JOIN equipment
                    INNER JOIN systems
                        INNER JOIN products
                            INNER JOIN item_sets
                                INNER JOIN scopes
                                    INNER JOIN items
                                        INNER JOIN jobs
                                        ON items.id = jobs.item_id
                                    ON scopes.id = items.scope_id
                                ON item_sets.id = items.item_set_id
                            ON products.id = item_sets.product_id
                        ON systems.id = item_sets.system_id
                    ON equipment.id = item_sets.equipment_id
                ON machine_sets.id = items.machine_set_id
                WHERE jobs.project_id='.$id.'');
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
                ->addColumn('action', function($data) {
                    if ( $data->CheckList == "" ) {
                        return '
                        <div class="text-center">
                            <a href="'. url('checklist3/'.$data->id.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                            [Attachment<button class="attachment btn btn-xs btn-default text-success mx-1 shadow" name="show" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>]
                        </div>';
                    } else {
                        return '
                        <div class="text-center">
                            <a href="'. url('checklist3/'.$data->id.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Print"><i class="fa fa-lg fa-fw fa-print"></i></a>
                            [Attachment<a href="'. url('storage/project'.$data->project_id.'/check_list/'.$data->CheckList.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                            <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="show" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete_attachment btn btn-xs btn-default text-danger mx-1 shadow" name="show" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>]
                        </div>';
                    }
                })
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        return view('projects.checklist',compact('project'));
    }

    public function safetyhealth(Request $request, $id)
    {
        $project = Project::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id
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
                        <a href="'. url('risk/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-print"></i></a>
                    </div>
                ')
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        return view('projects.safetyhealth',compact('project'));
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Project::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Project $id)
    {
        $rules = array(
            'ProjectName'=>'required',
            'project_type_id'=>'required',
            'StartDate'=>'required',
            'FinishDate'=>'required|after_or_equal:StartDate',
            'Status'=>'required',
            'SiteEngineer'=>'required',
            'AreaManager'=>'required',
            'Supervisor'=>'required',
            'Foreman'=>'required',
            'Skill'=>'required',
            'show'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ProjectName' => $request->ProjectName,
            'project_type_id' => $request->project_type_id,
            'StartDate' => $request->StartDate,
            'FinishDate' => $request->FinishDate,
            'SiteEngineer' => $request->SiteEngineer,
            'AreaManager' => $request->AreaManager,
            'Supervisor' => $request->Supervisor,
            'Foreman' => $request->Foreman,
            'Skill' => $request->Skill,
            'Status' => $request->Status,
            'show' => $request->show,
            'DailyReport' => $request->DailyReport
        );

        Project::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Project::findOrFail($id);
        $data->delete();
    }

    public function keydate(Request $request)
    {
        $rules = array(
            'select_file'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $projectid = $request->get('project_id');
        $file = $request->file('select_file');

        $path = 'project'.$projectid.'/keydate/';
        $file_name = $projectid.'-'.$file->getClientOriginalName();
        $upload = $file->storeAs($path, $file_name, 'public');
        if($upload){

            $keydate = Project::find($projectid);
            $keydate->update([
                'KeyDate' => $file_name,
                'KeyDatePath' => $path
            ]);

            return response()->json(['success' => 'Upload successfully.']);
        }
    }

    public function keydateupdate(Request $request)
    {
        $rules = array(
            'select_file'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $projectid = $request->get('project_id');
        $file = $request->file('select_file');

        $keydate = Project::find($projectid);
        $path = $keydate->KeyDatePath;
        $file_name = $projectid.'-'.$file->getClientOriginalName();
        $update = $file->storeAs($path, $file_name, 'public');
        $file_path = $path.$keydate->KeyDate;
        if ( $keydate->KeyDate != null && \Storage::disk('public')->exists($file_path)) {
            \Storage::disk('public')->delete($file_path);
        }
        $keydate->update([
            'KeyDate' => $file_name
        ]);

        return response()->json(['success' => 'Update successfully.']);
    }

    public function keydatedelete($id)
    {
        $keydate = Project::find($id);
        $path = $keydate->KeyDatePath;
        $file_path = $path.$keydate->KeyDate;
        if ( $keydate->KeyDate != null && \Storage::disk('public')->exists($file_path)) {
            \Storage::disk('public')->delete($file_path);
        }
        $keydate->update([
            'KeyDate' => null,
            'KeyDatePath' => null
        ]);
    }

    public function procedure(Request $request, $id)
    {
        $project = Project::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT locations.LocationName, products.ProductName, CONCAT(machines.MachineName,machine_sets.Remark) AS MachineName, systems.SystemName, items.SpecificName, activities.Order AS AO, activities.ActivityName, work_procedures.Order AS WPO, work_procedures.Procedure, work_procedures.ControlledPoint, work_procedures.Class, work_procedures.Man, work_procedures.Hour
                FROM (((machines INNER JOIN (equipment INNER JOIN (locations INNER JOIN (systems INNER JOIN (products INNER JOIN (machine_sets INNER JOIN (item_sets INNER JOIN items ON item_sets.id = items.item_set_id) ON machine_sets.id = items.machine_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON locations.id = machine_sets.location_id) ON equipment.id = item_sets.equipment_id) ON machines.id = machine_sets.machine_id) INNER JOIN activities ON items.id = activities.item_id) INNER JOIN jobs ON items.id = jobs.item_id) LEFT JOIN work_procedures ON activities.id = work_procedures.activity_id
                WHERE (((jobs.project_id)='.$id.'))
                ORDER BY locations.LocationName, products.ProductName, CONCAT(machines.MachineName,machine_sets.Remark), systems.SystemName, items.SpecificName, activities.Order, work_procedures.Order');
            return DataTables::of($data)
                ->editColumn('AO', function($data) {
                    return '<div class="text-center">'.$data->AO.'</div>';
                })
                ->editColumn('WPO', function($data) {
                    return '<div class="text-center">'.$data->WPO.'</div>';
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
                ->rawColumns(['AO','WPO','Class','Man','Hour'])
                ->make(true);
        }

        return view('projects.procedure',compact('project'));
    }

    public function type(Request $request)
    {
        if($request->ajax())
        {
            $data = ProjectType::all();
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->addColumn('action', function($data) {
                    return '
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>';
                    })
                ->rawColumns(['id','action'])
                ->make(true);
        }

        return view('projects.type');
    }

    public function typestore(Request $request)
    {
        $rules = array(
            'TypeName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'TypeName' => $request->TypeName
        );

        ProjectType::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function typeedit($id)
    {
        if(request()->ajax())
        {
            $data = ProjectType::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function typeupdate(Request $request,ProjectType $id)
    {
        $rules = array(
            'TypeName' =>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'TypeName' => $request->TypeName
        );

        ProjectType::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function typedestroy($id)
    {
        $data = ProjectType::findOrFail($id);
        $data->delete();
    }
}
