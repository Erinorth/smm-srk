<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Item;
use App\Models\Tool;
use App\Models\ToolCatagory;
use App\Models\ItemToolCatagory;
use App\Models\Project;
use App\Models\ToolCatagorySite;
use App\Models\ToolCalibrate;
use App\Models\ToolPM;
use App\Models\ExpensiveTool;
use App\Models\ToolUpdate;
use App\Models\Employee;
use App\Models\ToolPMInterval;
use App\Models\ToolBreakdown;
use App\Models\ToolPreUse;
use App\Models\ToolProjectCertificate;
use App\Models\ToolType;
use Auth;
use Carbon\Carbon;

class ToolController extends Controller
{
    public function tool(Request $request, $id)
    {
        $toolcatagory = ToolCatagory::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE tool_status AS (
                SELECT tools.id AS tool_id, 'Add' AS Status, '' AS Remark, tools.updated_at, 'In Store' AS location
                FROM tools
                WHERE tools.tool_catagory_id=$id
                UNION
                SELECT t.tool_id, t.Status, t.Remark, t.updated_at, 'In Store' AS location
                FROM tools INNER JOIN (tool_updates AS t INNER JOIN (SELECT id, max(updated_at) AS MaxDate
                FROM tool_updates
                GROUP BY id
                )  AS tm ON (t.id = tm.id) AND (t.updated_at = tm.MaxDate)) ON tools.id = t.tool_id
                WHERE (((tools.tool_catagory_id)=$id))
                UNION
                SELECT t.tool_id, t.Status, t.Remark, t.updated_at, projects.ProjectName AS location
                FROM projects INNER JOIN (tool_catagory_sites INNER JOIN (tool_updates AS t INNER JOIN (SELECT id, max(updated_at) AS MaxDate
                FROM tool_updates
                GROUP BY id
                )  AS tm ON (t.id = tm.id) AND (t.updated_at = tm.MaxDate)) ON tool_catagory_sites.id = t.tool_catagory_site_id) ON projects.id = tool_catagory_sites.project_id
                WHERE (((tool_catagory_sites.tool_catagory_id)=$id))
                );

            CREATE TEMPORARY TABLE tool_status_now AS (
                SELECT t.tool_id, t.Status, t.Remark, t.updated_at, t.location
                FROM tool_status AS t INNER JOIN (SELECT tool_id, max(updated_at) AS MaxDate
                FROM tool_status
                GROUP BY tool_id)  AS tm ON (t.tool_id = tm.tool_id) AND (t.updated_at = tm.MaxDate)
                );

            CREATE TEMPORARY TABLE tool_cost AS (
                SELECT id, SUM(Cost) AS Cost
                FROM (SELECT id, IF(Price-((Price*DATEDIFF(Now(), RegisterDate))/LifeTime) <= 1,1,Price-((Price*DATEDIFF(Now(), RegisterDate))/LifeTime)) AS Cost
                    FROM tools
                    UNION
                    SELECT tool_id, SUM(IF(Cost-((Cost*DATEDIFF(Now(), CalibrateDate))/DATEDIFF(ExpireDate, CalibrateDate))<0,0,Cost-((Cost*DATEDIFF(Now(), CalibrateDate))/DATEDIFF(ExpireDate, CalibrateDate)))) AS Cost
                    FROM tool_calibrates
                    GROUP BY tool_id
                    UNION
                    SELECT tool_p_m_intervals.tool_id, SUM(IF(tool_p_m_s.Cost-((tool_p_m_s.Cost*DATEDIFF(Now(), tool_p_m_s.PMDate))/tool_p_m_intervals.Interval)<0,0,tool_p_m_s.Cost-((tool_p_m_s.Cost*DATEDIFF(Now(), tool_p_m_s.PMDate))/tool_p_m_intervals.Interval))) AS Cost
                    FROM tool_p_m_s
                    INNER JOIN tool_p_m_intervals
                    ON tool_p_m_s.tool_p_m_interval_id = tool_p_m_intervals.id
                    GROUP BY tool_id) AS cost
                GROUP BY id
                );
            ")
        );

        /* $test = DB::table('tool_cost')->get();
        dd($test); */

