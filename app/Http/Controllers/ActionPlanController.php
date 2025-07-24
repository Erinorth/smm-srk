<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Meeting;
use App\Models\ActionPlan;

class ActionPlanController extends Controller
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
    public function create($meetingid)
    {
        $meeting = Meeting::find($meetingid);
        $meetingdetail = DB::select('SELECT projects.ProjectName, project_meetings.MeetingDate, project_meetings.Subject, meetings.MainPoint, meetings.id
            FROM projects INNER JOIN (project_meetings INNER JOIN meetings ON project_meetings.id = meetings.project_meeting_id) ON projects.id = project_meetings.project_id
            WHERE (((meetings.id)='.$meetingid.'))');
        $actionplan = DB::select('SELECT action_plans.id, action_plans.Activity, action_plans.Responsible, action_plans.DeadLine, action_plans.Status, action_plans.meeting_id
            FROM action_plans
            WHERE (((action_plans.meeting_id)='.$meetingid.'))
            ORDER BY action_plans.DeadLine');

        return view('actionplans.create',compact('meeting','meetingdetail','actionplan'));
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
            'Activity' => 'required',
            'Responsible' => 'required',
            'DeadLine' => 'required'
        ]);

        $actionplan = new ActionPlan;
        $actionplan->Activity = $request->input('Activity');
        $actionplan->Responsible = $request->input('Responsible');
        $actionplan->DeadLine = $request->input('DeadLine');
        $actionplan->Status = $request->input('Status');
        $actionplan->meeting_id = $request->input('meeting_id');
        $actionplan->save();

        return back()->with('message','Successfully created Action Plan!');
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
    public function edit($actionplanid)
    {
        $actionplan = ActionPlan::find($actionplanid);
        $meetingdetail = DB::select('SELECT action_plans.id, projects.ProjectName, project_meetings.MeetingDate, project_meetings.Subject, meetings.MainPoint
            FROM ((projects INNER JOIN project_meetings ON projects.id = project_meetings.project_id) INNER JOIN meetings ON project_meetings.id = meetings.project_meeting_id) INNER JOIN action_plans ON meetings.id = action_plans.meeting_id
            WHERE (((action_plans.id)='.$actionplanid.'))');

        return view('actionplans.edit',compact('actionplan','meetingdetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $actionplanid)
    {
        $this->validate($request, [
            'Activity' => 'required',
            'Responsible' => 'required',
            'DeadLine' => 'required'
        ]);

        $actionplan = ActionPlan::find($actionplanid);
        $actionplan->Activity = $request->input('Activity');
        $actionplan->Responsible = $request->input('Responsible');
        $actionplan->DeadLine = $request->input('DeadLine');
        $actionplan->Status = $request->input('Status');
        $actionplan->meeting_id = $request->input('meeting_id');
        $actionplan->save();

        return back()->with('message','Successfully update Action Plan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($actionplanid)
    {
        $actionplan = ActionPlan::find($actionplanid);
        $actionplan->delete();

        return back()->with('message','Successfully delete Action Plan!');
    }
}
