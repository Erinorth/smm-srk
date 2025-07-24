<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function manhour()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE job AS (
                SELECT jobs.id, jobs.project_id, products.ProductName, locations.LocationName, machines.MachineName, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, jobs.Remark, items.SpecificName
                FROM jobs
                INNER JOIN items
                    INNER JOIN machine_sets
                        INNER JOIN locations
                        ON machine_sets.location_id = locations.id
                        INNER JOIN machines
                        ON machine_sets.machine_id = machines.id
                    ON items.machine_set_id = machine_sets.id
                    INNER JOIN item_sets
                        INNER JOIN products
                        ON item_sets.product_id = products.id
                        INNER JOIN systems
                        ON item_sets.system_id = systems.id
                        INNER JOIN equipment
                        ON item_sets.equipment_id = equipment.id
                    ON items.item_set_id = item_sets.id
                    INNER JOIN scopes
                    ON items.scope_id = scopes.id
                ON jobs.item_id = items.id
                INNER JOIN projects
                ON jobs.project_id = projects.id
                WHERE NOW() >= DATE_ADD(projects.StartDate,INTERVAL -3 MONTH) AND NOW() <= DATE_ADD(projects.FinishDate,INTERVAL 3 MONTH) AND projects.project_type_id IN (1,2,3,4,5,6,7,11,13,14)
                );
            ")
        );

        $job = DB::table('job')->get();

        return response()->json($job);
    }
}
