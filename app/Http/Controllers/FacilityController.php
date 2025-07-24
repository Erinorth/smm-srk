<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCrane;
use App\Models\SupportTool;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Validator;

class FacilityController extends Controller
{
    public function project(Request $request, $id)
    {
        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS location ;
                DROP TABLE IF EXISTS max_certificate ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE location AS (
                SELECT machine_sets.location_id
                FROM jobs
                INNER JOIN items
                    INNER JOIN machine_sets
                    ON items.machine_set_id = machine_sets.id
                ON jobs.item_id = items.id
                WHERE jobs.project_id = $id
                GROUP BY machine_sets.location_id
                );

            CREATE TEMPORARY TABLE max_certificate AS (
                SELECT crane_certificates.*
                FROM crane_certificates
                INNER JOIN (SELECT machine_set_id, MAX(TestDate) AS MaxTestDate
                    FROM crane_certificates
                    GROUP BY machine_set_id) t
                ON crane_certificates.machine_set_id = t.machine_set_id AND crane_certificates.TestDate = t.MaxTestDate
                );
            ")
        );

        $project = Project::find($id);
        $crane = DB::select('SELECT machine_sets.id, machines.MachineName, machine_sets.Remark, machine_sets.SerialNumber
            FROM machine_sets
            INNER JOIN machines
            ON machine_sets.machine_id = machines.id
            INNER JOIN location
            ON machine_sets.location_id = location.location_id
            WHERE machine_sets.machine_id IN (1,2,3,6,7,9)');

        if ( NOW() <= $project->FinishDate ) {
            $require_machine_set = DB::select('SELECT project_cranes.*
                FROM project_cranes
                WHERE project_id = '.$project->id.'');

            foreach ($require_machine_set as $value) {
                $certificate = DB::table('max_certificate')
                    ->where('machine_set_id','=',$value->machine_set_id)
                    ->first();
                if ($certificate) {
                    $form_data = array(
                        'crane_certificate_id' => $certificate->id,
                    );

                    ProjectCrane::whereId($value->id)->update($form_data);
                }
            }
        }

        return view('facility.project',compact('project','crane'));

        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS location ;
                DROP TABLE IF EXISTS max_certificate ;
            ")
        );
    }

