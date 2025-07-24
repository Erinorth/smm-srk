<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Item;
use App\Models\SpecialTool;
use App\Models\Project;

class SpecialToolController extends Controller
{
    public function item(Request $request, $id)
    {
        $item = Item::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT special_tools.id, special_tools.item_id, special_tools.SpecialToolName, special_tools.PartName, special_tools.DrawingNumber, special_tools.Remark, special_tools.Attachment, special_tools.AttachmentPath
                FROM special_tools
                WHERE (((special_tools.item_id)='.$id.'))');
            return DataTables::of($data)
                ->addColumn('Attachment', function($data) {
                    return '
                    <div class="text-center">
                        <a href="'. url('storage/'.$data->AttachmentPath.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    </div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['Attachment','action'])
                ->make(true);
        }
        return view('specialtools.create',compact('item'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'SpecialToolName'=>'required',
            'PartName'=>'required',
            'DrawingNumber'=>'required',
            'Attachment'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $itemid = $request->get('item_id');
        $file = $request->file('Attachment');

        $path = 'item'.$itemid.'/specialtool/';
        $file_name = time().'-'.$file->getClientOriginalName();
        $upload = $file->storeAs($path, $file_name, 'public');

        if ($upload) {
            $form_data = array(
                'SpecialToolName' => $request->SpecialToolName,
                'PartName' => $request->PartName,
                'DrawingNumber' => $request->DrawingNumber,
                'Remark' => $request->Remark,
                'item_id' => $request->item_id,
                'Attachment' => $file_name,
                'AttachmentPath' => $path
            );
        }

        SpecialTool::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = SpecialTool::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, SpecialTool $specialtoolid)
    {
        $rules = array(
            'SpecialToolName'=>'required',
            'PartName'=>'required',
            'DrawingNumber'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'SpecialToolName' => $request->SpecialToolName,
            'PartName' => $request->PartName,
            'DrawingNumber' => $request->DrawingNumber,
            'Remark' => $request->Remark,
            'item_id' => $request->item_id,
        );

        SpecialTool::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function change(Request $request)
    {
        $rules = array(
            'Attachment'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $specialtoolid = $request->get('hidden_id');
        $file = $request->file('Attachment');

        $specialtool = SpecialTool::find($specialtoolid);

        $path = $specialtool->AttachmentPath;
        $file_name = time().'_'.$file->getClientOriginalName();
        $update = $file->storeAs($path, $file_name, 'public');
        if($update){

            $file_path = $path.$specialtool->Attachment;
            if ( $specialtool->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $specialtool->update([
                'Attachment' => $file_name
            ]);

            return response()->json(['success' => 'Update successfully.']);
        }
    }

    public function destroy($id)
    {
        $data = SpecialTool::find($id);
        $path = $data->AttachmentPath;
        $file_path = $path.$data->Attachment;
        if ( $data->Attachment != null && \Storage::disk('public')->exists($file_path)) {
            \Storage::disk('public')->delete($file_path);
        }
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
                            <a href="'. url('specialtools/{{$item_id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        return view('specialtools.project',compact('project'));
    }

    public function amount(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id, Count(special_tools.id) AS CountOfid
                FROM ((locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) LEFT JOIN special_tools ON items.id = special_tools.item_id
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
                ->editColumn('CountOfid', function($data) {
                    return '<div class="text-center">'.$data->CountOfid.'</div>';
                })
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','CountOfid'])
                ->make(true);
        }
    }
}
