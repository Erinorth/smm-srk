<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SafetyHealthControlGraph;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;

class ControlGraphController extends Controller
{
    public function safety_health(Request $request)
    {
        if($request->ajax())
        {
            $data = SafetyHealthControlGraph::all();
            return DataTables::of($data)
                ->editColumn('Month', function($data) {
                    return '<div class="text-center">'.$data->Month.'</div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <button class="edit_safety_health_control btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    <button class="delete_safety_health_control btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                </div>
                ')
                ->rawColumns(['Month','action'])
                ->make(true);
        }
    }

    public function safety_healthstore(Request $request)
    {
        $rules = array(
            'Month'=>'required',
            'T_TIFR'=>'required',
            'Incident'=>'required',
            'Man'=>'required',
            'Day'=>'required',
            'T_DI'=>'required',
            'DI'=>'required',
            'LossDay'=>'required',
            'TotalLoss'=>'required',
            'T_TotalLoss'=>'required',
            'T_Examination'=>'required',
            'Examination'=>'required',
            'T_Disease'=>'required',
            'Disease'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Month' => $request->Month.'-01',
            'T_TIFR' => $request->T_TIFR,
            'Incident' => $request->Incident,
            'Man' => $request->Man,
            'Day' => $request->Day,
            'T_DI' => $request->T_DI,
            'DI' => $request->DI,
            'LossDay' => $request->LossDay,
            'T_TotalLoss' => $request->T_TotalLoss,
            'TotalLoss' => $request->TotalLoss,
            'T_Examination' => $request->T_Examination,
            'Examination' => $request->Examination,
            'T_Disease' => $request->T_Disease,
            'Disease' => $request->Disease,
        );

        SafetyHealthControlGraph::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function safety_healthedit()
    {

    }

    public function safety_healthupdate()
    {

    }

    public function safety_healthdestroy()
    {

    }
}
