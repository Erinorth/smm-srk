<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\User;
use Auth;
use DB;
use DataTables;
use Validator;
use App\Models\Employee;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT users.id, employees.WorkID, employees.ThaiName, users.name AS UserName, users.email, roles.name AS Role
                FROM roles RIGHT JOIN ((users LEFT JOIN employees ON users.id = employees.user_id) LEFT JOIN model_has_roles ON users.id = model_has_roles.model_id) ON roles.id = model_has_roles.role_id');
            return DataTables::of($data)
                ->editColumn('WorkID', function($data) {
                    return '<div class="text-center">'.$data->WorkID.'</div>';
                })
                ->addColumn('action',function($data){
                    if ( $data->id == Auth::user()->id )
                    return view('users.action',compact('data'));
                    return view('users.action2',compact('data'));
                })
                ->rawColumns(['WorkID','action'])
                ->make(true);
        }

        return view('users.index');
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = User::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, User $id)
    {
        $rules = array(
            'name'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name' => $request->name
        );

        User::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
    }

    public function employee(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT employees.WorkID, employees.ThaiName, users.name AS UserName, users.email, employees.id
                FROM users RIGHT JOIN employees ON users.id = employees.user_id');
            return DataTables::of($data)
                ->editColumn('WorkID', function($data) {
                    return '<div class="text-center">'.$data->WorkID.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit_link_employee btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    </div>
                ')
                ->rawColumns(['WorkID','action'])
                ->make(true);
        }
    }

    public function employeeedit($id)
    {
        if(request()->ajax())
        {
            $data = Employee::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function employeeupdate(Request $request, Employee $id)
    {
        $rules = array(
            //
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'user_id' => $request->user_id
        );

        Employee::whereId($request->hidden_id_link_employee)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function role(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT model_has_roles.model_id, users.name AS UserName, users.email, model_has_roles.role_id, roles.name AS Role
                FROM users INNER JOIN (roles INNER JOIN model_has_roles ON roles.id = model_has_roles.role_id) ON users.id = model_has_roles.model_id');
            return DataTables::of($data)
                ->editColumn('email', function($data) {
                    return '<div class="text-center">'.$data->email.'</div>';
                })
                ->editColumn('Role', function($data) {
                    return '<div class="text-center">'.$data->Role.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="delete_add_role btn btn-xs btn-default text-danger mx-1 shadow" name="edit" user_id="{{$model_id}}" role_id="{{$role_id}}"  title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['email','Role','action'])
                ->make(true);
        }
    }

    public function rolestore(Request $request)
    {
        $rules = array(
            'model_id'=>'required',
            'role_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $user = User::find($request->model_id);
        $role = Role::find($request->role_id);

        $user->assignRole($role);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function roledestroy($userid, $roleid)
    {
        $user = User::find($userid);
        $role = Role::find($roleid);

        $user->removeRole($role);
    }
}
