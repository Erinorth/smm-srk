<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Project;
use App\Models\Item;
use App\Models\HotWork;

class HotWorkController extends Controller
{
    public function create(Request $request, $id)
    {
        $project = Project::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT hot_works.id, hot_works.project_id, hot_works.CompanyName, hot_works.WorkingArea, hot_works.JobName, hot_works.Amount, hot_works.PlanedDate, hot_works.Reference, hot_works.Applicant, hot_works.Supervisor, hot_works.created_at, hot_works.Attachment
                FROM hot_works
                WHERE (((hot_works.project_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('created_at',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->created_at.'</div>';
                        return '<div class="text-center">'.$data->created_at.'</div>';
                    })
                    ->editColumn('CompanyName',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->CompanyName.'</div>';
                        return '<div class="text-center">'.$data->CompanyName.'</div>';
                    })
                    ->editColumn('WorkingArea',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-danger">'.$data->WorkingArea.'</div>';
                        return $data->WorkingArea;
                    })
                    ->editColumn('JobName',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-danger">'.$data->JobName.'</div>';
                        return $data->JobName;
                    })
                    ->editColumn('Amount',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->Amount.'</div>';
                        return '<div class="text-center">'.$data->Amount.'</div>';
                    })
                    ->editColumn('PlanedDate',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->PlanedDate.'</div>';
                        return '<div class="text-center">'.$data->PlanedDate.'</div>';
                    })
                    ->editColumn('Reference',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-danger">'.$data->Reference.'</div>';
                        return $data->Reference;
                    })
                    ->editColumn('Applicant',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->Applicant.'</div>';
                        return '<div class="text-center">'.$data->Applicant.'</div>';
                    })
                    ->editColumn('Supervisor',function($data){
                        if ( $data->created_at > $data->PlanedDate)
                        return '<div class="text-center text-danger">'.$data->Supervisor.'</div>';
                        return '<div class="text-center">'.$data->Supervisor.'</div>';
                    })
                    ->addColumn('action', function($data) {
                        if ( $data->Attachment == "" ) {
                            return '
                            <div class="text-center">
                                <a class="btnprn btn btn-xs btn-default text-info mx-1 shadow" title="Print" href="'.url('hotwork/'.$data->id).'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                [Attachment<button class="attachment btn btn-xs btn-default text-success mx-1 shadow" name="attachment" id="'.$data->id.'" title="Add Attachment"><i class="fa fa-lg fa-fw fa-plus"></i></button>]
                            </div>';
                        } else {
                            return '
                            <div class="text-center">
                                <a class="btnprn btn btn-xs btn-default text-info mx-1 shadow" title="Print" href="'.url('hotwork/'.$data->id).'"><i class="fa fa-lg fa-fw fa-print"></i></a>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                                [Attachment<a href="'. url('storage/project'.$data->project_id.'/hot_work/'.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                <button class="edit_attachment btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="'.$data->id.'" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_attachment btn btn-xs btn-default text-danger mx-1 shadow" name="attachment" id="'.$data->id.'" title="Delete Attachment"><i class="fa fa-lg fa-fw fa-trash"></i></button>]
                            </div>';
                        }
                    })
                    ->rawColumns(['created_at','CompanyName','WorkingArea','JobName','Amount','PlanedDate','Reference','Applicant','Supervisor','action'])
                    ->make(true);
        }

        return view('hotworks.create',compact('project'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'CompanyName'=>'required',
            'WorkingArea'=>'required',
            'JobName'=>'required',
            'Amount'=>'required',
            'PlanedDate'=>'required',
            'Reference'=>'required',
            'Applicant'=>'required',
            'Supervisor'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'CompanyName' => $request->CompanyName,
            'WorkingArea' => $request->WorkingArea,
            'JobName' => $request->JobName,
            'Amount' => $request->Amount,
            'PlanedDate' => $request->PlanedDate,
            'Reference' => $request->Reference,
            'Applicant' => $request->Applicant,
            'Supervisor' => $request->Supervisor,
            'project_id' => $request->project_id
        );

        HotWork::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = HotWork::findOrFail($id);
            return response()->json(['result' => $data]);
        }

        return view('jobs.edit',compact('job','machinesystemdetail','pmorder','cpmorder','work','workdetail'));
    }

    public function update(Request $request, HotWork $hotworkid)
    {
        $rules = array(
            'CompanyName'=>'required',
            'WorkingArea'=>'required',
            'JobName'=>'required',
            'Amount'=>'required',
            'PlanedDate'=>'required',
            'Reference'=>'required',
            'Applicant'=>'required',
            'Supervisor'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'CompanyName' => $request->CompanyName,
            'WorkingArea' => $request->WorkingArea,
            'JobName' => $request->JobName,
            'Amount' => $request->Amount,
            'PlanedDate' => $request->PlanedDate,
            'Reference' => $request->Reference,
            'Applicant' => $request->Applicant,
            'Supervisor' => $request->Supervisor,
            'project_id' => $request->project_id
        );

        HotWork::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = HotWork::findOrFail($id);
        $data->delete();
    }
}
