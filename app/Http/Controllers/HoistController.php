<?php

namespace App\Http\Controllers;

use App\Models\HoistList;
use App\Models\HoistTesting;
use App\Models\Project;
use App\Models\Tool;
use App\Models\ToolCatagory;
use DataTables;
use DB;
use Validator;
use Illuminate\Http\Request;

class HoistController extends Controller
{
    public function list(Request $request)
    {
        if($request->ajax())
            {
                $data = DB::select('SELECT hoist_lists.*
                    FROM hoist_lists
                    UNION
                    SELECT tools.id, "กฟนม-ธ." AS Customer, tools.Brand, tool_catagories.RangeCapacity, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tools.RegisterDate, "N/A" AS StandardP, "N/A" AS StandardD, "N/A" AS Standard10Link, tools.created_at, tools.updated_at
                    FROM tools
                    INNER JOIN tool_catagories
                    ON tools.tool_catagory_id = tool_catagories.id
                    WHERE tool_catagories.id IN (117,132,133,114,669,490,486,487)');
                return DataTables::of($data)
                    ->editColumn('Brand',function($data){
                        return '<div class="text-center">'.$data->Brand.'</div>';
                    })
                    ->editColumn('Capacity',function($data){
                        return '<div class="text-center">'.$data->Capacity.'</div>';
                    })
                    ->editColumn('Model',function($data){
                        return '<div class="text-center">'.$data->Model.'</div>';
                    })
                    ->editColumn('SerialNumber',function($data){
                        return '<div class="text-center">'.$data->SerialNumber.'</div>';
                    })
                    ->editColumn('LocalCode',function($data){
                        return '<div class="text-center">'.$data->LocalCode.'</div>';
                    })
                    ->editColumn('DurableSupplieCode',function($data){
                        return '<div class="text-center">'.$data->DurableSupplieCode.'</div>';
                    })
                    ->editColumn('AssetToolCode',function($data){
                        return '<div class="text-center">'.$data->AssetToolCode.'</div>';
                    })
                    ->editColumn('RegisterDate',function($data){
                        return '<div class="text-center">'.$data->RegisterDate.'</div>';
                    })
                    ->editColumn('StandardP',function($data){
                        return '<div class="text-center">'.$data->StandardP.'</div>';
                    })
                    ->editColumn('StandardD',function($data){
                        return '<div class="text-center">'.$data->StandardD.'</div>';
                    })
                    ->editColumn('Standard10Link',function($data){
                        return '<div class="text-center">'.$data->Standard10Link.'</div>';
                    })
                    ->addColumn('action',function($data){
                        if ($data->Customer == "กฟนม-ธ.") {
                            return '
                            <div class="text-center">
                                <a class="btn btn-xs btn-default text-info mx-1 shadow" title="History" href="'.url('hoist_list/'.$data->id.'/renew').'"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                            </div>';
                        } else {
                            return '
                            <div class="text-center">
                                <a class="btn btn-xs btn-default text-info mx-1 shadow" title="History" href="'.url('hoist_list/'.$data->id.'/other').'"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>';
                        }
                    })
                    ->rawColumns(['Brand','Capacity','Model','SerialNumber','LocalCode','DurableSupplieCode','AssetToolCode','RegisterDate','StandardP','StandardD','Standard10Link','action'])
                    ->make(true);
            }

        return view('hoist.list');
    }

    public function liststore(Request $request)
    {
        $rules = array(
            'Customer'=>'required',
            'Brand'=>'required',
            'Capacity'=>'required',
            'StandardP'=>'nullable|numeric',
            'StandardD'=>'nullable|numeric',
            'Standard10Link'=>'nullable|numeric'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Customer' => $request->Customer,
            'Brand' => $request->Brand,
            'Capacity' => $request->Capacity,
            'Model' => $request->Model,
            'SerialNumber' => $request->SerialNumber,
            'LocalCode' => $request->LocalCode,
            'DurableSupplieCode' => $request->DurableSupplieCode,
            'AssetToolCode' => $request->AssetToolCode,
            'RegisterDate' => $request->RegisterDate,
            'StandardP' => $request->StandardP,
            'StandardD' => $request->StandardD,
            'Standard10Link' => $request->Standard10Link
        );

        HoistList::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function listshow(Request $request, $id, $type)
    {
        if ($type == "renew") {
            $hoist = Tool::find($id);
            $toolcatagory = ToolCatagory::find($hoist->tool_catagory_id);

            $createTempTables = DB::unprepared(DB::raw("
                CREATE TEMPORARY TABLE hoist AS (
                    SELECT *
                    FROM hoist_testings
                    WHERE tool_id = $id
                    );
                ")
            );
        } else {
            $hoist = HoistList::find($id);
            $toolcatagory = null;

            $createTempTables = DB::unprepared(DB::raw("
                CREATE TEMPORARY TABLE hoist AS (
                    SELECT *
                    FROM hoist_testings
                    WHERE hoist_list_id = $id
                    );
                ")
            );
        }

        if($request->ajax())
            {
                $data = DB::table('hoist')->get();
                return DataTables::of($data)
                    ->editColumn('TestDate',function($data){
                        return '<div class="text-center">'.$data->TestDate.'</div>';
                    })
                    ->editColumn('TopHook',function($data){
                        return '<div class="text-center">'.$data->TopHook.'</div>';
                    })
                    ->editColumn('BottomHook',function($data){
                        return '<div class="text-center">'.$data->BottomHook.'</div>';
                    })
                    ->editColumn('SafetyLatch',function($data){
                        return '<div class="text-center">'.$data->SafetyLatch.'</div>';
                    })
                    ->editColumn('Condition',function($data){
                        return '<div class="text-center">'.$data->Condition.'</div>';
                    })
                    ->editColumn('Pin',function($data){
                        return '<div class="text-center">'.$data->Pin.'</div>';
                    })
                    ->editColumn('Testing',function($data){
                        return '<div class="text-center">'.$data->Testing.'</div>';
                    })
                    ->editColumn('Remark',function($data){
                        return nl2br($data->Remark);
                    })
                    ->editColumn('LoadP',function($data){
                        return '<div class="text-center">'.$data->LoadP.'</div>';
                    })
                    ->editColumn('LoadD',function($data){
                        return '<div class="text-center">'.$data->LoadD.'</div>';
                    })
                    ->editColumn('Load10Link',function($data){
                        return '<div class="text-center">'.$data->Load10Link.'</div>';
                    })
                    ->editColumn('Twist',function($data){
                        return '<div class="text-center">'.$data->Twist.'</div>';
                    })
                    ->editColumn('HookTop',function($data){
                        return '<div class="text-center">'.$data->HookTop.'</div>';
                    })
                    ->editColumn('HookBottom',function($data){
                        return '<div class="text-center">'.$data->HookBottom.'</div>';
                    })
                    ->editColumn('Result',function($data){
                        return '<div class="text-center">'.$data->Result.'</div>';
                    })
                    ->addColumn('Attachment',function($data){
                        if ($data->Attachment != "") {
                            return '
                            <div class="text-center">
                                <a class="btn btn-xs btn-default text-info mx-1 shadow" title="Attachment" href="'.url('storage/'.$data->AttachmentPath.$data->Attachment.'').'"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                            </div>';
                        } else {
                            return '
                            <div class="text-center">N/A</div>';
                        }
                    })
                    ->rawColumns(['TestDate','TopHook','BottomHook','SafetyLatch','Condition','Pin','Testing','Remark','LoadP','LoadD','Load10Link','Twist','HookTop','HookBottom','Result','Attachment'])
                    ->make(true);
            }

        return view('hoist.listshow',compact('hoist','toolcatagory'));
    }

    public function listedit($id)
    {
        if(request()->ajax())
        {
            $data = HoistList::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function listupdate(Request $request)
    {
        $rules = array(
            'Customer'=>'required',
            'Brand'=>'required',
            'Capacity'=>'required',
            'StandardP'=>'nullable|numeric',
            'StandardD'=>'nullable|numeric',
            'Standard10Link'=>'nullable|numeric'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Customer' => $request->Customer,
            'Brand' => $request->Brand,
            'Capacity' => $request->Capacity,
            'Model' => $request->Model,
            'SerialNumber' => $request->SerialNumber,
            'LocalCode' => $request->LocalCode,
            'DurableSupplieCode' => $request->DurableSupplieCode,
            'AssetToolCode' => $request->AssetToolCode,
            'RegisterDate' => $request->RegisterDate,
            'StandardP' => $request->StandardP,
            'StandardD' => $request->StandardD,
            'Standard10Link' => $request->Standard10Link
        );

        HoistList::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function listdestroy($id)
    {
        $data = HoistList::findOrFail($id);
        $data->delete();
    }

    public function project(Request $request, $id)
    {
        $project = Project::find($id);

        $hoist = DB::select('SELECT id, Brand, Capacity, Model, SerialNumber, LocalCode, DurableSupplieCode, AssetToolCode, Type
            FROM (SELECT id, Brand, Capacity, Model, SerialNumber, LocalCode, DurableSupplieCode, AssetToolCode, "Hoist" AS Type
                FROM hoist_lists
                UNION
                SELECT tools.id, tools.Brand, tool_catagories.RangeCapacity AS Capacity, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, "Tool" AS Type
                FROM tools
                INNER JOIN tool_catagories
                ON tools.tool_catagory_id = tool_catagories.id
                WHERE tool_catagories.id IN (117,132,133,114,669,490,486,487)) t
            ORDER BY Brand, Capacity, Model, SerialNumber, LocalCode, DurableSupplieCode, AssetToolCode');

        //dd($hoist);

        if($request->ajax())
            {
                $data = DB::select('SELECT hoist_testings.*, hoist_lists.Brand, hoist_lists.Capacity, hoist_lists.Model, hoist_lists.SerialNumber, hoist_lists.LocalCode, hoist_lists.DurableSupplieCode, hoist_lists.AssetToolCode
                    FROM hoist_testings
                    INNER JOIN hoist_lists
                    ON hoist_testings.hoist_list_id = hoist_lists.id
                    UNION
                    SELECT hoist_testings.*, tools.Brand, tool_catagories.RangeCapacity, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode
                    FROM hoist_testings
                    INNER JOIN tools
                        INNER JOIN tool_catagories
                        ON tools.tool_catagory_id = tool_catagories.id
                    ON hoist_testings.tool_id = tools.id
                    ');
                return DataTables::of($data)
                    ->editColumn('Brand',function($data){
                        return '<div class="text-center">'.$data->Brand.'</div>';
                    })
                    ->editColumn('Capacity',function($data){
                        return '<div class="text-center">'.$data->Capacity.'</div>';
                    })
                    ->editColumn('Model',function($data){
                        return '<div class="text-center">'.$data->Model.'</div>';
                    })
                    ->editColumn('SerialNumber',function($data){
                        return '<div class="text-center">'.$data->SerialNumber.'</div>';
                    })
                    ->editColumn('LocalCode',function($data){
                        return '<div class="text-center">'.$data->LocalCode.'</div>';
                    })
                    ->editColumn('DurableSupplieCode',function($data){
                        return '<div class="text-center">'.$data->DurableSupplieCode.'</div>';
                    })
                    ->editColumn('AssetToolCode',function($data){
                        return '<div class="text-center">'.$data->AssetToolCode.'</div>';
                    })
                    ->editColumn('TestDate',function($data){
                        return '<div class="text-center">'.$data->TestDate.'</div>';
                    })
                    ->editColumn('TopHook',function($data){
                        return '<div class="text-center">'.$data->TopHook.'</div>';
                    })
                    ->editColumn('BottomHook',function($data){
                        return '<div class="text-center">'.$data->BottomHook.'</div>';
                    })
                    ->editColumn('SafetyLatch',function($data){
                        return '<div class="text-center">'.$data->SafetyLatch.'</div>';
                    })
                    ->editColumn('Condition',function($data){
                        return '<div class="text-center">'.$data->Condition.'</div>';
                    })
                    ->editColumn('Pin',function($data){
                        return '<div class="text-center">'.$data->Pin.'</div>';
                    })
                    ->editColumn('Testing',function($data){
                        return '<div class="text-center">'.$data->Testing.'</div>';
                    })
                    ->editColumn('Remark',function($data){
                        return nl2br($data->Remark);
                    })
                    ->editColumn('LoadP',function($data){
                        return '<div class="text-center">'.$data->LoadP.'</div>';
                    })
                    ->editColumn('LoadD',function($data){
                        return '<div class="text-center">'.$data->LoadD.'</div>';
                    })
                    ->editColumn('Load10Link',function($data){
                        return '<div class="text-center">'.$data->Load10Link.'</div>';
                    })
                    ->editColumn('Twist',function($data){
                        return '<div class="text-center">'.$data->Twist.'</div>';
                    })
                    ->editColumn('HookTop',function($data){
                        return '<div class="text-center">'.$data->HookTop.'</div>';
                    })
                    ->editColumn('HookBottom',function($data){
                        return '<div class="text-center">'.$data->HookBottom.'</div>';
                    })
                    ->editColumn('Result',function($data){
                        return '<div class="text-center">'.$data->Result.'</div>';
                    })
                    ->addColumn('Report',function($data){
                        return '<div class="text-center"><a href = "'.url('hoist_testing/'.$data->id.'') .'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Report"><i class="fa fa-lg fa-fw fa-print"></i></a></div>';
                    })
                    ->addColumn('Attachment',function($data){
                        if ( $data->Attachment == null ) {
                            return '
                            <div class="text-center">
                                <button class="attachment btn btn-xs btn-default text-success mx-1 shadow" name="attachment" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>
                            </div>';
                        } else {
                            return '
                            <div class="text-center">
                                <a href="'. url('storage/'.$data->AttachmentPath.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_attachment btn btn-xs btn-default text-danger mx-1 shadow" name="attachment" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </div>';
                        }
                    })
                    ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>                        </div>
                    </div>
                    ')
                    ->rawColumns(['Brand','Capacity','Model','SerialNumber','LocalCode','DurableSupplieCode','AssetToolCode','TestDate','TopHook','BottomHook','SafetyLatch','Condition','Pin','Testing','Remark','LoadP','LoadD','Load10Link','Twist','HookTop','HookBottom','Result','Report','Attachment','action'])
                    ->make(true);
            }

        return view('hoist.project',compact('project','hoist'));
    }

    public function projectstore(Request $request)
    {
        $rules = array(
            'hoist_list_id'=>'required',
            'TestDate'=>'required',
            'TopHook'=>'required',
            'BottomHook'=>'required',
            'SafetyLatch'=>'required',
            'Condition'=>'required',
            'Pin'=>'required',
            'Testing'=>'required',
            'LoadP'=>'required|numeric',
            'LoadD'=>'required|numeric',
            'Load10Link'=>'required|numeric',
            'LoadTesting'=>'required',
            'Twist'=>'required',
            'HookTop'=>'required|numeric',
            'HookBottom'=>'required|numeric',
            'Result'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $hoist = explode(',',$request->hoist_list_id);

        if ($hoist[1] == "Tool") {
            $form_data = array(
                'tool_id' => $hoist[0],
                'project_id' => $request->project_id,
                'TestDate' => $request->TestDate,
                'TopHook' => $request->TopHook,
                'BottomHook' => $request->BottomHook,
                'SafetyLatch' => $request->SafetyLatch,
                'Condition' => $request->Condition,
                'Pin' => $request->Pin,
                'Testing' => $request->Testing,
                'Remark' => $request->Remark,
                'LoadP' => $request->LoadP,
                'LoadD' => $request->LoadD,
                'Load10Link' => $request->Load10Link,
                'LoadTesting' => $request->LoadTesting,
                'Twist' => $request->Twist,
                'HookTop' => $request->HookTop,
                'HookBottom' => $request->HookBottom,
                'Result' => $request->Result,
                'Note' => $request->Note
            );
        } else {
            $form_data = array(
                'hoist_list_id' => $hoist[0],
                'project_id' => $request->project_id,
                'TestDate' => $request->TestDate,
                'TopHook' => $request->TopHook,
                'BottomHook' => $request->BottomHook,
                'SafetyLatch' => $request->SafetyLatch,
                'Condition' => $request->Condition,
                'Pin' => $request->Pin,
                'Testing' => $request->Testing,
                'Remark' => $request->Remark,
                'LoadP' => $request->LoadP,
                'LoadD' => $request->LoadD,
                'Load10Link' => $request->Load10Link,
                'LoadTesting' => $request->LoadTesting,
                'Twist' => $request->Twist,
                'HookTop' => $request->HookTop,
                'HookBottom' => $request->HookBottom,
                'Result' => $request->Result,
                'Note' => $request->Note
            );
        }

        HoistTesting::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function projectedit($id)
    {
        if(request()->ajax())
        {
            $data = HoistTesting::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function projectupdate(Request $request)
    {
        $rules = array(
            'TestDate'=>'required',
            'TopHook'=>'required',
            'BottomHook'=>'required',
            'SafetyLatch'=>'required',
            'Condition'=>'required',
            'Pin'=>'required',
            'Testing'=>'required',
            'LoadP'=>'required|numeric',
            'LoadD'=>'required|numeric',
            'Load10Link'=>'required|numeric',
            'LoadTesting'=>'required',
            'Twist'=>'required',
            'HookTop'=>'required|numeric',
            'HookBottom'=>'required|numeric',
            'Result'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'TestDate' => $request->TestDate,
            'TopHook' => $request->TopHook,
            'BottomHook' => $request->BottomHook,
            'SafetyLatch' => $request->SafetyLatch,
            'Condition' => $request->Condition,
            'Pin' => $request->Pin,
            'Testing' => $request->Testing,
            'Remark' => $request->Remark,
            'LoadP' => $request->LoadP,
            'LoadD' => $request->LoadD,
            'Load10Link' => $request->Load10Link,
            'LoadTesting' => $request->LoadTesting,
            'Twist' => $request->Twist,
            'HookTop' => $request->HookTop,
            'HookBottom' => $request->HookBottom,
            'Result' => $request->Result,
            'Note' => $request->Note
        );

        HoistTesting::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function projectdestroy($id)
    {
        $data = HoistTesting::findOrFail($id);
        $data->delete();
    }
}
