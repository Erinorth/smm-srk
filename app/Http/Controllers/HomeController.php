<?php

namespace App\Http\Controllers;

use App\Models\PMOrder;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $startdate = "2022-01-01";
        $enddate = "2022-01-31";

        $count_projectx = DB::select('SELECT date_count.id, date_count.Date, COUNT(date_count.Date) AS count_project
            FROM (SELECT dates.id, projects.StartDate, dates.Date, projects.FinishDate, projects.ProjectName
                FROM dates, projects
                WHERE dates.Date BETWEEN CAST("'.$startdate.'" AS DATE) AND CAST("'.$enddate.'" AS DATE)
                GROUP BY dates.id, projects.StartDate, dates.Date, projects.FinishDate, projects.ProjectName
                HAVING dates.Date BETWEEN CAST(projects.StartDate AS DATE) AND CAST(projects.FinishDate AS DATE)) AS date_count
            GROUP BY date_count.id, date_count.Date');

        $date = array();
        $count_project = array();

        if ( ! empty( $count_projectx ) ) {
            foreach ( $count_projectx as $value ){
                array_push( $date, $value->Date );
                array_push( $count_project, $value->count_project );
            }
        }

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE expensive AS (
                SELECT id
                FROM tools
                WHERE Price > 200000
                );

            CREATE TEMPORARY TABLE toolstatus AS (
                SELECT tool_updates.tool_id, tool_updates.Status
                FROM tool_updates
                INNER JOIN (SELECT tool_id, MAX(updated_at) AS MaxDate
                    FROM tool_updates
                    GROUP BY tool_id) AS max
                ON tool_updates.tool_id = max.tool_id AND tool_updates.updated_at = max.MaxDate
                );

            CREATE TEMPORARY TABLE toollist AS (
                SELECT expensive.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, DATEDIFF(NOW(),tools.RegisterDate)/365 AS Old
                FROM expensive
                    LEFT JOIN toolstatus
                    ON expensive.id = toolstatus.tool_id
                    INNER JOIN tools
                        INNER JOIN tool_catagories
                        ON tools.tool_catagory_id = tool_catagories.id
                    ON expensive.id = tools.id
                WHERE toolstatus.Status NOT IN('Cut Off','Lost')
                );

            CREATE TEMPORARY TABLE time_confirm AS (
                SELECT toollist.id, SUM(IF(expensive_tools.Hour IS NULL,0,expensive_tools.Hour)) AS Hour
                FROM toollist
                LEFT JOIN expensive_tools
                ON toollist.id = expensive_tools.tool_id
                GROUP BY toollist.id
                );

            CREATE TEMPORARY TABLE time_confirm_data AS (
                SELECT toollist.CatagoryName, toollist.RangeCapacity, toollist.Brand, toollist.Model, toollist.SerialNumber, toollist.LocalCode, toollist.DurableSupplieCode, toollist.AssetToolCode, FORMAT(time_confirm.Hour,2) AS Hour, FORMAT(time_confirm.Hour/toollist.old,2) AS UF
                FROM time_confirm
                INNER JOIN toollist
                ON time_confirm.id = toollist.id
                ORDER BY UF
                );
            ")
        );

        $expensive_tool = DB::table('time_confirm_data')->first();

        $pm_all = PMOrder::count();
        $pm_use = PMOrder::where('Status','=','ใช้งาน')->count();

        //dd($count_project);

        return view('dashboard',compact('expensive_tool','pm_all','pm_use'));
    }
}
