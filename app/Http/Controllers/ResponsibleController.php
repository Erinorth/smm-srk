<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\JobPosition;
use DataTables;
use DB;
use Validator;
use App\Models\Project;
use App\Models\ProjectEmployeeCertificate;
use App\Models\Responsible;
use Illuminate\Http\Request;

class ResponsibleController extends Controller
{
    public function project(Request $request, $id)
    {
        $project = Project::find($id);

        $duty = JobPosition::whereNotIn('id', [1,10,11,12,13,14,15])
            ->orderBy('JobPositionName')->get();

        $employee = Employee::orderBy('ThaiName')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT responsible2.id, responsible2.JobPositionName, responsible2.TypeofJob, responsible2.ThaiName
                FROM(SELECT responsible.id, job_positions.JobPositionName, job_positions.TypeofJob, employees.ThaiName
                    FROM job_positions
                    LEFT JOIN (SELECT id, Duty, Responsible
                        FROM responsibles
                        WHERE project_id = '.$id.') AS responsible
                        LEFT JOIN employees
                        ON responsible.Responsible = employees.id
                    ON responsible.Duty = job_positions.id
                    WHERE job_positions.id NOT IN (1,4,10,11,12,13,14,15)
                    UNION
                    SELECT "" AS id, "Area Manager" AS JobPositionName, "ควบคุมงาน บริหารงาน และให้คำปรึกษา" AS TypeofJob, employees.ThaiName
                    FROM projects
                    INNER JOIN employees
                    ON projects.AreaManager = employees.id
                    WHERE projects.id = '.$id.'
                    UNION
                    SELECT "" AS id, "Planner" AS JobPositionName, "วางแผนงาน" AS TypeofJob, employees.ThaiName
                    FROM projects
                    INNER JOIN employees
                    ON projects.SiteEngineer = employees.id
                    WHERE projects.id = '.$id.') AS responsible2');
            return DataTables::of($data)
                ->editColumn('ThaiName', function($data) {
                    return '<div class="text-center">'.$data->ThaiName.'</div>';
                })
                ->editColumn('JobPositionName', function($data) {
                    return '<div class="text-center">'.$data->JobPositionName.'</div>';
                })
                ->addColumn('action', function($data) {
                    if ( $data->id == "" ) {
                        return '<div class="text-center">N/A</div>';
                    } else {
                        return '
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="'.$data->id.'" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>';
                    }
                })
                ->rawColumns(['ThaiName','JobPositionName','action'])
                ->make(true);
        }

