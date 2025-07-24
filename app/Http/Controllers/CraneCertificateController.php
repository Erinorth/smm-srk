<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CraneCertificate;
use App\Models\MachineSet;
use App\Models\Project;
use DataTables;
use DB;
use Validator;
use Illuminate\Http\Request;

class CraneCertificateController extends Controller
{
    public function index(Request $request)
    {
        $machineset = MachineSet::select('machine_sets.id','locations.LocationName','machines.MachineName','machine_sets.Remark','machine_sets.SerialNumber')
            ->join('locations','machine_sets.location_id','locations.id')
            ->join('machines','machine_sets.machine_id','machines.id')
            ->whereIn('machine_sets.machine_id',[1,2,3,6,7,9])
            ->orderBy('locations.LocationName')
            ->orderBy('machines.MachineName')
            ->orderBy('machine_sets.Remark')
            ->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT crane_certificates.* , locations.LocationName, machines.MachineName, machine_sets.Remark, machine_sets.SerialNumber
                FROM crane_certificates
                INNER JOIN machine_sets
                    INNER JOIN locations
                    ON machine_sets.location_id = locations.id
                    INNER JOIN machines
                    ON machine_sets.machine_id = machines.id
                ON crane_certificates.machine_set_id = machine_sets.id');
            return DataTables::of($data)
                ->editColumn('LocationName',function($data){
                    return '<div class="text-center">'.$data->LocationName.'</div>';
                })
                ->editColumn('MachineName',function($data){
                    return '<div class="text-center">'.$data->MachineName.'</div>';
                })
                ->editColumn('SerialNumber',function($data){
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->editColumn('TestDate',function($data){
                    return '<div class="text-center">'.$data->TestDate.'</div>';
                })
                ->editColumn('Result',function($data){
                    return nl2br($data->Result);
                })
                ->editColumn('Attachment',function($data){
                    if ($data->Attachment != "" ) {
                        return '
                        <div class="text-center">
                            <a href="'. url('storage/'.$data->AttachmentPath.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                            <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Change Attachment"><i class="fa fa-lg fa-fw fa-exchange"></i></button>
                        </div>';
                    } else {
                        return '<div class="text-center">N/A</div>';
                    }
                })
                ->addColumn('action',function($data){
                    if ($data->Attachment != "" ) {
                        return '
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>';
                    } else {
                        return '
                        <div class="text-center">
                            <button class="add btn btn-xs btn-default text-success mx-1 shadow" name="create_record" id="'.$data->id.'" title="Add"><i class="fa fa-lg fa-fw fa-plus"></i></button>
                        </div>';
                    }
                })
                ->rawColumns(['LocationName','MachineName','SerialNumber','TestDate','Result','Attachment','action'])
                ->make(true);
        }

        return view('cranes.certificate',compact('machineset'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'machine_set_id'=>'required',
            'TestDate'=>'required',
            'Result'=>'required',
            'Attachment'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $file = $request->file('Attachment');
        $machinesetid = $request->get('machine_set_id');
        $testdate = $request->get('TestDate');

        $path = 'crane'.$machinesetid.'/certificate/';
        $file_name = $testdate.'_'.$file->getClientOriginalName();
        $upload = $file->storeAs($path, $file_name, 'public');

        if ($upload) {
            $form_data = array(
                'machine_set_id' => $request->machine_set_id,
                'TestDate' => $request->TestDate,
                'Result' => $request->Result,
                'Attachment' => $file_name,
                'AttachmentPath' => $path
            );

            CraneCertificate::create($form_data);

            return response()->json(['success' => 'Data Added successfully.']);
        }
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = CraneCertificate::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'Result'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Result' => $request->Result
        );

        CraneCertificate::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
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

        $cranecertificateid = $request->get('hidden_id');
        $file = $request->file('Attachment');

        $cranecertificate = CraneCertificate::find($cranecertificateid);

        $path = $cranecertificate->AttachmentPath;
        $file_name = $cranecertificate->TestDate.'_'.$file->getClientOriginalName();
        $update = $file->storeAs($path, $file_name, 'public');
        if($update){

            $file_path = $path.$cranecertificate->Attachment;
            if ( $cranecertificate->Attachment != null && \Storage::disk('public')->exists($file_path)) {
                \Storage::disk('public')->delete($file_path);
            }
            $cranecertificate->update([
                'Attachment' => $file_name
            ]);

            return response()->json(['success' => 'Update successfully.']);
        }
    }

    public function destroy($id)
    {
        $data = CraneCertificate::find($id);
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

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE machine_set AS (
                SELECT machine_sets.id, machine_sets.location_id, machine_sets.machine_id, machine_sets.Remark, machine_sets.SerialNumber
                FROM machine_sets
                INNER JOIN items
                    INNER JOIN jobs
                    ON items.id = jobs.item_id
                ON machine_sets.id = items.machine_set_id
                WHERE jobs.project_id = $id AND items.scope_id = 9
                GROUP BY machine_sets.id, machine_sets.location_id, machine_sets.machine_id, machine_sets.Remark, machine_sets.SerialNumber
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::select('SELECT machine_set.* , locations.LocationName, machines.MachineName, crane_certificates.TestDate, crane_certificates.Result, crane_certificates.Attachment, crane_certificates.AttachmentPath, crane_certificates.id AS crane_certificate_id
                FROM machine_set
                INNER JOIN locations
                ON machine_set.location_id = locations.id
                INNER JOIN machines
                ON machine_set.machine_id = machines.id
                LEFT JOIN crane_certificates
                ON machine_set.id = crane_certificates.machine_set_id');
            return DataTables::of($data)
                ->editColumn('LocationName',function($data){
                    return '<div class="text-center">'.$data->LocationName.'</div>';
                })
                ->editColumn('MachineName',function($data){
                    return '<div class="text-center">'.$data->MachineName.'</div>';
                })
                ->editColumn('SerialNumber',function($data){
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->editColumn('TestDate',function($data){
                    return '<div class="text-center">'.$data->TestDate.'</div>';
                })
                ->editColumn('Result',function($data){
                    return nl2br($data->Result);
                })
                ->editColumn('Attachment',function($data){
                    if ($data->Attachment != "" ) {
                        return '
                        <div class="text-center">
                            <a href="'. url('storage/'.$data->AttachmentPath.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                            <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->crane_certificate_id.'" title="Change Attachment"><i class="fa fa-lg fa-fw fa-exchange"></i></button>
                        </div>';
                    } else {
                        return '<div class="text-center">N/A</div>';
                    }
                })
                ->addColumn('action',function($data){
                    if ($data->Attachment != "" ) {
                        return '
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->crane_certificate_id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->crane_certificate_id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>';
                    } else {
                        return '
                        <div class="text-center">
                            <button class="add btn btn-xs btn-default text-success mx-1 shadow" name="create_record" id="'.$data->id.'" title="Add"><i class="fa fa-lg fa-fw fa-plus"></i></button>
                        </div>';
                    }
                })
                ->rawColumns(['LocationName','MachineName','SerialNumber','TestDate','Result','Attachment','action'])
                ->make(true);
        }

        return view('cranes.project',compact('project'));
    }
}
