<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\JobPosition;
use App\Models\Course;
use DB;
use DataTables;
use Validator;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $department = Department::orderBy('DepartmentName','asc')->get();
        $position = JobPosition::orderBy('JobPositionname','asc')->get();
        
        if($request->ajax())
        {
            $data = DB::select('SELECT courses.id, courses.CourseName, courses.Type, departments.DepartmentName, job_positions.JobPositionName, courses.OnSite
                FROM job_positions INNER JOIN (departments INNER JOIN courses ON departments.id = courses.ForDepartment) ON job_positions.id = courses.ForPosition
                ORDER BY courses.CourseName, courses.Type, departments.DepartmentName');
            return DataTables::of($data)
                ->editColumn('Type',function($data){
                    return '<div class="text-center">'.$data->Type.'</div>';
                })
                ->editColumn('DepartmentName',function($data){
                    return '<div class="text-center">'.$data->DepartmentName.'</div>';
                })
                ->editColumn('PositionName',function($data){
                    return '<div class="text-center">'.$data->JobPositionName.'</div>';
                })
                ->editColumn('OnSite',function($data){
                    return '<div class="text-center">'.$data->OnSite.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        @role('."'admin|head_engineering|head_operation'".')
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['Type','DepartmentName','PositionName','OnSite','action'])
                ->make(true);
        }

        return view('courses.index',compact('department','position'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'CourseName'=>'required',
            'Type'=>'required',
            'ForDepartment'=>'required',
            'ForPosition'=>'required',
            'OnSite'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'CourseName' => $request->CourseName,
            'Type' => $request->Type,
            'ForDepartment' => $request->ForDepartment,
            'ForPosition' => $request->ForPosition,
            'OnSite' => $request->OnSite
        );

        Course::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Course::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Course $id)
    {
        $rules = array(
            'CourseName'=>'required',
            'Type'=>'required',
            'ForDepartment'=>'required',
            'ForPosition'=>'required',
            'OnSite'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'CourseName' => $request->CourseName,
            'Type' => $request->Type,
            'ForDepartment' => $request->ForDepartment,
            'ForPosition' => $request->ForPosition,
            'OnSite' => $request->OnSite
        );

        Course::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function destroy($id)
    {
        $data = Course::findOrFail($id);
        $data->delete();
    }
}
