<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Law;
use App\Models\LawDetail;
use App\Models\LawAssesment;
use App\Models\Department;
use DB;
use DataTables;
use Validator;

class LawController extends Controller
{
    public function index(Request $request)
    {
        $law = Law::orderBy('LawName','asc')->get();

        if($request->ajax())
        {
            $data = Law::all();
            return DataTables::of($data)
                ->editColumn('id',function($data){
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('AnnouncementDate',function($data){
                    return '<div class="text-center">'.$data->AnnouncementDate.'</div>';
                })
                ->editColumn('NumberOfPages',function($data){
                    return '<div class="text-center">'.$data->NumberOfPages.'</div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <a href="'. url('law_details/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                    <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                </div>
                ')
                ->rawColumns(['id','AnnouncementDate','NumberOfPages','action'])
                ->make(true);
        }

        return view('laws.index',compact('law'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'LawName'=>'required',
            'AnnouncementDate'=>'required',
            'NumberOfPages'=>'required',
            'Regulator'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'LawName' => $request->LawName,
            'AnnouncementDate'=> $request->AnnouncementDate,
            'NumberOfPages'=> $request->NumberOfPages,
            'Regulator'=> $request->Regulator
        );

        Law::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Law::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Law $id)
    {
        $rules = array(
            'LawName'=>'required',
            'AnnouncementDate'=>'required',
            'NumberOfPages'=>'required',
            'Regulator'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'LawName' => $request->LawName,
            'AnnouncementDate'=> $request->AnnouncementDate,
            'NumberOfPages'=> $request->NumberOfPages,
            'Regulator'=> $request->Regulator
        );

        Law::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Update successfully.']);
    }

    public function destroy($id)
    {
        $data = Law::findOrFail($id);
        $data->delete();
    }

    public function detail(Request $request, $id)
    {
        $law = Law::find($id);

        if($request->ajax())
            {
                $data = LawDetail::where('law_id','=',$id)
                    ->get();
                return DataTables::of($data)
                    ->editColumn('id',function($data){
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->editColumn('LawDetail',function($data){
                        return nl2br($data->LawDetail);
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>                        </div>
                        </div>
                    ')
                    ->rawColumns(['id','LawDetail','action'])
                    ->make(true);
            }

        return view('laws.detail',compact('law'));
    }

    public function detailstore(Request $request)
    {
        $rules = array(
            'law_id'=>'required',
            'LawDetail'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'law_id' => $request->law_id,
            'LawDetail'=> $request->LawDetail
        );

        LawDetail::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function detailedit($id)
    {
        if(request()->ajax())
        {
            $data = LawDetail::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function detailupdate(Request $request, LawDetail $id)
    {
        $rules = array(
            'law_id'=>'required',
            'LawDetail'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'law_id' => $request->law_id,
            'LawDetail'=> $request->LawDetail
        );

        LawDetail::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Update successfully.']);
    }

    public function detaildestroy($id)
    {
        $data = LawDetail::findOrFail($id);
        $data->delete();
    }

    public function department(Request $request)
    {
        if($request->ajax())
        {
            $data = Department::all();
            return DataTables::of($data)
                    ->editColumn('Business', function($data) {
                        return '<div class="text-center">'.$data->Business.'</div>';
                    })
                    ->editColumn('Division', function($data) {
                        return '<div class="text-center">'.$data->Division.'</div>';
                    })
                    ->editColumn('Department', function($data) {
                        return '<div class="text-center">'.$data->Department.'</div>';
                    })
                    ->editColumn('Section', function($data) {
                        return '<div class="text-center">'.$data->Section.'</div>';
                    })
                    ->addColumn('action', function($data) {
                        return '<div class="text-center">
                            <a href="'. url('law_assesments/'.$data->id.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        </div>';
                    })
                    ->rawColumns(['Business','Division','Department','Section','action'])
                    ->make(true);
        }

        return view('laws.department');
    }

    public function assesmentlaw(Request $request, $id)
    {
        $department = Department::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT laws.id, laws.LawName, laws.AnnouncementDate, laws.NumberOfPages, laws.Regulator, '.$department->id.' AS Department
                FROM laws');
            return DataTables::of($data)
                ->editColumn('id',function($data){
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('AnnouncementDate',function($data){
                    return '<div class="text-center">'.$data->AnnouncementDate.'</div>';
                })
                ->editColumn('NumberOfPages',function($data){
                    return '<div class="text-center">'.$data->NumberOfPages.'</div>';
                })
                ->addColumn('action','
                <div class="text-center">
                    <a href="'. url('law_assesments/{{$Department}}/{{$id}}').'" class="btn btn-xs btn-default text-warning mx-1 shadow" title="Assesment"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                    <a href="'. url('law_assesment/{{$Department}}/{{$id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Print"><i class="fa fa-lg fa-fw fa-print"></i></a>
                </div>
                ')
                ->rawColumns(['id','AnnouncementDate','NumberOfPages','action'])
                ->make(true);
        }

        return view('laws.assesmentlaw',compact('department'));
    }

    public function assesment(Request $request, $departmentid, $lawid)
    {
        $department = Department::find($departmentid);
        $law = Law::find($lawid);

        if($request->ajax())
            {
                $data = DB::select('SELECT law_assesments.id, law_details.LawDetail, law_assesments.Related, law_assesments.Evident
                    FROM law_assesments
                    INNER JOIN law_details
                    ON law_assesments.law_detail_id = law_details.id
                    WHERE law_assesments.department_id = '.$departmentid.' AND law_details.law_id = '.$lawid.'');
                return DataTables::of($data)
                    ->editColumn('id',function($data){
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->editColumn('LawDetail',function($data){
                        return nl2br($data->LawDetail);
                    })
                    ->editColumn('Related','
                        <div class="text-center">    
                            <input data-id="{{$id}}" class="toggle-class" type="checkbox" data-on-color="success" data-off-color="danger" data-toggle="toggle" data-on-text="Yes" data-off-text="No" {{ $Related == "Yes" ? '."'checked'".' : '."''".' }}>
                        </div>
                    ')
                    ->editColumn('Evident',function($data){
                        return nl2br($data->Evident).'</br>
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Evident"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        </div>';
                    })
                    ->rawColumns(['id','LawDetail','Related','Evident'])
                    ->make(true);
            }

        return view('laws.assesment',compact('department','law'));
    }

    public function assesmentstore(Request $request)
    {
        $lawid = $request->law_id;
        $departmentid = $request->department_id;

        $lawdetail = DB::select('SELECT id
            FROM law_details
            WHERE law_id='.$lawid.'');

        foreach ($lawdetail as $key => $value) {
            $count = LawAssesment::where('department_id','=',$departmentid)
                ->where('law_detail_id','=',$value->id)
                ->count();

            if($count == 0){
                $lawassesment = new LawAssesment();
                $lawassesment->department_id = $departmentid;
                $lawassesment->law_detail_id = $value->id;
                $lawassesment->Related = "No";
                $lawassesment->save();
            }
        }

        return back()->with('message','Successfully created Law Assesment!');
    }

    public function assesmentedit($id)
    {
        if(request()->ajax())
        {
            $data = LawAssesment::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function assesmentupdate(Request $request, LawAssesment $id)
    {
        $form_data = array(
            'Evident'=> $request->Evident
        );

        LawAssesment::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Update successfully.']);
    }

    public function related(Request $request)
    {
        $lawassesment = LawAssesment::find($request->law_assesment_id);
        $lawassesment->Related = $request->Related;
        $lawassesment->save();
  
        return response()->json(['success'=>'Done change successfully.']);
    }
}