        return view('responsible.project',compact('project','duty','employee'));
    }

    public function projectstore(Request $request)
    {
        $rules = array(
            'Duty'=>'required',
            'Responsible'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Duty' => $request->Duty,
            'Responsible' => $request->Responsible,
            'project_id' => $request->project_id
        );

        Responsible::create($form_data);

        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS max_certificate ;
                DROP TABLE IF EXISTS current_certificate ;
                DROP TABLE IF EXISTS require_certificate ;
                DROP TABLE IF EXISTS add_certificate ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE max_certificate AS (
                SELECT employee_id, certificate_type_id, Max(EffectiveDate) AS EffectiveDate
                FROM employee_certificates
                WHERE employee_certificates.employee_id = $request->Responsible
                GROUP BY employee_id, certificate_type_id
                );

            CREATE TEMPORARY TABLE current_certificate AS (
                SELECT employee_certificates.*
                FROM employee_certificates
                INNER JOIN max_certificate
                ON employee_certificates.employee_id = max_certificate.employee_id AND employee_certificates.certificate_type_id = max_certificate.certificate_type_id AND employee_certificates.EffectiveDate = max_certificate.EffectiveDate
                WHERE employee_certificates.employee_id = $request->Responsible
                );

            CREATE TEMPORARY TABLE require_certificate AS (
                SELECT *
                FROM responsible_certificates
                WHERE job_position_id = $request->Duty
                );

            CREATE TEMPORARY TABLE add_certificate AS (
                SELECT current_certificate.*
                FROM current_certificate
                INNER JOIN require_certificate
                ON current_certificate.certificate_type_id = require_certificate.certificate_type_id
                );
            ")
        );

        $addcertificate = DB::table('add_certificate')->get();
        //dd($addcertificate);

        if ( count($addcertificate) != 0 ) {
            foreach ($addcertificate as $key => $value) {
                $projectcertificate = ProjectEmployeeCertificate::where('project_id','=',$request->project_id)
                    ->where('job_position_id','=',$request->Duty)
                    ->where('employee_certificate_id','=',$value->id)
                    ->get();
                if ( count($projectcertificate) == 0 ) {

                    $form_data = array(
                        'project_id' => $request->project_id,
                        'job_position_id' => $request->Duty,
                        'employee_certificate_id' => $value->id
                    );

                    ProjectEmployeeCertificate::create($form_data);
                }
            }
        }

        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS max_certificate ;
                DROP TABLE IF EXISTS current_certificate ;
                DROP TABLE IF EXISTS require_certificate ;
                DROP TABLE IF EXISTS add_certificate ;
            ")
        );

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function projectedit($id)
    {
        if(request()->ajax())
        {
            $data = Responsible::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function projectupdate(Request $request)
    {
        $rules = array(
            'Duty'=>'required',
            'Responsible'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS require_certificate ;
            DROP TABLE IF EXISTS current_certificate ;
            DROP TABLE IF EXISTS delete_certificate ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE require_certificate AS (
                SELECT responsibles.project_id, responsibles.Responsible AS employee_id, responsible_certificates.certificate_type_id
                FROM responsibles
                INNER JOIN responsible_certificates
                ON responsibles.Duty = responsible_certificates.job_position_id
                WHERE responsibles.id = $request->hidden_id
                );

            CREATE TEMPORARY TABLE current_certificate AS (
                SELECT project_employee_certificates.id, project_employee_certificates.project_id, employee_certificates.employee_id, employee_certificates.certificate_type_id
                FROM project_employee_certificates
                INNER JOIN employee_certificates
                ON project_employee_certificates.employee_certificate_id = employee_certificates.id
                );

            CREATE TEMPORARY TABLE delete_certificate AS (
                SELECT current_certificate.id
                FROM current_certificate
                INNER JOIN require_certificate
                ON current_certificate.project_id = require_certificate.project_id AND current_certificate.employee_id = require_certificate.employee_id AND current_certificate.certificate_type_id = require_certificate.certificate_type_id
                );
            ")
        );

        $deletecertificate = DB::table('delete_certificate')->get();
        //dd($deletecertificate);

        if ( count($deletecertificate) !== 0 ) {
            foreach ($deletecertificate as $key => $value) {
                $data = ProjectEmployeeCertificate::findOrFail($value->id);
                $data->delete();
            }
        }

        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS require_certificate ;
                DROP TABLE IF EXISTS current_certificate ;
                DROP TABLE IF EXISTS delete_certificate ;
                DROP TABLE IF EXISTS max_certificate ;
                DROP TABLE IF EXISTS add_certificate ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE max_certificate AS (
                SELECT employee_id, certificate_type_id, Max(EffectiveDate) AS EffectiveDate
                FROM employee_certificates
                WHERE employee_certificates.employee_id = $request->Responsible
                GROUP BY employee_id, certificate_type_id
                );

            CREATE TEMPORARY TABLE current_certificate AS (
                SELECT employee_certificates.*
                FROM employee_certificates
                INNER JOIN max_certificate
                ON employee_certificates.employee_id = max_certificate.employee_id AND employee_certificates.certificate_type_id = max_certificate.certificate_type_id AND employee_certificates.EffectiveDate = max_certificate.EffectiveDate
                WHERE employee_certificates.employee_id = $request->Responsible
                );

            CREATE TEMPORARY TABLE require_certificate AS (
                SELECT *
                FROM responsible_certificates
                WHERE job_position_id = $request->Duty
                );

            CREATE TEMPORARY TABLE add_certificate AS (
                SELECT current_certificate.*
                FROM current_certificate
                INNER JOIN require_certificate
                ON current_certificate.certificate_type_id = require_certificate.certificate_type_id
                );
            ")
        );

        $addcertificate = DB::table('add_certificate')->get();
        //dd($addcertificate);

        if ( count($addcertificate) != 0 ) {
            foreach ($addcertificate as $key => $value) {
                $projectcertificate = ProjectEmployeeCertificate::where('project_id','=',$request->project_id)
                    ->where('job_position_id','=',$request->Duty)
                    ->where('employee_certificate_id','=',$value->id)
                    ->get();
                if ( count($projectcertificate) == 0 ) {

                    $form_data = array(
                        'project_id' => $request->project_id,
                        'job_position_id' => $request->Duty,
                        'employee_certificate_id' => $value->id
                    );

                    ProjectEmployeeCertificate::create($form_data);
                }
            }
        }

        $form_data = array(
            'Duty' => $request->Duty,
            'Responsible' => $request->Responsible
        );

        Responsible::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);

        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS max_certificate ;
            DROP TABLE IF EXISTS current_certificate ;
            DROP TABLE IF EXISTS require_certificate ;
            DROP TABLE IF EXISTS add_certificate ;
            ")
        );
    }

    public function projectdestroy($id)
    {
        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS require_certificate ;
                DROP TABLE IF EXISTS current_certificate ;
                DROP TABLE IF EXISTS delete_certificate ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE require_certificate AS (
                SELECT responsibles.project_id, responsibles.Responsible AS employee_id, responsible_certificates.certificate_type_id
                FROM responsibles
                INNER JOIN responsible_certificates
                ON responsibles.Duty = responsible_certificates.job_position_id
                WHERE responsibles.id = $id
                );

            CREATE TEMPORARY TABLE current_certificate AS (
                SELECT project_employee_certificates.id, project_employee_certificates.project_id, employee_certificates.employee_id, employee_certificates.certificate_type_id
                FROM project_employee_certificates
                INNER JOIN employee_certificates
                ON project_employee_certificates.employee_certificate_id = employee_certificates.id
                );

            CREATE TEMPORARY TABLE delete_certificate AS (
                SELECT current_certificate.id
                FROM current_certificate
                INNER JOIN require_certificate
                ON current_certificate.project_id = require_certificate.project_id AND current_certificate.employee_id = require_certificate.employee_id AND current_certificate.certificate_type_id = require_certificate.certificate_type_id
                );
            ")
        );

        $deletecertificate = DB::table('delete_certificate')->get();
        //dd($deletecertificate);

        if ( count($deletecertificate) != 0 ) {
            foreach ($deletecertificate as $key => $value) {
                $data = ProjectEmployeeCertificate::findOrFail($value->id);
                $data->delete();
            }
        }

        $data = Responsible::findOrFail($id);
        $data->delete();

        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS require_certificate ;
            DROP TABLE IF EXISTS current_certificate ;
            DROP TABLE IF EXISTS delete_certificate ;
            ")
        );
    }
}
