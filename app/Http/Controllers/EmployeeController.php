<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\EmployeeCertificate;
use App\Models\CertificateType;
use App\Models\Project;
use App\Models\ProjectEmployeeCertificate;
use Auth;
use DB;
use DataTables;
use Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $department = Department::orderBy('Business','asc')
            ->orderBy('Division','asc')
            ->orderBy('Department','asc')
            ->orderBy('Section','asc')
            ->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT employees.id, employees.WorkID, employees.ThaiName, employees.EnglishName, employees.Position, employees.EGATEmail, departments.DepartmentName, employees.Telephone, employees.user_id, employees.Admin
                FROM departments INNER JOIN employees ON departments.id = employees.department_id');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('WorkID', function($data) {
                    return '<div class="text-center">'.$data->WorkID.'</div>';
                })
                ->editColumn('Position', function($data) {
                    return '<div class="text-center">'.$data->Position.'</div>';
                })
                ->editColumn('EGATEmail', function($data) {
                    return '<div class="text-center">'.$data->EGATEmail.'</div>';
                })
                ->editColumn('DepartmentName', function($data) {
                    return '<div class="text-center">'.$data->DepartmentName.'</div>';
                })
                ->editColumn('Admin', function($data) {
                    return '<div class="text-center">'.$data->Admin.'</div>';
                })
                ->editColumn('Telephone', function($data) {
                    return '<div class="text-center">'.$data->Telephone.'</div>';
                })
                ->addColumn('action',function($data){
                    if ( $data->user_id == Auth::user()->id )
                    return view('employees.action',compact('data'));
                    return view('employees.action2',compact('data'));
                })
                ->rawColumns(['id','WorkID','Position','EGATEmail','DepartmentName','Admin','Telephone','action'])
                ->make(true);
        }

        return view('employees.index',compact('department'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'WorkID'=>'required|unique:employees,WorkID',
            'ThaiName'=>'required|unique:employees,ThaiName',
            'Position'=>'required',
            'department_id'=>'required',
            'Admin'=>'required',
            'Telephone'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'WorkID' => $request->WorkID,
            'ThaiName' => $request->ThaiName,
            'EnglishName' => $request->EnglishName,
            'Position' => $request->Position,
            'EGATEmail' => $request->EGATEmail,
            'department_id' => $request->department_id,
            'Admin' => $request->Admin,
            'Telephone' => $request->Telephone
        );

        Employee::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Employee::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Employee $id)
    {
        $rules = array(
            'WorkID'=>'required',
            'ThaiName'=>'required',
            'Position'=>'required',
            'department_id'=>'required',
            'Admin'=>'required',
            'Telephone'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'WorkID' => $request->WorkID,
            'ThaiName' => $request->ThaiName,
            'EnglishName' => $request->EnglishName,
            'Position' => $request->Position,
            'EGATEmail' => $request->EGATEmail,
            'department_id' => $request->department_id,
            'Admin' => $request->Admin,
            'Telephone' => $request->Telephone
        );

        Employee::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function destroy($id)
    {
        $data = Employee::findOrFail($id);
        $data->delete();
    }

    public function certificate(Request $request)
    {
        $type = CertificateType::orderBy('TypeName','asc')->get();
        $employee = Employee::orderBy('ThaiName','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT employee_certificates.id, employee_certificates.employee_id, employees.WorkID, employees.ThaiName, employee_certificates.certificate_type_id, certificate_types.TypeName, employee_certificates.EffectiveDate, employee_certificates.Attachment, employee_certificates.AttachmentPath
                FROM employee_certificates
                INNER JOIN certificate_types
                ON employee_certificates.certificate_type_id = certificate_types.id
                INNER JOIN employees
                ON employee_certificates.employee_id = employees.id');
            return DataTables::of($data)
                ->editColumn('id',function($data){
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('WorkID',function($data){
                    return '<div class="text-center">'.$data->WorkID.'</div>';
                })
                ->editColumn('TypeName',function($data){
                    return '<div class="text-center">'.$data->TypeName.'</div>';
                })
                ->editColumn('EffectiveDate',function($data){
                    return '<div class="text-center">'.$data->EffectiveDate.'</div>';
                })
                ->addColumn('Attachment','
                    <div class="text-center">
                        <a href="'. url('storage/{{ $AttachmentPath }}{{ $Attachment }}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                        @role('."'admin|head_engineering|head_operation'".')
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="attachment" id="{{ $id }}" title="Edit Attachment"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        @endrole
                    </div>
                ')
                ->addColumn('action','
                    <div class="text-center">
                        @role('."'admin|head_engineering|head_operation'".')
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{ $id }}" employeeid="{{ $employee_id }}" certificatetypeid="{{ $certificate_type_id }}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','WorkID','TypeName','EffectiveDate','action','Attachment'])
                ->make(true);
        }

        return view('employees.certificate',compact('type','employee'));
    }

    public function certificatestore(Request $request)
    {
        $rules = array(
            'employee_id' => 'required',
            'certificate_type_id' => 'required',
            'EffectiveDate' => 'required',
            'Attachment' => 'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $employeeid = $request->get('employee_id');
        $certificatetypeid = $request->get('certificate_type_id');
        $effectivedate = $request->get('EffectiveDate');
        $file = $request->file('Attachment');

        $path = 'certificate/employee'.$employeeid.'/'.$certificatetypeid.'/';
        $file_name = $employeeid.'-'.$effectivedate.'-'.$file->getClientOriginalName();
        $upload = $file->storeAs($path, $file_name, 'public');

        if ($upload) {
            $form_data = array(
                'employee_id' => $employeeid,
                'certificate_type_id' => $certificatetypeid,
                'EffectiveDate' => $effectivedate,
                'Attachment' => $file_name,
                'AttachmentPath' => $path,
                'Remark' => $request->Remark,
            );

            EmployeeCertificate::create($form_data);

            return response()->json(['success' => 'Data Added successfully.']);
        }
    }

    public function certificateupdate(Request $request)
    {
        $rules = array(
            'Attachment'=>'required|mimes:pdf'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $certificate = EmployeeCertificate::find($request->get('certificate_id'));

        $employeeid = $certificate->employee_id;
        $effectivedate = $certificate->EffectiveDate;
        $file = $request->file('Attachment');

        $path = $certificate->AttachmentPath;
        $file_name = $employeeid.'-'.$effectivedate.'-'.$file->getClientOriginalName();
        $update = $file->storeAs($path, $file_name, 'public');
        $file_path = $path.$certificate->Attachment;
        if ( $certificate->Attachment != null && \Storage::disk('public')->exists($file_path)) {
            \Storage::disk('public')->delete($file_path);
        }
        $certificate->update([
            'Attachment' => $file_name
        ]);

        return response()->json(['success' => 'Update successfully.']);
    }

    public function certificateproject(Request $request, $id)
    {
        $project = Project::find($id);
        $type = CertificateType::orderBy('TypeName','asc')->get();
        $employee = Employee::orderBy('ThaiName','asc')->get();

        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS current_certificate ;
                DROP TABLE IF EXISTS require_certificate ;
                DROP TABLE IF EXISTS max_cer ;
                DROP TABLE IF EXISTS add_cer ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE require_certificate AS (
                SELECT responsible_certificates.certificate_type_id, responsibles.Responsible AS employee_id
                FROM responsibles
                INNER JOIN responsible_certificates
                ON responsibles.Duty = responsible_certificates.job_position_id
                WHERE responsibles.project_id = $id
                UNION
                SELECT 56 AS certificate_type_id, employee_id
                FROM mobilization_plans
                WHERE project_id = $id
                GROUP BY certificate_type_id, employee_id
                );

            CREATE TEMPORARY TABLE current_certificate AS (
                SELECT employee_certificates.id, employee_certificates.certificate_type_id, employee_certificates.employee_id, employee_certificates.EffectiveDate, employee_certificates.Attachment, employee_certificates.AttachmentPath
                FROM project_employee_certificates
                INNER JOIN employee_certificates
                ON project_employee_certificates.employee_certificate_id = employee_certificates.id
                WHERE project_employee_certificates.project_id = $id
                );

            CREATE TEMPORARY TABLE max_cer AS (
                SELECT employee_certificates.id, employee_certificates.employee_id, employee_certificates.certificate_type_id
                FROM employee_certificates
                INNER JOIN(SELECT employee_id, certificate_type_id, MAX(EffectiveDate) AS MaxEffectiveDate
                    FROM employee_certificates
                    GROUP BY employee_id, certificate_type_id) t
                ON employee_certificates.employee_id = t.employee_id AND employee_certificates.certificate_type_id = t.certificate_type_id AND employee_certificates.EffectiveDate = t.MaxEffectiveDate
                );

            CREATE TEMPORARY TABLE add_cer AS (
                SELECT max_cer.id
                FROM require_certificate
                INNER JOIN max_cer
                ON require_certificate.employee_id = max_cer.employee_id AND require_certificate.certificate_type_id = max_cer.certificate_type_id
                );
            ")
        );

        /* $test = DB::table('require_certificate')
            ->where('employee_id','=',40)
            ->get();
        dd($test); */

        if ( NOW() <= $project->FinishDate ) {
            $current_cer = DB::table('current_certificate')->get();

            foreach ($current_cer as $value) {
                $require_cer = DB::table('require_certificate')
                    ->where('employee_id','=',$value->employee_id)
                    ->where('certificate_type_id','=',$value->certificate_type_id)
                    ->count();

                if($require_cer == 0){
                    $certificate = ProjectEmployeeCertificate::where('employee_certificate_id','=',$value->id)
                        ->where('project_id','=',$id);
                    $certificate->delete();
                }
            }

            $add_cer = DB::table('add_cer')->get();

            foreach ($add_cer as $value) {
                $current_cer2 = DB::table('current_certificate')
                    ->where('id','=',$value->id)
                    ->count();

                if($current_cer2 == 0){
                    $certificate2 = new ProjectEmployeeCertificate();
                    $certificate2->project_id = $project->id;
                    $certificate2->employee_certificate_id = $value->id;
                    $certificate2->save();
                }
            }
        }

        if($request->ajax())
        {
            $data = DB::select('SELECT current_certificate.id, require_certificate.certificate_type_id, require_certificate.employee_id, employees.WorkID, employees.ThaiName, certificate_types.TypeName, DATE_ADD(current_certificate.EffectiveDate,INTERVAL certificate_types.Age DAY) AS ExpireDate, current_certificate.Attachment, current_certificate.AttachmentPath
                FROM require_certificate
                LEFT JOIN current_certificate
                ON require_certificate.certificate_type_id = current_certificate.certificate_type_id AND require_certificate.employee_id = current_certificate.employee_id
                INNER JOIN employees
                ON require_certificate.employee_id = employees.id
                INNER JOIN certificate_types
                ON require_certificate.certificate_type_id = certificate_types.id
                GROUP BY current_certificate.id, require_certificate.certificate_type_id, require_certificate.employee_id, employees.WorkID, employees.ThaiName, certificate_types.TypeName, DATE_ADD(current_certificate.EffectiveDate,INTERVAL certificate_types.Age DAY), current_certificate.Attachment, current_certificate.AttachmentPath');
            return DataTables::of($data)
                ->editColumn('WorkID',function($data){
                    if ( NOW() > $data->ExpireDate)
                    return '<div class="text-center text-danger">'.$data->WorkID.'</div>';
                    return '<div class="text-center">'.$data->WorkID.'</div>';
                })
                ->editColumn('ThaiName',function($data){
                    if ( NOW() > $data->ExpireDate)
                    return '<div class="text-danger">'.$data->ThaiName.'</div>';
                    return '<div>'.$data->ThaiName.'</div>';
                })
                ->editColumn('TypeName',function($data){
                    if ( NOW() > $data->ExpireDate)
                    return '<div class="text-danger">'.$data->TypeName.'</div>';
                    return $data->TypeName;
                })
                ->editColumn('ExpireDate',function($data){
                    if ( NOW() > $data->ExpireDate)
                    return '<div class="text-center text-danger">'.$data->ExpireDate.'</div>';
                    return '<div class="text-center">'.$data->ExpireDate.'</div>';
                })
                ->addColumn('Attachment', function($data) {
                    if ( $data->Attachment == "" )
                    return '
                    <div class="text-center text-danger">N/A</div>';
                    return '
                    <div class="text-center">
                        <a href="'. url('storage/'.$data->AttachmentPath.$data->Attachment.'').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Show Attachment"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                    </div>';
                })
                ->rawColumns(['WorkID','ThaiName','TypeName','ExpireDate','Attachment'])
                ->make(true);
        }

        return view('employees.certificateproject',compact('project','type','employee'));

        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS current_certificate ;
                DROP TABLE IF EXISTS require_certificate ;
                DROP TABLE IF EXISTS max_cer ;
                DROP TABLE IF EXISTS add_cer ;
            ")
        );
    }

    public function certificatedestroy($id, $employeeid, $certificatetypeid)
    {
        $data = EmployeeCertificate::findOrFail($id);
        $path = $data->AttachmentPath;
        $file_path = $path.$data->Attachment;
        if ( $data->Attachment != null && \Storage::disk('public')->exists($file_path)) {
            \Storage::disk('public')->delete($file_path);
        }
        $data->delete();

        return back()->with('message','Successfully deleted the Certificate!');
    }

    public function department(Request $request)
    {
        if($request->ajax())
        {
            $data = Department::all();
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('Code', function($data) {
                    return '<div class="text-center">'.$data->Code.'</div>';
                })
                ->editColumn('DepartmentName', function($data) {
                    return '<div class="text-center">'.$data->DepartmentName.'</div>';
                })
                ->editColumn('Section', function($data) {
                    return '<div class="text-center">'.$data->Section.'</div>';
                })
                ->editColumn('Department', function($data) {
                    return '<div class="text-center">'.$data->Department.'</div>';
                })
                ->editColumn('Division', function($data) {
                    return '<div class="text-center">'.$data->Division.'</div>';
                })
                ->editColumn('Business', function($data) {
                    return '<div class="text-center">'.$data->Business.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        <button class="edit_department btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <button class="delete_department btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                    </div>
                ')
                ->rawColumns(['id','Code','DepartmentName','Section','Department','Division','Business','action'])
                ->make(true);
        }
    }

    public function departmentstore(Request $request)
    {
        $rules = array(
            'DepartmentName'=>'required',
            'Section'=>'required',
            'Department'=>'required',
            'Division'=>'required',
            'Business'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Code' => $request->Code,
            'DepartmentName' => $request->DepartmentName,
            'Section' => $request->Section,
            'Department' => $request->Department,
            'Division' => $request->Division,
            'Business' => $request->Business
        );

        Department::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function departmentedit($id)
    {
        if(request()->ajax())
        {
            $data = Department::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function departmentupdate(Request $request, Department $id)
    {
        $rules = array(
            'DepartmentName'=>'required',
            'Section'=>'required',
            'Department'=>'required',
            'Division'=>'required',
            'Business'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Code' => $request->Code,
            'DepartmentName' => $request->DepartmentName,
            'Section' => $request->Section,
            'Department' => $request->Department,
            'Division' => $request->Division,
            'Business' => $request->Business
        );

        Department::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function departmentdestroy($id)
    {
        $data = Department::findOrFail($id);
        $data->delete();
    }
}
