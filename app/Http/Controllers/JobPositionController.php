<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosition;
use App\Models\Craft;
use DB;
use DataTables;
use Validator;

class JobPositionController extends Controller
{
    public function index(Request $request)
    {
        $craft = CRAFT::all();

        if($request->ajax())
            {
                $data = DB::select('SELECT job_positions.id, job_positions.JobPositionName, job_positions.TypeofJob, crafts.CraftName
                    FROM crafts INNER JOIN job_positions ON crafts.id = job_positions.craft_id');
                return DataTables::of($data)
                    ->editColumn('id',function($data){
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->editColumn('CraftName',function($data){
                        return '<div class="text-center">'.$data->CraftName.'</div>';
                    })
                    ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>                        </div>
                    </div>
                    ')
                    ->rawColumns(['id','CraftName','action'])
                    ->make(true);
            }
    }

    public function store(Request $request)
    {
        $rules = array(
            'JobPositionName'=>'required',
            'TypeofJob'=>'required',
            'craft_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'JobPositionName' => $request->JobPositionName,
            'TypeofJob'=> $request->TypeofJob,
            'craft_id'=> $request->craft_id
        );

        JobPosition::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = JobPosition::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, JobPosition $id)
    {
        $rules = array(
            'JobPositionName'=>'required',
            'TypeofJob'=>'required',
            'craft_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'JobPositionName' => $request->JobPositionName,
            'TypeofJob'=> $request->TypeofJob,
            'craft_id'=> $request->craft_id
        );

        JobPosition::whereId($request->hidden_id_jobposition)->update($form_data);

        return response()->json(['success' => 'Data Update successfully.']);
    }

    public function destroy($id)
    {
        $data = JobPosition::findOrFail($id);
        $data->delete();
    }
}
