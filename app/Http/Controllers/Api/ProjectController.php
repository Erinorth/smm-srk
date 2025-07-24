<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use DB;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function import()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE project AS (
                SELECT *
                FROM projects
                WHERE NOW() >= DATE_ADD(StartDate,INTERVAL -3 MONTH) AND NOW() <= DATE_ADD(FinishDate,INTERVAL 3 MONTH) AND project_type_id IN (1,2,3,4,5,6,7,11,13,14)
                );
            ")
        );

        $project = DB::table('project')->get();;

        return response()->json($project);
    }

    public function project()
    {
        $project = Project::all();

        return response()->json($project);
    }
}