    public function projectcrane(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT project_cranes.*, locations.LocationName, machines.MachineName, machine_sets.Remark AS MachineDetail, machine_sets.SerialNumber, crane_certificates.Attachment, crane_certificates.AttachmentPath
                FROM project_cranes
                INNER JOIN machine_sets
                    INNER JOIN locations
                    ON machine_sets.location_id = locations.id
                    INNER JOIN machines
                    ON machine_sets.machine_id = machines.id
                ON project_cranes.machine_set_id = machine_sets.id
                LEFT JOIN crane_certificates
                ON project_cranes.crane_certificate_id = crane_certificates.id
                WHERE project_cranes.project_id = '.$id.'');
            return DataTables::of($data)
                ->editColumn('MaxUseLoad', function($data) {
                    return '<div class="text-center">'.$data->MaxUseLoad.'</div>';
                })
                ->editColumn('UseDate', function($data) {
                    return '<div class="text-center">'.$data->UseDate.'</div>';
                })
                ->editColumn('SerialNumber', function($data) {
                    return '<div class="text-center">'.$data->SerialNumber.'</div>';
                })
                ->addColumn('Attachment', function($data) {
                    if ( $data->Attachment == "" ) {
                        return '
                        <div class="text-center">N/A</div>';
                    } else {
                        return '
                        <div class="text-center">
                            <a href="'. url('storage/'.$data->AttachmentPath.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        </div>';
                    }
                })
                ->addColumn('action', function($data) {
                    return '
                    <div class="text-center">
                        <button class="editcrane btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="deletecrane btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>';
                })
                ->rawColumns(['MaxUseLoad','UseDate','SerialNumber','Attachment','action'])
                ->make(true);
        }
    }

    public function projectcranestore(Request $request)
    {
        $rules = array(
            'machine_set_id'=>'required',
            'MaxUseLoad'=>'required',
            'UseDate_crane'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'machine_set_id' => $request->machine_set_id,
            'MaxUseLoad' => $request->MaxUseLoad,
            'UseDate' => $request->UseDate_crane,
            'Remark' => $request->Remark_crane,
            'project_id' => $request->project_id
        );

        ProjectCrane::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function projectcraneedit($id)
    {
        if(request()->ajax())
        {
            $data = ProjectCrane::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function projectcraneupdate(Request $request)
    {
        $rules = array(
            'machine_set_id'=>'required',
            'MaxUseLoad'=>'required',
            'UseDate_crane'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'machine_set_id' => $request->machine_set_id,
            'MaxUseLoad' => $request->MaxUseLoad,
            'UseDate' => $request->UseDate_crane,
            'Remark' => $request->Remark_crane
        );

        ProjectCrane::whereId($request->hidden_idcrane)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function projectcranedestroy($id)
    {
        $data = ProjectCrane::findOrFail($id);
        $data->delete();
    }

    public function projecttool(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT *
                FROM support_tools
                WHERE project_id = '.$id.'');
            return DataTables::of($data)
                ->editColumn('Type', function($data) {
                    return '<div class="text-center">'.$data->Type.'</div>';
                })
                ->editColumn('UseDate', function($data) {
                    return '<div class="text-center">'.$data->UseDate.'</div>';
                })
                ->addColumn('Attachment', function($data) {
                    if ( $data->Attachment == "" ) {
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
                ->addColumn('action', function($data) {
                    if ( $data->Attachment == "" ) {
                        return '
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>';
                    } else {
                        return '
                        <div class="text-center">N/A</div>';
                    }
                })
                ->rawColumns(['Type','UseDate','Attachment','action'])
                ->make(true);
        }
    }

    public function projecttoolstore(Request $request)
    {
        $rules = array(
            'ToolName'=>'required',
            'Type'=>'required',
            'Detail'=>'required',
            'UseDate'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ToolName' => $request->ToolName,
            'Type' => $request->Type,
            'Detail' => $request->Detail,
            'UseDate' => $request->UseDate,
            'Remark' => $request->Remark,
            'project_id' => $request->project_id
        );

        SupportTool::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function projecttooledit($id)
    {
        if(request()->ajax())
        {
            $data = SupportTool::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function projecttoolupdate(Request $request)
    {
        $rules = array(
            'ToolName'=>'required',
            'Type'=>'required',
            'Detail'=>'required',
            'UseDate'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ToolName' => $request->ToolName,
            'Type' => $request->Type,
            'Detail' => $request->Detail,
            'UseDate' => $request->UseDate,
            'Remark' => $request->Remark,
        );

        SupportTool::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function projecttooldestroy($id)
    {
        $data = SupportTool::findOrFail($id);
        $data->delete();
    }

    public function projecttoolattachment(Request $request)
    {
        $rules = array(
            'Attachment'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $projectid = $request->get('project_id');
        $file = $request->file('Attachment');
        $attachmentid = $request->get('attachment_id');

        $path = 'project'.$projectid.'/facility_request/';
        $file_name = $attachmentid.'-'.$file->getClientOriginalName();
        $upload = $file->storeAs($path, $file_name, 'public');
        if($upload){

                $toolrequest = SupportTool::find($attachmentid);
                $toolrequest->update([
                    'Attachment' => $file_name,
                    'AttachmentPath' => $path
                ]);

            return response()->json(['success' => 'Upload successfully.']);
        }
    }

    public function projecttoolattachmentupdate(Request $request)
    {
        $rules = array(
            'Attachment'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $file = $request->file('Attachment');
        $attachmentid = $request->get('attachment_id');

        $toolrequest = SupportTool::find($attachmentid);
        $path = $toolrequest->AttachmentPath;
        $file_name = $attachmentid.'-'.$file->getClientOriginalName();
        $update = $file->storeAs($path, $file_name, 'public');
        $file_path = $path.$toolrequest->Attachment;
        if ( $toolrequest->Attachment != null && \Storage::disk('public')->exists($file_path)) {
            \Storage::disk('public')->delete($file_path);
        }
        $toolrequest->update([
            'Attachment' => $file_name
        ]);

        return response()->json(['success' => 'Update successfully.']);
    }

    public function projecttoolattachmentdelete($id, $projectid)
    {
        $toolrequest = SupportTool::find($id);
        $path = $toolrequest->AttachmentPath;
        $file_path = $path.$toolrequest->Attachment;
        if ( $toolrequest->Attachment != null && \Storage::disk('public')->exists($file_path)) {
            \Storage::disk('public')->delete($file_path);
        }
        $toolrequest->update([
            'Attachment' => null,
            'AttachmentPath' => null
        ]);
    }
}
