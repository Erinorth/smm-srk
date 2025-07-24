<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Location;
use App\Models\Item;
use App\Models\Product;
use App\Models\System;
use App\Models\Equipment;
use App\Models\Activity;
use App\Models\ProjectProduct;
use App\Models\JobActivity;
use App\Models\JobProgress;
use App\Models\PlanManHour;
use App\Models\Job;
use App\Models\Tool;
use App\Models\PMOrder;
use App\Chart;
use DB;

class TestController extends Controller
{
    public function index()
    {

        //$job = Job::where('project_id',90)->pluck('id');

        $parameter = DB::select('SELECT locations.LocationName, machines.MachineName, products.ProductName, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, Sum(progresses.Plan) AS SumOfPlan, Sum(progresses.Actual) AS SumOfActual, jobs.project_id
        FROM equipment INNER JOIN (scopes INNER JOIN (systems INNER JOIN (products INNER JOIN (machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (item_sets INNER JOIN (items INNER JOIN (jobs LEFT JOIN progresses ON jobs.id = progresses.job_id) ON items.id = jobs.item_id) ON item_sets.id = items.item_set_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON scopes.id = items.scope_id) ON equipment.id = item_sets.equipment_id
        GROUP BY locations.LocationName, machines.MachineName, products.ProductName, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, jobs.project_id
        HAVING (((jobs.project_id)=90))');

        //$parameter = DB::table('employee')->get();

        dd($parameter);
        //return $parameter;
        //echo $value;

        //print_r($value);
        /*foreach ($value as $values) {
            echo $values->TotalPlan;
        }
        foreach ($value2 as $values) {
            echo $values->Plan;
            echo $values->Actual;
        }*/

    }

    public function index2($id)
    {
        $parameter = PMOrder::where('PMOrder', $id)->first();
        dd($parameter);
    }

    public function mail()
    {
        $dropTempTables = DB::unprepared(
            DB::raw("
                DROP TABLE IF EXISTS tool_calibrate ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE tool_calibrate AS (
                SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.LocalCode, tools.Brand, tools.Model, tools.SerialNumber, tool_updates.Status, tool_calibrates.Remark, employees.EGATEmail, tool_calibrates.ExpireDate AS DueDate
                FROM ((employees
                INNER JOIN (tool_catagories
                    INNER JOIN (tools
                        INNER JOIN (tool_calibrates
                            INNER JOIN (SELECT tool_calibrates.tool_id, Max(tool_calibrates.ExpireDate) AS MaxOfExpireDate
                                FROM tool_calibrates
                                GROUP BY tool_calibrates.tool_id) AS max_calibrate
                            ON (tool_calibrates.ExpireDate = max_calibrate.MaxOfExpireDate) AND (tool_calibrates.tool_id = max_calibrate.tool_id))
                        ON tools.id = tool_calibrates.tool_id)
                    ON tool_catagories.id = tools.tool_catagory_id) ON employees.id = tools.Responsible)
                    INNER JOIN tool_updates
                    ON tools.id = tool_updates.tool_id)
                    INNER JOIN (SELECT tool_updates.tool_id, Max(tool_updates.created_at) AS MaxOfcreated_at
                        FROM tool_updates
                        GROUP BY tool_updates.tool_id) AS max_tool_update
                    ON (tool_updates.created_at = max_tool_update.MaxOfcreated_at) AND (tool_updates.tool_id = max_tool_update.tool_id)
                WHERE Status <> 'Cut Off' AND EGATEmail IS NOT NULL AND MeasuringTool = 'Yes'
                HAVING DueDate < DATE_ADD(NOW(), INTERVAL 90 DAY)
                );
            ")
        );

        $test = DB::table('tool_calibrate')->get();

        dd($test);
    }

    public function vue()
    {
        return view('test.vue');
    }
}
