<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Project;

class CheckDataController extends Controller
{
    public function show(Request $request, $id)
    {
        $project = Project::find($id);

        $projectdetail = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, employees.ThaiName AS PlannerName, employees_1.ThaiName AS SiteEngineerName, employees_2.ThaiName AS AreaManagerName, projects.Status
            FROM employees AS employees_2 RIGHT JOIN (employees AS employees_1 RIGHT JOIN (employees RIGHT JOIN projects ON employees.id = projects.Planner) ON employees_1.id = projects.SiteEngineer) ON employees_2.id = projects.AreaManager
            WHERE (((projects.id)='.$id.'))');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE count_consumable AS (
                SELECT item_consumables.item_id, Count(item_consumables.consumable_id) AS CountOfconsumable_id
                FROM item_consumables
                GROUP BY item_consumables.item_id
                );

            CREATE TEMPORARY TABLE count_hazard AS (
                SELECT activities.item_id, Count(activity_hazards.hazard_id) AS CountOfhazard_id
                FROM activities INNER JOIN activity_hazards ON activities.id = activity_hazards.activity_id
                GROUP BY activities.item_id
                );

            CREATE TEMPORARY TABLE count_safetytag AS (
                SELECT safety_tags.item_id, Count(safety_tags.TagLocation) AS CountOfTagLocation
                FROM safety_tags
                GROUP BY safety_tags.item_id
                );

            CREATE TEMPORARY TABLE count_specialtool AS (
                SELECT special_tools.item_id, Count(special_tools.SpecialToolName) AS CountOfSpecialToolName
                FROM special_tools
                GROUP BY special_tools.item_id
                );

            CREATE TEMPORARY TABLE count_tool AS (
                SELECT item_tool_catagories.item_id, Count(item_tool_catagories.tool_catagory_id) AS CountOftool_catagory_id
                FROM item_tool_catagories
                GROUP BY item_tool_catagories.item_id
                );

            CREATE TEMPORARY TABLE count_workprocedure AS (
                SELECT activities.item_id, Count(work_procedures.Procedure) AS CountOfProcedure
                FROM activities INNER JOIN work_procedures ON activities.id = work_procedures.activity_id
                GROUP BY activities.item_id
                );

            CREATE TEMPORARY TABLE count_document AS (
                SELECT documents.item_id, Count(documents.DocumentName) AS CountOfDocumentName
                FROM documents
                GROUP BY documents.item_id
                );

            CREATE TEMPORARY TABLE count_qualitycontrol AS (
                SELECT quality_controls.item_id, Count(quality_controls.ControlledOperation) AS CountOfControlledOperation
                FROM quality_controls
                GROUP BY quality_controls.item_id
                );

            CREATE TEMPORARY TABLE count_sparepart AS (
                SELECT item_spare_parts.item_id, Count(item_spare_parts.spare_part_id) AS CountOfspare_part_id
                FROM item_spare_parts
                GROUP BY item_spare_parts.item_id
                );
            ")
        );
        
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, jobs.project_id, count_consumable.CountOfconsumable_id AS Consumable, count_document.CountOfDocumentName AS Document, count_hazard.CountOfhazard_id AS Hazard, count_qualitycontrol.CountOfControlledOperation AS QualityControl, count_safetytag.CountOfTagLocation AS SafetyTag, count_sparepart.CountOfspare_part_id AS SparePart, count_specialtool.CountOfSpecialToolName AS SpecialTool, count_tool.CountOftool_catagory_id AS Tool, count_workprocedure.CountOfProcedure AS WorkProcedure, machine_sets.Remark
                FROM locations INNER JOIN ((machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN ((((((((((scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) LEFT JOIN count_consumable ON items.id = count_consumable.item_id) LEFT JOIN count_document ON items.id = count_document.item_id) LEFT JOIN count_hazard ON items.id = count_hazard.item_id) LEFT JOIN count_qualitycontrol ON items.id = count_qualitycontrol.item_id) LEFT JOIN count_safetytag ON items.id = count_safetytag.item_id) LEFT JOIN count_sparepart ON items.id = count_sparepart.item_id) LEFT JOIN count_specialtool ON items.id = count_specialtool.item_id) LEFT JOIN count_tool ON items.id = count_tool.item_id) LEFT JOIN count_workprocedure ON items.id = count_workprocedure.item_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id
                WHERE (((jobs.project_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('LocationName', function($data) {
                        return '<div class="text-center">'.$data->LocationName.'</div>';
                    })
                    ->editColumn('ProductName', function($data) {
                        return '<div class="text-center">'.$data->ProductName.'</div>';
                    })
                    ->editColumn('MachineName', function($data) {
                        return '<div class="text-center">'.$data->MachineName.'//'.$data->Remark.'</div>';
                    })
                    ->editColumn('SystemName', function($data) {
                        return '<div class="text-center">'.$data->SystemName.'</div>';
                    })
                    ->editColumn('EquipmentName', function($data) {
                        return '<div class="text-center">'.$data->EquipmentName.'</div>';
                    })
                    ->editColumn('ScopeName', function($data) {
                        return '<div class="text-center">'.$data->ScopeName.'</div>';
                    })
                    ->editColumn('Consumable', function($data) {
                        return '<div class="text-center">'.$data->Consumable.'</div>';
                    })
                    ->editColumn('Hazard', function($data) {
                        return '<div class="text-center">'.$data->Hazard.'</div>';
                    })
                    ->editColumn('SparePart', function($data) {
                        return '<div class="text-center">'.$data->SparePart.'</div>';
                    })
                    ->editColumn('SafetyTag', function($data) {
                        return '<div class="text-center">'.$data->SafetyTag.'</div>';
                    })
                    ->editColumn('SpecialTool', function($data) {
                        return '<div class="text-center">'.$data->SpecialTool.'</div>';
                    })
                    ->editColumn('Tool', function($data) {
                        return '<div class="text-center">'.$data->Tool.'</div>';
                    })
                    ->editColumn('WorkProcedure', function($data) {
                        return '<div class="text-center">'.$data->WorkProcedure.'</div>';
                    })
                    ->editColumn('Document', function($data) {
                        return '<div class="text-center">'.$data->Document.'</div>';
                    })
                    ->editColumn('QualityControl', function($data) {
                        return '<div class="text-center">'.$data->QualityControl.'</div>';
                    })
                    ->rawColumns(['LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','Consumable','Hazard','SafetyTag','SpecialTool','Tool','SparePart','WorkProcedure','Document','QualityControl'])
                    ->make(true);
        }

        return view('check.show',compact('project','projectdetail'));
    }
}
