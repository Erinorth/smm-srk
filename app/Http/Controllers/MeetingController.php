<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Project;
use App\Models\ProjectMeeting;
use App\Models\Meeting;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($projectmeetingid)
    {
        $projectmeeting = ProjectMeeting::find($projectmeetingid);
        $projectmeetingdetail = DB::select('SELECT projects.ProjectName, project_meetings.MeetingDate, project_meetings.Subject, project_meetings.id
            FROM projects INNER JOIN project_meetings ON projects.id = project_meetings.project_id
            WHERE (((project_meetings.id)='.$projectmeetingid.'))');
        $meeting = DB::select('SELECT meetings.id, meetings.project_meeting_id, meetings.MainPoint
            FROM meetings
            WHERE (((meetings.project_meeting_id)='.$projectmeetingid.'))');

        return view('meetings.create',compact('projectmeeting','projectmeetingdetail','meeting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'project_meeting_id' => 'required',
            'MainPoint'=>'required'
        ]);

        $meeting = new Meeting;
        $meeting->project_meeting_id = $request->input('project_meeting_id');
        $meeting->MainPoint = $request->input('MainPoint');
        $meeting->save();

        return back()->with('message','Successfully add Main Point!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($meetingid)
    {
        $meeting = Meeting::find($meetingid);
        $meeting->delete();

        return back()->with('message','Successfully delete Main Point!');
    }

    public function projectcreate($projectid)
    {
        $project = Project::find($projectid);
        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS planner;
            DROP TABLE IF EXISTS siteengineer;
            DROP TABLE IF EXISTS areamanager;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE planner AS (
                SELECT employees.id, employees.ThaiName AS PlannerName, employees.Planner
                FROM employees
                WHERE (((employees.Planner)='Yes'))
                );

            CREATE TEMPORARY TABLE siteengineer AS (
                SELECT employees.id, employees.ThaiName AS SiteEngineerName, employees.SiteEngineer
                FROM employees
                WHERE (((employees.SiteEngineer)='Yes'))
                );

            CREATE TEMPORARY TABLE areamanager AS (
                SELECT employees.id, employees.ThaiName AS AreaManagerName, employees.AreaManager
                FROM employees
                WHERE (((employees.AreaManager)='Yes'))
                );
            ")
        );

        $projectdetail = DB::select('SELECT projects.id, projects.ProjectName, locations.LocationName, projects.StartDate, projects.FinishDate, planner.PlannerName, siteengineer.SiteEngineerName, areamanager.AreaManagerName, projects.Status
            FROM siteengineer INNER JOIN (planner INNER JOIN (areamanager INNER JOIN (locations INNER JOIN projects ON locations.id = projects.location_id) ON areamanager.id = projects.AreaManager) ON planner.id = projects.Planner) ON siteengineer.id = projects.SiteEngineer
            WHERE (((projects.id)='.$projectid.'))');
        $meeting = DB::select('SELECT project_meetings.id, project_meetings.project_id, project_meetings.MeetingDate, project_meetings.Subject
            FROM project_meetings
            WHERE (((project_meetings.project_id)='.$projectid.'))');

        $dropTempTables = DB::unprepared(
            DB::raw("
                DROP TABLE IF EXISTS planner;
                DROP TABLE IF EXISTS siteengineer;
                DROP TABLE IF EXISTS areamanager;
            ")
        );

        return view('meetings.projectcreate',compact('project','projectdetail','meeting'));
    }
    public function projectstore(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'required',
            'MeetingDate'=>'required',
            'Subject'=>'required'
        ]);

        $projectmeeting = new ProjectMeeting;
        $projectmeeting->project_id = $request->input('project_id');
        $projectmeeting->MeetingDate = $request->input('MeetingDate');
        $projectmeeting->Subject = $request->input('Subject');
        $projectmeeting->save();

        return back()->with('message','Successfully add Meeting!');
    }

    public function projectdestroy($projectmeetingid)
    {
        $projectmeeting = ProjectMeeting::find($projectmeetingid);
        $projectmeeting->delete();

        return back()->with('message','Successfully delete Meeting!');
    }
}
