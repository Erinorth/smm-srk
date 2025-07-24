<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Location;
use App\Models\Product;
use App\Models\Machine;
use App\Models\System;
use App\Models\Equipment;
use App\Models\JobDate;
use App\Models\DateMeasuringTool;
use App\Models\Tool;
use DB;

class DateMeasuringToolController extends Controller
{
    public function create($jobdateid)
    {
        $jobdate = JobDate::find($jobdateid);
        $jobdatedetail = DB::select('SELECT job_dates.id, projects.ProjectName, locations.LocationName, products.ProductName, machines.MachineName, systems.SystemName, equipment.EquipmentName
            FROM job_dates INNER JOIN (equipment INNER JOIN ((systems INNER JOIN ((machines INNER JOIN ((products INNER JOIN ((locations INNER JOIN projects ON locations.id = projects.location_id) INNER JOIN project_products ON projects.id = project_products.project_id) ON products.id = project_products.product_id) INNER JOIN product_machines ON project_products.id = product_machines.project_product_id) ON machines.id = product_machines.machine_id) INNER JOIN machine_systems ON product_machines.id = machine_systems.product_machine_id) ON systems.id = machine_systems.system_id) INNER JOIN jobs ON machine_systems.id = jobs.machine_system_id) ON equipment.id = jobs.equipment_id) ON job_dates.job_id = jobs.id
            WHERE (((job_dates.id)='.$jobdateid.'))');
        $datemeasuringtool1 = DB::select('SELECT date_measuring_tools.id, date_measuring_tools.job_date_id, tools.ToolName, tools.SerialNumber, date_measuring_tools.OtherToolName, date_measuring_tools.OtherSerialNumber, date_measuring_tools.MeasuredObject, date_measuring_tools.User, date_measuring_tools.Remark
            FROM date_measuring_tools INNER JOIN tools ON date_measuring_tools.tool_id = tools.id
            WHERE (((date_measuring_tools.job_date_id)='.$jobdateid.'))');
        $datemeasuringtool2 = DB::select('SELECT date_measuring_tools.id, date_measuring_tools.job_date_id, date_measuring_tools.OtherToolName, date_measuring_tools.OtherSerialNumber, date_measuring_tools.MeasuredObject, date_measuring_tools.User, date_measuring_tools.Remark
            FROM date_measuring_tools
            WHERE (((date_measuring_tools.job_date_id)='.$jobdateid.') AND ((date_measuring_tools.OtherToolName) Is Not Null) AND ((date_measuring_tools.OtherSerialNumber) Is Not Null))');
        $measuringtool = Tool::where('tools.MeasuringTool','Yes')->orderBy('tools.ToolName')->get();

        return view('date_measuringtools.create',compact('jobdate','jobdatedetail','datemeasuringtool1','datemeasuringtool2','measuringtool'));
    }

    public function store(JobDate $jobdateid)
    {
        $this->validate(request(),[
            'MeasuredObject'=>'required',
            'User'=>'required'
        ]);
        
        DateMeasuringTool::create([
            'tool_id' => request('tool_id'),
            'OtherToolName' => request('OtherToolName'),
            'OtherSerialNumber' => request('OtherSerialNumber'),
            'MeasuredObject' => request('MeasuredObject'),
            'User' => request('User'),
            'Remark' => request('Remark'),
            'job_date_id' => $jobdateid->id
        ]);
        
        return back()->with('message','Successfully added the Measuring Tool!');
    }

    public function edit($datemeasuringtoolid)
    {
        $datemeasuringtool = DateMeasuringTool::find($datemeasuringtoolid);
        $datemeasuringtooldetail = DB::select('SELECT date_measuring_tools.id, projects.ProjectName, locations.LocationName, products.ProductName, machines.MachineName, systems.SystemName, equipment.EquipmentName, job_dates.Date
            FROM (job_dates INNER JOIN (equipment INNER JOIN ((systems INNER JOIN ((machines INNER JOIN ((products INNER JOIN ((locations INNER JOIN projects ON locations.id = projects.location_id) INNER JOIN project_products ON projects.id = project_products.project_id) ON products.id = project_products.product_id) INNER JOIN product_machines ON project_products.id = product_machines.project_product_id) ON machines.id = product_machines.machine_id) INNER JOIN machine_systems ON product_machines.id = machine_systems.product_machine_id) ON systems.id = machine_systems.system_id) INNER JOIN jobs ON machine_systems.id = jobs.machine_system_id) ON equipment.id = jobs.equipment_id) ON job_dates.job_id = jobs.id) INNER JOIN date_measuring_tools ON job_dates.id = date_measuring_tools.job_date_id
            WHERE (((date_measuring_tools.id)='.$datemeasuringtoolid.'))');
        $measuringtool = Tool::where('tools.MeasuringTool','Yes')->orderBy('tools.ToolName')->get();

        return view('date_measuringtools.edit',compact('datemeasuringtool','datemeasuringtooldetail','measuringtool'));
    }

    public function update(Request $request,$datemeasuringtoolid)
    {
        $this->validate(request(),[
            'MeasuredObject'=>'required',
            'User'=>'required'
        ]);

        $datemeasuringtool = DateMeasuringTool::find($datemeasuringtoolid);
        $datemeasuringtool->tool_id = $request->input('tool_id');
        $datemeasuringtool->OtherToolName = $request->input('OtherToolName');
        $datemeasuringtool->MeasuredObject = $request->input('MeasuredObject');
        $datemeasuringtool->User = $request->input('User');
        $datemeasuringtool->Remark = $request->input('Remark');
        $datemeasuringtool->save();
        
        return back()->with('message','Successfully updated the Measuring Tool!');
    }

    public function destroy($datemeasuringtoolid)
    {
        $datemeasuringtool = DateMeasuringTool::findOrFail($datemeasuringtoolid);
        $datemeasuringtool->delete();
		return back()->with('message','Successfully deleted the Measuring Tool!');
    }
}
