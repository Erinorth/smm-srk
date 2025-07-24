<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DB;
use DataTables;
use Validator;
use App\Models\Department;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT products.id, products.ProductCode, products.ProductName, products.Service, departments.DepartmentName
                FROM departments
                INNER JOIN products ON products.department_id = departments.id');
            return DataTables::of($data)
                    ->editColumn('id', function($data) {
                        return '<div class="text-center">'.$data->id.'</div>';
                    })
                    ->editColumn('ProductCode', function($data) {
                        return '<div class="text-center">'.$data->ProductCode.'</div>';
                    })
                    ->editColumn('ProductName', function($data) {
                        return '<div class="text-center">'.$data->ProductName.'</div>';
                    })
                    ->editColumn('DepartmentName', function($data) {
                        return '<div class="text-center">'.$data->DepartmentName.'</div>';
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            @role('."'admin|head_engineering'".')
                                <button class="edit_product btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                                <button class="delete_product btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            @else <div class="text-center">N/A</div>
                            @endrole
                        </div>
                    ')
                    ->rawColumns(['id','ProductCode','ProductName','DepartmentName','action'])
                    ->make(true);
        }
        $department = Department::orderby('DepartmentName','asc')->get();
        return view('products.index',compact('department'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'ProductCode'=>'required',
            'ProductName'=>'required',
            'department_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ProductCode' => $request->ProductCode,
            'ProductName' => $request->ProductName,
            'Service' => $request->Service,
            'department_id' => $request->department_id
        );

        Product::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Product::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Product $product)
    {
        $rules = array(
            'ProductCode'=>'required',
            'ProductName'=>'required',
            'department_id'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ProductCode' => $request->ProductCode,
            'ProductName' => $request->ProductName,
            'Service' => $request->Service,
            'department_id' => $request->department_id
        );

        Product::whereId($request->hidden_id_product)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();
    }
}