        if($request->ajax())
        {
            $data = DB::select('SELECT tools.id, tools.tool_catagory_id, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tools.Weight, tools.Price, tools.LifeTime, tool_cost.Cost AS PV, tools.RegisterDate, employees.ThaiName AS Responsible, tool_status_now.Status, tool_status_now.Remark, tools.Accepted
                FROM employees
                RIGHT JOIN (tools
                    INNER JOIN tool_status_now
                    ON tools.id = tool_status_now.tool_id)
                    INNER JOIN tool_cost
                    ON tools.id = tool_cost.id
                ON employees.id = tools.Responsible
                GROUP BY tools.id, tools.tool_catagory_id, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tools.Weight, tools.Price, tools.LifeTime, PV, tools.RegisterDate, employees.ThaiName, tool_status_now.Status, tool_status_now.Remark, tools.Accepted
                HAVING (((tools.tool_catagory_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('LocalCode', function($data) {
                    return '<div class="text-center">'.$data->LocalCode.'</div>';
                })
                ->editColumn('SerialNumber', function($data) {
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->editColumn('DurableSupplieCode', function($data) {
                    return '<div class="text-center">'.$data->DurableSupplieCode.'</div>';
                })
                ->editColumn('AssetToolCode', function($data) {
                    return '<div class="text-center">'.$data->AssetToolCode.'</div>';
                })
                ->editColumn('Weight', function($data) {
                    return '<div class="text-center">'.$data->Weight.'</div>';
                })
                ->editColumn('Price', function($data) {
                    return '<div class="text-center">'.number_format($data->Price, 2).'</div>';
                })
                ->editColumn('LifeTime', function($data) {
                    return '<div class="text-center">'.number_format($data->LifeTime, 0).'</div>';
                })
                ->editColumn('Responsible', function($data) {
                    return '<div class="text-center">'.$data->Responsible.'</div>';
                })
                ->editColumn('PV', function($data) {
                    if ( $data->PV <= 1 ) {
                        return '<div class="text-center">'.number_format(1, 2).'</div>';
                    } else {
                        return '<div class="text-center">'.number_format($data->PV, 2).'</div>';
                    }
                })
                ->editColumn('Status', function($data) {
                    if ( $data->Status == "Return" ) {
                        return '<div class="text-center">Available</div>';
                    } else {
                        return '<div class="text-center">'.$data->Status.'</div>';
                    }
                })
                ->addColumn('action','
                    <div class="text-center">
                        @role('."'admin|store_keeper'".')
                            <button class="update btn btn-xs btn-default text-warning mx-1 shadow" name="update" id="{{$id}}" title="Update"><i class="fa fa-lg fa-fw fa-sync-alt"></i></button>
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        @endrole
                        <button class="history btn btn-xs btn-default text-info mx-1 shadow" name="show" id="{{$id}}" title="History"><i class="fa fa-lg fa-fw fa-eye"></i></button>
                    </div>'
                )
                ->addColumn('PM','
                    <div class="text-center">
                        <a class="btn btn-xs btn-default text-info mx-1 shadow" name="PM" title="PM" href="'.url('tool_PM_intervals/{{$id}}').'"><i class="fa fa-lg fa-fw fa-tools"></i></a>
                        <a class="btn btn-xs btn-default text-info mx-1 shadow" name="PMRecord" title="PM Record" href="'.url('tool_pm_record/{{$id}}').'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                    </div>'
                )
                ->addColumn('PreUse','
                    <div class="text-center">
                        <a class="btn btn-xs btn-default text-info mx-1 shadow" name="PreUse" title="Pre Use" href="'.url('tool_pre_use_activities/{{$id}}').'"><i class="fa fa-lg fa-fw fa-tools"></i></a>
                    </div>'
                )
                ->addColumn('Accept', function($data) {
                    if ( $data->Accepted == "" ) {
                        return '
                        <div class="text-center">
                            <a href = "'.url('tool_accept/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Accept"><i class="fa fa-lg fa-fw fa-print"></i></a>
                            [Attachment<button class="attachment btn btn-xs btn-default text-success mx-1 shadow" name="attachment" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>]
                        </div>';
                    } else {
                        return '
                        <div class="text-center">
                            <a href = "'.url('tool_accept/'.$data->id) .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Accept"><i class="fa fa-lg fa-fw fa-print"></i></a>
                            [Attachment<a href="'. url('storage/tool'.$data->id.'/accepted/'.$data->Accepted.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                            <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete_attachment btn btn-xs btn-default text-danger mx-1 shadow" name="attachment" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>]
                        </div>';
                    }
                })
                ->rawColumns(['LocalCode','SerialNumber','DurableSupplieCode','AssetToolCode','Weight','Price','LifeTime','PV','Responsible','Status','action','PM','PreUse','Accept'])
                ->make(true);
        }

        $temptool = DB::select('SELECT tools.id, tools.tool_catagory_id, tools.SerialNumber, tools.DurableSupplieCode, tools.AssetToolCode, tools.Price
            FROM tools
            WHERE ((ISNULL(tools.tool_catagory_id)))');

        $responsible = Employee::orderBy('ThaiName','asc')->get();

        //$test = DB::table('tool_status_now')->get();
        //dd($test);

        return view('tools.create',compact('toolcatagory','temptool','responsible'));
    }

    public function toolstore(Request $request)
    {
        $rules = array(
            'LocalCode'=>'required',
            'SerialNumber'=>'required',
            'Weight'=>'required|numeric',
            'Price'=>'required|numeric',
            'LifeTime'=>'required|numeric|gt:0',
            'RegisterDate'=>'required',
            'Responsible'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_catagory_id' => $request->tool_catagory_id,
            'SerialNumber' => $request->SerialNumber,
            'Brand' => $request->Brand,
            'Model' => $request->Model,
            'LocalCode' => $request->LocalCode,
            'DurableSupplieCode' => $request->DurableSupplieCode,
            'AssetToolCode' => $request->AssetToolCode,
            'Weight' => $request->Weight,
            'Price'=> $request->Price,
            'LifeTime'=> $request->LifeTime,
            'RegisterDate'=> $request->RegisterDate,
            'Responsible'=> $request->Responsible
        );

        Tool::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function tooledit($id)
    {
        if(request()->ajax())
        {
            $data = Tool::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function toolupdate(Request $request,Tool $toolid)
    {
        $rules = array(
            'LocalCode'=>'required',
            'SerialNumber'=>'required',
            'Weight'=>'required|numeric',
            'Price'=>'required|numeric',
            'LifeTime'=>'required|numeric|gt:0',
            'RegisterDate'=>'required',
            'Responsible'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_catagory_id' => $request->tool_catagory_id,
            'SerialNumber' => $request->SerialNumber,
            'Brand' => $request->Brand,
            'Model' => $request->Model,
            'LocalCode' => $request->LocalCode,
            'DurableSupplieCode' => $request->DurableSupplieCode,
            'AssetToolCode' => $request->AssetToolCode,
            'Weight' => $request->Weight,
            'Price'=> $request->Price,
            'LifeTime'=> $request->LifeTime,
            'RegisterDate'=> $request->RegisterDate,
            'Responsible'=> $request->Responsible
        );

        Tool::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function tooldestroy($id)
    {
        $data = Tool::findOrFail($id);
        $data->delete();
    }

    public function history(Request $request, $id)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE history AS (
                SELECT tool_updates.created_at, projects.ProjectName, tool_updates.Status, tool_updates.Remark, tool_updates.tool_id
                FROM projects RIGHT JOIN (tool_catagory_sites RIGHT JOIN tool_updates ON tool_catagory_sites.id = tool_updates.tool_catagory_site_id) ON projects.id = tool_catagory_sites.project_id
                WHERE (((tool_updates.tool_id)=$id))
                );
            ")
        );

        $history = DB::table('history')->orderBy('created_at','desc')->get();
        return json_encode(array('data'=>$history));
    }

    public function historystore(Request $request)
    {
        $rules = array(
            'Status'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Status' => $request->Status,
            'Remark' => $request->Remark,
            'tool_id' => $request->update_id
        );

        ToolUpdate::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function catagory(Request $request)
    {
        $type = ToolType::orderBy('MainType','asc')->orderBy('SubType','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT tool_catagories.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagories.Unit, tool_types.MainType, tool_types.SubType, tool_catagories.MeasuringTool, tool_catagories.Min, tool_catagories.Max, count_tool_store.CountOftool_id AS InStore, count_tool_site.CountOftool_id AS OnSite
                FROM (tool_catagories
                    LEFT JOIN tool_types
                    ON tool_types.id = tool_catagories.tool_type_id
                    LEFT JOIN (SELECT tools.tool_catagory_id, tool_status.Status, Count(tool_status.tool_id) AS CountOftool_id
                        FROM tools
                            INNER JOIN (SELECT tool_updates.tool_id,
                                    IF( tool_updates.Status = "Available" OR tool_updates.Status = "Return",
                                        "Available",
                                        tool_updates.Status
                                    ) AS Status
                                FROM (SELECT tool_id, max(created_at) AS MaxDate FROM tool_updates GROUP BY tool_id)  AS MaxDate INNER JOIN tool_updates ON (MaxDate.tool_id = tool_updates.tool_id) AND (MaxDate.MaxDate = tool_updates.created_at)
                                GROUP BY tool_updates.tool_id, Status
                                ORDER BY tool_updates.tool_id) AS tool_status
                            ON tools.id = tool_status.tool_id
                        GROUP BY tools.tool_catagory_id, tool_status.Status
                        HAVING (((tool_status.Status)="On Site"))) AS count_tool_site
                    ON tool_catagories.id = count_tool_site.tool_catagory_id)
                    LEFT JOIN (SELECT tools.tool_catagory_id, tool_status.Status, Count(tool_status.tool_id) AS CountOftool_id
                        FROM tools
                            INNER JOIN (SELECT tool_updates.tool_id,
                                    IF( tool_updates.Status = "Available" OR tool_updates.Status = "Return",
                                        "Available",
                                        tool_updates.Status
                                    ) AS Status
                                FROM (SELECT tool_id, max(created_at) AS MaxDate FROM tool_updates GROUP BY tool_id)  AS MaxDate INNER JOIN tool_updates ON (MaxDate.tool_id = tool_updates.tool_id) AND (MaxDate.MaxDate = tool_updates.created_at)
                                GROUP BY tool_updates.tool_id, Status
                                ORDER BY tool_updates.tool_id) AS tool_status
                            ON tools.id = tool_status.tool_id
                        GROUP BY tools.tool_catagory_id, tool_status.Status
                        HAVING (((tool_status.Status)="Available"))) AS count_tool_store
                    ON tool_catagories.id = count_tool_store.tool_catagory_id');
            return DataTables::of($data)
                ->editColumn('CatagoryName', function($data) {
                    return '<div class="d-none">'.$data->CatagoryName.'</div><a href="tools/'.$data->id.'">'.$data->CatagoryName.'</a>';
                })
                ->editColumn('RangeCapacity', function($data) {
                    return '<div class="text-center">'.$data->RangeCapacity.'</div>';
                })
                ->editColumn('Unit', function($data) {
                    return '<div class="text-center">'.$data->Unit.'</div>';
                })
                ->editColumn('Type', function($data) {
                    if ( $data->SubType != "" ) {
                        return '<div class="text-center">'.$data->MainType.' // '.$data->SubType.'</div>';
                    }
                    return '';
                })
                ->editColumn('MeasuringTool', function($data) {
                    return '<div class="text-center">'.$data->MeasuringTool.'</div>';
                })
                ->editColumn('Min', function($data) {
                    return '<div class="text-center">'.$data->Min.'</div>';
                })
                ->editColumn('Max', function($data) {
                    return '<div class="text-center">'.$data->Max.'</div>';
                })
                ->editColumn('InStore', function($data) {
                    return '<div class="text-center">'.$data->InStore.'</div>';
                })
                ->editColumn('OnSite', function($data) {
                    return '<div class="text-center">'.$data->OnSite.'</div>';
                })
                ->editColumn('action', function($data) {
                    if ( $data->InStore > 0 OR $data->OnSite > 0 ) {
                        return view('tools.catagory_option1',compact('data'));
                    } else {
                        return view('tools.catagory_option2',compact('data'));;
                    }
                })
                ->rawColumns(['CatagoryName','RangeCapacity','Unit','Type','MeasuringTool','Min','Max','InStore','OnSite','action'])
                ->make(true);
        }

        //$test = DB::table('count_tool_site')->get();
        //dd($test);

        return view('tools.catagory',compact('type'));
    }

    public function catagorystore(Request $request)
    {
        $rules = array(
            'CatagoryName'=>'required',
            'Unit'=>'required',
            'MeasuringTool'=>'required',
            'Min'=>'required|numeric',
            'Max'=>'required|numeric'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'CatagoryName' => $request->CatagoryName,
            'RangeCapacity' => $request->RangeCapacity,
            'Unit' => $request->Unit,
            'tool_type_id' => $request->tool_type_id,
            'MeasuringTool' => $request->MeasuringTool,
            'Min' => $request->Min,
            'Max' => $request->Max
        );

        ToolCatagory::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function catagoryedit($id)
    {
        if(request()->ajax())
        {
            $data = ToolCatagory::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function catagoryupdate(Request $request)
    {
        $rules = array(
            'CatagoryName'=>'required',
            'Unit'=>'required',
            'MeasuringTool'=>'required',
            'Min'=>'required|numeric',
            'Max'=>'required|numeric'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'CatagoryName' => $request->CatagoryName,
            'RangeCapacity' => $request->RangeCapacity,
            'Unit' => $request->Unit,
            'tool_type_id' => $request->tool_type_id,
            'MeasuringTool' => $request->MeasuringTool,
            'Min' => $request->Min,
            'Max' => $request->Max
        );

        ToolCatagory::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function catagorydestroy($id)
    {
        $data = ToolCatagory::findOrFail($id);
        $data->delete();
    }

    public function itemcatagorycreate(Request $request, $id)
    {
        $item = Item::find($id);

        $toolcatagory = ToolCatagory::orderBy('CatagoryName','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT item_tool_catagories.id, item_tool_catagories.item_id, tool_catagories.CatagoryName, item_tool_catagories.Quantity, tool_catagories.Unit, item_tool_catagories.Remark
                FROM tool_catagories INNER JOIN item_tool_catagories ON tool_catagories.id = item_tool_catagories.tool_catagory_id
                WHERE (((item_tool_catagories.item_id)='.$id.'))
                ORDER BY tool_catagories.CatagoryName');
            return DataTables::of($data)
                    ->editColumn('Unit', function($data) {
                        return '<div class="text-center">'.$data->Unit.'</div>';
                    })
                    ->editColumn('Quantity', function($data) {
                        return '<div class="text-center">'.$data->Quantity.'</div>';
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>
                    ')
                    ->rawColumns(['Unit','Quantity','action'])
                    ->make(true);
        }
        return view('tools.itemcatagorycreate',compact('item','toolcatagory'));
    }

    public function itemcatagorystore(Request $request)
    {
        $rules = array(
            'tool_catagory_id'=>'required',
            'Quantity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_catagory_id' => $request->tool_catagory_id,
            'Quantity' => $request->Quantity,
            'Remark' => $request->Remark,
            'item_id' => $request->item_id
        );

        ItemToolCatagory::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function itemcatagoryedit($id)
    {
        if(request()->ajax())
        {
            $data = ItemToolCatagory::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function itemcatagoryupdate(Request $request, ItemToolCatagory $itemtoolcatagoryid)
    {
        $rules = array(
            'tool_catagory_id'=>'required',
            'Quantity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_catagory_id' => $request->tool_catagory_id,
            'Quantity' => $request->Quantity,
            'Remark' => $request->Remark,
            'item_id' => $request->item_id
        );

        ItemToolCatagory::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function itemcatagorydestroy($id)
    {
        $data = ItemToolCatagory::findOrFail($id);
        $data->delete();
    }

    public function catagorysitepick(Request $request, $id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE max_tool_update AS (
                SELECT tool_updates.*
                FROM tool_updates
                INNER JOIN(SELECT tool_catagory_site_id, tool_id, MAX(created_at) AS MAXcreated_at
                    FROM tool_updates
                    GROUP BY tool_catagory_site_id, tool_id) t
                ON tool_updates.tool_catagory_site_id = t.tool_catagory_site_id AND tool_updates.tool_id = t.tool_id AND tool_updates.created_at = t.MAXcreated_at
                );

            CREATE TEMPORARY TABLE tool_site_quantity AS (
                SELECT max_tool_update.tool_catagory_site_id, COUNT(max_tool_update.tool_id) AS Quantity
                FROM max_tool_update
                WHERE max_tool_update.Status = 'On Site'
                GROUP BY max_tool_update.tool_catagory_site_id
                );
            ")
        );

        /* $test = DB::table('tool_site_quantity')->get();
        dd($test); */

        $toolcatagory = ToolCatagory::orderBy('CatagoryName','asc')->get();

        $group = ToolCatagorySite::select('Group')
            ->where('project_id','=',$id)
            ->whereNotNull('Group')
            ->groupBy('Group')
            ->orderBy('Group','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT tool_catagory_sites.id, tool_catagory_sites.updated_at, tool_catagory_sites.tool_catagory_id, tool_catagory_sites.project_id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagory_sites.PickQuantity, tool_catagories.Unit, tool_catagory_sites.Remark, tool_catagory_sites.Group, tool_site_quantity.Quantity, tool_catagory_sites.tool_catagory_id
                FROM tool_site_quantity
                RIGHT JOIN tool_catagory_sites
                ON tool_site_quantity.tool_catagory_site_id = tool_catagory_sites.id
                INNER JOIN tool_catagories
                ON tool_catagory_sites.tool_catagory_id = tool_catagories.id
                WHERE tool_catagory_sites.project_id='.$id.'');
            return DataTables::of($data)
                    ->editColumn('updated_at', function($data) {
                        return '<div class="text-center">'.$data->updated_at.'</div>';
                    })
                    ->editColumn('RangeCapacity', function($data) {
                        return '<div class="text-center">'.$data->RangeCapacity.'</div>';
                    })
                    ->editColumn('PickQuantity', function($data) {
                        return '<div class="text-center">'.$data->PickQuantity.'</div>';
                    })
                    ->editColumn('Unit', function($data) {
                        return '<div class="text-center">'.$data->Unit.'</div>';
                    })
                    ->editColumn('Group', function($data) {
                        return '<div class="text-center">'.$data->Group.'</div>';
                    })
                    ->addColumn('action',function($data) {
                        if ( $data->Quantity > 0 )
                        return '<div class="text-center">
                                    <a class="btn btn-info btn-sm" href="'.url('tool_sites/'.$data->id).'">On Site ( '.$data->Quantity.' )</a>
                                </div>';
                        return '<div class="text-center">
                                    <a class="btn btn-info btn-sm" href="'.url('tool_sites/'.$data->id).'">On Site ( '.$data->Quantity.' )</a>
                                    <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                    <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                </div>';
                    })
                    ->rawColumns(['updated_at','RangeCapacity','PickQuantity','Unit','Group','action'])
                    ->make(true);
        }

        return view('tools.catagorysitepick',compact('project','toolcatagory','group'));
    }

    public function catagorysitepickstore(Request $request)
    {
        $rules = array(
            'tool_catagory_id'=>'required',
            'PickQuantity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_catagory_id' => $request->tool_catagory_id,
            'PickQuantity' => $request->PickQuantity,
            'Group' => $request->Group,
            'Remark' => $request->Remark,
            'project_id' => $request->project_id
        );

        ToolCatagorySite::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function catagorysiteedit($id)
    {
        if(request()->ajax())
        {
            $data = ToolCatagorySite::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function catagorysiteupdate(Request $request, ToolCatagorySite $toolcatagoryid)
    {
        $rules = array(
            'tool_catagory_id'=>'required',
            'PickQuantity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_catagory_id' => $request->tool_catagory_id,
            'PickQuantity' => $request->PickQuantity,
            'Group' => $request->Group,
            'Remark' => $request->Remark,
            'project_id' => $request->project_id
        );

        ToolCatagorySite::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function catagorysitedestroy($id)
    {
        $data = ToolCatagorySite::findOrFail($id);
        $data->delete();
    }

    public function toolsitepick(Request $request, $id)
    {
        $toolcatagorysite = ToolCatagorySite::find($id);

        $toolcatagory = $toolcatagorysite->tool_catagory_id;

        $tool = DB::select('SELECT t.tool_id, tools.LocalCode, tools.Brand, tools.Model, tools.SerialNumber, t.Status, tools.tool_catagory_id
            FROM tools INNER JOIN (tool_updates AS t INNER JOIN
                (SELECT tool_id, max(created_at) AS MaxDate
                    FROM tool_updates
                    GROUP BY tool_id
                )  AS tm ON (t.tool_id = tm.tool_id) AND (t.created_at = tm.MaxDate)) ON tools.id = t.tool_id
            WHERE (t.Status="Available" OR t.Status="Return") AND tools.tool_catagory_id='.$toolcatagory.'');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE max_tool_site AS (
                SELECT tool_updates.*
                FROM tool_updates
                INNER JOIN(SELECT tool_catagory_site_id, tool_id, MAX(created_at) AS MAXcreated_at
                    FROM tool_updates
                    GROUP BY tool_catagory_site_id, tool_id) t
                ON tool_updates.tool_catagory_site_id = t.tool_catagory_site_id AND tool_updates.tool_id = t.tool_id AND tool_updates.created_at = t.MAXcreated_at
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::select('SELECT max_tool_site.id, max_tool_site.tool_id, max_tool_site.tool_catagory_site_id, tools.LocalCode, tools.Brand, tools.Model, tools.SerialNumber, tools.DurableSupplieCode, tools.AssetToolCode, max_tool_site.Status, max_tool_site.Remark
                FROM tools
                INNER JOIN max_tool_site
                ON tools.id = max_tool_site.tool_id
                WHERE max_tool_site.tool_catagory_site_id='.$id.'');
            return DataTables::of($data)
                ->editColumn('LocalCode', function($data) {
                    return '<div class="text-center">'.$data->LocalCode.'</div>';
                })
                ->editColumn('Brand', function($data) {
                    return '<div class="text-center">'.$data->Brand.'</div>';
                })
                ->editColumn('Model', function($data) {
                    return '<div class="text-center">'.$data->Model.'</div>';
                })
                ->editColumn('SerialNumber', function($data) {
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->editColumn('DurableSupplieCode', function($data) {
                    return '<div class="text-center">'.$data->DurableSupplieCode.'</div>';
                })
                ->editColumn('AssetToolCode', function($data) {
                    return '<div class="text-center">'.$data->AssetToolCode.'</div>';
                })
                ->editColumn('Status', function($data) {
                    return '<div class="text-center">'.$data->Status.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="update btn btn-xs btn-default text-warning mx-1 shadow" name="update" id="{{$id}}" tool_id="{{$tool_id}}" tool_catagory_site_id="{{$tool_catagory_site_id}}" title="Update"><i class="fa fa-lg fa-fw fa-sync-alt"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        <button class="transfer btn btn-xs btn-default text-info mx-1 shadow" name="transfer" id="{{$tool_id}}" title="transfer"><i class="fa fa-lg fa-fw fa-exchange"></i></button>
                    </div>
                ')
                ->rawColumns(['LocalCode','Status','Brand','Model','SerialNumber','DurableSupplieCode','AssetToolCode','action'])
                ->make(true);
        }

        $project = Project::where('Status','=','Confirmed')
            ->whereDate('FinishDate','>',Carbon::today())
            ->orderBy('ProjectName')
            ->get();

        return view('tools.toolsitepick',compact('toolcatagorysite','toolcatagory','tool','project'));
    }

    public function toolsitepickstore(Request $request)
    {
        $rules = array(
            'tool_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_catagory_site_id' => $request->tool_catagory_site_id,
            'tool_id' => $request->tool_id,
            'Status' => $request->Status,
            'Remark' => $request->Remark
        );

        ToolUpdate::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function toolsiteupdate(Request $request)
    {
        $rules = array(
            'tool_catagory_site_id2'=>'required',
            'tool_id2'=>'required',
            'Status2'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_catagory_site_id' => $request->tool_catagory_site_id2,
            'tool_id' => $request->tool_id2,
            'Status' => $request->Status2,
            'Remark' => $request->Remark2
        );

        ToolUpdate::create($form_data);

        return response()->json(['success' => 'Data updated successfully.']);
    }

    public function toolsitedestroy($id)
    {
        $data = ToolUpdate::findOrFail($id);
        $data->delete();
    }

    public function toolsitetransfer(Request $request)
    {
        $rules = array(
            'project_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $projectid = $request->project_id;
        $tool = Tool::find($request->transfer_id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE tool_catagory_project AS (
                SELECT id, project_id, tool_catagory_id, updated_at
                FROM tool_catagory_sites
                WHERE project_id = $projectid AND tool_catagory_id = $tool->tool_catagory_id
                );

            CREATE TEMPORARY TABLE tool_catagory_update AS (
                SELECT tool_catagory_project.id, tool_catagory_project.project_id, tool_catagory_project.tool_catagory_id, tool_catagory_project.updated_at
                FROM tool_catagory_project
                INNER JOIN (SELECT tool_catagory_id, MAX(updated_at) AS MaxToolCatagoryProject
                    FROM tool_catagory_project
                    GROUP BY tool_catagory_id) AS maxtoolcatagoryproject
                ON tool_catagory_project.tool_catagory_id = maxtoolcatagoryproject.tool_catagory_id AND tool_catagory_project.updated_at = maxtoolcatagoryproject.MaxToolCatagoryProject
                );
            ")
        );

        $toolcatagoryupdate = DB::table('tool_catagory_update')->orderBy('updated_at', 'desc')->first();

        if ($request->Remark) {
            $remark = "Transfer - ".$request->Remark;
        }else{
            $remark = "Transfer";
        };

        if ($toolcatagoryupdate) {
            $form_data = array(
                'tool_catagory_site_id' => $request->tool_catagory_site_id,
                'tool_id' => $request->transfer_id,
                'Status' => "Return",
                'Remark' => $remark
            );

            ToolUpdate::create($form_data);

            $form_data = array(
                'tool_catagory_site_id' => $toolcatagoryupdate->id,
                'tool_id' => $request->transfer_id,
                'Status' => "On Site",
                'Remark' => $remark
            );

            ToolUpdate::create($form_data);
        } else {
            $form_data = array(
                'tool_catagory_site_id' => $request->tool_catagory_site_id,
                'tool_id' => $request->transfer_id,
                'Status' => "Return",
                'Remark' => $remark
            );

            ToolUpdate::create($form_data);

            $toolcatagorysite = new ToolCatagorySite;
            $toolcatagorysite->project_id = $projectid;
            $toolcatagorysite->tool_catagory_id = $tool->tool_catagory_id;
            $toolcatagorysite->PickQuantity = 1;
            $toolcatagorysite->Group = "Trasfer";
            $toolcatagorysite->Remark = $remark;
            $toolcatagorysite->save();

            $toolupdate = new ToolUpdate;
            $toolupdate->tool_id = $request->transfer_id;
            $toolupdate->Status = "On Site";
            $toolupdate->Remark = $remark;

            $toolcatagorysite->toolupdate()->save($toolupdate);
        }

        return response()->json(['success' => 'Data Transfer successfully.']);
    }

    public function calibrate(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT tools.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.LocalCode, tools.Brand, tools.Model, tools.SerialNumber, tool_calibrates.CalibrateDate, tool_calibrates.Attachment,
                IF ( ISNULL(tool_calibrates.ExpireDate),
                    DATE_FORMAT(NOW(),"%Y-%m-%d"),
                    tool_calibrates.ExpireDate
                ) AS ExpireDate
                , tool_calibrates.Remark, tool_calibrates.updated_at,
                IF ( ISNULL(tool_calibrates.ExpireDate),
                    0,
                    DATEDIFF(tool_calibrates.ExpireDate, NOW())
                ) AS Diff
                FROM tool_catagories
                    INNER JOIN tools
                        INNER JOIN ( SELECT tool_updates.tool_id
                            FROM tool_updates
                            INNER JOIN ( SELECT tool_id, MAX(created_at) AS max_created_at
                                FROM tool_updates
                                GROUP BY tool_id) AS max_tool_updates
                            ON tool_updates.tool_id = max_tool_updates.tool_id AND tool_updates.created_at = max_tool_updates.max_created_at
                            WHERE tool_updates.Status IN("Available","Lend","Calibrating","On Site","Return")) AS tool_available
                        ON tools.id = tool_available.tool_id
                        LEFT JOIN tool_calibrates
                            INNER JOIN (SELECT tool_id, max(created_at) AS MaxDate
                                FROM tool_calibrates
                                GROUP BY tool_id)  AS tm
                            ON tool_calibrates.created_at = tm.MaxDate AND tool_calibrates.tool_id = tm.tool_id
                        ON tools.id = tool_calibrates.tool_id
                    ON tool_catagories.id = tools.tool_catagory_id
                WHERE tool_catagories.MeasuringTool="Yes"');
            return DataTables::of($data)
                ->editColumn('CatagoryName', function($data) {
                    if ( $data->Diff < 60 )
                    return '<div class="text-danger">'.$data->CatagoryName.'</div>';
                    if ( $data->Diff <= 90)
                    return '<div class="text-warning">'.$data->CatagoryName.'</div>';
                    if ( $data->Diff <= 180)
                    return '<div class="text-success">'.$data->CatagoryName.'</div>';
                    return '<div>'.$data->CatagoryName.'</div>';
                })
                ->editColumn('RangeCapacity', function($data) {
                    if ( $data->Diff < 60 )
                    return '<div class="text-center text-danger">'.$data->RangeCapacity.'</div>';
                    if ( $data->Diff <= 90)
                    return '<div class="text-center text-warning">'.$data->RangeCapacity.'</div>';
                    if ( $data->Diff <= 180)
                    return '<div class="text-center text-success">'.$data->RangeCapacity.'</div>';
                    return '<div class="text-center">'.$data->RangeCapacity.'</div>';
                })
                ->editColumn('LocalCode', function($data) {
                    if ( $data->Diff < 60 )
                    return '<div class="text-center text-danger">'.$data->LocalCode.'</div>';
                    if ( $data->Diff <= 90)
                    return '<div class="text-center text-warning">'.$data->LocalCode.'</div>';
                    if ( $data->Diff <= 180)
                    return '<div class="text-center text-success">'.$data->LocalCode.'</div>';
                    return '<div class="text-center">'.$data->LocalCode.'</div>';
                })
                ->editColumn('Brand', function($data) {
                    if ( $data->Diff < 60 )
                    return '<div class="text-center text-danger">'.$data->Brand.'</div>';
                    if ( $data->Diff <= 90)
                    return '<div class="text-center text-warning">'.$data->Brand.'</div>';
                    if ( $data->Diff <= 180)
                    return '<div class="text-center text-success">'.$data->Brand.'</div>';
                    return '<div class="text-center">'.$data->Brand.'</div>';
                })
                ->editColumn('Model', function($data) {
                    if ( $data->Diff < 60 )
                    return '<div class="text-center text-danger">'.$data->Model.'</div>';
                    if ( $data->Diff <= 90)
                    return '<div class="text-center text-warning">'.$data->Model.'</div>';
                    if ( $data->Diff <= 180)
                    return '<div class="text-center text-success">'.$data->Model.'</div>';
                    return '<div class="text-center">'.$data->Model.'</div>';
                })
                ->editColumn('SerialNumber', function($data) {
                    if ( $data->Diff < 60 )
                    return '<div class="text-center text-danger">'.$data->SerialNumber.'</div>';
                    if ( $data->Diff <= 90)
                    return '<div class="text-center text-warning">'.$data->SerialNumber.'</div>';
                    if ( $data->Diff <= 180)
                    return '<div class="text-center text-success">'.$data->SerialNumber.'</div>';
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->editColumn('CalibrateDate', function($data) {
                    if ( $data->Diff < 60 )
                    return '<div class="text-center text-danger">'.$data->CalibrateDate.'</div>';
                    if ( $data->Diff <= 90)
                    return '<div class="text-center text-warning">'.$data->CalibrateDate.'</div>';
                    if ( $data->Diff <= 180)
                    return '<div class="text-center text-success">'.$data->CalibrateDate.'</div>';
                    return '<div class="text-center">'.$data->CalibrateDate.'</div>';
                })
                ->editColumn('ExpireDate', function($data) {
                    if ( $data->Diff < 60 )
                    return '<div class="d-none">'.$data->ExpireDate.'</div><div class="text-center text-danger">'.$data->ExpireDate.'</div>';
                    if ( $data->Diff <= 90)
                    return '<div class="d-none">'.$data->ExpireDate.'</div><div class="text-center text-warning">'.$data->ExpireDate.'</div>';
                    if ( $data->Diff <= 180)
                    return '<div class="d-none">'.$data->ExpireDate.'</div><div class="text-center text-success">'.$data->ExpireDate.'</div>';
                    return '<div class="d-none">'.$data->ExpireDate.'</div><div class="text-center">'.$data->ExpireDate.'</div>';
                })
                ->editColumn('Remark', function($data) {
                    if ( $data->Diff < 60 )
                    return '<div class="text-danger">'.$data->Remark.'</div>';
                    if ( $data->Diff <= 90)
                    return '<div class="text-warning">'.$data->Remark.'</div>';
                    if ( $data->Diff <= 180)
                    return '<div class="text-success">'.$data->Remark.'</div>';
                    return '<div>'.$data->Remark.'</div>';
                })
                ->editColumn('Attachment2', function($data) {
                    if ( $data->Attachment != "" )
                    return '
                    <div class="text-center text-success">
                        <a href="'. url('storage/tool'.$data->id.'/calibrated/'.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                    </div>';
                    if ( $data->Diff < 60 )
                    return '<div class="text-center text-danger">N/A</div>';
                    if ( $data->Diff <= 90)
                    return '<div class="text-center text-warning">N/A</div>';
                    if ( $data->Diff <= 180)
                    return '<div class="text-center text-success">N/A</div>';
                    return '<div class="text-center">N/A</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <a class="btn btn-xs btn-default text-info mx-1 shadow" name="Accept" title="Accept" href="'.url('tool_calibrate_accept/{{$id}}').'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                        <a class="btn btn-xs btn-default text-info mx-1 shadow" name="Record" title="Record" href="'.url('tool_calibrate_record/{{$id}}').'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                        <button class="update btn btn-xs btn-default text-warning mx-1 shadow" name="update" id="{{$id}}" title="Update"><i class="fa fa-lg fa-fw fa-sync-alt"></i></button>
                        <button class="history btn btn-xs btn-default text-info mx-1 shadow" name="show" id="{{$id}}" title="History"><i class="fa fa-lg fa-fw fa-eye"></i></button>
                    </div>
                ')
                ->rawColumns(['CatagoryName','RangeCapacity','LocalCode','Brand','Model','SerialNumber','CalibrateDate','ExpireDate','Remark','Attachment2','action'])
                ->make(true);
        }

        return view('tools.calibrate');
    }

    public function calibrateall(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT tool_calibrates.id, tool_calibrates.tool_id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.LocalCode, tools.Brand, tools.Model, tools.SerialNumber, tool_calibrates.CalibrateDate, tool_calibrates.Calibrator, tool_calibrates.Result, tool_calibrates.Certificate, tool_calibrates.Accuracy, tool_calibrates.AcceptError, tool_calibrates.ExpireDate, tool_calibrates.Cost, tool_calibrates.Remark, tool_calibrates.Attachment, employees.ThaiName
                FROM tool_calibrates
                INNER JOIN tools
                    INNER JOIN tool_catagories
                    ON tools.tool_catagory_id = tool_catagories.id
                ON tool_calibrates.tool_id = tools.id
                INNER JOIN employees
                ON tool_calibrates.Responsible = employees.id');
            return DataTables::of($data)
                ->editColumn('CatagoryName', function($data) {
                    return '<div>'.$data->CatagoryName.'</div>';
                })
                ->editColumn('RangeCapacity', function($data) {
                    return '<div class="text-center">'.$data->RangeCapacity.'</div>';
                })
                ->editColumn('LocalCode', function($data) {
                    return '<div class="text-center">'.$data->LocalCode.'</div>';
                })
                ->editColumn('Brand', function($data) {
                    return '<div class="text-center">'.$data->Brand.'</div>';
                })
                ->editColumn('Model', function($data) {
                    return '<div class="text-center">'.$data->Model.'</div>';
                })
                ->editColumn('SerialNumber', function($data) {
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->editColumn('CalibrateDate', function($data) {
                    return '<div class="text-center">'.$data->CalibrateDate.'</div>';
                })
                ->editColumn('ExpireDate', function($data) {
                    return '<div class="text-center">'.$data->ExpireDate.'</div>';
                })
                ->editColumn('Remark', function($data) {
                    return '<div>'.$data->Remark.'</div>';
                })
                ->addColumn('Attachment3', function($data) {
                    if ( $data->Attachment != "" )
                    return '
                    <div class="text-center">
                        <a href="'. url('storage/tool'.$data->tool_id.'/calibrated/'.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                    </div>';
                    return '<div class="text-center">N/A</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="delete" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['CatagoryName','RangeCapacity','LocalCode','Brand','Model','SerialNumber','CalibrateDate','ExpireDate','Remark','Attachment3','action'])
                ->make(true);
        }
    }

    public function calibratestore(Request $request)
    {
        $rules = array(
            'CalibrateDate'=>'required|date',
            'Calibrator'=>'required',
            'Certificate'=>'required',
            'Accuracy'=>'required',
            'AcceptError'=>'required',
            'ExpireDate'=>'required|date|after:CalibrateDate',
            'Cost'=>'required',
            'Result'=>'required',
            'Attachment'=>'requiredIf:Result,"Pass"|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $employee = Employee::where('user_id','=',Auth::user()->id)->first();

        $toolid = $request->get('hidden_id_update');
        $calibratedate = $request->get('CalibrateDate');
        $file = $request->file('Attachment');

        //dd($file);

        if ( $file != "") {
            $path = 'tool'.$toolid.'/calibrated/';
            $file_name = $calibratedate.'-'.$file->getClientOriginalName();
            $upload = $file->storeAs($path, $file_name, 'public');

            if ($upload) {
                $form_data = array(
                    'CalibrateDate' => $request->CalibrateDate,
                    'Calibrator' => $request->Calibrator,
                    'Certificate' => $request->Certificate,
                    'Result' => $request->Result,
                    'Accuracy' => $request->Accuracy,
                    'AcceptError' => $request->AcceptError,
                    'ExpireDate' => $request->ExpireDate,
                    'Cost' => $request->Cost,
                    'tool_id'=> $request->hidden_id_update,
                    'Remark' => $request->Remark,
                    'Responsible' => $employee->id,
                    'Attachment' => $file_name
                );
            }
        } else {
            $form_data = array(
                'CalibrateDate' => $request->CalibrateDate,
                'Calibrator' => $request->Calibrator,
                'Certificate' => $request->Certificate,
                'Result' => $request->Result,
                'Accuracy' => $request->Accuracy,
                'AcceptError' => $request->AcceptError,
                'ExpireDate' => $request->ExpireDate,
                'Cost' => $request->Cost,
                'tool_id'=> $request->hidden_id_update,
                'Remark' => $request->Remark,
                'Responsible' => $employee->id
            );
        }

        ToolCalibrate::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function calibratedestroy($id)
    {
        $data = ToolCalibrate::findOrFail($id);
        $path = 'tool'.$data->tool_id.'/calibrated/';
        $file_path = $path.$data->Attachment;
            if ( $data->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
        $data->delete();
		return back()->with('message','Successfully deleted the Calibrate!');
    }

    public function calibratehistory(Request $request, $id)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE history AS (
                SELECT tool_calibrates.tool_id, tool_calibrates.CalibrateDate, tool_calibrates.Calibrator, tool_calibrates.Certificate, tool_calibrates.Result, tool_calibrates.Accuracy, tool_calibrates.AcceptError, tool_calibrates.Cost, tool_calibrates.Remark, employees.ThaiName AS Responsible
                FROM employees
                INNER JOIN (tool_calibrates
                    INNER JOIN (SELECT id, max(CalibrateDate) AS MaxDate
                        FROM tool_calibrates
                        GROUP BY id)  AS max_tool_calibrates
                    ON (tool_calibrates.id = max_tool_calibrates.id) AND (tool_calibrates.CalibrateDate = max_tool_calibrates.MaxDate))
                ON employees.id = tool_calibrates.Responsible
                WHERE (((tool_calibrates.tool_id)=$id))
                );
            ")
        );

        $history = DB::table('history')->orderBy('CalibrateDate','desc')->get();
        return json_encode(array('data'=>$history));
    }

    public function pminterval(Request $request, $id)
    {
        $tool = Tool::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT tool_p_m_intervals.id, tool_p_m_intervals.tool_id, tool_p_m_intervals.Activity, tool_p_m_intervals.Interval, tool_p_m_intervals.Remark
                FROM tool_p_m_intervals
                WHERE (((tool_p_m_intervals.tool_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('Activity', function($data) {
                        return nl2br($data->Activity);
                    })
                    ->editColumn('Interval', function($data) {
                        return '<div class="text-center">'.$data->Interval.'</div>';
                    })
                    ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                    ')
                    ->rawColumns(['Activity','Interval','action'])
                    ->make(true);
        }

        return view('tools.PMinterval',compact('tool'));
    }

    public function pmintervalstore(Request $request)
    {
        $rules = array(
            'Activity'=>'required',
            'Interval'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Interval' => $request->Interval,
            'Activity' => $request->Activity,
            'tool_id'=> $request->tool_id,
            'Remark' => $request->Remark
        );

        ToolPMInterval::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function pmintervaledit($id)
    {
        if(request()->ajax())
        {
            $data = ToolPMInterval::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function pmintervalupdate(Request $request)
    {
        $rules = array(
            'Activity'=>'required',
            'Interval'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Interval' => $request->Interval,
            'Activity' => $request->Activity,
            'tool_id'=> $request->tool_id,
            'Remark' => $request->Remark
        );

        ToolPMInterval::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function pmintervaldestroy($id)
    {
        $pminterval = ToolPMInterval::findOrFail($id);
        $pminterval->delete();
		return back()->with('message','Successfully deleted the PM!');
    }

    public function PM(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT tool_p_m_intervals.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.LocalCode, tools.Brand, tools.Model, tools.SerialNumber, tool_p_m_intervals.Activity,
                IF ( ISNULL(t.PMDate),
                    tools.RegisterDate,
                    t.PMDate
                ) AS PMDate,
                IF ( ISNULL(t.PMDate),
                    DATE_ADD(tools.RegisterDate, INTERVAL tool_p_m_intervals.Interval DAY),
                    DATE_ADD(t.PMDate, INTERVAL tool_p_m_intervals.Interval DAY)
                ) AS NextPM,
                IF ( ISNULL(t.PMDate),
                    "ตรวจรับครั้งแรก",
                    t.Remark
                ) AS Remark,
                IF ( ISNULL(t.PMDate),
                    DATEDIFF(DATE_ADD(tools.RegisterDate, INTERVAL tool_p_m_intervals.Interval DAY), NOW()),
                    DATEDIFF(DATE_ADD(t.PMDate, INTERVAL tool_p_m_intervals.Interval DAY), NOW())
                ) AS Diff
                FROM tool_catagories
                    INNER JOIN (tools
                        INNER JOIN (tool_p_m_intervals
                            LEFT JOIN (tool_p_m_s AS t
                                INNER JOIN (SELECT tool_p_m_interval_id, max(PMDate) AS MaxDate
                                    FROM tool_p_m_s
                                    GROUP BY tool_p_m_interval_id)  AS tm
                                ON (t.PMDate = tm.MaxDate) AND (t.tool_p_m_interval_id = tm.tool_p_m_interval_id))
                            ON tool_p_m_intervals.id = t.tool_p_m_interval_id)
                        ON tools.id = tool_p_m_intervals.tool_id)
                        INNER JOIN ( SELECT tool_updates.tool_id
                            FROM tool_updates
                            INNER JOIN ( SELECT tool_id, MAX(created_at) AS max_created_at
                                FROM tool_updates
                                GROUP BY tool_id) AS max_tool_updates
                            ON tool_updates.tool_id = max_tool_updates.tool_id AND tool_updates.created_at = max_tool_updates.max_created_at
                            WHERE tool_updates.Status IN("Available","Lend","Calibrating","On Site","Return")) AS tool_available
                        ON tools.id = tool_available.tool_id
                    ON tool_catagories.id = tools.tool_catagory_id');
            return DataTables::of($data)
                ->editColumn('CatagoryName', function($data) {
                    if ( $data->Diff < 0 )
                    return '<div class="text-danger">'.$data->CatagoryName.'</div>';
                    if ( $data->Diff <= 7)
                    return '<div class="text-warning">'.$data->CatagoryName.'</div>';
                    if ( $data->Diff <= 14)
                    return '<div class="text-success">'.$data->CatagoryName.'</div>';
                    return '<div>'.$data->CatagoryName.'</div>';
                })
                ->editColumn('RangeCapacity', function($data) {
                    if ( $data->Diff < 0 )
                    return '<div class="text-danger">'.$data->RangeCapacity.'</div>';
                    if ( $data->Diff <= 7)
                    return '<div class="text-warning">'.$data->RangeCapacity.'</div>';
                    if ( $data->Diff <= 14)
                    return '<div class="text-success">'.$data->RangeCapacity.'</div>';
                    return '<div>'.$data->RangeCapacity.'</div>';
                })
                ->editColumn('LocalCode', function($data) {
                    if ( $data->Diff < 0 )
                    return '<div class="text-center text-danger">'.$data->LocalCode.'</div>';
                    if ( $data->Diff <= 7)
                    return '<div class="text-center text-warning">'.$data->LocalCode.'</div>';
                    if ( $data->Diff <= 14)
                    return '<div class="text-center text-success">'.$data->LocalCode.'</div>';
                    return '<div class="text-center">'.$data->LocalCode.'</div>';
                })
                ->editColumn('Brand', function($data) {
                    if ( $data->Diff < 0 )
                    return '<div class="text-center text-danger">'.$data->Brand.'</div>';
                    if ( $data->Diff <= 7)
                    return '<div class="text-center text-warning">'.$data->Brand.'</div>';
                    if ( $data->Diff <= 14)
                    return '<div class="text-center text-success">'.$data->Brand.'</div>';
                    return '<div class="text-center">'.$data->Brand.'</div>';
                })
                ->editColumn('Model', function($data) {
                    if ( $data->Diff < 0 )
                    return '<div class="text-center text-danger">'.$data->Model.'</div>';
                    if ( $data->Diff <= 7)
                    return '<div class="text-center text-warning">'.$data->Model.'</div>';
                    if ( $data->Diff <= 14)
                    return '<div class="text-center text-success">'.$data->Model.'</div>';
                    return '<div class="text-center">'.$data->Model.'</div>';
                })
                ->editColumn('SerialNumber', function($data) {
                    if ( $data->Diff < 0 )
                    return '<div class="text-center text-danger">'.$data->SerialNumber.'</div>';
                    if ( $data->Diff <= 7)
                    return '<div class="text-center text-warning">'.$data->SerialNumber.'</div>';
                    if ( $data->Diff <= 14)
                    return '<div class="text-center text-success">'.$data->SerialNumber.'</div>';
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->editColumn('Activity', function($data) {
                    if ( $data->Diff < 0 )
                    return '<div class="text-danger">'.nl2br($data->Activity).'</div>';
                    if ( $data->Diff <= 7)
                    return '<div class="text-warning">'.nl2br($data->Activity).'</div>';
                    if ( $data->Diff <= 14)
                    return '<div class="text-success">'.nl2br($data->Activity).'</div>';
                    return '<div>'.nl2br($data->Activity).'</div>';
                })
                ->editColumn('PMDate', function($data) {
                    if ( $data->Diff < 0 )
                    return '<div class="text-center text-danger">'.$data->PMDate.'</div>';
                    if ( $data->Diff <= 7)
                    return '<div class="text-center text-warning">'.$data->PMDate.'</div>';
                    if ( $data->Diff <= 14)
                    return '<div class="text-center text-success">'.$data->PMDate.'</div>';
                    return '<div class="text-center">'.$data->PMDate.'</div>';
                })
                ->editColumn('NextPM', function($data) {
                    if ( $data->Diff < 0 )
                    return '<div class="text-center text-danger">'.$data->NextPM.'</div>';
                    if ( $data->Diff <= 7)
                    return '<div class="text-center text-warning">'.$data->NextPM.'</div>';
                    if ( $data->Diff <= 14)
                    return '<div class="text-center text-success">'.$data->NextPM.'</div>';
                    return '<div class="text-center">'.$data->NextPM.'</div>';
                })
                ->editColumn('Remark', function($data) {
                    if ( $data->Diff < 0 )
                    return '<div class="text-danger">'.$data->Remark.'</div>';
                    if ( $data->Diff <= 7)
                    return '<div class="text-warning">'.$data->Remark.'</div>';
                    if ( $data->Diff <= 14)
                    return '<div class="text-success">'.$data->Remark.'</div>';
                    return '<div>'.$data->Remark.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="update btn btn-xs btn-default text-warning mx-1 shadow" name="update" id="{{$id}}" title="Update"><i class="fa fa-lg fa-fw fa-sync-alt"></i></button>
                        <button class="history btn btn-xs btn-default text-info mx-1 shadow" name="show" id="{{$id}}" title="History"><i class="fa fa-lg fa-fw fa-eye"></i></button>
                    </div>
                ')
                ->rawColumns(['CatagoryName','RangeCapacity','LocalCode','Brand','Model','SerialNumber','Activity','PMDate','NextPM','Remark','action'])
                ->make(true);
        }

        return view('tools.PM');
    }

    public function PMstore(Request $request)
    {
        $employee = Employee::find(Auth::user()->id);

        $rules = array(
            'PMDate'=>'required',
            'Operator'=>'required',
            'Cost'=>'required',
            'Result'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'PMDate' => $request->PMDate,
            'tool_p_m_interval_id'=> $request->update_id,
            'Operator'=> $request->Operator,
            'Cost'=> $request->Cost,
            'Result'=> $request->Result,
            'Remark' => $request->Remark
        );

        $data = ToolPM::where([['PMDate','=',$form_data['PMDate']],['tool_p_m_interval_id','=',$form_data['tool_p_m_interval_id']]]);
        $data->delete();

        ToolPM::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function PMhistory(Request $request, $id)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE history AS (
                SELECT t.tool_p_m_interval_id, t.PMDate, t.Operator, t.Cost, t.Result, t.Remark
                FROM tool_p_m_s AS t INNER JOIN (SELECT tool_p_m_interval_id, max(PMDate) AS MaxDate
                FROM tool_p_m_s
                GROUP BY tool_p_m_interval_id
                )  AS tm ON (t.tool_p_m_interval_id = tm.tool_p_m_interval_id) AND (t.PMDate = tm.MaxDate)
                WHERE (((t.tool_p_m_interval_id)=$id))
                );
            ")
        );

        $history = DB::table('history')->orderBy('PMDate','desc')->get();
        return json_encode(array('data'=>$history));
    }

    public function PMplan()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE tool_site_PM AS (
                SELECT tool_sites.tool_id, tool_sites.updated_at AS PMDate, tool_sites.Status
                FROM tool_sites
                WHERE (((tool_sites.Status)='Return'))
                );

            CREATE TEMPORARY TABLE tool_PM AS (
                SELECT tool_site_PM.tool_id, tool_site_PM.PMDate
                FROM tool_site_PM
                UNION
                SELECT tool_p_m_s.tool_id, tool_p_m_s.PMDate
                FROM tool_p_m_s
                );

            CREATE TEMPORARY TABLE tool_PM_plan AS (
                SELECT t.tool_id, t.PMDate
                FROM tool_PM t
                INNER JOIN (
                SELECT tool_id, max(PMDate) AS MaxDate
                FROM tool_PM
                GROUP BY tool_id
                ) tm ON t.tool_id = tm.tool_id AND t.PMDate = tm.MaxDate
                );

            CREATE TEMPORARY TABLE tool_PM_plan2 AS (
                SELECT tools.id, tool_catagories.CatagoryName, tools.LocalCode, tool_PM_plan.PMDate, DATE_ADD(tool_PM_plan.PMDate, INTERVAL 90 DAY) AS NextPM
                FROM tool_catagories INNER JOIN (tools INNER JOIN tool_PM_plan ON tools.id = tool_PM_plan.tool_id) ON tool_catagories.id = tools.tool_catagory_id
                ORDER BY tool_PM_plan.PMDate
                );
            ")
        );

        $toolPM = DB::table('tool_PM_plan2')->paginate(20);
        return view('tools.PMplan',compact('toolPM'));
    }

    public function projectcertificate(Request $request, $id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE require_cer AS (
                SELECT tools.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagories.Unit, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, projects.StartDate
                FROM tool_catagory_sites
                INNER JOIN tool_catagories
                    INNER JOIN tools
                    ON tool_catagories.id = tools.tool_catagory_id
                ON tool_catagory_sites.tool_catagory_id = tool_catagories.id
                INNER JOIN projects
                ON tool_catagory_sites.project_id = projects.id
                WHERE tool_catagory_sites.project_id = $id AND tool_catagories.MeasuringTool = 'Yes'
                );

            CREATE TEMPORARY TABLE current_cer AS (
                SELECT tool_project_certificates.id, tool_project_certificates.tool_calibrate_id, tool_calibrates.tool_id, tool_calibrates.ExpireDate, tool_calibrates.Attachment
                FROM tool_project_certificates
                INNER JOIN tool_calibrates
                ON tool_project_certificates.tool_calibrate_id = tool_calibrates.id
                WHERE tool_project_certificates.project_id = $id
                );

            CREATE TEMPORARY TABLE max_cer AS (
                SELECT tool_calibrates.id, tool_calibrates.tool_id
                FROM tool_calibrates
                INNER JOIN(SELECT tool_id, MAX(ExpireDate) AS MaxExpireDate
                    FROM tool_calibrates
                    GROUP BY tool_id) t
                ON tool_calibrates.tool_id = t.tool_id AND tool_calibrates.ExpireDate = t.MaxExpireDate
                );

            CREATE TEMPORARY TABLE add_cer AS (
                SELECT max_cer.id
                FROM require_cer
                INNER JOIN max_cer
                ON require_cer.id = max_cer.tool_id
                );
            ")
        );

        //$test = DB::table('current_cer')->get();
        //dd($certificate);

        if ( NOW() <= $project->FinishDate ) {
            $current_cer = DB::table('current_cer')->get();

            foreach ($current_cer as $value) {
                $require_cer = DB::table('require_cer')
                    ->where('id','=',$value->tool_id)
                    ->count();

                if($require_cer == 0){
                    $certificate = ToolProjectCertificate::findOrFail($value->id);
                    $certificate->delete();
                }
            }

            $add_cer = DB::table('add_cer')->get();

            foreach ($add_cer as $value) {
                $current_cer2 = DB::table('current_cer')
                    ->where('tool_calibrate_id','=',$value->id)
                    ->count();

                if($current_cer2 == 0){
                    $certificate2 = new ToolProjectCertificate();
                    $certificate2->project_id = $project->id;
                    $certificate2->tool_calibrate_id = $value->id;
                    $certificate2->save();
                }
            }
        }

        if($request->ajax())
        {
            $data = DB::select('SELECT require_cer.id, require_cer.CatagoryName, require_cer.RangeCapacity, require_cer.Unit, require_cer.Brand, require_cer.Model, require_cer.SerialNumber, require_cer.LocalCode, require_cer.DurableSupplieCode, require_cer.AssetToolCode, current_cer.ExpireDate, require_cer.StartDate, current_cer.Attachment
                FROM require_cer
                LEFT JOIN current_cer
                ON require_cer.id = current_cer.tool_id');
            return DataTables::of($data)
                ->editColumn('CatagoryName', function($data) {
                    if ( $data->ExpireDate >= $data->StartDate) {
                        return '<div>'.$data->CatagoryName.'</div>';
                    } else {
                        return '<div class="text-danger">'.$data->CatagoryName.'</div>';
                    }
                })
                ->editColumn('RangeCapacity', function($data) {
                    if ( $data->ExpireDate >= $data->StartDate) {
                        return '<div>'.$data->RangeCapacity.'</div>';
                    } else {
                        return '<div class="text-danger">'.$data->RangeCapacity.'</div>';
                    }
                })
                ->editColumn('Unit', function($data) {
                    if ( $data->ExpireDate >= $data->StartDate) {
                        return '<div class="text-center">'.$data->Unit.'</div>';
                    } else {
                        return '<div class="text-center text-danger">'.$data->Unit.'</div>';
                    }
                })
                ->editColumn('Brand', function($data) {
                    if ( $data->ExpireDate >= $data->StartDate) {
                        return '<div class="text-center">'.$data->Brand.'</div>';
                    } else {
                        return '<div class="text-center text-danger">'.$data->Brand.'</div>';
                    }
                })
                ->editColumn('Model', function($data) {
                    if ( $data->ExpireDate >= $data->StartDate) {
                        return '<div class="text-center">'.$data->Model.'</div>';
                    } else {
                        return '<div class="text-center text-danger">'.$data->Model.'</div>';
                    }
                })
                ->editColumn('SerialNumber', function($data) {
                    if ( $data->ExpireDate >= $data->StartDate) {
                        return '<div class="text-center">'.$data->SerialNumber.'</div>';
                    } else {
                        return '<div class="text-center text-danger">'.$data->SerialNumber.'</div>';
                    }
                })
                ->editColumn('LocalCode', function($data) {
                    if ( $data->ExpireDate >= $data->StartDate) {
                        return '<div class="text-center">'.$data->LocalCode.'</div>';
                    } else {
                        return '<div class="text-center text-danger">'.$data->LocalCode.'</div>';
                    }
                })
                ->editColumn('DurableSupplieCode', function($data) {
                    if ( $data->ExpireDate >= $data->StartDate) {
                        return '<div class="text-center">'.$data->DurableSupplieCode.'</div>';
                    } else {
                        return '<div class="text-center text-danger">'.$data->DurableSupplieCode.'</div>';
                    }
                })
                ->editColumn('AssetToolCode', function($data) {
                    if ( $data->ExpireDate >= $data->StartDate) {
                        return '<div class="text-center">'.$data->AssetToolCode.'</div>';
                    } else {
                        return '<div class="text-center text-danger">'.$data->AssetToolCode.'</div>';
                    }
                })
                ->editColumn('ExpireDate', function($data) {
                    if ( $data->ExpireDate >= $data->StartDate) {
                        return '<div class="text-center">'.$data->ExpireDate.'</div>';
                    } else {
                        return '<div class="text-center text-danger">'.$data->ExpireDate.'</div>';
                    }
                })
                ->addColumn('Attachment', function($data) {
                    if ( $data->Attachment != "" ) {
                        return '
                        <div class="text-center">
                            <a href="'. url('storage/tool'.$data->id.'/calibrated/'.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        </div>';
                    } else {
                        return '<div class="text-center text-danger">N/A</div>';
                    }
                })
                ->rawColumns(['CatagoryName','RangeCapacity','Unit','Brand','Model','SerialNumber','LocalCode','DurableSupplieCode','AssetToolCode','ExpireDate','Attachment'])
                ->make(true);
        }

        return view('tools.projectcertificate',compact('project'));

    }

    public function expensive(Request $request, $id)
    {
        $project = Project::find($id);

        $job = DB::select('SELECT jobs.id, locations.LocationName, machines.MachineName, products.ProductName, systems.SystemName, items.SpecificName, scopes.ScopeName
            FROM jobs
                INNER JOIN items ON jobs.item_id = items.id
                INNER JOIN machine_sets ON items.machine_set_id = machine_sets.id
                INNER JOIN item_sets ON items.item_set_id = item_sets.id
                INNER JOIN locations ON machine_sets.location_id = locations.id
                INNER JOIN machines ON machine_sets.machine_id = machines.id
                INNER JOIN products ON item_sets.product_id = products.id
                INNER JOIN systems ON item_sets.system_id = systems.id
                INNER JOIN equipment ON item_sets.equipment_id = equipment.id
                INNER JOIN scopes ON items.scope_id = scopes.id
            WHERE jobs.project_id = '.$id.'');

        $tool = DB::select('SELECT tools.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tools.Price
            FROM tool_catagories
                INNER JOIN tools
                ON tool_catagories.id = tools.tool_catagory_id
                INNER JOIN tool_catagory_sites
                    INNER JOIN tool_updates
                    ON tool_catagory_sites.id = tool_updates.tool_catagory_site_id AND tools.id = tool_updates.tool_id
            WHERE tools.Price > 200000 AND tool_catagory_sites.project_id = '.$id.'
            ORDER BY tool_catagories.CatagoryName ASC, tool_catagories.RangeCapacity ASC');

        if($request->ajax())
        {
            $data = DB::select('SELECT expensive_tools.id, expensive_tools.Date, jobs.id AS job_id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, expensive_tools.Activity, expensive_tools.`Hour`, expensive_tools.Remark
                FROM expensive_tools
                    INNER JOIN jobs
                    ON expensive_tools.job_id = jobs.id
                    INNER JOIN tools
                    ON expensive_tools.tool_id = tools.id
                    INNER JOIN tool_catagories
                    ON tools.tool_catagory_id = tool_catagories.id
                WHERE jobs.project_id = '.$id.'');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('Date', function($data) {
                    return '<div class="text-center">'.$data->Date.'</div>';
                })
                ->editColumn('job_id', function($data) {
                    return '<div class="text-center">'.$data->job_id.'</div>';
                })
                ->editColumn('CatagoryName', function($data) {
                    return '<div class="text-center">'.$data->CatagoryName.'</div>';
                })
                ->editColumn('RangeCapacity', function($data) {
                    return '<div class="text-center">'.$data->RangeCapacity.'</div>';
                })
                ->editColumn('Brand', function($data) {
                    return '<div class="text-center">'.$data->Brand.'</div>';
                })
                ->editColumn('Model', function($data) {
                    return '<div class="text-center">'.$data->Model.'</div>';
                })
                ->editColumn('SerialNumber', function($data) {
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->editColumn('LocalCode', function($data) {
                    return '<div class="text-center">'.$data->LocalCode.'</div>';
                })
                ->editColumn('DurableSupplieCode', function($data) {
                    return '<div class="text-center">'.$data->DurableSupplieCode.'</div>';
                })
                ->editColumn('AssetToolCode', function($data) {
                    return '<div class="text-center">'.$data->AssetToolCode.'</div>';
                })
                ->editColumn('Activity', function($data) {
                    return '<div class="text-center">'.$data->Activity.'</div>';
                })
                ->editColumn('Hour', function($data) {
                    return '<div class="text-center">'.$data->Hour.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['id','Date','job_id','CatagoryName','RangeCapacity','Brand','Model','SerialNumber','LocalCode','DurableSupplieCode','AssetToolCode','Activity','Hour','action'])
                ->make(true);
        }
        return view('tools.expensive',compact('project','job','tool'));
    }

    public function expensivestore(Request $request)
    {
        $rules = array(
            'Date'=>'required',
            'job_id'=>'required',
            'tool_id'=>'required',
            'Activity'=>'required',
            'Hour'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Date' => $request->Date,
            'job_id' => $request->job_id,
            'tool_id'=> $request->tool_id,
            'Activity' => $request->Activity,
            'Activity' => $request->Activity,
            'Hour' => $request->Hour,
            'Remark' => $request->Remark
        );

        ExpensiveTool::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function expensiveedit($id)
    {
        if(request()->ajax())
        {
            $data = ExpensiveTool::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function expensiveupdate(Request $request,ExpensiveTool $id)
    {
        $rules = array(
            'Date'=>'required',
            'job_id'=>'required',
            'tool_id'=>'required',
            'Activity'=>'required',
            'Hour'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Date' => $request->Date,
            'job_id' => $request->job_id,
            'tool_id'=> $request->tool_id,
            'Activity' => $request->Activity,
            'Activity' => $request->Activity,
            'Hour' => $request->Hour,
            'Remark' => $request->Remark
        );

        ExpensiveTool::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function expensivedestroy($id)
    {
        $data = ExpensiveTool::findOrFail($id);
        $data->delete();
    }

    public function preuse(Request $request, $id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE count_preuse AS (
                SELECT tool_pre_uses.tool_id, Count(tool_pre_uses.Activity) AS CountOfActivity, tool_catagory_sites.project_id
                FROM tool_catagory_sites INNER JOIN (tool_updates INNER JOIN tool_pre_uses ON tool_updates.tool_id = tool_pre_uses.tool_id) ON tool_catagory_sites.id = tool_updates.tool_catagory_site_id
                GROUP BY tool_pre_uses.tool_id, tool_catagory_sites.project_id
                HAVING (((tool_catagory_sites.project_id)=$id))
                );
            ")
        );

        $tool = DB::select('SELECT tools.id, tool_catagories.CatagoryName, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tools.Brand, tools.Model, tools.SerialNumber, count_preuse.CountOfActivity
            FROM (tool_catagories INNER JOIN tools ON tool_catagories.id = tools.tool_catagory_id) INNER JOIN count_preuse ON tools.id = count_preuse.tool_id
            WHERE (((count_preuse.CountOfActivity)>0))
            ORDER BY tool_catagories.CatagoryName, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tools.Brand, tools.Model, tools.SerialNumber');

        return view('tools.preuses',compact('project','tool'));
    }

    public function preuseactivity(Request $request, $id)
    {
        $tool = Tool::find($id);

        if($request->ajax())
        {
            $data = ToolPreUse::where('tool_id',$id)->get();
            return DataTables::of($data)
                ->editColumn('Activity', function($data) {
                    return nl2br($data->Activity);
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['Activity','Interval','action'])
                ->make(true);
        }

        return view('tools.preuseactivity',compact('tool'));
    }

    public function preuseactivitystore(Request $request)
    {
        $rules = array(
            'tool_id'=>'required',
            'Activity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_id' => $request->tool_id,
            'Activity' => $request->Activity,
            'Remark' => $request->Remark
        );

        ToolPreUse::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function preuseactivityedit($id)
    {
        if(request()->ajax())
        {
            $data = ToolPreUse::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function preuseactivityupdate(Request $request,ToolPreUse $id)
    {
        $rules = array(
            'tool_id'=>'required',
            'Activity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_id' => $request->tool_id,
            'Activity' => $request->Activity,
            'Remark' => $request->Remark
        );

        ToolPreUse::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function preuseactivitydestroy($id)
    {
        $data = ToolPreUse::findOrFail($id);
        $data->delete();
    }

    public function project(Request $request, $id)
    {
        $project = Project::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, jobs.item_id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id
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
                            <a href="'. url('item_tool_catagories/{{$item_id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        return view('tools.project',compact('project'));
    }

    public function amount(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id, Count(tool_catagories.CatagoryName) AS CountOfCatagoryName
            FROM tool_catagories INNER JOIN (((locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) INNER JOIN item_tool_catagories ON items.id = item_tool_catagories.item_id) ON tool_catagories.id = item_tool_catagories.tool_catagory_id
            GROUP BY jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id
            HAVING (((jobs.project_id)='.$id.'))');
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
                ->editColumn('CountOfCatagoryName', function($data) {
                    return '<div class="text-center">'.$data->CountOfCatagoryName.'</div>';
                })
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','CountOfCatagoryName'])
                ->make(true);
        }
    }

    public function breakdown(Request $request)
    {
        $tool = DB::select('SELECT tools.id, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.DurableSupplieCode
            FROM tool_catagories INNER JOIN tools ON tool_catagories.id = tools.tool_catagory_id');

        if($request->ajax())
        {
            $data = DB::select('SELECT tool_breakdowns.created_at, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tools.Brand, tools.Model, tools.SerialNumber, tool_breakdowns.id, tool_breakdowns.updated_at, tool_breakdowns.Report, tool_breakdowns.Cause, tool_breakdowns.Value, tool_breakdowns.Guideline, tool_breakdowns.Operation, tool_breakdowns.Result
                FROM (tool_catagories INNER JOIN tools ON tool_catagories.id = tools.tool_catagory_id) INNER JOIN tool_breakdowns ON tools.id = tool_breakdowns.tool_id');
            return DataTables::of($data)
                ->editColumn('RangeCapacity', function($data) {
                    return '<div class="text-center">'.$data->RangeCapacity.'</div>';
                })
                ->editColumn('LocalCode', function($data) {
                    return '<div class="text-center">'.$data->LocalCode.'</div>';
                })
                ->editColumn('SerialNumber', function($data) {
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->editColumn('DurableSupplieCode', function($data) {
                    return '<div class="text-center">'.$data->DurableSupplieCode.'</div>';
                })
                ->editColumn('AssetToolCode', function($data) {
                    return '<div class="text-center">'.$data->AssetToolCode.'</div>';
                })
                ->editColumn('created_at', function($data) {
                    return '<div class="text-center">'.$data->created_at.'</div>';
                })
                ->editColumn('Brand', function($data) {
                    return '<div class="text-center">'.$data->Brand.'</div>';
                })
                ->editColumn('Model', function($data) {
                    return '<div class="text-center">'.$data->Model.'</div>';
                })
                ->editColumn('Status', function($data) {
                    if ( $data->Result <> "" ) {
                        return '<div class="text-center">ดำเนินการแล้วเสร็จ/'.$data->updated_at.'</div>';
                    } elseif ( $data->Operation <> "" ) {
                        return '<div class="text-center">กำลังดำเนินการซ่อม/'.$data->updated_at.'</div>';
                    } else {
                        return '<div class="text-center">ยังไม่ได้ดำเนินการซ่อม/'.$data->updated_at.'</div>';
                    }
                })
                ->addColumn('action','
                    <div class="text-center">
                        <a class="btn btn-xs btn-default text-info mx-1 shadow" name="Print" title="Print" href="'.url('tool_breakdown/{{$id}}').'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>'
                )
                ->rawColumns(['RangeCapacity','LocalCode','SerialNumber','DurableSupplieCode','AssetToolCode','created_at','Brand','Model','Status','action'])
                ->make(true);
        }

        //$test = DB::table('tool_status_now')->get();
        //dd($test);

        return view('tools.breakdown',compact('tool'));
    }

    public function breakdownstore(Request $request)
    {
        $rules = array(
            'tool_id'=>'required',
            'Report'=>'required',
            'Cause'=>'required',
            'Value'=>'required|numeric',
            'Guideline'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_id' => $request->tool_id,
            'Report' => $request->Report,
            'Cause' => $request->Cause,
            'Value' => $request->Value,
            'Guideline' => $request->Guideline
        );

        ToolBreakdown::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function breakdownedit($id)
    {
        if(request()->ajax())
        {
            $data = ToolBreakdown::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function breakdownupdate(Request $request,ToolBreakdown $toolid)
    {
        $rules = array(
            'tool_id'=>'required',
            'Report'=>'required',
            'Cause'=>'required',
            'Value'=>'required|numeric',
            'Guideline'=>'required',
            'Operation'=>'required',
            'Operator'=>'required',
            'Result'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tool_id' => $request->tool_id,
            'Report' => $request->Report,
            'Cause' => $request->Cause,
            'Value' => $request->Value,
            'Guideline' => $request->Guideline,
            'Operation' => $request->Operation,
            'Operator' => $request->Operator,
            'Result' => $request->Result
        );

        ToolBreakdown::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function breakdowndestroy($id)
    {
        $data = ToolBreakdown::findOrFail($id);
        $data->delete();
    }

    public function type(Request $request)
    {
        if($request->ajax())
        {
            $data = ToolType::all();
            return DataTables::of($data)
                ->editColumn('ActivityType', function($data) {
                    return '<div class="text-center">'.$data->ActivityType.'</div>';
                })
                ->editColumn('MainType', function($data) {
                    return '<div class="text-center">'.$data->MainType.'</div>';
                })
                ->editColumn('SubType', function($data) {
                    return '<div class="text-center">'.$data->SubType.'</div>';
                })
                ->editColumn('ToolName', function($data) {
                    return '<div class="text-center">'.$data->ToolName.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit_tooltype btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete_tooltype btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>'
                )
                ->rawColumns(['ActivityType','MainType','SubType','ToolName','action'])
                ->make(true);
        }
    }

    public function typestore(Request $request)
    {
        $rules = array(
            'SubType'=>'required',
            'ToolName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ActivityType' => $request->ActivityType,
            'MainType' => $request->MainType,
            'SubType' => $request->SubType,
            'ToolName' => $request->ToolName,
            'Remark' => $request->Remark
        );

        ToolType::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function typeedit($id)
    {
        if(request()->ajax())
        {
            $data = ToolType::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function typeupdate(Request $request,ToolType $id)
    {
        $rules = array(
            'SubType'=>'required',
            'ToolName'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ActivityType' => $request->ActivityType,
            'MainType' => $request->MainType,
            'SubType' => $request->SubType,
            'ToolName' => $request->ToolName,
            'Remark' => $request->Remark
        );

        ToolType::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function typedestroy($id)
    {
        $data = ToolType::findOrFail($id);
        $data->delete();
    }
}
