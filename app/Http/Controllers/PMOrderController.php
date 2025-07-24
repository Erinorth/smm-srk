<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Project;
use App\Models\PMOrder;

class PMOrderController extends Controller
{
    public function index(Request $request, $id)
    {
            if($request->ajax())
            {
                $data = DB::select('SELECT p_m_orders.id, projects.ProjectName, projects.FinishDate, p_m_orders_1.PMOrder AS Sup, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.Status, p_m_orders.Remark
                    FROM p_m_orders AS p_m_orders_1 INNER JOIN (projects INNER JOIN p_m_orders ON projects.id = p_m_orders.project_id) ON p_m_orders_1.id = p_m_orders.SupPMOrder');
                return DataTables::of($data)
                    ->editColumn('id', function($data) {
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->editColumn('FinishDate', function($data) {
                        return '<div class="text-center">'.$data->FinishDate.'</div>';
                    })
                    ->editColumn('Sup', function($data) {
                        return '<div class="text-center">'.$data->Sup.'</div>';
                    })
                    ->editColumn('PMOrder', function($data) {
                        return '<div class="text-center">'.$data->PMOrder.'</div>';
                    })
                    ->editColumn('Status', function($data) {
                        return '<div class="text-center">'.$data->Status.'</div>';
                    })
                    ->rawColumns(['id','FinishDate','Sup','PMOrder','Status'])
                    ->make(true);
            }

        return view('pmorders.index');
    }

    public function project(Request $request, $id)
    {
        $project = Project::find($id);

        $superpmorder = DB::select('SELECT p_m_orders.id, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.project_id
            FROM p_m_orders
            WHERE (((p_m_orders.project_id)='.$id.'))
            ORDER BY p_m_orders.PMOrder');

        if($request->ajax())
        {
            $data = DB::select('SELECT p_m_orders.id, p_m_orders_1.PMOrder AS SupPMOrder, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.Status, p_m_orders.Remark, p_m_orders.project_id
                FROM p_m_orders AS p_m_orders_1 INNER JOIN p_m_orders ON p_m_orders_1.id = p_m_orders.SupPMOrder
                WHERE (((p_m_orders.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('SupPMOrder', function($data) {
                    return '<div class="text-center">'.$data->SupPMOrder.'</div>';
                })
                ->editColumn('PMOrder', function($data) {
                    return '<div class="text-center">'.$data->PMOrder.'</div>';
                })
                ->editColumn('Status', function($data) {
                    return '<div class="text-center">'.$data->Status.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                    ')
                ->rawColumns(['id','SupPMOrder','PMOrder','Status','action'])
                ->make(true);
        }

        return view('pmorders.project',compact('project','superpmorder'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'PMOrder'=>'required|unique:p_m_orders,PMOrder',
            'SupPMOrder'=>'required',
            'PMOrderName'=>'required',
            'Status'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'PMOrder' => $request->PMOrder,
            'PMOrderName' => $request->PMOrderName,
            'SupPMOrder' => $request->SupPMOrder,
            'Status' => $request->Status,
            'Remark' => $request->Remark,
            'project_id' => $request->project_id
        );

        PMOrder::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = PMOrder::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request,PMOrder $pmorderid)
    {
        $rules = array(
            'PMOrder'=>'required',
            'SupPMOrder'=>'required',
            'PMOrderName'=>'required',
            'Status'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'PMOrder' => $request->PMOrder,
            'PMOrderName' => $request->PMOrderName,
            'SupPMOrder' => $request->SupPMOrder,
            'Status' => $request->Status,
            'Remark' => $request->Remark,
            'project_id' => $request->project_id
        );

        PMOrder::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Updated successfully.']);
    }

    public function destroy($id)
    {
        $data = PMOrder::findOrFail($id);
        $data->delete();
    }
}
