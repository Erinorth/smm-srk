<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use App\Models\Project;
use App\Models\ConfinedSpace;
use App\Models\Course;
use App\Models\Department;
use App\Models\Drone;
use App\Models\HotWork;
use App\Models\Employee;
use App\Models\Lifting;
use App\Models\Location;
use App\Models\WorkAtHight;
use App\Models\WorkAtHightWind;
use App\Models\DangerousZone;
use App\Models\HoistList;
use App\Models\HoistTesting;
use App\Models\PerformanceProject;
use App\Models\Week;
use App\Models\Participation;
use App\Models\PMOrder;
use App\Models\OnTheJobTraining;
use App\Models\Tool;
use App\Models\ToolCatagory;
use App\Models\WorkPermit;

class PrintController extends Controller
{
    public function checklist($id)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE hazardx AS (
                SELECT hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazard_controls.HazardControl, jobs.id
                FROM jobs INNER JOIN ((hazards INNER JOIN hazard_controls ON hazards.id = hazard_controls.hazard_id) INNER JOIN (activities INNER JOIN activity_hazards ON activities.id = activity_hazards.activity_id) ON hazards.id = activity_hazards.hazard_id) ON jobs.item_id = activities.item_id
                GROUP BY hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazard_controls.HazardControl, jobs.id
                HAVING (((jobs.id)=$id))
                );

            CREATE TEMPORARY TABLE count_hazard AS (
                SELECT hazardx.HazardName, Count(hazardx.HazardName) AS CountOfHazardName
                FROM hazardx
                GROUP BY hazardx.HazardName
                );

            CREATE TEMPORARY TABLE procedurex AS (
                SELECT activities.Order AS AOrder, activities.ActivityName, activities.Detail, work_procedures.Order AS POrder, work_procedures.Procedure, work_procedures.ControlledPoint, work_procedures.Class, work_procedures.Man, work_procedures.Hour, jobs.id
                FROM jobs INNER JOIN (activities INNER JOIN work_procedures ON activities.id = work_procedures.activity_id) ON jobs.item_id = activities.item_id
                WHERE (((jobs.id)=$id))
                ORDER BY activities.Order, work_procedures.Order
                );

            CREATE TEMPORARY TABLE count_procedure AS (
                SELECT procedurex.ActivityName, Count(procedurex.ActivityName) AS CountOfActivityName
                FROM procedurex
                GROUP BY procedurex.ActivityName
                );
            ")
        );

        $itemdetail = DB::select('SELECT projects.ProjectName, locations.LocationName, projects.StartDate, projects.FinishDate, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineDetail, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, jobs.Remark, jobs.id
            FROM equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (projects INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON projects.id = jobs.project_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id
            WHERE (((jobs.id)='.$id.'))');
        $procedure = DB::select('SELECT procedurex.AOrder, procedurex.ActivityName, count_procedure.CountOfActivityName, procedurex.Detail, procedurex.POrder, procedurex.Procedure, procedurex.ControlledPoint, procedurex.Class, procedurex.Man, procedurex.Hour
            FROM count_procedure INNER JOIN procedurex ON count_procedure.ActivityName = procedurex.ActivityName
            ORDER BY procedurex.AOrder, procedurex.POrder');
        $hazard = DB::select('SELECT hazardx.HazardName, count_hazard.CountOfHazardName, hazardx.KindofHazard, hazardx.Effect, hazardx.HazardControl
            FROM count_hazard INNER JOIN hazardx ON count_hazard.HazardName = hazardx.HazardName
            ORDER BY hazardx.HazardName');
        $qualitycontrol = DB::select('SELECT jobs.id, quality_controls.ControlledOperation, quality_controls.ControlledQuality, quality_controls.AcceptanceCriteria, quality_controls.RecordedDocument
            FROM jobs INNER JOIN quality_controls ON jobs.item_id = quality_controls.item_id
            WHERE (((jobs.id)='.$id.'))');
        $sparepart = DB::select('SELECT jobs.id, spare_parts.SparePartName, spare_parts.Detail, item_spare_parts.Quantity, spare_parts.Unit
            FROM jobs INNER JOIN (spare_parts INNER JOIN item_spare_parts ON spare_parts.id = item_spare_parts.spare_part_id) ON jobs.item_id = item_spare_parts.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY spare_parts.SparePartName');
        $consumable = DB::select('SELECT jobs.id, consumables.ConsumableName, consumables.Detail, item_consumables.Quantity, consumables.Unit, item_consumables.Remark
            FROM jobs INNER JOIN (consumables INNER JOIN item_consumables ON consumables.id = item_consumables.consumable_id) ON jobs.item_id = item_consumables.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY consumables.ConsumableName');
        $toolcatagory = DB::select('SELECT jobs.id, tool_catagories.CatagoryName, item_tool_catagories.Quantity, tool_catagories.Unit, item_tool_catagories.Remark
            FROM jobs INNER JOIN (tool_catagories INNER JOIN item_tool_catagories ON tool_catagories.id = item_tool_catagories.tool_catagory_id) ON jobs.item_id = item_tool_catagories.item_id
            WHERE (((jobs.id)='.$id.'))');
        $document = DB::select('SELECT documents.id, jobs.id AS jobid, documents.DocumentName, documents.DocumentCode, documents.Remark
            FROM jobs INNER JOIN documents ON jobs.item_id = documents.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY documents.DocumentName, documents.DocumentCode');
        $safetytag = DB::select('SELECT safety_tags.id, jobs.id AS jobid, safety_tags.TagLocation, safety_tags.Purpose, safety_tags.Remark
            FROM jobs INNER JOIN safety_tags ON jobs.item_id = safety_tags.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY safety_tags.TagLocation, safety_tags.Purpose');
        $specialtool = DB::select('SELECT special_tools.id, jobs.id AS jobid, special_tools.SpecialToolName, special_tools.PartName, special_tools.DrawingNumber, special_tools.Remark
            FROM jobs INNER JOIN special_tools ON jobs.item_id = special_tools.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY special_tools.SpecialToolName, special_tools.PartName, special_tools.DrawingNumber');


        return view('print.checklist',compact('itemdetail','procedure','hazard','qualitycontrol','sparepart','consumable','toolcatagory','document','safetytag','specialtool'));
    }

    public function checklist2($id)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE procedurex AS (
                SELECT activities.Order AS AOrder, activities.ActivityName, activities.Detail, work_procedures.Order AS POrder, work_procedures.Procedure, work_procedures.ControlledPoint, work_procedures.Class, work_procedures.Man, work_procedures.Hour, jobs.id
                FROM jobs INNER JOIN (activities INNER JOIN work_procedures ON activities.id = work_procedures.activity_id) ON jobs.item_id = activities.item_id
                WHERE (((jobs.id)=$id))
                ORDER BY activities.Order, work_procedures.Order
                );

            CREATE TEMPORARY TABLE count_procedure AS (
                SELECT procedurex.ActivityName, Count(procedurex.ActivityName) AS CountOfActivityName
                FROM procedurex
                GROUP BY procedurex.ActivityName
                );
            ")
        );

        $header = DB::select('SELECT locations.LocationName, machines.MachineName, machine_sets.Remark, items.SpecificName, p_m_orders.PMOrder, jobs.id
            FROM p_m_orders INNER JOIN (equipment INNER JOIN (item_sets INNER JOIN (machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) ON item_sets.id = items.item_set_id) ON equipment.id = item_sets.equipment_id) ON p_m_orders.id = jobs.p_m_order_id
            WHERE (((jobs.id)='.$id.'))');
        $procedure = DB::select('SELECT procedurex.AOrder, procedurex.ActivityName, count_procedure.CountOfActivityName, procedurex.Detail, procedurex.POrder, procedurex.Procedure, procedurex.ControlledPoint, procedurex.Class, procedurex.Man, procedurex.Hour
            FROM count_procedure INNER JOIN procedurex ON count_procedure.ActivityName = procedurex.ActivityName
            ORDER BY procedurex.AOrder, procedurex.POrder');

        return view('print.checklist2',compact('header','procedure'));
    }

    public function checklist3($id)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE hazardx AS (
                SELECT hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazard_controls.HazardControl, jobs.id
                FROM jobs INNER JOIN ((hazards INNER JOIN hazard_controls ON hazards.id = hazard_controls.hazard_id) INNER JOIN (activities INNER JOIN activity_hazards ON activities.id = activity_hazards.activity_id) ON hazards.id = activity_hazards.hazard_id) ON jobs.item_id = activities.item_id
                GROUP BY hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazard_controls.HazardControl, jobs.id
                HAVING (((jobs.id)=$id))
                );

            CREATE TEMPORARY TABLE count_hazard AS (
                SELECT hazardx.HazardName, Count(hazardx.HazardName) AS CountOfHazardName
                FROM hazardx
                GROUP BY hazardx.HazardName
                );
            ")
        );

        $itemdetail = DB::select('SELECT projects.ProjectName, locations.LocationName, projects.StartDate, projects.FinishDate, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineDetail, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, jobs.Remark, jobs.id
            FROM equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (projects INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON projects.id = jobs.project_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id
            WHERE (((jobs.id)='.$id.'))');
        $procedure = DB::select('SELECT work_procedures.Order2, work_procedures.Procedure, work_procedures.ControlledPoint, work_procedures.Class, work_procedures.Man, work_procedures.Hour
            FROM jobs INNER JOIN work_procedures ON jobs.item_id = work_procedures.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY work_procedures.Order2 ASC');
        $hazard = DB::select('SELECT hazardx.HazardName, count_hazard.CountOfHazardName, hazardx.KindofHazard, hazardx.Effect, hazardx.HazardControl
            FROM count_hazard INNER JOIN hazardx ON count_hazard.HazardName = hazardx.HazardName
            ORDER BY hazardx.HazardName');
        $qualitycontrol = DB::select('SELECT jobs.id, quality_controls.ControlledOperation, quality_controls.ControlledQuality, quality_controls.AcceptanceCriteria, quality_controls.RecordedDocument
            FROM jobs INNER JOIN quality_controls ON jobs.item_id = quality_controls.item_id
            WHERE (((jobs.id)='.$id.'))');
        $sparepart = DB::select('SELECT jobs.id, spare_parts.SparePartName, spare_parts.Detail, item_spare_parts.Quantity, spare_parts.Unit
            FROM jobs INNER JOIN (spare_parts INNER JOIN item_spare_parts ON spare_parts.id = item_spare_parts.spare_part_id) ON jobs.item_id = item_spare_parts.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY spare_parts.SparePartName');
        $consumable = DB::select('SELECT jobs.id, consumables.ConsumableName, consumables.Detail, item_consumables.Quantity, consumables.Unit
            FROM jobs INNER JOIN (consumables INNER JOIN item_consumables ON consumables.id = item_consumables.consumable_id) ON jobs.item_id = item_consumables.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY consumables.ConsumableName');
        $toolcatagory = DB::select('SELECT jobs.id, tool_catagories.CatagoryName, item_tool_catagories.Quantity, tool_catagories.Unit
            FROM jobs INNER JOIN (tool_catagories INNER JOIN item_tool_catagories ON tool_catagories.id = item_tool_catagories.tool_catagory_id) ON jobs.item_id = item_tool_catagories.item_id
            WHERE (((jobs.id)='.$id.'))');
        $document = DB::select('SELECT documents.id, jobs.id AS jobid, documents.DocumentName, documents.DocumentCode
            FROM jobs INNER JOIN documents ON jobs.item_id = documents.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY documents.DocumentName, documents.DocumentCode');
        $safetytag = DB::select('SELECT safety_tags.id, jobs.id AS jobid, safety_tags.TagLocation, safety_tags.Purpose
            FROM jobs INNER JOIN safety_tags ON jobs.item_id = safety_tags.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY safety_tags.TagLocation, safety_tags.Purpose');
        $specialtool = DB::select('SELECT special_tools.id, jobs.id AS jobid, special_tools.SpecialToolName, special_tools.PartName, special_tools.DrawingNumber
            FROM jobs INNER JOIN special_tools ON jobs.item_id = special_tools.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY special_tools.SpecialToolName, special_tools.PartName, special_tools.DrawingNumber');
        $activity = DB::select('SELECT activities.Order, activities.ActivityName, activities.Detail
            FROM jobs INNER JOIN activities ON jobs.item_id = activities.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY activities.Order ASC');


        return view('print.checklist3',compact('itemdetail','procedure','hazard','qualitycontrol','sparepart','consumable','toolcatagory','document','safetytag','specialtool','activity'));
    }

    public function checklist4($id)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE hazardx AS (
                SELECT hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazard_controls.HazardControl, jobs.id
                FROM jobs INNER JOIN ((hazards INNER JOIN hazard_controls ON hazards.id = hazard_controls.hazard_id) INNER JOIN (activities INNER JOIN activity_hazards ON activities.id = activity_hazards.activity_id) ON hazards.id = activity_hazards.hazard_id) ON jobs.item_id = activities.item_id
                GROUP BY hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazard_controls.HazardControl, jobs.id
                HAVING (((jobs.id)=$id))
                );

            CREATE TEMPORARY TABLE count_hazard AS (
                SELECT hazardx.HazardName, Count(hazardx.HazardName) AS CountOfHazardName
                FROM hazardx
                GROUP BY hazardx.HazardName
                );
            ")
        );

        $itemdetail = DB::select('SELECT projects.ProjectName, locations.LocationName, projects.StartDate, projects.FinishDate, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineDetail, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, jobs.Remark, jobs.id
            FROM equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (projects INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON projects.id = jobs.project_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id
            WHERE (((jobs.id)='.$id.'))');
        $procedure = DB::select('SELECT work_procedures.Order2, work_procedures.Procedure, work_procedures.ControlledPoint, work_procedures.Class, work_procedures.Man, work_procedures.Hour
            FROM jobs INNER JOIN work_procedures ON jobs.item_id = work_procedures.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY work_procedures.Order2 ASC');
        $hazard = DB::select('SELECT hazardx.HazardName, count_hazard.CountOfHazardName, hazardx.KindofHazard, hazardx.Effect, hazardx.HazardControl
            FROM count_hazard INNER JOIN hazardx ON count_hazard.HazardName = hazardx.HazardName
            ORDER BY hazardx.HazardName');
        $qualitycontrol = DB::select('SELECT jobs.id, quality_controls.ControlledOperation, quality_controls.ControlledQuality, quality_controls.AcceptanceCriteria, quality_controls.RecordedDocument
            FROM jobs INNER JOIN quality_controls ON jobs.item_id = quality_controls.item_id
            WHERE (((jobs.id)='.$id.'))');
        $sparepart = DB::select('SELECT jobs.id, spare_parts.SparePartName, spare_parts.Detail, item_spare_parts.Quantity, spare_parts.Unit
            FROM jobs INNER JOIN (spare_parts INNER JOIN item_spare_parts ON spare_parts.id = item_spare_parts.spare_part_id) ON jobs.item_id = item_spare_parts.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY spare_parts.SparePartName');
        $consumable = DB::select('SELECT jobs.id, consumables.ConsumableName, consumables.Detail, item_consumables.Quantity, consumables.Unit, item_consumables.Remark
            FROM jobs INNER JOIN (consumables INNER JOIN item_consumables ON consumables.id = item_consumables.consumable_id) ON jobs.item_id = item_consumables.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY consumables.ConsumableName');
        $toolcatagory = DB::select('SELECT jobs.id, tool_catagories.CatagoryName, item_tool_catagories.Quantity, tool_catagories.Unit, item_tool_catagories.Remark
            FROM jobs INNER JOIN (tool_catagories INNER JOIN item_tool_catagories ON tool_catagories.id = item_tool_catagories.tool_catagory_id) ON jobs.item_id = item_tool_catagories.item_id
            WHERE (((jobs.id)='.$id.'))');
        $document = DB::select('SELECT documents.id, jobs.id AS jobid, documents.DocumentName, documents.DocumentCode, documents.Remark
            FROM jobs INNER JOIN documents ON jobs.item_id = documents.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY documents.DocumentName, documents.DocumentCode');
        $safetytag = DB::select('SELECT safety_tags.id, jobs.id AS jobid, safety_tags.TagLocation, safety_tags.Purpose, safety_tags.Remark
            FROM jobs INNER JOIN safety_tags ON jobs.item_id = safety_tags.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY safety_tags.TagLocation, safety_tags.Purpose');
        $specialtool = DB::select('SELECT special_tools.id, jobs.id AS jobid, special_tools.SpecialToolName, special_tools.PartName, special_tools.DrawingNumber, special_tools.Remark
            FROM jobs INNER JOIN special_tools ON jobs.item_id = special_tools.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY special_tools.SpecialToolName, special_tools.PartName, special_tools.DrawingNumber');
        $activity = DB::select('SELECT activities.Order, activities.ActivityName, activities.Detail
            FROM jobs INNER JOIN activities ON jobs.item_id = activities.item_id
            WHERE (((jobs.id)='.$id.'))
            ORDER BY activities.Order ASC');


        return view('print.checklist4',compact('itemdetail','procedure','hazard','qualitycontrol','sparepart','consumable','toolcatagory','document','safetytag','specialtool','activity'));
    }

    public function confinedspace($id)
    {
        $confinedspace = ConfinedSpace::find($id);
        $i = 0;
        $j = 0;

        return view('print.confinedspace',compact('confinedspace','i','j'));
    }

    public function consumable($projectid)
    {
        $project = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer
            FROM projects
            WHERE (((projects.id)='.$projectid.'))');
        $consumable = DB::select('SELECT jobs.project_id, consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, Sum(item_consumables.Quantity) AS SumOfQuantity, consumables.Unit, item_consumables.Remark
            FROM consumables INNER JOIN (jobs INNER JOIN item_consumables ON jobs.item_id = item_consumables.item_id) ON consumables.id = item_consumables.consumable_id
            GROUP BY jobs.project_id, consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, item_consumables.Remark
            HAVING (((jobs.project_id)='.$projectid.'))
            ORDER BY consumables.ConsumableCode');
        $i = 1;

        return view('print.consumable',compact('project','consumable','i'));
    }

    public function consumablepick(Request $request)
    {
        $projectid = $request->get('project_id');
        $pmorderid = $request->get('pmorderreport');
        $group = $request->get('group');

        //dd($group);

        if ( $pmorderid == "All" ) {
            $pmorder = "All";
            if ( $group == "All" ) {
                $project = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                    FROM projects
                    GROUP BY projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                    HAVING (((projects.id)='.$projectid.'))');
                $consumable = DB::select('SELECT consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, Sum(consumable_sites.Pick) AS Pick, Sum(consumable_sites.Return) AS "Return", consumables.Cost, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price, consumable_sites.Remark, p_m_orders.project_id
                    FROM p_m_orders INNER JOIN (consumables INNER JOIN consumable_sites ON consumables.id = consumable_sites.consumable_id) ON p_m_orders.id = consumable_sites.p_m_order_id
                    WHERE p_m_orders.project_id='.$projectid.'
                    GROUP BY consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumables.Cost, consumable_sites.Remark, p_m_orders.project_id
                    ORDER BY consumables.ConsumableCode');
                $i = 1;
                $sum = DB::select('SELECT p_m_orders.project_id, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price
                    FROM p_m_orders INNER JOIN (consumables INNER JOIN consumable_sites ON consumables.id = consumable_sites.consumable_id) ON p_m_orders.id = consumable_sites.p_m_order_id
                    WHERE p_m_orders.project_id='.$projectid.'
                    GROUP BY p_m_orders.project_id');
                $x = 0;
            } else {
                if ( $group == "No Group" ) {
                    $project = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                        FROM projects
                        GROUP BY projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                        HAVING (((projects.id)='.$projectid.'))');
                    $consumable = DB::select('SELECT consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, Sum(consumable_sites.Pick) AS Pick, Sum(consumable_sites.Return) AS "Return", consumables.Cost, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price, consumable_sites.Remark, p_m_orders.project_id
                        FROM p_m_orders INNER JOIN (consumables INNER JOIN consumable_sites ON consumables.id = consumable_sites.consumable_id) ON p_m_orders.id = consumable_sites.p_m_order_id
                        WHERE p_m_orders.project_id='.$projectid.' AND consumable_sites.Group IS NULL
                        GROUP BY consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumables.Cost, consumable_sites.Remark, p_m_orders.project_id
                        ORDER BY consumables.ConsumableCode');
                    $i = 1;
                    $sum = DB::select('SELECT p_m_orders.project_id, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price
                        FROM p_m_orders INNER JOIN (consumables INNER JOIN consumable_sites ON consumables.id = consumable_sites.consumable_id) ON p_m_orders.id = consumable_sites.p_m_order_id
                        WHERE p_m_orders.project_id='.$projectid.' AND consumable_sites.Group IS NULL
                        GROUP BY p_m_orders.project_id');
                    $x = 0;
                } else {
                    $project = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                        FROM projects
                        GROUP BY projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                        HAVING (((projects.id)='.$projectid.'))');
                    $consumable = DB::select('SELECT consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, Sum(consumable_sites.Pick) AS Pick, Sum(consumable_sites.Return) AS "Return", consumables.Cost, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price, consumable_sites.Remark, p_m_orders.project_id
                        FROM p_m_orders
                        INNER JOIN consumables
                            INNER JOIN consumable_sites
                            ON consumables.id = consumable_sites.consumable_id
                        ON p_m_orders.id = consumable_sites.p_m_order_id
                        WHERE p_m_orders.project_id='.$projectid.' AND consumable_sites.Group='.$group.'
                        GROUP BY consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumables.Cost, consumable_sites.Remark, p_m_orders.project_id
                        ORDER BY consumables.ConsumableCode');
                    $i = 1;
                    $sum = DB::select('SELECT p_m_orders.project_id, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price
                        FROM p_m_orders
                        INNER JOIN consumables
                            INNER JOIN consumable_sites
                            ON consumables.id = consumable_sites.consumable_id
                        ON p_m_orders.id = consumable_sites.p_m_order_id
                        WHERE p_m_orders.project_id='.$projectid.' AND consumable_sites.Group='.$group.'
                        GROUP BY p_m_orders.project_id');
                    $x = 0;
                }
            }
        } else {
            $pmorder = PMOrder::find($pmorderid);
            if ( $group == "All" ) {
                $project = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                    FROM projects
                    GROUP BY projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                    HAVING (((projects.id)='.$projectid.'))');
                $consumable = DB::select('SELECT consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, Sum(consumable_sites.Pick) AS Pick, Sum(consumable_sites.Return) AS "Return", consumables.Cost, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price, consumable_sites.Remark, p_m_orders.project_id
                    FROM p_m_orders INNER JOIN (consumables INNER JOIN consumable_sites ON consumables.id = consumable_sites.consumable_id) ON p_m_orders.id = consumable_sites.p_m_order_id
                    WHERE p_m_orders.project_id='.$projectid.' AND consumable_sites.p_m_order_id='.$pmorderid.'
                    GROUP BY consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumables.Cost, consumable_sites.Remark, p_m_orders.project_id
                    ORDER BY consumables.ConsumableCode');
                $i = 1;
                $sum = DB::select('SELECT p_m_orders.project_id, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price
                    FROM p_m_orders INNER JOIN (consumables INNER JOIN consumable_sites ON consumables.id = consumable_sites.consumable_id) ON p_m_orders.id = consumable_sites.p_m_order_id
                    WHERE p_m_orders.project_id='.$projectid.' AND consumable_sites.p_m_order_id='.$pmorderid.'
                    GROUP BY p_m_orders.project_id');
                $x = 1;
                //dd($consumable);
            } else {
                if ( $group == "No Group" ) {
                    $project = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                        FROM projects
                        GROUP BY projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                        HAVING (((projects.id)='.$projectid.'))');
                    $consumable = DB::select('SELECT consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, Sum(consumable_sites.Pick) AS Pick, Sum(consumable_sites.Return) AS "Return", consumables.Cost, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price, consumable_sites.Remark, p_m_orders.project_id
                        FROM p_m_orders INNER JOIN (consumables INNER JOIN consumable_sites ON consumables.id = consumable_sites.consumable_id) ON p_m_orders.id = consumable_sites.p_m_order_id
                        WHERE p_m_orders.project_id='.$projectid.' AND consumable_sites.Group IS NULL AND consumable_sites.p_m_order_id='.$pmorderid.'
                        GROUP BY consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumables.Cost, consumable_sites.Remark, p_m_orders.project_id
                        ORDER BY consumables.ConsumableCode');
                    $i = 1;
                    $sum = DB::select('SELECT p_m_orders.project_id, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price
                        FROM p_m_orders INNER JOIN (consumables INNER JOIN consumable_sites ON consumables.id = consumable_sites.consumable_id) ON p_m_orders.id = consumable_sites.p_m_order_id
                        WHERE p_m_orders.project_id='.$projectid.' AND consumable_sites.Group IS NULL AND consumable_sites.p_m_order_id='.$pmorderid.'
                        GROUP BY p_m_orders.project_id');
                    $x = 1;
                } else {
                    $project = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                        FROM projects
                        GROUP BY projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer, projects.id
                        HAVING (((projects.id)='.$projectid.'))');
                    $consumable = DB::select('SELECT consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, Sum(consumable_sites.Pick) AS Pick, Sum(consumable_sites.Return) AS "Return", consumables.Cost, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price, consumable_sites.Remark, p_m_orders.project_id
                        FROM p_m_orders
                        INNER JOIN consumables
                            INNER JOIN consumable_sites
                            ON consumables.id = consumable_sites.consumable_id
                        ON p_m_orders.id = consumable_sites.p_m_order_id
                        WHERE p_m_orders.project_id='.$projectid.' AND consumable_sites.Group='.$group.' AND consumable_sites.p_m_order_id='.$pmorderid.'
                        GROUP BY consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumables.Cost, consumable_sites.Remark, p_m_orders.project_id
                        ORDER BY consumables.ConsumableCode');
                    $i = 1;
                    $sum = DB::select('SELECT p_m_orders.project_id, Sum((consumable_sites.Pick-consumable_sites.Return)*consumables.Cost) AS Price
                        FROM p_m_orders
                        INNER JOIN consumables
                            INNER JOIN consumable_sites
                            ON consumables.id = consumable_sites.consumable_id
                        ON p_m_orders.id = consumable_sites.p_m_order_id
                        WHERE p_m_orders.project_id='.$projectid.' AND consumable_sites.Group='.$group.' AND consumable_sites.p_m_order_id='.$pmorderid.'
                        GROUP BY p_m_orders.project_id');
                    $x = 1;
                }
            }
        }

        return view('print.consumablepick',compact('project','consumable','i','sum','x','pmorder'));
    }

    public function countermeasureproject($id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE risk AS (
                SELECT hazards.id, hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazards.ManPower, hazards.Contact, hazards.Procedure, hazards.Training, hazards.PPE, hazards.SafetyEquipment, hazards.Verification, hazards.SafetySign, hazard_controls.HazardControl, jobs.project_id
                FROM ((jobs INNER JOIN activities ON jobs.item_id = activities.item_id) INNER JOIN (hazards INNER JOIN activity_hazards ON hazards.id = activity_hazards.hazard_id) ON activities.id = activity_hazards.activity_id) INNER JOIN hazard_controls ON hazards.id = hazard_controls.hazard_id
                GROUP BY hazards.id, hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazards.ManPower, hazards.Contact, hazards.Procedure, hazards.Training, hazards.PPE, hazards.SafetyEquipment, hazards.Verification, hazards.SafetySign, hazard_controls.HazardControl, jobs.project_id
                HAVING (((jobs.project_id)=$id))
                );

            CREATE TEMPORARY TABLE count_hazard AS (
                SELECT risk.id, Count(risk.HazardName) AS CountOfHazardName
                FROM risk
                GROUP BY risk.id
                );

            CREATE TEMPORARY TABLE count_kindofhazard AS (
                SELECT risk.id, risk.HazardName, risk.KindofHazard, Count(risk.KindofHazard) AS CountOfKindofHazard
                FROM risk
                GROUP BY risk.id, risk.HazardName, risk.KindofHazard
                );

            CREATE TEMPORARY TABLE count_effect AS (
                SELECT risk.id, risk.HazardName, risk.KindofHazard, risk.Effect, Count(risk.Effect) AS CountOfEffect
                FROM risk
                GROUP BY risk.id, risk.HazardName, risk.KindofHazard, risk.Effect
                );
            ")
        );

        $risk = DB::select('SELECT risk.id, risk.HazardName, count_kindofhazard.CountOfKindofHazard, risk.KindofHazard, count_hazard.CountOfHazardName, Concat(risk.HazardName,risk.KindofHazard) AS CodeKindofHazard, risk.Effect, Concat(risk.HazardName,risk.KindofHazard,risk.Effect) AS CodeEffect, count_effect.CountOfEffect, risk.ManPower, risk.Contact, risk.Procedure, risk.Training, risk.PPE, risk.SafetyEquipment, risk.Verification, risk.SafetySign, risk.HazardControl
            FROM count_effect INNER JOIN (count_hazard INNER JOIN (count_kindofhazard INNER JOIN risk ON count_kindofhazard.id = risk.id) ON count_hazard.id = risk.id) ON count_effect.id = risk.id
            GROUP BY risk.id, risk.HazardName, count_kindofhazard.CountOfKindofHazard, risk.KindofHazard, count_hazard.CountOfHazardName, Concat(risk.HazardName,risk.KindofHazard), risk.Effect, Concat(risk.HazardName,risk.KindofHazard,risk.Effect), count_effect.CountOfEffect, risk.ManPower, risk.Contact, risk.Procedure, risk.Training, risk.PPE, risk.SafetyEquipment, risk.Verification, risk.SafetySign, risk.HazardControl
            ORDER BY risk.HazardName, risk.KindofHazard, risk.Effect');

        //$test = DB::table('risk')->get();
        //dd($test);

        return view('print.riskcountermeasure',compact('project','risk'));
    }

    public function crane_report(Request $request)
    {
        $project = Project::find($request->project_id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE machine_set AS (
                SELECT machine_sets.id, machine_sets.location_id, machine_sets.machine_id, machine_sets.Remark, machine_sets.SerialNumber
                FROM machine_sets
                INNER JOIN items
                    INNER JOIN jobs
                    ON items.id = jobs.item_id
                ON machine_sets.id = items.machine_set_id
                WHERE jobs.project_id = $request->project_id AND items.scope_id = 9
                GROUP BY machine_sets.id, machine_sets.location_id, machine_sets.machine_id, machine_sets.Remark, machine_sets.SerialNumber
                );
            ")
        );

        $report = DB::select('SELECT machine_set.* , locations.LocationName, machines.MachineName, crane_certificates.TestDate, crane_certificates.Result, crane_certificates.Attachment, crane_certificates.AttachmentPath, crane_certificates.id AS crane_certificate_id
            FROM machine_set
            INNER JOIN locations
            ON machine_set.location_id = locations.id
            INNER JOIN machines
            ON machine_set.machine_id = machines.id
            LEFT JOIN crane_certificates
            ON machine_set.id = crane_certificates.machine_set_id');

        return view('print.crane_report',compact('project','report'));
    }

    public function dangerouszone($id)
    {
        $dangerouszone = DangerousZone::find($id);

        return view('print.dangerouszone',compact('dangerouszone'));
    }

    public function drone($id)
    {
        $drone = Drone::find($id);

        return view('print.drone',compact('drone'));
    }

    public function factor($departmentid)
    {
        $department = Department::find($departmentid);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE factor AS (
                SELECT products.department_id, products.ProductCode, products.ProductName, products.Service, expectations.Expectation, factors.Factor
                FROM product_expectation_factors
                INNER JOIN products
                ON product_expectation_factors.product_id = products.id
                INNER JOIN expectations
                ON product_expectation_factors.expectation_id = expectations.id
                INNER JOIN factors
                ON product_expectation_factors.factor_id = factors.id
                WHERE products.department_id = $departmentid AND product_expectation_factors.Related = 'Yes'
                UNION
                SELECT products.department_id, products.ProductCode, products.ProductName, products.Service, expectations.Expectation, factors.Factor
                FROM product_expectation_factors
                INNER JOIN products
                    INNER JOIN departments
                    ON products.department_id = departments.id
                ON product_expectation_factors.product_id = products.id
                INNER JOIN expectations
                ON product_expectation_factors.expectation_id = expectations.id
                INNER JOIN factors
                ON product_expectation_factors.factor_id = factors.id
                WHERE departments.department_id = $departmentid AND product_expectation_factors.Related = 'Yes'
                );

            CREATE TEMPORARY TABLE count_productcode AS (
                SELECT factor.ProductCode, Count(factor.ProductCode) AS CountOfProductCode
                FROM factor
                GROUP BY factor.ProductCode
                );

            CREATE TEMPORARY TABLE count_expectation AS (
                SELECT factor.ProductCode, factor.Expectation, Count(factor.Expectation) AS CountOfExpectation
                FROM factor
                GROUP BY factor.ProductCode, factor.Expectation
                );
            ")
        );

        $factor = DB::select('SELECT factor.ProductCode, count_productcode.CountOfProductCode, factor.ProductName, factor.Service, factor.Expectation, count_expectation.CountOfExpectation, factor.Factor, CONCAT(factor.ProductCode,factor.Expectation) AS code_expectation
            FROM count_expectation
            INNER JOIN (count_productcode
                INNER JOIN factor
                ON count_productcode.ProductCode = factor.ProductCode)
            ON (count_expectation.Expectation = factor.Expectation) AND (count_expectation.ProductCode = factor.ProductCode)
            GROUP BY factor.ProductCode, count_productcode.CountOfProductCode, factor.ProductName, factor.Service, factor.Expectation, count_expectation.CountOfExpectation, factor.Factor, ""
            ORDER BY factor.ProductCode, factor.Expectation, factor.Factor');

        return view('print.factor',compact('department','factor'));
    }

    public function factorproject($id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE department AS (
                SELECT departments.Code, departments.Section, departments.Department, departments.Division, departments.Business
                FROM departments INNER JOIN (employees INNER JOIN projects ON employees.id = projects.AreaManager) ON departments.id = employees.department_id
                WHERE projects.id=$id
                );

            CREATE TEMPORARY TABLE product_location AS (
                SELECT item_sets.product_id, machine_sets.location_id
                FROM item_sets
                INNER JOIN items
                    INNER JOIN jobs
                    ON items.id = jobs.item_id
                    INNER JOIN machine_sets
                    ON items.machine_set_id = machine_sets.id
                ON item_sets.id = items.item_set_id
                WHERE jobs.project_id = $id
                GROUP BY item_sets.product_id, machine_sets.location_id
                );

            CREATE TEMPORARY TABLE expectation AS (
                SELECT stakeholder_projects.product_id, expectations.id AS expectation_id
                    FROM stakeholder_projects
                        INNER JOIN stakeholders
                            INNER JOIN stakeholder_expectations
                                INNER JOIN expectations
                                ON stakeholder_expectations.expectation_id = expectations.id
                            ON stakeholders.id = stakeholder_expectations.stakeholder_id
                        ON stakeholder_projects.stakeholder_id = stakeholders.id
                    WHERE stakeholder_projects.project_id = $id
                    UNION
                    SELECT product.product_id, product_stakeholder_expectations.expectation_id
                    FROM (SELECT product_id
                        FROM product_location
                        GROUP BY product_id) AS product
                    INNER JOIN product_stakeholder_expectations
                        INNER JOIN stakeholders
                        ON product_stakeholder_expectations.stakeholder_id =stakeholders.id
                    ON product.product_id = product_stakeholder_expectations.product_id
                    WHERE product_stakeholder_expectations.Related = 'Yes' AND stakeholders.stakeholder_type_id In (1,6)
                    UNION
                    SELECT product_location.product_id, product_stakeholder_expectations.expectation_id
                    FROM product_location
                    INNER JOIN product_stakeholder_expectations
                        INNER JOIN stakeholders
                        ON product_stakeholder_expectations.stakeholder_id =stakeholders.id
                    ON product_location.product_id = product_stakeholder_expectations.product_id
                    WHERE product_stakeholder_expectations.Related = 'Yes' AND stakeholders.stakeholder_type_id In (3,4) AND product_location.location_id = stakeholders.location_id
                );

            CREATE TEMPORARY TABLE factor AS (
                SELECT products.ProductCode, products.ProductName, products.Service, expectations.Expectation, factors.Factor
                FROM products
                INNER JOIN product_expectation_factors
                    INNER JOIN expectations
                    ON product_expectation_factors.expectation_id = expectations.id
                    INNER JOIN factors
                    ON product_expectation_factors.factor_id = factors.id
                    INNER JOIN expectation
                    ON product_expectation_factors.product_id = expectation.product_id AND product_expectation_factors.expectation_id = expectation.expectation_id
                ON products.id = product_expectation_factors.product_id
                );

            CREATE TEMPORARY TABLE count_productcode AS (
                SELECT factor.ProductCode, Count(factor.ProductCode) AS CountOfProductCode
                FROM factor
                GROUP BY factor.ProductCode
                );

            CREATE TEMPORARY TABLE count_expectation AS (
                SELECT factor.ProductCode, factor.Expectation, Count(factor.Expectation) AS CountOfExpectation
                FROM factor
                GROUP BY factor.ProductCode, factor.Expectation
                );
            ")
        );

        /* $test = DB::table('factor')->get();
        dd($test); */

        $factor = DB::select('SELECT factor.ProductCode, count_productcode.CountOfProductCode, factor.ProductName, factor.Service, factor.Expectation, count_expectation.CountOfExpectation, factor.Factor, CONCAT(factor.ProductCode,factor.Expectation) AS code_expectation
            FROM count_expectation
            INNER JOIN (count_productcode
                INNER JOIN factor
                ON count_productcode.ProductCode = factor.ProductCode)
            ON (count_expectation.Expectation = factor.Expectation) AND (count_expectation.ProductCode = factor.ProductCode)
            GROUP BY factor.ProductCode, count_productcode.CountOfProductCode, factor.ProductName, factor.Service, factor.Expectation, count_expectation.CountOfExpectation, factor.Factor, ""
            ORDER BY factor.ProductCode, factor.Expectation, factor.Factor');

        $department = DB::table('department')->first();

        return view('print.factorproject',compact('department','project','factor'));
    }

    public function hazard()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE hazard AS (
                SELECT hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazards.ManPower, hazards.Contact, hazards.Procedure, hazards.Training, hazards.PPE, hazards.SafetyEquipment, hazards.Verification, hazards.SafetySign, hazard_controls.HazardControl, hazard_controls.Severity, hazards.Opportunity
                FROM (hazard_controls RIGHT JOIN hazards ON hazard_controls.hazard_id = hazards.id) INNER JOIN activity_hazards ON hazards.id = activity_hazards.hazard_id
                GROUP BY hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazards.ManPower, hazards.Contact, hazards.Procedure, hazards.Training, hazards.PPE, hazards.SafetyEquipment, hazards.Verification, hazards.SafetySign, hazard_controls.HazardControl, hazard_controls.Severity, hazards.Opportunity
                );

            CREATE TEMPORARY TABLE count_hazard AS (
                SELECT hazard.HazardName, Count(hazard.HazardName) AS CountOfHazardName
                FROM hazard
                GROUP BY hazard.HazardName
                );

            CREATE TEMPORARY TABLE count_kindofhazard AS (
                SELECT hazard.HazardName, hazard.KindofHazard, Count(hazard.KindofHazard) AS CountOfKindofHazard
                FROM hazard
                GROUP BY hazard.HazardName, hazard.KindofHazard
                );
            ")
        );

        $hazard = DB::select('SELECT hazard.HazardName, count_hazard.CountOfHazardName, hazard.KindofHazard, count_kindofhazard.CountOfKindofHazard, CONCAT(hazard.HazardName,hazard.KindofHazard) AS code_kindofhazard, hazard.Effect, hazard.ManPower, hazard.Contact, hazard.Procedure, hazard.Training, hazard.PPE, hazard.SafetyEquipment, hazard.Verification, hazard.SafetySign, hazard.HazardControl, hazard.Severity, hazard.Opportunity
            FROM count_kindofhazard INNER JOIN (count_hazard INNER JOIN hazard ON count_hazard.HazardName = hazard.HazardName) ON (count_kindofhazard.KindofHazard = hazard.KindofHazard) AND (count_kindofhazard.HazardName = hazard.HazardName)
            GROUP BY hazard.HazardName, count_hazard.CountOfHazardName, hazard.KindofHazard, count_kindofhazard.CountOfKindofHazard, hazard.Effect, hazard.ManPower, hazard.Contact, hazard.Procedure, hazard.Training, hazard.PPE, hazard.SafetyEquipment, hazard.Verification, hazard.SafetySign, hazard.HazardControl, hazard.Severity, hazard.Opportunity
            ORDER BY hazard.HazardName, hazard.KindofHazard');

        return view('print.hazard',compact('hazard'));
    }

    public function history($itemid,$productid,$locationid,$machineid,$systemid,$equipmentid)
    {
        $item = DB::select('SELECT items.id, products.ProductName, locations.LocationName, machines.MachineName, machine_sets.Remark, systems.SystemName, items.SpecificName
            FROM machines INNER JOIN (systems INNER JOIN (products INNER JOIN (locations INNER JOIN (equipment INNER JOIN (machine_sets INNER JOIN (item_sets INNER JOIN items ON item_sets.id = items.item_set_id) ON machine_sets.id = items.machine_set_id) ON equipment.id = item_sets.equipment_id) ON locations.id = machine_sets.location_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON machines.id = machine_sets.machine_id
            WHERE (((items.id)='.$itemid.'))');
        $history = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, scopes.ScopeName, "" AS ActivityName, "" AS Done, m_r_conditions.Condition, m_r_countermeasures.Countermeasure, m_r_countermeasures.Remark, item_sets.product_id, machine_sets.location_id, machine_sets.machine_id, item_sets.system_id, item_sets.equipment_id
            FROM item_sets INNER JOIN (machine_sets INNER JOIN (projects INNER JOIN ((scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) INNER JOIN (m_r_conditions INNER JOIN m_r_countermeasures ON m_r_conditions.id = m_r_countermeasures.m_r_condition_id) ON jobs.id = m_r_conditions.job_id) ON projects.id = jobs.project_id) ON machine_sets.id = items.machine_set_id) ON item_sets.id = items.item_set_id
            WHERE (((item_sets.product_id)='.$productid.') AND ((machine_sets.location_id)='.$locationid.') AND ((machine_sets.machine_id)='.$machineid.') AND ((item_sets.system_id)='.$systemid.') AND ((item_sets.equipment_id)='.$equipmentid.'))
            UNION
            SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, scopes.ScopeName, activities.ActivityName, maintenance_reports.Done, m_r_conditions.Condition, m_r_countermeasures.Countermeasure, m_r_countermeasures.Remark, item_sets.product_id, machine_sets.location_id, machine_sets.machine_id, item_sets.system_id, item_sets.equipment_id
            FROM (((item_sets INNER JOIN (machine_sets INNER JOIN (projects INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON projects.id = jobs.project_id) ON machine_sets.id = items.machine_set_id) ON item_sets.id = items.item_set_id) INNER JOIN activities ON items.id = activities.item_id) INNER JOIN maintenance_reports ON activities.id = maintenance_reports.activity_id) LEFT JOIN (m_r_conditions LEFT JOIN m_r_countermeasures ON m_r_conditions.id = m_r_countermeasures.m_r_condition_id) ON maintenance_reports.id = m_r_conditions.maintenance_report_id
            WHERE (((item_sets.product_id)='.$productid.') AND ((machine_sets.location_id)='.$locationid.') AND ((machine_sets.machine_id)='.$machineid.') AND ((item_sets.system_id)='.$systemid.') AND ((item_sets.equipment_id)='.$equipmentid.'))');

        return view('print.history',compact('item','history'));
    }

    public function hoist($id)
    {
        $report = HoistTesting::find($id);
        if ($report->hoist_list_id != null) {
            $hoist = HoistList::find($report->hoist_list_id);
            $tool = null;
            $toolcatagory = null;
        } else {
            $tool = Tool::find($report->tool_id);
            $toolcatagory = ToolCatagory::find($tool->tool_catagory_id);
            $hoist = null;
        }

        return view('print.hoist',compact('hoist','report','tool','toolcatagory'));
    }

    public function hotwork($id)
    {
        $hotwork = HotWork::find($id);

        return view('print.hotwork',compact('hotwork'));
    }

    public function knowledgeskill($employeeid)
    {
        $employee = Employee::find($employeeid);
        $knowledgeskill = DB::select('SELECT knowledge_skills.id, knowledge_skills.JobPosition, knowledge_skills.TypeofJob, knowledge_skills.KnowledgeSkilled, knowledge_skills.Recorder, knowledge_skills.Approver, knowledge_skills.updated_at, knowledge_skills.employee_id
            FROM knowledge_skills
            WHERE (((knowledge_skills.employee_id)='.$employeeid.'))');
        $i = 1;

        return view('print.knowledgeskill',compact('employee','knowledgeskill','i'));
    }

    public function lawassesment(Request $request, $departmentid, $lawid)
    {
        $department = Department::find($departmentid);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE lawassesment AS (
                SELECT laws.AnnouncementDate, Concat(laws.LawName,' // ',laws.AnnouncementDate,' // ',laws.Regulator) AS LawName, law_details.LawDetail, law_assesments.Related, law_assesments.Evident, law_assesments.department_id
                FROM (laws
                INNER JOIN law_details
                ON laws.id = law_details.law_id)
                INNER JOIN law_assesments
                ON law_details.id = law_assesments.law_detail_id
                WHERE laws.id=$lawid AND law_assesments.department_id = $departmentid
                GROUP BY laws.AnnouncementDate, Concat(laws.LawName,' // ',laws.AnnouncementDate,' // ',laws.Regulator), law_details.LawDetail, law_assesments.Related, law_assesments.Evident, law_assesments.department_id
                ORDER BY LawDetail
                );
            ")
        );

        $lawassesment = DB::table('lawassesment')->get()->groupBy('LawName');

        //dd($lawassesment);

        return view('print.lawassesment',compact('department','lawassesment','departmentid'));
    }

    public function lifting($id)
    {
        $lifting = Lifting::find($id);

        return view('print.lifting',compact('lifting'));
    }

    public function mobilization(Request $request)
    {
        $mobilizationid = $request->get('id');
        $mobilizationid = implode(',', $mobilizationid);
        $startdate = date_create($request->get('startDate'));
        $enddate = date_create($request->get('endDate'));
        $datediff = date_diff($startdate,$enddate);

        $project = Project::find($request->get('project_id'));
        $department = Department::find($request->get('department'));
        $location = DB::select('SELECT locations.LocationThaiName, jobs.project_id
            FROM (locations INNER JOIN machine_sets ON locations.id = machine_sets.location_id) INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON machine_sets.id = items.machine_set_id
            GROUP BY locations.LocationThaiName, jobs.project_id
            HAVING (((jobs.project_id)='.$request->get('project_id').'))');
        $otherdepartment = DB::select('SELECT mobilization_plans.project_id, employees.department_id, departments.Section, Count(departments.Section) AS CountOfSection
            FROM departments INNER JOIN (employees INNER JOIN mobilization_plans ON employees.id = mobilization_plans.employee_id) ON departments.id = employees.department_id
            GROUP BY mobilization_plans.project_id, employees.department_id, departments.Section
            HAVING (((mobilization_plans.project_id)='.$request->get('project_id').') AND ((employees.department_id)<>'.$request->get('department').'))');
        $pmorder = PMOrder::find($request->get('pmorder'));
        $mobilization = DB::select('SELECT mobilization_plans.id, employees.ThaiName, departments.DepartmentName, mobilization_plans.StartDate, mobilization_plans.EndDate, mobilization_plans.Remark
            FROM departments INNER JOIN (employees INNER JOIN mobilization_plans ON employees.id = mobilization_plans.employee_id) ON departments.id = employees.department_id
            GROUP BY mobilization_plans.id, employees.ThaiName, departments.DepartmentName, mobilization_plans.StartDate, mobilization_plans.EndDate, mobilization_plans.Remark
            HAVING (((mobilization_plans.id) IN ('.$mobilizationid.')))');
        $controller = Employee::find($request->get('controller'));

        //$test = DB::table('count_craft')->get();
        //dd($datediff);

        return view('print.mobilization',compact('pmorder','project','department','location','otherdepartment','mobilization','startdate','enddate','datediff','controller'));
    }

    public function MR($id)
    {
        $job = DB::select('SELECT projects.ProjectName, locations.LocationName, projects.StartDate, projects.FinishDate, products.ProductName, machines.MachineName, machine_sets.Remark, systems.SystemName, items.SpecificName, scopes.ScopeName, jobs.id
            FROM equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (item_sets INNER JOIN (projects INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON projects.id = jobs.project_id) ON item_sets.id = items.item_set_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id
            GROUP BY projects.ProjectName, locations.LocationName, projects.StartDate, projects.FinishDate, products.ProductName, machines.MachineName, machine_sets.Remark, systems.SystemName, items.SpecificName, scopes.ScopeName, jobs.id
            HAVING (((jobs.id)='.$id.'))');

        $report = DB::select('SELECT maintenance_reports.Done, activities.Order, activities.ActivityName, activities.Detail, maintenance_reports.Condition, maintenance_reports.Countermeasure, maintenance_reports.Remark, maintenance_reports.job_id
        FROM activities INNER JOIN maintenance_reports ON activities.id = maintenance_reports.activity_id
        WHERE (((maintenance_reports.job_id)='.$id.'))
        ORDER BY activities.Order');

        //dd($report);

        return view('print.MR',compact('job','report'));
    }
    public function observation($id)
    {
        $observation = DB::select('SELECT observations.id, employees.ThaiName, employees.WorkID, employees.Position, departments.Section, departments.Department, departments.Division, locations.LocationName, machines.MachineName, machine_sets.Remark, products.ProductName, systems.SystemName, items.SpecificName, scopes.ScopeName, observations.Date
            FROM scopes INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (item_sets INNER JOIN (items INNER JOIN (jobs INNER JOIN (departments INNER JOIN (employees INNER JOIN observations ON employees.id = observations.Observer) ON departments.id = employees.department_id) ON jobs.id = observations.job_id) ON items.id = jobs.item_id) ON item_sets.id = items.item_set_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON scopes.id = items.scope_id
            WHERE (((observations.id)='.$id.'))');

        return view('print.observation',compact('observation'));
    }

    public function OJTevaluation($id)
    {
        $onthejobtraining = OnTheJobTraining::find($id);
        $course = Course::find($onthejobtraining->course_id);
        $evaluationdate = $onthejobtraining->EvaluationDate;
        $location = Location::find($onthejobtraining->location_id);
        $coach = Employee::find($onthejobtraining->coach_id);

        $evaluation = DB::select('SELECT on_the_job_trainings.EvaluationDate, on_the_job_trainings.course_id, on_the_job_trainings.location_id, on_the_job_trainings.coach_id, employees.WorkID, employees.ThaiName, departments.DepartmentName, employees.Position, on_the_job_trainings.Result
            FROM locations INNER JOIN ((departments INNER JOIN employees ON departments.id = employees.department_id) INNER JOIN (projects INNER JOIN (courses INNER JOIN on_the_job_trainings ON courses.id = on_the_job_trainings.course_id) ON projects.id = on_the_job_trainings.project_id) ON employees.id = on_the_job_trainings.employee_id) ON locations.id = on_the_job_trainings.location_id
            WHERE (((on_the_job_trainings.EvaluationDate)="'.$onthejobtraining->EvaluationDate.'") AND ((on_the_job_trainings.course_id)='.$onthejobtraining->course_id.') AND ((on_the_job_trainings.location_id)='.$onthejobtraining->location_id.') AND ((on_the_job_trainings.coach_id)='.$onthejobtraining->coach_id.'))
            ORDER BY employees.WorkID');
        $i = 1;

        return view('print.OJTevaluation',compact('onthejobtraining','course','evaluationdate','location','evaluation','coach','i'));
    }

    public function OJTevaluationoffice($id)
    {
        $onthejobtraining = OnTheJobTraining::find($id);
        $course = Course::find($onthejobtraining->course_id);
        $evaluationdate = $onthejobtraining->EvaluationDate;
        $coach = Employee::find($onthejobtraining->coach_id);

        $evaluation = DB::select('SELECT on_the_job_trainings.EvaluationDate, on_the_job_trainings.course_id, on_the_job_trainings.coach_id, employees.WorkID, employees.ThaiName, departments.DepartmentName, employees.Position, on_the_job_trainings.Result
            FROM (departments INNER JOIN employees ON departments.id = employees.department_id) INNER JOIN (courses INNER JOIN on_the_job_trainings ON courses.id = on_the_job_trainings.course_id) ON employees.id = on_the_job_trainings.employee_id
            WHERE (((on_the_job_trainings.EvaluationDate)="'.$onthejobtraining->EvaluationDate.'") AND ((on_the_job_trainings.course_id)='.$onthejobtraining->course_id.') AND ((on_the_job_trainings.coach_id)='.$onthejobtraining->coach_id.'))
            ORDER BY employees.WorkID');
        $i = 1;

        return view('print.OJTevaluationoffice',compact('onthejobtraining','course','evaluationdate','evaluation','coach','i'));
    }

    public function OJTMaster($departmentid)
    {
        $ojtmaster = DB::select('SELECT courses.ForDepartment, courses.CourseName, job_positions.JobPositionName, job_positions.TypeofJob, courses.CourseName
        FROM courses INNER JOIN job_positions ON courses.ForPosition = job_positions.id
        WHERE (((courses.ForDepartment)='.$departmentid.'))');
        $i = 1;

        return view('print.OJTmaster',compact('ojtmaster','i'));
    }

    public function OJTplan($departmentid,$year)
    {
        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS query1;
            DROP TABLE IF EXISTS query2;
            ")
        );

        $department = Department::find($departmentid);
        $year = $year;

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE query1 AS (
                SELECT on_the_job_trainings.project_id, projects.ProjectName, job_positions.JobPositionName, Count(job_positions.JobPositionName) AS CountOfJobPositionName, courses.CourseName, courses.Type, on_the_job_trainings.department_id, Year(projects.StartDate) AS Year
                FROM courses INNER JOIN (job_positions INNER JOIN (projects INNER JOIN on_the_job_trainings ON projects.id = on_the_job_trainings.project_id) ON job_positions.id = on_the_job_trainings.job_position_id) ON courses.id = on_the_job_trainings.course_id
                GROUP BY on_the_job_trainings.project_id, projects.ProjectName, job_positions.JobPositionName, courses.CourseName, courses.Type, on_the_job_trainings.department_id, Year(projects.StartDate)
                );

            CREATE TEMPORARY TABLE query2 AS (
                SELECT projects.id, projects.ProjectName, DATEDIFF(projects.FinishDate,projects.StartDate)+1 AS Duration
                FROM projects
                );
            ")
        );

        $plan = DB::select('SELECT query1.ProjectName, query1.JobPositionName, query1.CountOfJobPositionName, query1.CountOfJobPositionName*query2.Duration AS MD, query1.CourseName, query1.Type, query1.department_id, query1.Year
            FROM query2 INNER JOIN query1 ON query2.id = query1.project_id
            WHERE (((query1.department_id)='.$departmentid.') AND ((query1.Year)='.$year.'))
            ORDER BY query1.ProjectName, query1.JobPositionName, query1.Type');

        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS query1;
            DROP TABLE IF EXISTS query2;
            ")
        );

        return view('print.OJTplan',compact('department','year','plan'));
    }

    public function OJTrecord($employeeid)
    {
        $employee = Employee::find($employeeid);
        $ojtrecord = DB::select('SELECT on_the_job_trainings.employee_id, on_the_job_trainings.Result, job_positions.JobPositionName, job_positions.TypeofJob, projects.ProjectName, courses.CourseName, employees.ThaiName AS Recorder, employees_1.ThaiName AS Approver, on_the_job_trainings.ApprovedDate
            FROM employees AS employees_1
            INNER JOIN (employees
                INNER JOIN (courses
                    INNER JOIN (projects
                        RIGHT JOIN (job_positions
                            RIGHT JOIN on_the_job_trainings
                            ON job_positions.id = on_the_job_trainings.job_position_id)
                        ON projects.id = on_the_job_trainings.project_id)
                    ON courses.id = on_the_job_trainings.course_id)
                ON employees.id = on_the_job_trainings.Recorder)
            ON employees_1.id = on_the_job_trainings.Approver
            WHERE (((on_the_job_trainings.employee_id)='.$employeeid.') AND ((on_the_job_trainings.Result)="ผ่าน"))
            ORDER BY on_the_job_trainings.ApprovedDate');

        $i = 1;

        return view('print.OJTrecord',compact('employee','ojtrecord','i'));
    }

    public function OJTotherrecord($employeeid)
    {
        $employee = Employee::find($employeeid);
        $ojtrecord = DB::select('SELECT OJT.employee_id, OJT.Result, OJT.JobPositionName, OJT.TypeofJob, OJT.ProjectName, OJT.CourseName, OJT.Recorder, OJT.Approver, OJT.ApprovedDate
            FROM (SELECT on_the_job_trainings.employee_id, on_the_job_trainings.Result, job_positions.JobPositionName, job_positions.TypeofJob, projects.ProjectName, courses.CourseName, employees.ThaiName AS Recorder, employees_1.ThaiName AS Approver, on_the_job_trainings.ApprovedDate
                FROM employees AS employees_1
                INNER JOIN (employees
                    INNER JOIN (courses
                        INNER JOIN (projects
                            RIGHT JOIN (job_positions
                                RIGHT JOIN on_the_job_trainings
                                ON job_positions.id = on_the_job_trainings.job_position_id)
                            ON projects.id = on_the_job_trainings.project_id)
                        ON courses.id = on_the_job_trainings.course_id)
                    ON employees.id = on_the_job_trainings.Recorder)
                ON employees_1.id = on_the_job_trainings.Approver
                WHERE (((on_the_job_trainings.employee_id)='.$employeeid.') AND ((on_the_job_trainings.Result)="ผ่าน"))
                UNION
                SELECT trainings.employee_id, "ผ่าน" AS Result, "" AS JobPositionName, "เข้ารับการอบรม" AS TypeofJob, "" AS ProjectName, trainings.Course, employees.ThaiName AS Recorder, employees_1.ThaiName AS Approver, trainings.ApprovedDate
                FROM trainings
                INNER JOIN employees
                ON trainings.Recorder = employees.id
                INNER JOIN employees AS employees_1
                ON trainings.Approver = employees_1.id
                WHERE trainings.employee_id = '.$employeeid.') AS OJT
            ORDER BY OJT.ApprovedDate');

        $i = 1;

        return view('print.OJTrecord',compact('employee','ojtrecord','i'));
    }

    public function packing(Request $request)
    {
        $projectid = $request->get('project_id');
        $packingid = $request->get('PackingList');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE packings AS (
                SELECT consumables.ConsumableName AS Name, consumables.Detail, consumables.Unit, consumable_sites.Pick AS Amount, consumable_sites.Remark, consumable_sites.Packing, Sum(consumables.Cost*consumable_sites.Pick) AS Price, Sum(consumables.Weight*consumable_sites.Pick) AS Weight, p_m_orders.project_id
                FROM consumables INNER JOIN (p_m_orders INNER JOIN consumable_sites ON p_m_orders.id = consumable_sites.p_m_order_id) ON consumables.id = consumable_sites.consumable_id
                GROUP BY consumables.ConsumableName, consumables.Detail, consumables.Unit, consumable_sites.Pick, consumable_sites.Remark, consumable_sites.Packing, p_m_orders.project_id
                HAVING (((consumable_sites.Packing)='$packingid') AND ((p_m_orders.project_id)=$projectid))
                UNION
                SELECT CONCAT(tool_catagories.CatagoryName, tool_catagories.RangeCapacity) AS Name, CONCAT(tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode) AS Detail, tool_catagories.Unit, 1 AS Amount, tool_updates.Remark, tool_updates.Packing, tools.Price, tools.Weight, tool_catagory_sites.project_id
                FROM tools
                INNER JOIN (tool_catagories
                    INNER JOIN (tool_catagory_sites
                        INNER JOIN (tool_updates
                            INNER JOIN (SELECT tool_updates.tool_id, tool_updates.Status, Max(tool_updates.created_at) AS MaxOfcreated_at
                            FROM tool_updates
                            GROUP BY tool_updates.tool_id, tool_updates.Status
                            HAVING (((tool_updates.Status)='On Site'))) AS max_tool
                            ON (tool_updates.created_at = max_tool.MaxOfcreated_at) AND (tool_updates.tool_id = max_tool.tool_id))
                        ON tool_catagory_sites.id = tool_updates.tool_catagory_site_id)
                    ON tool_catagories.id = tool_catagory_sites.tool_catagory_id)
                ON tools.id = tool_updates.tool_id
                WHERE (((tool_updates.Packing)='$packingid') AND ((tool_catagory_sites.project_id)=$projectid))
                );
            ")
        );

            $project = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, projects.id
                FROM projects
                GROUP BY projects.ProjectName, projects.StartDate, projects.FinishDate, projects.id
                HAVING (((projects.id)='.$projectid.'))');
            $packing = DB::table('packings')->get();

            $i = 1;
            $sum = DB::select('SELECT Sum(packings.Price) AS SumOfPrice, Sum(packings.Weight) AS SumOfWeight
                FROM packings');

        return view('print.packing',compact('project','packingid','packing','i','sum'));
    }

    public function participation1($id)
    {
        $participation = Participation::find($id);

        $employee = DB::select('SELECT participations.id, participations.Date, employees.ThaiName
            FROM (employees INNER JOIN projects ON employees.id = projects.AreaManager) INNER JOIN participations ON projects.id = participations.project_id
            WHERE (((participations.id)='.$id.'))');

        return view('print.participation1',compact('participation','employee'));
    }

    public function participation2($id)
    {
        $participation = Participation::find($id);

        $project = DB::select('SELECT participations.id, projects.ProjectName, projects.StartDate, projects.FinishDate, employees.ThaiName AS AM, employees_1.ThaiName AS FM
            FROM employees AS employees_1 INNER JOIN (employees INNER JOIN (projects INNER JOIN participations ON projects.id = participations.project_id) ON employees.id = projects.AreaManager) ON employees_1.id = participations.Foreman
            WHERE (((participations.id)='.$id.'))');

        return view('print.participation2',compact('participation','project'));
    }

    public function pdf($id)
    {
        $confinedspace = ConfinedSpace::find($id);
        $i = 0;
        $j = 0;

        $pdf = PDF::loadView('print.confinedspace', $confinedspace);
	    return $pdf->stream();

        //return view('print.confinedspace',compact('confinedspace','i','j'));
    }

    public function performancemanhour($id)
    {
        $project = Project::find($id);

        $manhourx = DB::select('SELECT jobs.project_id, job_positions.JobPositionName, crafts.CraftName, Sum(man_hours.Normal) AS SumOfNormal, Sum(man_hours.OT1) AS SumOfOT1, Sum(man_hours.OT15) AS SumOfOT15, Sum(man_hours.OT2) AS SumOfOT2, Sum(man_hours.OT3) AS SumOfOT3
            FROM crafts INNER JOIN (job_positions INNER JOIN (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) ON job_positions.id = man_hours.job_position_id) ON crafts.id = job_positions.craft_id
            GROUP BY jobs.project_id, job_positions.JobPositionName, crafts.CraftName
            HAVING (((jobs.project_id)='.$id.'))');
        $summanhourx = DB::select('SELECT jobs.project_id, Sum(man_hours.Normal) AS SumOfNormal, Sum(man_hours.OT1) AS SumOfOT1, Sum(man_hours.OT15) AS SumOfOT15, Sum(man_hours.OT2) AS SumOfOT2, Sum(man_hours.OT3) AS SumOfOT3
            FROM crafts INNER JOIN (job_positions INNER JOIN (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) ON job_positions.id = man_hours.job_position_id) ON crafts.id = job_positions.craft_id
            GROUP BY jobs.project_id
            HAVING (((jobs.project_id)='.$id.'))');
        $allmanhour = DB::select('SELECT jobs.project_id, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS "All"
            FROM jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id
            GROUP BY jobs.project_id
            HAVING (((jobs.project_id)='.$id.'))');

        $work = DB::select('SELECT jobs.project_id, jobs.id, Sum(work_procedures.Man*work_procedures.Hour) AS Plan, actualwork.ActualWork, avrpastmahhour.AvgOfPastManHour
            FROM (jobs
                LEFT JOIN activities
                ON jobs.item_id = activities.item_id)
                LEFT JOIN work_procedures
                ON activities.id = work_procedures.activity_id
                LEFT JOIN (SELECT pastmanhour.item_id, Avg(pastmanhour.PastManHour) AS AvgOfPastManHour
                    FROM (SELECT jobs.item_id, projects.FinishDate, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS PastManHour, jobs.project_id
                        FROM projects INNER JOIN (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) ON projects.id = jobs.project_id
                        GROUP BY jobs.item_id, projects.FinishDate, jobs.project_id
                        HAVING (((projects.FinishDate)<"'.$project->StartDate.'"))) AS pastmanhour
                    GROUP BY pastmanhour.item_id) AS avrpastmahhour
                ON jobs.item_id = avrpastmahhour.item_id
                INNER JOIN (SELECT jobs.id, jobs.item_id, items.scope_id, jobs.project_id, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS ActualWork
                    FROM items RIGHT JOIN (jobs LEFT JOIN man_hours ON jobs.id = man_hours.job_id) ON items.id = jobs.item_id
                    GROUP BY jobs.id, jobs.item_id, items.scope_id, jobs.project_id
                    HAVING (((items.scope_id)<>5) AND ((jobs.project_id)='.$id.'))) AS actualwork
                ON jobs.id = actualwork.id
            GROUP BY jobs.project_id, jobs.id, actualwork.ActualWork, avrpastmahhour.AvgOfPastManHour
            HAVING (((jobs.project_id)='.$id.'))');
        $support = DB::select('SELECT support.id, SUM(support.Support) AS Support
            FROM (SELECT jobs.project_id, jobs.id, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS Support
            FROM items INNER JOIN (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) ON items.id = jobs.item_id
            GROUP BY jobs.project_id, jobs.id, items.scope_id, man_hours.job_position_id
            HAVING (((jobs.project_id)='.$id.') AND ((items.scope_id)=5) AND ((man_hours.job_position_id)<>4))) AS support
            GROUP BY support.id');
        $waiting = DB::select('SELECT jobs.project_id, jobs.id, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS Waiting
            FROM items INNER JOIN (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) ON items.id = jobs.item_id
            GROUP BY jobs.project_id, jobs.id, items.scope_id, man_hours.job_position_id
            HAVING (((jobs.project_id)='.$id.') AND ((items.scope_id)=5) AND ((man_hours.job_position_id)=4))');

        $perperson = DB::select('SELECT man_hours.employee_id, employees.WorkID, employees.ThaiName, p_m_orders.PMOrder AS JobPM, p_m_orders_1.PMOrder AS SpecificPM, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS ManHour, jobs.project_id, totalmanhour.TotalManHour
            FROM p_m_orders AS p_m_orders_1
            RIGHT JOIN (p_m_orders
                INNER JOIN (employees
                    INNER JOIN (jobs
                        INNER JOIN man_hours
                            INNER JOIN (SELECT man_hours.employee_id, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS TotalManHour, jobs.project_id
                                FROM jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id
                                GROUP BY man_hours.employee_id, jobs.project_id
                                HAVING (((jobs.project_id)='.$id.'))) AS totalmanhour
                            ON man_hours.employee_id = totalmanhour.employee_id
                        ON jobs.id = man_hours.job_id)
                    ON employees.id = man_hours.employee_id)
                ON p_m_orders.id = jobs.p_m_order_id)
            ON p_m_orders_1.id = man_hours.p_m_order_id
            GROUP BY man_hours.employee_id, employees.WorkID, employees.ThaiName, p_m_orders.PMOrder, p_m_orders_1.PMOrder, jobs.project_id, totalmanhour.TotalManHour
            HAVING (((jobs.project_id)='.$id.'))');

        /*$test = DB::select('SELECT pastmanhour.item_id, Avg(pastmanhour.PastManHour) AS AvgOfPastManHour
        FROM (SELECT jobs.item_id, projects.FinishDate, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS PastManHour, jobs.project_id
            FROM projects INNER JOIN (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) ON projects.id = jobs.project_id
            GROUP BY jobs.item_id, projects.FinishDate, jobs.project_id
            HAVING (((projects.FinishDate)<"'.$project->StartDate.'"))) AS pastmanhour
        GROUP BY pastmanhour.item_id');
        $test2 = DB::select('SELECT jobs.item_id, projects.FinishDate, Sum(man_hours.Normal+man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3) AS PastManHour, jobs.project_id
            FROM projects INNER JOIN (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) ON projects.id = jobs.project_id
            GROUP BY jobs.item_id, projects.FinishDate, jobs.project_id
            HAVING (((projects.FinishDate)<"'.$project->StartDate.'"))');
        dd($test2);*/

        return view('print.performance_manhour',compact('project','work','manhourx','summanhourx','allmanhour','support','waiting','perperson'));
    }

    public function performanceweekly($id)
    {
        $project = Project::find($id);

        $weeklyreport = PerformanceProject::where('project_id','=',$id)->get();

        //$test = DB::table('manhour')->get();
        //dd($manhour);

        return view('print.performance_weekly',compact('project','weeklyreport'));
    }

    public function planot(Request $request)
    {
        $year = $request->get('yearnumber');
        $month = $request->get('monthnumber');
        $project = Project::find($request->get('project_id'));
        $dayinmonth=cal_days_in_month(CAL_GREGORIAN,$month,$year);

        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS employee;
            DROP TABLE IF EXISTS date;
            DROP TABLE IF EXISTS main;
            DROP TABLE IF EXISTS actual;
            DROP TABLE IF EXISTS maxdateactual;
            DROP TABLE IF EXISTS plan;
            DROP TABLE IF EXISTS frame;
            DROP TABLE IF EXISTS combine;
            DROP TABLE IF EXISTS result;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE employee AS (
                SELECT employee_id
                FROM (SELECT employee_id
                    FROM plan_o_t_s
                    WHERE YEAR(PlanDate) = $year AND MONTH(PlanDate) = $month AND project_id = $project->id
                    GROUP BY employee_id
                    UNION
                    SELECT employee_id
                    FROM (SELECT man_hours.employee_id, man_hours.WorkingDate, jobs.project_id
                        FROM man_hours
                        INNER JOIN jobs
                        ON man_hours.job_id = jobs.id) AS man_hour
                    WHERE YEAR(man_hour.WorkingDate) = $year AND MONTH(man_hour.WorkingDate) = $month AND man_hour.project_id = $project->id
                    GROUP BY employee_id) AS employee
                GROUP BY employee_id
                );

            CREATE TEMPORARY TABLE date AS (
                SELECT Date
                FROM dates
                WHERE YEAR(Date) = $year AND MONTH(Date) = $month
                );

            CREATE TEMPORARY TABLE main AS (
                SELECT date.Date, employee.employee_id
                FROM date
                CROSS JOIN employee
                );

            CREATE TEMPORARY TABLE actual AS (
                SELECT t.Date, t.employee_id, SUM(t.ActualOT) AS ActualOT, t.project_id
                FROM (SELECT main.Date, main.employee_id, SUM(man_hours.ot1+man_hours.ot15+man_hours.ot2+man_hours.ot3) AS ActualOT, jobs.project_id
                    FROM man_hours
                    RIGHT JOIN main
                    ON man_hours.employee_id = main.employee_id AND man_hours.WorkingDate = main.Date
                    LEFT JOIN jobs
                    ON man_hours.job_id = jobs.id
                    GROUP BY main.Date, main.employee_id, jobs.project_id
                    UNION
                    SELECT Date_ADD(support_men.StartDate, INTERVAL -1 DAY) AS Date, support_men.employee_id, SUM(support_men.OT) AS ActualOT, 0 AS project_id
                    FROM support_men
                    INNER JOIN support_requests
                    ON support_men.support_request_id = support_requests.id
                    GROUP BY Date_ADD(support_men.StartDate, INTERVAL -1 DAY), support_men.employee_id, support_requests.project_id) t
                GROUP BY t.Date, t.employee_id, t.project_id
                );

            CREATE TEMPORARY TABLE maxdateactual AS (
                SELECT employee.employee_id, IF(t.MaxActualDate >= t2.MaxWeek,t.MaxActualDate,t2.MaxWeek) AS MaxActualDate
                FROM employee
                LEFT JOIN (SELECT employee_id, MAX(WorkingDate) AS MaxActualDate
                    FROM man_hours
                    WHERE YEAR(NOW()) = Year(WorkingDate) AND MONTH(NOW()) = MONTH(WorkingDate)
                    GROUP BY employee_id) t
                ON employee.employee_id = t.employee_id
                JOIN (SELECT Date AS MaxWeek
                    FROM dates
                    WHERE YEAR(DATE_ADD(NOW(), INTERVAL -1 WEEK)) = Year AND WEEK(DATE_ADD(NOW(), INTERVAL -1 WEEK)) = Week AND DayofWeek = 7 ) t2
                );

            CREATE TEMPORARY TABLE plan AS (
                SELECT main.Date, main.employee_id, SUM(plan_o_t_s.PlanHour) AS PlanOT, plan_o_t_s.project_id, plan_o_t_s.Remark
                FROM plan_o_t_s
                RIGHT JOIN main
                ON plan_o_t_s.employee_id = main.employee_id AND plan_o_t_s.PlanDate = main.Date
                GROUP BY main.Date, main.employee_id, plan_o_t_s.project_id, plan_o_t_s.Remark
                );

            CREATE TEMPORARY TABLE frame AS (
                SELECT o_t_frames.employee_id, o_t_frames.Frame, o_t_frames.updated_at
                FROM o_t_frames
                INNER JOIN employee
                ON o_t_frames.employee_id = employee.employee_id
                WHERE o_t_frames.Month = $month
                );

            CREATE TEMPORARY TABLE combine AS (
                SELECT main.Date, actual.employee_id, plan.PlanOT, actual.ActualOT, maxdateactual.MaxActualDate, plan.project_id AS PlanProject, actual.project_id AS ActualProject, plan.Remark, frame.Frame, DAY(frame.updated_at) AS UpdateFrame
                FROM main
                LEFT JOIN actual
                ON main.Date = actual.Date AND main.employee_id = actual.employee_id
                LEFT JOIN plan
                ON main.Date = plan.Date AND main.employee_id = plan.employee_id
                LEFT JOIN maxdateactual
                ON main.employee_id = maxdateactual.employee_id
                LEFT JOIN frame
                ON main.employee_id = frame.employee_id
                ORDER BY main.Date, actual.employee_id
                );

            CREATE TEMPORARY TABLE result AS (
                SELECT combine.Date, combine.employee_id, employees.WorkID, employees.ThaiName, combine.MaxActualDate, combine.Frame, combine.UpdateFrame,
                    IF(combine.Date <= combine.MaxActualDate,
                        combine.ActualOT,
                        combine.PlanOT
                    ) AS OT,
                    IF(combine.ActualProject IS NOT NULL,
                        combine.ActualProject,
                        combine.PlanProject
                    ) AS Project
                FROM combine
                    INNER JOIN employees
                    ON combine.employee_id = employees.id
                );
            ")
        );

        $plan = DB::select('SELECT result.WorkID, result.ThaiName, SUM(result.OT) AS TotalOT, result.Frame, result.UpdateFrame, DAY(result.MaxActualDate) AS MaxActualDate, sumactual.SumActual,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 1) THEN result.OT ELSE "0" END) AS Plan1,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 1) THEN result.Project ELSE "-" END) AS Project1,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 2) THEN result.OT ELSE "0" END) AS Plan2,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 2) THEN result.Project ELSE "-" END) AS Project2,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 3) THEN result.OT ELSE "0" END) AS Plan3,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 3) THEN result.Project ELSE "-" END) AS Project3,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 4) THEN result.OT ELSE "0" END) AS Plan4,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 4) THEN result.Project ELSE "-" END) AS Project4,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 5) THEN result.OT ELSE "0" END) AS Plan5,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 5) THEN result.Project ELSE "-" END) AS Project5,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 6) THEN result.OT ELSE "0" END) AS Plan6,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 6) THEN result.Project ELSE "-" END) AS Project6,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 7) THEN result.OT ELSE "0" END) AS Plan7,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 7) THEN result.Project ELSE "-" END) AS Project7,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 8) THEN result.OT ELSE "0" END) AS Plan8,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 8) THEN result.Project ELSE "-" END) AS Project8,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 9) THEN result.OT ELSE "0" END) AS Plan9,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 9) THEN result.Project ELSE "-" END) AS Project9,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 10) THEN result.OT ELSE "0" END) AS Plan10,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 10) THEN result.Project ELSE "-" END) AS Project10,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 11) THEN result.OT ELSE "0" END) AS Plan11,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 11) THEN result.Project ELSE "-" END) AS Project11,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 12) THEN result.OT ELSE "0" END) AS Plan12,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 12) THEN result.Project ELSE "-" END) AS Project12,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 13) THEN result.OT ELSE "0" END) AS Plan13,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 13) THEN result.Project ELSE "-" END) AS Project13,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 14) THEN result.OT ELSE "0" END) AS Plan14,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 14) THEN result.Project ELSE "-" END) AS Project14,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 15) THEN result.OT ELSE "0" END) AS Plan15,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 15) THEN result.Project ELSE "-" END) AS Project15,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 16) THEN result.OT ELSE "0" END) AS Plan16,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 16) THEN result.Project ELSE "-" END) AS Project16,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 17) THEN result.OT ELSE "0" END) AS Plan17,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 17) THEN result.Project ELSE "-" END) AS Project17,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 18) THEN result.OT ELSE "0" END) AS Plan18,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 18) THEN result.Project ELSE "-" END) AS Project18,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 19) THEN result.OT ELSE "0" END) AS Plan19,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 19) THEN result.Project ELSE "-" END) AS Project19,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 20) THEN result.OT ELSE "0" END) AS Plan20,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 20) THEN result.Project ELSE "-" END) AS Project20,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 21) THEN result.OT ELSE "0" END) AS Plan21,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 21) THEN result.Project ELSE "-" END) AS Project21,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 22) THEN result.OT ELSE "0" END) AS Plan22,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 22) THEN result.Project ELSE "-" END) AS Project22,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 23) THEN result.OT ELSE "0" END) AS Plan23,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 23) THEN result.Project ELSE "-" END) AS Project23,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 24) THEN result.OT ELSE "0" END) AS Plan24,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 24) THEN result.Project ELSE "-" END) AS Project24,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 25) THEN result.OT ELSE "0" END) AS Plan25,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 25) THEN result.Project ELSE "-" END) AS Project25,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 26) THEN result.OT ELSE "0" END) AS Plan26,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 26) THEN result.Project ELSE "-" END) AS Project26,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 27) THEN result.OT ELSE "0" END) AS Plan27,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 27) THEN result.Project ELSE "-" END) AS Project27,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 28) THEN result.OT ELSE "0" END) AS Plan28,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 28) THEN result.Project ELSE "-" END) AS Project28,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 29) THEN result.OT ELSE "0" END) AS Plan29,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 29) THEN result.Project ELSE "-" END) AS Project29,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 30) THEN result.OT ELSE "0" END) AS Plan30,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 30) THEN result.Project ELSE "-" END) AS Project30,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 31) THEN result.OT ELSE "0" END) AS Plan31,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 31) THEN result.Project ELSE "-" END) AS Project31
            FROM result
            LEFT JOIN (SELECT employee_id, SUM(OT) AS SumActual
                FROM result
                WHERE Date <= MaxActualDate
                GROUP BY employee_id) AS sumactual
            ON result.employee_id = sumactual.employee_id
            GROUP BY result.WorkID, result.ThaiName, result.Frame, result.UpdateFrame, result.MaxActualDate, sumactual.SumActual');

        $allproject = DB::select('SELECT projects.id, projects.ProjectName
            FROM result
                INNER JOIN projects
                ON result.Project = projects.id
            GROUP BY projects.id, projects.ProjectName');

        /* $test = DB::table('maxdateactual')->get();
        dd($test); */

        return view('print.planot',compact('plan','year','month','project','dayinmonth','allproject'));

        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS employee;
            DROP TABLE IF EXISTS date;
            DROP TABLE IF EXISTS main;
            DROP TABLE IF EXISTS actual;
            DROP TABLE IF EXISTS maxdateactual;
            DROP TABLE IF EXISTS plan;
            DROP TABLE IF EXISTS frame;
            DROP TABLE IF EXISTS combine;
            DROP TABLE IF EXISTS result;
            ")
        );
    }

    /* public function planot16(Request $request)
    {
        $year = $request->get('yearnumber');
        $month = $request->get('monthnumber');
        $project = Project::find($request->get('project_id'));
        $dayinmonth=cal_days_in_month(CAL_GREGORIAN,$month,$year);
        $employee_id = $request->get('employee_16');
        $employee_id = implode(',', $employee_id);

        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS employee;
            DROP TABLE IF EXISTS date;
            DROP TABLE IF EXISTS main;
            DROP TABLE IF EXISTS actual;
            DROP TABLE IF EXISTS maxdateactual;
            DROP TABLE IF EXISTS plan;
            DROP TABLE IF EXISTS frame;
            DROP TABLE IF EXISTS combine;
            DROP TABLE IF EXISTS result;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE employee AS (
                SELECT employee_id
                FROM (SELECT employee_id
                    FROM plan_o_t_s
                    WHERE YEAR(PlanDate) = $year AND MONTH(PlanDate) = $month AND project_id = $project->id AND plan_o_t_s.employee_id IN ($employee_id)
                    GROUP BY employee_id
                    UNION
                    SELECT employee_id
                    FROM (SELECT man_hours.employee_id, man_hours.WorkingDate, jobs.project_id
                        FROM man_hours
                        INNER JOIN jobs
                        ON man_hours.job_id = jobs.id) AS man_hour
                    WHERE YEAR(man_hour.WorkingDate) = $year AND MONTH(man_hour.WorkingDate) = $month AND man_hour.project_id = $project->id AND man_hours.employee_id IN ($employee_id)
                    GROUP BY employee_id) AS employee
                GROUP BY employee_id
                );

            CREATE TEMPORARY TABLE date AS (
                SELECT Date
                FROM dates
                WHERE YEAR(Date) = $year AND MONTH(Date) = $month
                );

            CREATE TEMPORARY TABLE main AS (
                SELECT date.Date, employee.employee_id
                FROM date
                CROSS JOIN employee
                );

            CREATE TEMPORARY TABLE actual AS (
                SELECT t.Date, t.employee_id, SUM(t.ActualOT) AS ActualOT, t.project_id
                FROM (SELECT main.Date, main.employee_id, SUM(man_hours.ot1+man_hours.ot15+man_hours.ot2+man_hours.ot3) AS ActualOT, jobs.project_id
                    FROM man_hours
                    RIGHT JOIN main
                    ON man_hours.employee_id = main.employee_id AND man_hours.WorkingDate = main.Date
                    LEFT JOIN jobs
                    ON man_hours.job_id = jobs.id
                    GROUP BY main.Date, main.employee_id, jobs.project_id
                    UNION
                    SELECT Date_ADD(support_men.StartDate, INTERVAL -1 DAY) AS Date, support_men.employee_id, SUM(support_men.OT) AS ActualOT, 0 AS project_id
                    FROM support_men
                    INNER JOIN support_requests
                    ON support_men.support_request_id = support_requests.id
                    GROUP BY Date_ADD(support_men.StartDate, INTERVAL -1 DAY), support_men.employee_id, support_requests.project_id) t
                GROUP BY t.Date, t.employee_id, t.project_id
                );

            CREATE TEMPORARY TABLE maxdateactual AS (
                SELECT employee.employee_id, IF(t.MaxActualDate >= t2.MaxWeek,t.MaxActualDate,t2.MaxWeek) AS MaxActualDate
                FROM employee
                LEFT JOIN (SELECT employee_id, MAX(WorkingDate) AS MaxActualDate
                    FROM man_hours
                    WHERE YEAR(NOW()) = Year(WorkingDate) AND MONTH(NOW()) = MONTH(WorkingDate)
                    GROUP BY employee_id) t
                ON employee.employee_id = t.employee_id
                JOIN (SELECT Date AS MaxWeek
                    FROM dates
                    WHERE YEAR(DATE_ADD(NOW(), INTERVAL -1 WEEK)) = Year AND WEEK(DATE_ADD(NOW(), INTERVAL -1 WEEK)) = Week AND DayofWeek = 7 ) t2
                );

            CREATE TEMPORARY TABLE plan AS (
                SELECT main.Date, main.employee_id, SUM(plan_o_t_s.PlanHour) AS PlanOT, plan_o_t_s.project_id, plan_o_t_s.Remark
                FROM plan_o_t_s
                RIGHT JOIN main
                ON plan_o_t_s.employee_id = main.employee_id AND plan_o_t_s.PlanDate = main.Date
                GROUP BY main.Date, main.employee_id, plan_o_t_s.project_id, plan_o_t_s.Remark
                );

            CREATE TEMPORARY TABLE frame AS (
                SELECT o_t_frames.employee_id, o_t_frames.Frame, o_t_frames.updated_at
                FROM o_t_frames
                INNER JOIN employee
                ON o_t_frames.employee_id = employee.employee_id
                WHERE o_t_frames.Month = $month
                );

            CREATE TEMPORARY TABLE combine AS (
                SELECT main.Date, actual.employee_id, plan.PlanOT, actual.ActualOT, maxdateactual.MaxActualDate, plan.project_id AS PlanProject, actual.project_id AS ActualProject, plan.Remark, frame.Frame, DAY(frame.updated_at) AS UpdateFrame
                FROM main
                LEFT JOIN actual
                ON main.Date = actual.Date AND main.employee_id = actual.employee_id
                LEFT JOIN plan
                ON main.Date = plan.Date AND main.employee_id = plan.employee_id
                LEFT JOIN maxdateactual
                ON main.employee_id = maxdateactual.employee_id
                LEFT JOIN frame
                ON main.employee_id = frame.employee_id
                ORDER BY main.Date, actual.employee_id
                );

            CREATE TEMPORARY TABLE result AS (
                SELECT combine.Date, combine.employee_id, employees.WorkID, employees.ThaiName, combine.MaxActualDate, combine.Frame, combine.UpdateFrame,
                    IF(combine.Date <= combine.MaxActualDate,
                        combine.ActualOT,
                        combine.PlanOT
                    ) AS OT,
                    IF(combine.ActualProject IS NOT NULL,
                        combine.ActualProject,
                        combine.PlanProject
                    ) AS Project
                FROM combine
                    INNER JOIN employees
                    ON combine.employee_id = employees.id
                );
            ")
        );

        $plan = DB::select('SELECT result.WorkID, result.ThaiName, SUM(result.OT) AS TotalOT, result.Frame, result.UpdateFrame, DAY(result.MaxActualDate) AS MaxActualDate, sumactual.SumActual,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 1) THEN result.OT ELSE "0" END) AS Plan1,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 1) THEN result.Project ELSE "-" END) AS Project1,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 2) THEN result.OT ELSE "0" END) AS Plan2,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 2) THEN result.Project ELSE "-" END) AS Project2,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 3) THEN result.OT ELSE "0" END) AS Plan3,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 3) THEN result.Project ELSE "-" END) AS Project3,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 4) THEN result.OT ELSE "0" END) AS Plan4,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 4) THEN result.Project ELSE "-" END) AS Project4,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 5) THEN result.OT ELSE "0" END) AS Plan5,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 5) THEN result.Project ELSE "-" END) AS Project5,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 6) THEN result.OT ELSE "0" END) AS Plan6,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 6) THEN result.Project ELSE "-" END) AS Project6,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 7) THEN result.OT ELSE "0" END) AS Plan7,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 7) THEN result.Project ELSE "-" END) AS Project7,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 8) THEN result.OT ELSE "0" END) AS Plan8,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 8) THEN result.Project ELSE "-" END) AS Project8,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 9) THEN result.OT ELSE "0" END) AS Plan9,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 9) THEN result.Project ELSE "-" END) AS Project9,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 10) THEN result.OT ELSE "0" END) AS Plan10,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 10) THEN result.Project ELSE "-" END) AS Project10,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 11) THEN result.OT ELSE "0" END) AS Plan11,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 11) THEN result.Project ELSE "-" END) AS Project11,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 12) THEN result.OT ELSE "0" END) AS Plan12,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 12) THEN result.Project ELSE "-" END) AS Project12,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 13) THEN result.OT ELSE "0" END) AS Plan13,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 13) THEN result.Project ELSE "-" END) AS Project13,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 14) THEN result.OT ELSE "0" END) AS Plan14,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 14) THEN result.Project ELSE "-" END) AS Project14,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 15) THEN result.OT ELSE "0" END) AS Plan15,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 15) THEN result.Project ELSE "-" END) AS Project15,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 16) THEN result.OT ELSE "0" END) AS Plan16,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 16) THEN result.Project ELSE "-" END) AS Project16,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 17) THEN result.OT ELSE "0" END) AS Plan17,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 17) THEN result.Project ELSE "-" END) AS Project17,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 18) THEN result.OT ELSE "0" END) AS Plan18,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 18) THEN result.Project ELSE "-" END) AS Project18,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 19) THEN result.OT ELSE "0" END) AS Plan19,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 19) THEN result.Project ELSE "-" END) AS Project19,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 20) THEN result.OT ELSE "0" END) AS Plan20,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 20) THEN result.Project ELSE "-" END) AS Project20,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 21) THEN result.OT ELSE "0" END) AS Plan21,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 21) THEN result.Project ELSE "-" END) AS Project21,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 22) THEN result.OT ELSE "0" END) AS Plan22,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 22) THEN result.Project ELSE "-" END) AS Project22,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 23) THEN result.OT ELSE "0" END) AS Plan23,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 23) THEN result.Project ELSE "-" END) AS Project23,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 24) THEN result.OT ELSE "0" END) AS Plan24,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 24) THEN result.Project ELSE "-" END) AS Project24,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 25) THEN result.OT ELSE "0" END) AS Plan25,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 25) THEN result.Project ELSE "-" END) AS Project25,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 26) THEN result.OT ELSE "0" END) AS Plan26,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 26) THEN result.Project ELSE "-" END) AS Project26,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 27) THEN result.OT ELSE "0" END) AS Plan27,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 27) THEN result.Project ELSE "-" END) AS Project27,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 28) THEN result.OT ELSE "0" END) AS Plan28,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 28) THEN result.Project ELSE "-" END) AS Project28,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 29) THEN result.OT ELSE "0" END) AS Plan29,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 29) THEN result.Project ELSE "-" END) AS Project29,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 30) THEN result.OT ELSE "0" END) AS Plan30,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 30) THEN result.Project ELSE "-" END) AS Project30,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 31) THEN result.OT ELSE "0" END) AS Plan31,
            MAX(CASE WHEN (DAYOFMONTH(result.Date) = 31) THEN result.Project ELSE "-" END) AS Project31
            FROM result
            LEFT JOIN (SELECT employee_id, SUM(OT) AS SumActual
                FROM result
                WHERE Date <= MaxActualDate
                GROUP BY employee_id) AS sumactual
            ON result.employee_id = sumactual.employee_id
            GROUP BY result.WorkID, result.ThaiName, result.Frame, result.UpdateFrame, result.MaxActualDate, sumactual.SumActual');

        $allproject = DB::select('SELECT projects.id, projects.ProjectName
            FROM result
                INNER JOIN projects
                ON result.Project = projects.id
            GROUP BY projects.id, projects.ProjectName');

        $test = DB::table('maxdateactual')->get();
        dd($test);

        return view('print.planot16',compact('plan','year','month','project','dayinmonth','allproject'));

        $dropTempTables = DB::unprepared(DB::raw("
            DROP TABLE IF EXISTS employee;
            DROP TABLE IF EXISTS date;
            DROP TABLE IF EXISTS main;
            DROP TABLE IF EXISTS actual;
            DROP TABLE IF EXISTS maxdateactual;
            DROP TABLE IF EXISTS plan;
            DROP TABLE IF EXISTS frame;
            DROP TABLE IF EXISTS combine;
            DROP TABLE IF EXISTS result;
            ")
        );
    } */

    public function product($departmentid)
    {
        $department = Department::find($departmentid);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE product AS (
                SELECT products.id, products.ProductCode, products.ProductName, products.Service, stakeholders.StakeholderName, stakeholder_types.TypeName, expectations.Expectation, product_stakeholder_expectations.Related
                FROM product_stakeholder_expectations
                INNER JOIN products
                ON product_stakeholder_expectations.product_id = products.id
                INNER JOIN stakeholders
                    INNER JOIN stakeholder_types
                    ON stakeholders.stakeholder_type_id = stakeholder_types.id
                ON product_stakeholder_expectations.stakeholder_id = stakeholders.id
                INNER JOIN expectations
                ON product_stakeholder_expectations.expectation_id = expectations.id
                WHERE products.department_id = $department->id AND product_stakeholder_expectations.Related = 'Yes'
                UNION
                SELECT products.id, products.ProductCode, products.ProductName, products.Service, stakeholders.StakeholderName, stakeholder_types.TypeName, expectations.Expectation, product_stakeholder_expectations.Related
                FROM product_stakeholder_expectations
                INNER JOIN products
                    INNER JOIN departments
                    ON products.department_id = departments.id
                ON product_stakeholder_expectations.product_id = products.id
                INNER JOIN stakeholders
                    INNER JOIN stakeholder_types
                    ON stakeholders.stakeholder_type_id = stakeholder_types.id
                ON product_stakeholder_expectations.stakeholder_id = stakeholders.id
                INNER JOIN expectations
                ON product_stakeholder_expectations.expectation_id = expectations.id
                WHERE departments.department_id = $department->id AND product_stakeholder_expectations.Related = 'Yes'
                );

            CREATE TEMPORARY TABLE count_productcode AS (
                SELECT product.id, Count(product.ProductCode) AS CountOfProductCode
                FROM product
                GROUP BY product.id
                );

            CREATE TEMPORARY TABLE count_stakeholder AS (
                SELECT product.id, product.StakeholderName, Count(product.StakeholderName) AS CountOfStakeholderName
                FROM product
                GROUP BY product.id, product.StakeholderName
                );
            ")
        );

        $product = DB::select('SELECT product.id, product.ProductCode, count_productcode.CountOfProductCode, product.ProductName, product.Service, CONCAT(product.TypeName," - ",product.StakeholderName) AS StakeholderName, count_stakeholder.CountOfStakeholderName, product.Expectation, Concat(product.ProductCode,product.TypeName,product.StakeholderName) AS code_stakeholder
            FROM count_stakeholder
            INNER JOIN (count_productcode
                INNER JOIN product
                ON count_productcode.id = product.id)
            ON (count_stakeholder.StakeholderName = product.StakeholderName) AND (count_stakeholder.id = product.id)
            GROUP BY product.id, product.ProductCode, count_productcode.CountOfProductCode, product.ProductName, product.Service, CONCAT(product.TypeName," - ",product.StakeholderName), count_stakeholder.CountOfStakeholderName, product.Expectation, Concat(product.ProductCode,product.TypeName,product.StakeholderName)
            ORDER BY product.ProductCode, product.ProductName, CONCAT(product.TypeName," - ",product.StakeholderName), product.Expectation');

        /* $test = DB::select('SELECT departments.id
            FROM departments
            INNER JOIN ( SELECT departments.id, departments.department_id
                FROM departments) AS lower_department
            ON departments.id = lower_department.department_id
            WHERE departments.id = 1');
        dd($test); */

        return view('print.product',compact('department','product'));
    }

    public function risk($jobid)
    {
        $job = DB::select('SELECT jobs.id, projects.ProjectName, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark, systems.SystemName, equipment.EquipmentName, scopes.ScopeName
            FROM machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (projects INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON projects.id = jobs.project_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id
            WHERE (((jobs.id)='.$jobid.'))');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE risk AS (
                SELECT jobs.id, activities.Order, activities.ActivityName, hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazard_controls.Severity, hazards.ManPower, hazards.Contact, hazards.Procedure, hazards.Training, hazards.PPE, hazards.SafetyEquipment, hazards.Verification, hazards.SafetySign, hazard_controls.HazardControl, hazards.Opportunity
                FROM (hazard_controls RIGHT JOIN hazards ON hazard_controls.hazard_id = hazards.id) INNER JOIN (((jobs INNER JOIN items ON jobs.item_id = items.id) INNER JOIN activities ON items.id = activities.item_id) INNER JOIN activity_hazards ON activities.id = activity_hazards.activity_id) ON hazards.id = activity_hazards.hazard_id
                GROUP BY jobs.id, activities.Order, activities.ActivityName, hazards.HazardName, hazard_controls.KindofHazard, hazard_controls.Effect, hazard_controls.Severity, hazards.ManPower, hazards.Contact, hazards.Procedure, hazards.Training, hazards.PPE, hazards.SafetyEquipment, hazards.Verification, hazards.SafetySign, hazard_controls.HazardControl, hazards.Opportunity
                HAVING (((jobs.id)=$jobid))
                ORDER BY activities.Order
                );

            CREATE TEMPORARY TABLE count_activity AS (
                SELECT risk.ActivityName, Count(risk.ActivityName) AS CountOfActivityName
                FROM risk
                GROUP BY risk.ActivityName
                );

            CREATE TEMPORARY TABLE count_hazard AS (
                SELECT risk.ActivityName, risk.HazardName, Count(risk.HazardName) AS CountOfHazardName
                FROM risk
                GROUP BY risk.ActivityName, risk.HazardName
                );

            CREATE TEMPORARY TABLE count_kindofhazard AS (
                SELECT risk.ActivityName, risk.HazardName, risk.KindofHazard, Count(risk.KindofHazard) AS CountOfKindofHazard
                FROM risk
                GROUP BY risk.ActivityName, risk.HazardName, risk.KindofHazard
                );
            ")
        );

        $risk = DB::select('SELECT risk.id, risk.Order, risk.ActivityName, count_activity.CountOfActivityName, risk.HazardName, count_hazard.CountOfHazardName, CONCAT(risk.ActivityName,risk.HazardName) AS CodeHazardName, risk.KindofHazard, count_kindofhazard.CountOfKindofHazard, CONCAT(risk.ActivityName,risk.HazardName,risk.KindofHazard) AS CodeKindOfHazard, risk.Effect, risk.Severity, risk.ManPower, risk.Contact, risk.Procedure, risk.Training, risk.PPE, risk.SafetyEquipment, risk.Verification, risk.SafetySign, risk.HazardControl, risk.Opportunity
            FROM count_kindofhazard INNER JOIN (count_hazard INNER JOIN (count_activity INNER JOIN risk ON count_activity.ActivityName = risk.ActivityName) ON (count_hazard.HazardName = risk.HazardName) AND (count_hazard.ActivityName = risk.ActivityName)) ON (count_kindofhazard.KindofHazard = risk.KindofHazard) AND (count_kindofhazard.HazardName = risk.HazardName) AND (count_kindofhazard.ActivityName = risk.ActivityName)
            GROUP BY risk.id, risk.Order, risk.ActivityName, count_activity.CountOfActivityName, risk.HazardName, count_hazard.CountOfHazardName, CONCAT(risk.ActivityName,risk.HazardName), risk.KindofHazard, count_kindofhazard.CountOfKindofHazard, CONCAT(risk.ActivityName,risk.HazardName,risk.KindofHazard), risk.Effect, risk.Severity, risk.ManPower, risk.Contact, risk.Procedure, risk.Training, risk.PPE, risk.SafetyEquipment, risk.Verification, risk.SafetySign, risk.HazardControl, risk.Opportunity
            ORDER BY risk.Order, risk.HazardName, risk.KindofHazard');

        //$test = DB::table('risk')->get();
        //dd($risk);

            return view('print.risk',compact('job','risk'));
    }

    public function riskquality($jobid)
    {
        $job = DB::select('SELECT jobs.id, projects.ProjectName, locations.LocationName, products.ProductName, machines.MachineName, systems.SystemName, items.SpecificName, scopes.ScopeName
            FROM locations INNER JOIN (machines INNER JOIN (machine_sets INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (projects INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON projects.id = jobs.project_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id
            WHERE (((jobs.id)='.$jobid.'))');
        $risk = DB::select('SELECT jobs.id, activities.Order, activities.ActivityName, activities.Detail
            FROM activities INNER JOIN jobs ON activities.item_id = jobs.item_id
            WHERE (((jobs.id)='.$jobid.'))
            ORDER BY activities.Order');
        $i = 1;
        return view('print.riskquality',compact('job','risk','i'));
    }

    public function riskqualityhmrs($id)
    {
        $department = Department::find($id);
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE riskx AS (
                SELECT riskx.Factor, riskx.TypeofRisk, riskx.Effect, riskx.EffectValue, riskx.Measure, riskx.Followup
                FROM (SELECT factors.Factor, type_of_risks.TypeofRisk, type_of_risks.Effect, type_of_risks.EffectValue, type_of_risks.Measure, type_of_risks.Followup
                    FROM department_factors
                    INNER JOIN factors
                        INNER JOIN type_of_risks
                        ON factors.id = type_of_risks.factor_id
                    ON department_factors.factor_id = factors.id
                    WHERE department_factors.department_id = $id AND department_factors.Related = 'Yes'
                    GROUP BY factors.Factor, type_of_risks.TypeofRisk, type_of_risks.Effect, type_of_risks.EffectValue, type_of_risks.Measure, type_of_risks.Followup
                    UNION
                    SELECT factors.Factor, type_of_risks.TypeofRisk, type_of_risks.Effect, type_of_risks.EffectValue, type_of_risks.Measure, type_of_risks.Followup
                    FROM department_factors
                    INNER JOIN factors
                        INNER JOIN type_of_risks
                        ON factors.id = type_of_risks.factor_id
                    ON department_factors.factor_id = factors.id
                    INNER JOIN departments
                    ON department_factors.department_id = departments.id
                    WHERE departments.department_id = $id AND department_factors.Related = 'Yes'
                    GROUP BY factors.Factor, type_of_risks.TypeofRisk, type_of_risks.Effect, type_of_risks.EffectValue, type_of_risks.Measure, type_of_risks.Followup) AS riskx
                GROUP BY riskx.Factor, riskx.TypeofRisk, riskx.Effect, riskx.EffectValue, riskx.Measure, riskx.Followup
                );

            CREATE TEMPORARY TABLE count_factor AS (
                SELECT riskx.Factor, Count(riskx.Factor) AS CountOfFactor
                FROM riskx
                GROUP BY riskx.Factor
                );
            ")
        );

        $factor = DB::select('SELECT riskx.Factor
            FROM riskx
            GROUP BY riskx.Factor');

        $risk = DB::select('SELECT riskx.Factor, count_factor.CountOfFactor, riskx.TypeofRisk, riskx.Effect, riskx.EffectValue, riskx.Measure, riskx.Followup
            FROM count_factor INNER JOIN riskx ON count_factor.Factor = riskx.Factor
            ORDER BY riskx.Factor');

        return view('print.riskqualityhmrs',compact('department','factor','risk'));
    }

    public function riskqualityproject($id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE riskx AS (
                SELECT factors.Factor, type_of_risks.TypeofRisk, type_of_risks.Effect, type_of_risks.EffectValue, type_of_risks.Measure, type_of_risks.Followup
                FROM factors INNER JOIN type_of_risks ON factors.id = type_of_risks.factor_id
                GROUP BY factors.Factor, type_of_risks.TypeofRisk, type_of_risks.Effect, type_of_risks.EffectValue, type_of_risks.Measure, type_of_risks.Followup
                ORDER BY factors.Factor, type_of_risks.TypeofRisk, type_of_risks.Effect
                );

            CREATE TEMPORARY TABLE count_factor AS (
                SELECT riskx.Factor, Count(riskx.Factor) AS CountOfFactor
                FROM riskx
                GROUP BY riskx.Factor
                );
            ")
        );

        $factor = DB::select('SELECT riskx.Factor
            FROM riskx
            GROUP BY riskx.Factor');

        $risk = DB::select('SELECT riskx.Factor, count_factor.CountOfFactor, riskx.TypeofRisk, riskx.Effect, riskx.EffectValue, riskx.Measure, riskx.Followup
            FROM count_factor INNER JOIN riskx ON count_factor.Factor = riskx.Factor
            ORDER BY riskx.Factor');

        return view('print.riskqualityproject',compact('project','factor','risk'));
    }

    public function workathight($id)
    {
        $workathight = WorkAtHight::find($id);

        return view('print.workathight',compact('workathight'));
    }

    public function workathightwind($id)
    {
        $workathightwind = WorkAtHightWind::find($id);

        return view('print.workathightwind',compact('workathightwind'));
    }

    public function safetychecklist($id)
    {


        return view('print.safetychecklist');
    }

    public function sparepart($projectid)
    {
        $project = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer
            FROM projects
            WHERE (((projects.id)='.$projectid.'))');
        $sparepart = DB::select('SELECT jobs.project_id, spare_parts.SparePartName, spare_parts.Detail, Sum(item_spare_parts.Quantity) AS SumOfQuantity, spare_parts.Unit
            FROM spare_parts INNER JOIN (jobs INNER JOIN item_spare_parts ON jobs.item_id = item_spare_parts.item_id) ON spare_parts.id = item_spare_parts.spare_part_id
            GROUP BY jobs.project_id, spare_parts.SparePartName, spare_parts.Detail, spare_parts.Unit
            HAVING (((jobs.project_id)='.$projectid.'))
            ORDER BY spare_parts.SparePartName, spare_parts.Detail');
        $i = 1;

        return view('print.sparepart',compact('project','sparepart','i'));
    }

    public function stakeholderproject($id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE department AS (
                SELECT departments.Code, departments.Section, departments.Department, departments.Division, departments.Business
                FROM departments INNER JOIN (employees INNER JOIN projects ON employees.id = projects.AreaManager) ON departments.id = employees.department_id
                WHERE projects.id=$id
                );

            CREATE TEMPORARY TABLE product_location AS (
                SELECT products.id, products.ProductCode, products.ProductName, products.Service, machine_sets.location_id AS location_id
                FROM products
                INNER JOIN item_sets
                    INNER JOIN items
                        INNER JOIN jobs
                        ON items.id = jobs.item_id
                        INNER JOIN machine_sets
                        ON items.machine_set_id = machine_sets.id
                    ON item_sets.id = items.item_set_id
                ON products.id = item_sets.product_id
                WHERE jobs.project_id = $id
                GROUP BY products.id, products.ProductCode, products.ProductName, products.Service, machine_sets.location_id
                );

            CREATE TEMPORARY TABLE expectation AS (
                SELECT expectation.ProductCode, expectation.ProductName, expectation.Service, expectation.StakeholderName, expectation.MoreDetail
                FROM (SELECT products.ProductCode, products.ProductName, products.Service, stakeholders.StakeholderName, expectations.MoreDetail
                    FROM products
                    INNER JOIN stakeholder_projects
                        INNER JOIN stakeholders
                            INNER JOIN stakeholder_expectations
                                INNER JOIN expectations
                                ON stakeholder_expectations.expectation_id = expectations.id
                            ON stakeholders.id = stakeholder_expectations.stakeholder_id
                        ON stakeholder_projects.stakeholder_id = stakeholders.id
                    ON products.id = stakeholder_projects.product_id
                    WHERE stakeholder_projects.project_id = $id
                    UNION
                    SELECT product.ProductCode, product.ProductName, product.Service, stakeholders.StakeholderName, expectations.MoreDetail
                    FROM (SELECT id, ProductCode, ProductName, Service
                        FROM product_location
                        GROUP BY id, ProductCode, ProductName, Service) AS product
                    INNER JOIN product_stakeholder_expectations
                        INNER JOIN stakeholders
                        ON product_stakeholder_expectations.stakeholder_id =stakeholders.id
                        INNER JOIN expectations
                        ON product_stakeholder_expectations.expectation_id = expectations.id
                    ON product.id = product_stakeholder_expectations.product_id
                    WHERE product_stakeholder_expectations.Related = 'Yes' AND stakeholders.stakeholder_type_id In (1,6)
                    UNION
                    SELECT product_location.ProductCode, product_location.ProductName, product_location.Service, stakeholders.StakeholderName, expectations.MoreDetail
                    FROM product_location
                    INNER JOIN product_stakeholder_expectations
                        INNER JOIN stakeholders
                        ON product_stakeholder_expectations.stakeholder_id =stakeholders.id
                        INNER JOIN expectations
                        ON product_stakeholder_expectations.expectation_id = expectations.id
                    ON product_location.id = product_stakeholder_expectations.product_id
                    WHERE product_stakeholder_expectations.Related = 'Yes' AND stakeholders.stakeholder_type_id In (3,4) AND product_location.location_id = stakeholders.location_id) AS expectation
                ORDER BY expectation.ProductCode, expectation.ProductName, expectation.Service, expectation.StakeholderName, expectation.MoreDetail
                );

            CREATE TEMPORARY TABLE count_productcode AS (
                SELECT expectation.ProductCode, COUNT(expectation.ProductCode) AS count_productcode
                FROM expectation
                GROUP BY expectation.ProductCode
                );

            CREATE TEMPORARY TABLE count_stakeholder AS (
                SELECT expectation.ProductCode, expectation.StakeholderName, COUNT(expectation.StakeholderName) AS count_stakeholdername, CONCAT_WS('/', expectation.ProductCode, expectation.StakeholderName) AS code_stakeholdername
                FROM expectation
                GROUP BY expectation.ProductCode, expectation.StakeholderName, code_stakeholdername
                );
            ")
        );

        $department = DB::table('department')->get();

        /* $product = DB::table('product')->get();
        dd($product); */

        $product = DB::select('SELECT expectation.ProductCode, count_productcode.count_productcode, expectation.ProductName, expectation.Service, expectation.StakeholderName, count_stakeholder.code_stakeholdername, count_stakeholder.count_stakeholdername, expectation.MoreDetail
            FROM expectation
            INNER JOIN count_productcode
            ON expectation.ProductCode = count_productcode.ProductCode
            INNER JOIN count_stakeholder
            ON expectation.ProductCode = count_stakeholder.ProductCode AND expectation.StakeholderName = count_stakeholder.StakeholderName');

        return view('print.stakeholderproject',compact('project','department','product'));
    }

    public function timeconfirmed(Request $request)
    {
        $workid = $request->get('WorkID');
        $workid = implode(',', $workid);
        $startdate = $request->get('startDate');
        $enddate = $request->get('endDate');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE timeconfirmed AS (
                SELECT projects.ProjectName, employees.WorkID, employees.ThaiName, man_hours.WorkingDate, Sum(man_hours.Normal) AS Normal, Sum(man_hours.OT1) AS OT1, Sum(man_hours.OT15) AS OT15, Sum(man_hours.OT2) AS OT2, Sum(man_hours.OT3) AS OT3
                FROM employees INNER JOIN (projects INNER JOIN (jobs INNER JOIN man_hours ON jobs.id = man_hours.job_id) ON projects.id = jobs.project_id) ON employees.id = man_hours.employee_id
                GROUP BY projects.ProjectName, employees.WorkID, employees.ThaiName, man_hours.WorkingDate
                HAVING (((man_hours.WorkingDate) BETWEEN CAST('$startdate' AS DATE) AND CAST('$enddate' AS DATE)) AND ((employees.WorkID) IN ($workid)))
                ORDER BY employees.WorkID
                );

            CREATE TEMPORARY TABLE total_project AS (
                SELECT timeconfirmed.WorkID, timeconfirmed.ThaiName, timeconfirmed.ProjectName, Sum(timeconfirmed.Normal) AS Normal, Sum(timeconfirmed.OT1) AS OT1, Sum(timeconfirmed.OT15) AS OT15, Sum(timeconfirmed.OT2) AS OT2, Sum(timeconfirmed.OT3) AS OT3
                FROM timeconfirmed
                GROUP BY timeconfirmed.WorkID, timeconfirmed.ThaiName, timeconfirmed.ProjectName
                );

            CREATE TEMPORARY TABLE total_employee AS (
                SELECT timeconfirmed.WorkID, timeconfirmed.ThaiName, Sum(timeconfirmed.Normal) AS SumOfNormal, Sum(timeconfirmed.OT1) AS SumOfOT1, Sum(timeconfirmed.OT15) AS SumOfOT15, Sum(timeconfirmed.OT2) AS SumOfOT2, Sum(timeconfirmed.OT3) AS SumOfOT3, Sum(timeconfirmed.OT1+timeconfirmed.OT15+timeconfirmed.OT2+timeconfirmed.OT3) AS SumOftotalOT
                FROM timeconfirmed
                GROUP BY timeconfirmed.WorkID, timeconfirmed.ThaiName
                );

            CREATE TEMPORARY TABLE employee AS (
                SELECT total_employee.WorkID, CONCAT(total_employee.WorkID,' - ',total_employee.ThaiName,' - Total : Normal = ',total_employee.SumOfNormal,' || OT1 = ',total_employee.SumOfOT1,', OT1.5 = ',total_employee.SumOfOT15,', OT2 = ',total_employee.SumOfOT2,', OT3 = ',total_employee.SumOfOT3,', Total OT = ',total_employee.SumOftotalOT) AS Employee
                FROM total_employee
                GROUP BY total_employee.WorkID, CONCAT(total_employee.WorkID,' - ',total_employee.ThaiName,' - Total : Normal = ',total_employee.SumOfNormal,' || OT1 = ',total_employee.SumOfOT1,', OT1.5 = ',total_employee.SumOfOT15,', OT2 = ',total_employee.SumOfOT2,', OT3 = ',total_employee.SumOfOT3,', Total OT = ',total_employee.SumOftotalOT)
                );

            CREATE TEMPORARY TABLE timeconfirmedx AS (
                SELECT employee.Employee, total_project.ProjectName, total_project.Normal, total_project.OT1, total_project.OT15, total_project.OT2, total_project.OT3
                FROM employee INNER JOIN total_project ON employee.WorkID = total_project.WorkID
                );
            ")
        );

        $timeconfirmed = DB::table('timeconfirmedx')->get()->groupBy('Employee');

        //$test = DB::table('timeconfirmedx')->get();
        //dd($test);

        return view('print.timeconfirmed',compact('timeconfirmed','startdate','enddate'));
    }

    public function timesheet(Request $request)
    {
        $id = $request->get('project_id');
        $workid = $request->get('WorkID');
        $workid = implode(',', $workid);
        $startdate = $request->get('startDate');
        $enddate = $request->get('endDate');
        $pmorderreport = $request->get('pmorderreport');

        $project = Project::find($id);

        if ( $pmorderreport == 'Job') {
            $createTempTables = DB::unprepared(DB::raw("
                CREATE TEMPORARY TABLE timesheet AS (
                    SELECT employees.WorkID, employees.ThaiName, man_hours.WorkingDate, p_m_orders.PMOrder, crafts.CraftName, Sum(man_hours.Normal) AS Normal, man_hours.OTfrom, man_hours.OTto, Sum(man_hours.OT1) AS OT1, Sum(man_hours.OT15) AS OT15, Sum(man_hours.OT2) AS OT2, Sum(man_hours.OT3) AS OT3, man_hours.Remark, jobs.project_id
                    FROM crafts INNER JOIN (job_positions INNER JOIN (p_m_orders INNER JOIN (jobs INNER JOIN (employees INNER JOIN man_hours ON employees.id = man_hours.employee_id) ON jobs.id = man_hours.job_id) ON p_m_orders.id = jobs.p_m_order_id) ON job_positions.id = man_hours.job_position_id) ON crafts.id = job_positions.craft_id
                    GROUP BY employees.WorkID, employees.ThaiName, man_hours.WorkingDate, p_m_orders.PMOrder, crafts.CraftName, man_hours.OTfrom, man_hours.OTto, man_hours.Remark, jobs.project_id
                    HAVING (((man_hours.WorkingDate) BETWEEN CAST('$startdate' AS DATE) AND CAST('$enddate' AS DATE)) AND ((jobs.project_id)=$id)) AND ((employees.WorkID) IN ($workid))
                    ORDER BY employees.WorkID, man_hours.WorkingDate, p_m_orders.PMOrder
                    );
                ")
            );
        } else {
            $createTempTables = DB::unprepared(DB::raw("
                CREATE TEMPORARY TABLE timesheet AS (
                    SELECT employees.WorkID, employees.ThaiName, man_hours.WorkingDate, p_m_orders.PMOrder, crafts.CraftName, Sum(man_hours.Normal) AS Normal, man_hours.OTfrom, man_hours.OTto, Sum(man_hours.OT1) AS OT1, Sum(man_hours.OT15) AS OT15, Sum(man_hours.OT2) AS OT2, Sum(man_hours.OT3) AS OT3, man_hours.Remark, jobs.project_id
                    FROM crafts INNER JOIN (job_positions INNER JOIN (p_m_orders INNER JOIN (jobs INNER JOIN (employees INNER JOIN man_hours ON employees.id = man_hours.employee_id) ON jobs.id = man_hours.job_id) ON p_m_orders.id = man_hours.p_m_order_id) ON job_positions.id = man_hours.job_position_id) ON crafts.id = job_positions.craft_id
                    GROUP BY employees.WorkID, employees.ThaiName, man_hours.WorkingDate, p_m_orders.PMOrder, crafts.CraftName, man_hours.OTfrom, man_hours.OTto, man_hours.Remark, jobs.project_id
                    HAVING (((man_hours.WorkingDate) BETWEEN CAST('$startdate' AS DATE) AND CAST('$enddate' AS DATE)) AND ((jobs.project_id)=$id)) AND ((employees.WorkID) IN ($workid))
                    ORDER BY employees.WorkID, man_hours.WorkingDate, p_m_orders.PMOrder
                    );
                ")
            );
        }

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE totalperemployee AS (
                SELECT timesheet.WorkID, timesheet.ThaiName, Sum(timesheet.Normal) AS SumOfNormal, Sum(timesheet.OT1) AS SumOfOT1, Sum(timesheet.OT15) AS SumOfOT15, Sum(timesheet.OT2) AS SumOfOT2, Sum(timesheet.OT3) AS SumOfOT3
                FROM timesheet
                GROUP BY timesheet.WorkID, timesheet.ThaiName
                );

            CREATE TEMPORARY TABLE employee AS (
                SELECT totalperemployee.WorkID, CONCAT(totalperemployee.WorkID,' - ',totalperemployee.ThaiName,' - Total : Normal = ',totalperemployee.SumOfNormal,', OT1 = ',totalperemployee.SumOfOT1,', OT1.5 = ',totalperemployee.SumOfOT15,', OT2 = ',totalperemployee.SumOfOT2,', OT3 = ',totalperemployee.SumOfOT3) AS Employee
                FROM totalperemployee
                );

            CREATE TEMPORARY TABLE count_pmorder AS (
                SELECT timesheet.WorkID, timesheet.WorkingDate, timesheet.PMOrder, Count(timesheet.PMOrder) AS CountOfPMOrder
                FROM timesheet
                GROUP BY timesheet.WorkID, timesheet.WorkingDate, timesheet.PMOrder
                );

            CREATE TEMPORARY TABLE count_workingdate AS (
                SELECT timesheet.WorkID, timesheet.WorkingDate, Count(timesheet.WorkingDate) AS CountOfWorkingDate
                FROM timesheet
                GROUP BY timesheet.WorkID, timesheet.WorkingDate
                );

            CREATE TEMPORARY TABLE count_craft AS (
                SELECT timesheet.WorkID, timesheet.WorkingDate, timesheet.PMOrder, timesheet.CraftName, Count(timesheet.CraftName) AS CountOfCraftName
                FROM timesheet
                GROUP BY timesheet.WorkID, timesheet.WorkingDate, timesheet.PMOrder, timesheet.CraftName
                );

            CREATE TEMPORARY TABLE timesheetx AS (
                SELECT employee.Employee, timesheet.WorkingDate, count_workingdate.CountOfWorkingDate, Concat(timesheet.WorkID,timesheet.WorkingDate) AS WorkingDateCode, timesheet.PMOrder, count_pmorder.CountOfPMOrder, Concat(timesheet.WorkID,timesheet.WorkingDate,timesheet.PMOrder) AS PMOrderCode, timesheet.CraftName, count_craft.CountOfCraftName, Concat(timesheet.WorkID,timesheet.WorkingDate,timesheet.PMOrder,timesheet.CraftName) AS CraftNameCode, timesheet.Normal, timesheet.OTfrom, timesheet.OTto, timesheet.OT1, timesheet.OT15, timesheet.OT2, timesheet.OT3, timesheet.Remark
                FROM count_craft INNER JOIN (count_pmorder INNER JOIN (count_workingdate INNER JOIN (employee INNER JOIN timesheet ON employee.WorkID = timesheet.WorkID) ON (count_workingdate.WorkID = timesheet.WorkID) AND (count_workingdate.WorkingDate = timesheet.WorkingDate)) ON (count_pmorder.WorkID = timesheet.WorkID) AND (count_pmorder.WorkingDate = timesheet.WorkingDate) AND (count_pmorder.PMOrder = timesheet.PMOrder)) ON (count_craft.CraftName = timesheet.CraftName) AND (count_craft.PMOrder = timesheet.PMOrder) AND (count_craft.WorkingDate = timesheet.WorkingDate) AND (count_craft.WorkID = timesheet.WorkID)
                GROUP BY employee.Employee, timesheet.WorkingDate, count_workingdate.CountOfWorkingDate, Concat(timesheet.WorkID,timesheet.WorkingDate), timesheet.PMOrder, count_pmorder.CountOfPMOrder, Concat(timesheet.WorkID,timesheet.WorkingDate,timesheet.PMOrder), timesheet.CraftName, count_craft.CountOfCraftName, Concat(timesheet.WorkID,timesheet.WorkingDate,timesheet.PMOrder,timesheet.CraftName), timesheet.Normal, timesheet.OTfrom, timesheet.OTto, timesheet.OT1, timesheet.OT15, timesheet.OT2, timesheet.OT3, timesheet.Remark, timesheet.WorkID
                );
            ")
        );

        $pmorder = DB::select('SELECT p_m_orders.PMOrder, p_m_orders.PMOrderName
            FROM timesheet INNER JOIN p_m_orders ON timesheet.PMOrder = p_m_orders.PMOrder
            GROUP BY p_m_orders.PMOrder, p_m_orders.PMOrderName
            ORDER BY p_m_orders.PMOrder');
        $timesheet = DB::table('timesheetx')->get()->groupBy('Employee');

        return view('print.timesheet',compact('pmorder','project','timesheet','pmorderreport'));
    }

    public function tool($projectid)
    {
        $project = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer
            FROM projects
            WHERE (((projects.id)='.$projectid.'))');
        $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.Unit, Sum(item_tool_catagories.Quantity) AS SumOfQuantity, item_tool_catagories.Remark
            FROM tool_catagories INNER JOIN (item_tool_catagories INNER JOIN jobs ON item_tool_catagories.item_id = jobs.item_id) ON tool_catagories.id = item_tool_catagories.tool_catagory_id
            GROUP BY tool_catagories.CatagoryName, tool_catagories.Unit, item_tool_catagories.Remark
            ORDER BY tool_catagories.CatagoryName');
        $i = 1;

        return view('print.tool',compact('project','tool','i'));
    }

    public function toolaccept($id)
    {
        $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.DurableSupplieCode, tools.AssetToolCode, tools.id
            FROM tool_catagories INNER JOIN tools ON tool_catagories.id = tools.tool_catagory_id
            WHERE (((tools.id)='.$id.'))');

        return view('print.toolaccept',compact('tool'));
    }

    public function toolbreakdown($id)
    {
        $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tools.Brand, tools.Model, tools.SerialNumber, tool_breakdowns.id, tool_breakdowns.Report, tool_breakdowns.Cause, tool_breakdowns.Value, tool_breakdowns.Guideline, tool_breakdowns.Operation, tool_breakdowns.Operator, tool_breakdowns.Result
            FROM (tool_catagories INNER JOIN tools ON tool_catagories.id = tools.tool_catagory_id) INNER JOIN tool_breakdowns ON tools.id = tool_breakdowns.tool_id
            WHERE (((tool_breakdowns.id)='.$id.'))');

        return view('print.toolbreakdown',compact('tool'));
    }

    public function toolcalibratelist()
    {
        $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagories.MeasuringTool, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_calibrates.Accuracy, tool_calibrates.AcceptError, employees.ThaiName AS Responsible
            FROM employees
            INNER JOIN (tool_catagories
                INNER JOIN (tools
                    LEFT JOIN (tool_calibrates
                        INNER JOIN (SELECT tool_calibrates.tool_id, Max(tool_calibrates.created_at) AS MaxOfcreated_at
                            FROM tool_calibrates
                            GROUP BY tool_calibrates.tool_id)  AS t
                        ON (tool_calibrates.tool_id = t.tool_id) AND (tool_calibrates.created_at = t.MaxOfcreated_at))
                    ON tools.id = tool_calibrates.tool_id)
                    INNER JOIN ( SELECT tool_updates.tool_id
                        FROM tool_updates
                        INNER JOIN ( SELECT tool_id, MAX(created_at) AS max_created_at
                            FROM tool_updates
                            GROUP BY tool_id) AS max_tool_updates
                        ON tool_updates.tool_id = max_tool_updates.tool_id AND tool_updates.created_at = max_tool_updates.max_created_at
                        WHERE tool_updates.Status IN("Available","Lend","Calibrating","Broken","On Site","Return")) AS tool_available
                    ON tools.id = tool_available.tool_id
                ON tool_catagories.id = tools.tool_catagory_id)
            ON employees.id = tools.Responsible
            WHERE (((tool_catagories.MeasuringTool)="Yes"))');

        return view('print.toolcalibratelist',compact('tool'));
    }

    public function toolcalibrateplan(Request $request)
    {
        $year = $request->get('year');

        $plan = DB::select('SELECT calibrate_plan.CatagoryName, calibrate_plan.RangeCapacity, calibrate_plan.Brand, calibrate_plan.Model, calibrate_plan.SerialNumber, calibrate_plan.LocalCode, calibrate_plan.DurableSupplieCode, calibrate_plan.AssetToolCode, calibrate_plan.Calibrator,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 01 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PJan,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 01 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS AJan,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 02 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PFeb,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 02 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS AFeb,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 03 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PMar,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 03 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS AMar,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 04 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PApr,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 04 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS AApr,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 05 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PMay,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 05 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS AMay,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 06 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PJun,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 06 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS AJun,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 07 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PJul,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 07 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS AJul,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 08 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PAug,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 08 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS AAug,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 09 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PSep,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 09 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS ASep,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 10 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS POct,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 10 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS AOct,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 11 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PNov,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 11 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS ANov,
                MAX(CASE WHEN (MONTH(calibrate_plan.ExpireDate) = 12 AND YEAR(calibrate_plan.ExpireDate) = '.$year.') THEN 1 ELSE 0 END) AS PDec,
                MAX(CASE WHEN (MONTH(calibrate_plan.CalibrateDate) = 12 AND YEAR(calibrate_plan.CalibrateDate) = '.$year.') THEN 1 ELSE 0 END) AS ADec
                FROM (SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_calibrates.CalibrateDate, tool_calibrates.ExpireDate, max_tool_calibrates.Calibrator
                    FROM tool_catagories
                        INNER JOIN (tools
                            LEFT JOIN ( SELECT tool_calibrates.tool_id, tool_calibrates.Calibrator
                                FROM tool_calibrates
                                INNER JOIN ( Select tool_id, MAX(CalibrateDate) AS max_calibrate
                                    FROM tool_calibrates
                                    GROUP BY tool_id) AS max_tool_calibrates
                                ON tool_calibrates.tool_id = max_tool_calibrates.tool_id AND tool_calibrates.CalibrateDate = max_tool_calibrates.max_calibrate) AS max_tool_calibrates
                            ON tools.id = max_tool_calibrates.tool_id
                            INNER JOIN tool_calibrates
                            ON tools.id = tool_calibrates.tool_id)
                            INNER JOIN ( SELECT tool_updates.tool_id
                                FROM tool_updates
                                INNER JOIN ( SELECT tool_id, MAX(created_at) AS max_created_at
                                    FROM tool_updates
                                    GROUP BY tool_id) AS max_tool_updates
                                ON tool_updates.tool_id = max_tool_updates.tool_id AND tool_updates.created_at = max_tool_updates.max_created_at
                                WHERE tool_updates.Status IN("Available","Lend","Calibrating","Broken","On Site","Return")) AS tool_available
                            ON tools.id = tool_available.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                    WHERE ((Year(tool_calibrates.CalibrateDate)="'.$year.'") OR (Year(tool_calibrates.ExpireDate)="'.$year.'"))) AS calibrate_plan
                GROUP BY calibrate_plan.CatagoryName, calibrate_plan.RangeCapacity, calibrate_plan.Brand, calibrate_plan.Model, calibrate_plan.SerialNumber, calibrate_plan.LocalCode, calibrate_plan.DurableSupplieCode, calibrate_plan.AssetToolCode, calibrate_plan.Calibrator');

        //dd($plan);
            return view('print.toolcalibrateplan',compact('plan','year'));
    }

    public function toolcalibrateaccept($id)
    {
        $calibrate = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_calibrates.CalibrateDate, tool_calibrates.Result, tool_calibrates.Certificate, tool_calibrates.ExpireDate, tool_calibrates.Remark, tool_calibrates.id
        FROM tool_catagories INNER JOIN (tools INNER JOIN (tool_calibrates INNER JOIN (SELECT tool_id, max(CalibrateDate) AS MaxDate FROM tool_calibrates GROUP BY tool_id)  AS tm ON (tool_calibrates.tool_id = tm.tool_id) AND (tool_calibrates.CalibrateDate = tm.MaxDate)) ON tools.id = tool_calibrates.tool_id) ON tool_catagories.id = tools.tool_catagory_id
        GROUP BY tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_calibrates.CalibrateDate, tool_calibrates.Result, tool_calibrates.Certificate, tool_calibrates.ExpireDate, tool_calibrates.Remark, tool_calibrates.id, tool_calibrates.tool_id
        HAVING (((tool_calibrates.tool_id)='.$id.'))');

        return view('print.toolcalibrateaccept',compact('calibrate'));
    }

    public function toolcalibraterecord($id)
    {
        $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tools.id
            FROM tool_catagories INNER JOIN tools ON tool_catagories.id = tools.tool_catagory_id
            WHERE (((tools.id)='.$id.'))');

        $record = DB::select('SELECT tool_calibrates.CalibrateDate, tool_calibrates.ExpireDate, tool_calibrates.Calibrator, tool_calibrates.Result, tool_calibrates.Certificate, tool_calibrates.Accuracy, tool_calibrates.AcceptError, tool_calibrates.Remark, employees.ThaiName AS Responsible, tool_calibrates.tool_id
        FROM employees RIGHT JOIN (tools INNER JOIN tool_calibrates ON tools.id = tool_calibrates.tool_id) ON employees.id = tool_calibrates.Responsible
        WHERE (((tool_calibrates.tool_id)='.$id.'))');

        return view('print.toolcalibraterecord',compact('tool','record'));
    }

    public function toolget($id)
    {
        $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.Unit, Sum(item_tool_catagories.Quantity) AS SumOfQuantity, item_tool_catagories.Remark
            FROM tool_catagories INNER JOIN (item_tool_catagories INNER JOIN jobs ON item_tool_catagories.item_id = jobs.item_id) ON tool_catagories.id = item_tool_catagories.tool_catagory_id
            GROUP BY tool_catagories.CatagoryName, tool_catagories.Unit, item_tool_catagories.Remark
            ORDER BY tool_catagories.CatagoryName');

        return view('print.toolget',compact('tool'));
    }

    public function toolexpensive(Request $request, $id)
    {
        $project = Project::find($id);

        $pmorder = DB::select('SELECT p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.Remark
            FROM expensive_tools
                INNER JOIN jobs
                ON expensive_tools.job_id = jobs.id
                INNER JOIN p_m_orders
                ON jobs.p_m_order_id = p_m_orders.id
            WHERE jobs.project_id = '.$id.'
            GROUP BY p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.Remark');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE Query1 AS (
                SELECT tools.id, tool_types.ActivityType, expensive_tools.Activity, Sum(expensive_tools.Hour) AS SumOfTravel, jobs.project_id
                FROM tool_types
                    RIGHT JOIN (tool_catagories
                        INNER JOIN (tools
                            INNER JOIN (jobs
                                INNER JOIN expensive_tools
                                ON jobs.id = expensive_tools.job_id)
                            ON tools.id = expensive_tools.tool_id)
                        ON tool_catagories.id = tools.tool_catagory_id)
                    ON tool_types.id = tool_catagories.tool_type_id
                GROUP BY tools.id, tool_types.ActivityType, expensive_tools.Activity, jobs.project_id
                HAVING expensive_tools.Activity='Travel' AND jobs.project_id=$id
            );

            CREATE TEMPORARY TABLE Query2 AS (
                SELECT tools.id, tool_types.ActivityType, expensive_tools.Activity, Sum(expensive_tools.Hour) AS SumOfUsed, jobs.project_id
                FROM tool_types
                    RIGHT JOIN (tool_catagories
                        INNER JOIN (tools
                            INNER JOIN (jobs
                                INNER JOIN expensive_tools
                                ON jobs.id = expensive_tools.job_id)
                            ON tools.id = expensive_tools.tool_id)
                        ON tool_catagories.id = tools.tool_catagory_id)
                    ON tool_types.id = tool_catagories.tool_type_id
                GROUP BY tools.id, tool_types.ActivityType, expensive_tools.Activity, jobs.project_id
                HAVING expensive_tools.Activity='Used' AND jobs.project_id=$id
            );

            CREATE TEMPORARY TABLE Query3 AS (
                SELECT expensive_tools.tool_id, expensive_tools.Date, Count(expensive_tools.Date) AS CountOfDate, CONCAT_WS('-',tool_id,expensive_tools.Date) AS DateCode, jobs.project_id
                FROM jobs
                INNER JOIN expensive_tools
                ON jobs.id = expensive_tools.job_id
                GROUP BY expensive_tools.tool_id, expensive_tools.Date, jobs.project_id
                HAVING jobs.project_id=$id
            );

            CREATE TEMPORARY TABLE Query4 AS (
                SELECT expensive_tools.tool_id, expensive_tools.Date, jobs.p_m_order_id, Count(jobs.p_m_order_id) AS CountOfp_m_order_id, CONCAT_WS('-',tool_id,expensive_tools.Date,jobs.p_m_order_id) AS PMOrderCode, jobs.project_id
                FROM jobs
                    INNER JOIN expensive_tools
                    ON jobs.id = expensive_tools.job_id
                GROUP BY expensive_tools.tool_id, expensive_tools.Date, jobs.p_m_order_id, jobs.project_id
                HAVING jobs.project_id=$id
            );

            CREATE TEMPORARY TABLE reportx AS (
                SELECT CONCAT_WS(' // ',tool_catagories.CatagoryName,tool_catagories.RangeCapacity,tools.Brand,tools.Model,tools.SerialNumber,tools.LocalCode,tools.DurableSupplieCode,tools.AssetToolCode,
                    CONCAT(CONCAT('V',IF(ISNULL(Query1.ActivityType),'-',Query1.ActivityType),' = '),IF(ISNULL(Query1.SumOfTravel),0,Query1.SumOfTravel)),CONCAT(CONCAT('M',IF(ISNULL(Query2.ActivityType),'-',Query2.ActivityType),' = '),
                    IF(ISNULL(Query2.SumOfUsed),0,Query2.SumOfUsed))) AS Tool, tools.id, expensive_tools.Date, p_m_orders.PMOrder, expensive_tools.Activity, tool_types.ActivityType, expensive_tools.`Hour`, expensive_tools.Remark,
                    Query3.CountOfDate, Query3.DateCode, Query4.CountOfp_m_order_id, Query4.PMOrderCode
                FROM expensive_tools
                    INNER JOIN jobs
                    ON expensive_tools.job_id = jobs.id
                    INNER JOIN p_m_orders
                    ON jobs.p_m_order_id = p_m_orders.id
                    INNER JOIN tools
                    ON expensive_tools.tool_id = tools.id
                    INNER JOIN tool_catagories
                    ON tools.tool_catagory_id = tool_catagories.id
                    LEFT JOIN tool_types
                    ON tool_catagories.tool_type_id = tool_types.id
                    LEFT JOIN Query1
                    ON tools.id = Query1.id
                    LEFT JOIN Query2
                    ON tools.id = Query2.id
                    INNER JOIN Query3
                    ON expensive_tools.tool_id = Query3.tool_id AND expensive_tools.Date = Query3.Date
                    INNER JOIN Query4
                    ON expensive_tools.tool_id = Query4.tool_id AND expensive_tools.Date = Query4.Date AND jobs.p_m_order_id = Query4.p_m_order_id
                WHERE jobs.project_id = $id
                );

            CREATE TEMPORARY TABLE report AS (
                SELECT Tool, id, Date, PMOrder, Activity, ActivityType, Hour, Remark, CountOfDate, DateCode, CountOfp_m_order_id, PMOrderCode
                FROM reportx
                );
            ")
        );

        $report = DB::table('report')->get()->groupBy('Tool');

        //dd($report);

        return view('print.expensivetool',compact('project','pmorder','report'));
    }

    public function toollist()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE pmcount AS (
                SELECT tool_p_m_intervals.tool_id, Count(tool_p_m_intervals.Activity) AS CountOfActivity
                FROM tool_p_m_intervals
                GROUP BY tool_p_m_intervals.tool_id
                );

            CREATE TEMPORARY TABLE preusecount AS (
                SELECT tool_pre_uses.tool_id, Count(tool_pre_uses.Activity) AS CountOfActivity
                FROM tool_pre_uses
                GROUP BY tool_pre_uses.tool_id
                );
            ")
        );

        $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_catagories.MeasuringTool, pmcount.CountOfActivity AS PM, preusecount.CountOfActivity AS PreUse, tools.RegisterDate, employees.ThaiName AS Responsible
            FROM ((employees
            INNER JOIN (tool_catagories
                INNER JOIN tools
                    INNER JOIN ( SELECT tool_updates.tool_id
                        FROM tool_updates
                        INNER JOIN ( SELECT tool_id, MAX(created_at) AS max_created_at
                            FROM tool_updates
                            GROUP BY tool_id) AS max_tool_updates
                        ON tool_updates.tool_id = max_tool_updates.tool_id AND tool_updates.created_at = max_tool_updates.max_created_at
                        WHERE tool_updates.Status NOT IN("Lost","Cut off")) AS tool_available
                    ON tools.id = tool_available.tool_id
                ON tool_catagories.id = tools.tool_catagory_id)
            ON employees.id = tools.Responsible)
            LEFT JOIN pmcount
            ON tools.id = pmcount.tool_id)
            LEFT JOIN preusecount
            ON tools.id = preusecount.tool_id
            ORDER BY tools.RegisterDate');

        return view('print.toollist',compact('tool'));
    }

    public function toolsitereport(Request $request)
    {
        $project_id = $request->get('project_id');
        $type = $request->get('type');
        $group = $request->get('Group');

        if ( $type == 'Picked') {
            $project = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer
                FROM projects
                WHERE projects.id='.$project_id.'');
            if ( $group == "All" ) {
                $tool = DB::select('SELECT tool_catagory_sites.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagory_sites.PickQuantity, tool_catagories.Unit, tool_catagory_sites.Remark
                    FROM tool_catagories
                    INNER JOIN tool_catagory_sites
                    ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                    WHERE tool_catagory_sites.project_id='.$project_id.'
                    ORDER BY tool_catagories.CatagoryName');
            } else {
                if ( $group == "No Group" ) {
                    $tool = DB::select('SELECT tool_catagory_sites.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagory_sites.PickQuantity, tool_catagories.Unit, tool_catagory_sites.Remark
                        FROM tool_catagories
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE tool_catagory_sites.project_id='.$project_id.' AND tool_catagory_sites.Group IS NULL
                        ORDER BY tool_catagories.CatagoryName');
                } else {
                    $tool = DB::select('SELECT tool_catagory_sites.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagory_sites.PickQuantity, tool_catagories.Unit, tool_catagory_sites.Remark
                        FROM tool_catagories
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE tool_catagory_sites.project_id='.$project_id.' AND tool_catagory_sites.Group = '.$group.'
                        ORDER BY tool_catagories.CatagoryName');
                }
            }

            return view('print.toolpick',compact('project','tool'));
        } else {
            $createTempTables = DB::unprepared(DB::raw("
                CREATE TEMPORARY TABLE tool_onsite AS (
                    SELECT tool_updates.tool_id, Count(tool_updates.id) AS CountOfonsite, tool_updates.Status, tool_catagory_sites.project_id
                    FROM tool_catagory_sites INNER JOIN tool_updates ON tool_catagory_sites.id = tool_updates.tool_catagory_site_id
                    GROUP BY tool_updates.tool_id, tool_updates.Status, tool_catagory_sites.project_id
                    HAVING (((tool_updates.Status)='On Site') AND ((tool_catagory_sites.project_id)=$project_id))
                    );

                CREATE TEMPORARY TABLE tool_return AS (
                    SELECT tool_updates.tool_id, Count(tool_updates.id) AS CountOfreturn, tool_updates.Status, tool_catagory_sites.project_id
                    FROM tool_catagory_sites INNER JOIN tool_updates ON tool_catagory_sites.id = tool_updates.tool_catagory_site_id
                    GROUP BY tool_updates.tool_id, tool_updates.Status, tool_catagory_sites.project_id
                    HAVING (((tool_updates.Status)='Returned') AND ((tool_catagory_sites.project_id)=$project_id))
                    );

                CREATE TEMPORARY TABLE tool_lost AS (
                    SELECT tool_updates.tool_id, Count(tool_updates.id) AS CountOflost, tool_updates.Status, tool_catagory_sites.project_id
                    FROM tool_catagory_sites INNER JOIN tool_updates ON tool_catagory_sites.id = tool_updates.tool_catagory_site_id
                    GROUP BY tool_updates.tool_id, tool_updates.Status, tool_catagory_sites.project_id
                    HAVING (((tool_updates.Status)='Lost') AND ((tool_catagory_sites.project_id)=$project_id))
                    );

                CREATE TEMPORARY TABLE tool_broken AS (
                    SELECT tool_updates.tool_id, Count(tool_updates.id) AS CountOfbroken, tool_updates.Status, tool_catagory_sites.project_id
                    FROM tool_catagory_sites INNER JOIN tool_updates ON tool_catagory_sites.id = tool_updates.tool_catagory_site_id
                    GROUP BY tool_updates.tool_id, tool_updates.Status, tool_catagory_sites.project_id
                    HAVING (((tool_updates.Status)='Broken') AND ((tool_catagory_sites.project_id)=$project_id))
                    );

                CREATE TEMPORARY TABLE tool_site_status AS (
                    SELECT tool_updates.tool_id, tool_updates.STATUS, tool_updates.created_at
                    FROM tool_catagory_sites
                    INNER JOIN tool_updates 
                    ON tool_catagory_sites.id = tool_updates.tool_catagory_site_id
                    WHERE tool_catagory_sites.project_id = $project_id
                    );

                CREATE TEMPORARY TABLE tool_site_status_max AS (
                    SELECT tool_id, MAX(created_at) AS MaxCreatedAt
                    FROM tool_site_status
                    GROUP BY tool_id
                    );

                CREATE TEMPORARY TABLE tool_site_status_now AS (
                    SELECT tool_site_status.tool_id, tool_site_status.STATUS
                    FROM tool_site_status
                    INNER JOIN tool_site_status_max 
                    ON tool_site_status.tool_id = tool_site_status_max.tool_id AND tool_site_status.created_at = tool_site_status_max.MaxCreatedAt
                    );

                CREATE TEMPORARY TABLE tool_site_count AS (
                    SELECT tool_id, IF(STATUS='On Site',1,0) AS OnSite, IF(STATUS='Return',1,0) AS Returned, IF(STATUS='Lost',1,0) AS Lost, IF(STATUS='Broken',1,0) AS Broken
                    FROM tool_site_status_now
                    );
                ")
            );

            $project = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, projects.SiteEngineer
                FROM projects
                WHERE (((projects.id)='.$project_id.'))');
            if ( $group == "All" ) {
                $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagories.Unit, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_site_count.OnSite, tool_site_count.Returned, tool_site_count.Lost, tool_site_count.Broken
                    FROM tool_catagories
                    INNER JOIN tools
                        INNER JOIN tool_site_count
                        ON tools.id = tool_site_count.tool_id
                    ON tool_catagories.id = tools.tool_catagory_id');
                $onsite = DB::select('SELECT tool_id
                    FROM tool_site_count
                    WHERE OnSite=1');
                $return = DB::select('SELECT tool_id
                    FROM tool_site_count
                    WHERE Returned=1');
                $lost = DB::select('SELECT tool_id
                    FROM tool_site_count
                    WHERE Lost=1');
                $broken = DB::select('SELECT tool_id
                    FROM tool_site_count
                    WHERE Broken=1');
            } else {
                if ( $group == "No Group" ) {
                    $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagories.Unit, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_site_count.OnSite, tool_site_count.Returned, tool_site_count.Lost, tool_site_count.Broken
                        FROM tool_catagories
                        INNER JOIN tools
                            INNER JOIN tool_site_count
                            ON tools.id = tool_site_count.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE tool_catagory_sites.Group IS NULL AND tool_catagory_sites.project_id = '.$project_id.'');
                    $onsite = DB::select('SELECT tool_site_count.tool_id
                        FROM tool_catagories
                        INNER JOIN tools
                            INNER JOIN tool_site_count
                            ON tools.id = tool_site_count.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE OnSite=1 AND tool_catagory_sites.Group IS NULL AND tool_catagory_sites.project_id = '.$project_id.'');
                    $return = DB::select('SELECT tool_site_count.tool_id
                        FROM tool_catagories
                        INNER JOIN tools
                            INNER JOIN tool_site_count
                            ON tools.id = tool_site_count.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE Returned=1 AND tool_catagory_sites.Group IS NULL AND tool_catagory_sites.project_id = '.$project_id.'');
                    $lost = DB::select('SELECT tool_site_count.tool_id
                        FROM tool_catagories
                        INNER JOIN tools
                            INNER JOIN tool_site_count
                            ON tools.id = tool_site_count.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE Lost=1 AND tool_catagory_sites.Group IS NULL AND tool_catagory_sites.project_id = '.$project_id.'');
                    $broken = DB::select('SELECT tool_site_count.tool_id
                        FROM tool_catagories
                        INNER JOIN tools
                            INNER JOIN tool_site_count
                            ON tools.id = tool_site_count.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE Broken=1 AND tool_catagory_sites.Group IS NULL AND tool_catagory_sites.project_id = '.$project_id.'');
                } else {
                    $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagories.Unit, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_site_count.OnSite, tool_site_count.Returned, tool_site_count.Lost, tool_site_count.Broken
                        FROM tool_catagories
                        INNER JOIN tools
                            INNER JOIN tool_site_count
                            ON tools.id = tool_site_count.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE tool_catagory_sites.Group ='.$group.' AND tool_catagory_sites.project_id = '.$project_id.'');
                    $onsite = DB::select('SELECT tool_site_count.tool_id
                        FROM tool_catagories
                        INNER JOIN tools
                            INNER JOIN tool_site_count
                            ON tools.id = tool_site_count.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE OnSite=1 AND tool_catagory_sites.Group ='.$group.' AND tool_catagory_sites.project_id = '.$project_id.'');
                    $return = DB::select('SELECT tool_site_count.tool_id
                        FROM tool_catagories
                        INNER JOIN tools
                            INNER JOIN tool_site_count
                            ON tools.id = tool_site_count.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE Returned=1 AND tool_catagory_sites.Group ='.$group.' AND tool_catagory_sites.project_id = '.$project_id.'');
                    $lost = DB::select('SELECT tool_site_count.tool_id
                        FROM tool_catagories
                        INNER JOIN tools
                            INNER JOIN tool_site_count
                            ON tools.id = tool_site_count.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE Lost=1 AND tool_catagory_sites.Group ='.$group.' AND tool_catagory_sites.project_id = '.$project_id.'');
                    $broken = DB::select('SELECT tool_site_count.tool_id
                        FROM tool_catagories
                        INNER JOIN tools
                            INNER JOIN tool_site_count
                            ON tools.id = tool_site_count.tool_id
                        ON tool_catagories.id = tools.tool_catagory_id
                        INNER JOIN tool_catagory_sites
                        ON tool_catagories.id = tool_catagory_sites.tool_catagory_id
                        WHERE Broken=1 AND tool_catagory_sites.Group ='.$group.' AND tool_catagory_sites.project_id = '.$project_id.'');
                }
            }

            return view('print.toolused',compact('project','tool','onsite','return','lost','broken'));
        }
    }

    public function toolpmplan(Request $request)
    {
        $year = $request->get('year');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE pm_plan AS (
                SELECT tool_p_m_intervals.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, employees.ThaiName AS Responsible, tool_p_m_intervals.Activity,
                    IF( ISNULL(tool_p_m_s.PMDate),
                        DATE_ADD(tools.RegisterDate, INTERVAL tool_p_m_intervals.Interval DAY),
                        DATE_ADD(tool_p_m_s.PMDate, INTERVAL tool_p_m_intervals.Interval DAY)
                    ) AS PDate,
                    IF( Year(tool_p_m_s.PMDate) = $year ,
                        tool_p_m_s.PMDate,
                        '0000-00-00'
                    ) AS ADate
                FROM employees
                INNER JOIN (((tool_catagories
                    INNER JOIN tools
                        INNER JOIN ( SELECT tool_updates.tool_id
                            FROM tool_updates
                            INNER JOIN ( SELECT tool_id, MAX(created_at) AS max_created_at
                                FROM tool_updates
                                GROUP BY tool_id) AS max_tool_updates
                            ON tool_updates.tool_id = max_tool_updates.tool_id AND tool_updates.created_at = max_tool_updates.max_created_at
                            WHERE tool_updates.Status IN('Available','Lend','Calibrating','Broken','On Site','Return')) AS tool_available
                        ON tools.id = tool_available.tool_id
                    ON tool_catagories.id = tools.tool_catagory_id)
                    INNER JOIN tool_p_m_intervals
                    ON tools.id = tool_p_m_intervals.tool_id)
                    LEFT JOIN tool_p_m_s
                    ON tool_p_m_intervals.id = tool_p_m_s.tool_p_m_interval_id)
                ON employees.id = tools.Responsible
                WHERE ((Year(IF( ISNULL(tool_p_m_s.PMDate), DATE_ADD(tools.RegisterDate, INTERVAL tool_p_m_intervals.Interval DAY), DATE_ADD(tool_p_m_s.PMDate, INTERVAL tool_p_m_intervals.Interval DAY)))=$year) OR (Year(tool_p_m_s.PMDate)=$year))
                );
            ")
        );

        $plan = DB::select('SELECT pm_plan.id, pm_plan.CatagoryName, pm_plan.RangeCapacity, pm_plan.Brand, pm_plan.Model, pm_plan.SerialNumber, pm_plan.LocalCode, pm_plan.DurableSupplieCode, pm_plan.AssetToolCode, pm_plan.Responsible, pm_plan.Activity,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 01) THEN 1 ELSE 0 END) AS PJan,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 01) THEN 1 ELSE 0 END) AS AJan,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 02) THEN 1 ELSE 0 END) AS PFeb,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 02) THEN 1 ELSE 0 END) AS AFeb,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 03) THEN 1 ELSE 0 END) AS PMar,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 03) THEN 1 ELSE 0 END) AS AMar,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 04) THEN 1 ELSE 0 END) AS PApr,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 04) THEN 1 ELSE 0 END) AS AApr,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 05) THEN 1 ELSE 0 END) AS PMay,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 05) THEN 1 ELSE 0 END) AS AMay,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 06) THEN 1 ELSE 0 END) AS PJun,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 06) THEN 1 ELSE 0 END) AS AJun,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 07) THEN 1 ELSE 0 END) AS PJul,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 07) THEN 1 ELSE 0 END) AS AJul,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 08) THEN 1 ELSE 0 END) AS PAug,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 08) THEN 1 ELSE 0 END) AS AAug,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 09) THEN 1 ELSE 0 END) AS PSep,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 09) THEN 1 ELSE 0 END) AS ASep,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 10) THEN 1 ELSE 0 END) AS POct,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 10) THEN 1 ELSE 0 END) AS AOct,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 11) THEN 1 ELSE 0 END) AS PNov,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 11) THEN 1 ELSE 0 END) AS ANov,
            MAX(CASE WHEN (MONTH(pm_plan.PDate) = 12) THEN 1 ELSE 0 END) AS PDec,
            MAX(CASE WHEN (MONTH(pm_plan.ADate) = 12) THEN 1 ELSE 0 END) AS ADec
            FROM pm_plan
            GROUP BY pm_plan.id, pm_plan.CatagoryName, pm_plan.RangeCapacity, pm_plan.Brand, pm_plan.Model, pm_plan.SerialNumber, pm_plan.LocalCode, pm_plan.DurableSupplieCode, pm_plan.AssetToolCode, pm_plan.Responsible, pm_plan.Activity');
        //$test = DB::table('pm_plan')->get();
        //dd($test);

        return view('print.toolpmplan',compact('plan','year'));
    }

    public function toolpmrecord(Request $request, $id)
    {
        $tool = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.LocalCode, tools.SerialNumber, tools.DurableSupplieCode, tools.AssetToolCode, tools.Brand, tools.Model, tools.RegisterDate, employees.ThaiName AS Responsible, tools.id
            FROM employees INNER JOIN (tool_catagories INNER JOIN tools ON tool_catagories.id = tools.tool_catagory_id) ON employees.id = tools.Responsible
            WHERE (((tools.id)='.$id.'))');

        $record = DB::select('SELECT tool_p_m_s.PMDate, tool_p_m_intervals.Activity, tool_p_m_s.Operator, tool_p_m_s.Result, tool_p_m_s.Remark, tool_p_m_intervals.tool_id
            FROM tool_p_m_intervals INNER JOIN tool_p_m_s ON tool_p_m_intervals.id = tool_p_m_s.tool_p_m_interval_id
            WHERE (((tool_p_m_intervals.tool_id)='.$id.'))
            UNION
            SELECT tool_breakdowns.updated_at AS PMDate, tool_breakdowns.Operation AS Activity, tool_breakdowns.Operator, tool_breakdowns.Result, tool_breakdowns.Report AS Remark, tool_breakdowns.tool_id
            FROM tool_breakdowns
            WHERE (((tool_breakdowns.tool_id)='.$id.'))');

        return view('print.toolpmrecord',compact('tool','record'));
    }

    public function toolpreuse(Request $request)
    {
        $request->validate([
            'month'=>'required|digits:2',
            'year'=>'required|digits:4',
            'selected_tool'=>'required'
        ]);

        $day = cal_days_in_month(CAL_GREGORIAN,$request->get('month'),$request->get('year'));
        $month = $request->get('month');
        $year = $request->get('year');

        $tool = DB::select('SELECT tool_catagories.CatagoryName, tools.LocalCode, tools.SerialNumber, tools.DurableSupplieCode, tools.AssetToolCode, tools.Brand, tools.Model, tools.id
            FROM tool_catagories INNER JOIN tools ON tool_catagories.id = tools.tool_catagory_id
            WHERE (((tools.id)='.$request->get('selected_tool').'))');

        $activity = DB::select('SELECT tool_pre_uses.Activity, tool_pre_uses.Remark, tool_pre_uses.tool_id
            FROM tool_pre_uses
            WHERE (((tool_pre_uses.tool_id)='.$request->get('selected_tool').'))');


        //$test = DB::table('test')->get();
        //dd($day);

        return view('print.toolpreuse',compact('day','month','year','tool','activity'));
    }

    public function toolreport(Request $request)
    {
        $year = $request->get('year');
        $month = $request->get('month');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE PM_plan AS (
                SELECT tool_p_m_s.tool_p_m_interval_id, DATE_ADD(tool_p_m_s.PMDate, INTERVAL tool_p_m_intervals.Interval DAY) AS Plan
                FROM tool_p_m_intervals INNER JOIN tool_p_m_s ON tool_p_m_intervals.id = tool_p_m_s.tool_p_m_interval_id
                WHERE ((YEAR(DATE_ADD(tool_p_m_s.PMDate, INTERVAL tool_p_m_intervals.Interval DAY))=$year) AND (MONTH(DATE_ADD(tool_p_m_s.PMDate, INTERVAL tool_p_m_intervals.Interval DAY))=$month))
                );

            CREATE TEMPORARY TABLE PM_actual AS (
                SELECT tool_p_m_s.tool_p_m_interval_id, tool_p_m_s.PMDate AS Actual
                FROM tool_p_m_intervals INNER JOIN tool_p_m_s ON tool_p_m_intervals.id = tool_p_m_s.tool_p_m_interval_id
                WHERE ((YEAR(tool_p_m_s.PMDate)=$year) AND (MONTH(tool_p_m_s.PMDate)=$month))
                );
            ")
        );

        $PM = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_p_m_intervals.Activity, PM_plan.Plan, PM_actual.Actual
            FROM ((tool_catagories INNER JOIN (tools INNER JOIN tool_p_m_intervals ON tools.id = tool_p_m_intervals.tool_id) ON tool_catagories.id = tools.tool_catagory_id) LEFT JOIN PM_actual ON tool_p_m_intervals.id = PM_actual.tool_p_m_interval_id) INNER JOIN PM_plan ON tool_p_m_intervals.id = PM_plan.tool_p_m_interval_id
            WHERE ((ISNULL(PM_actual.Actual)))');

        $breakdown = DB::select('SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tools.Brand, tools.Model, tools.SerialNumber, tool_breakdowns.Report, tool_breakdowns.Cause, tool_breakdowns.Value, tool_breakdowns.Guideline, tool_breakdowns.Result, tool_breakdowns.created_at
            FROM (tool_catagories INNER JOIN tools ON tool_catagories.id = tools.tool_catagory_id) INNER JOIN tool_breakdowns ON tools.id = tool_breakdowns.tool_id
            WHERE ((YEAR(tool_breakdowns.created_at)='.$year.') AND (MONTH(tool_breakdowns.created_at)='.$month.'))');

        //$test = DB::table('PM_actual')->get();
        //dd($PM);

        return view('print.toolreport',compact('PM','breakdown','month'));
    }

    public function WFHWFAactual(Request $request)
    {
        $id = $request->get('weekreport');

        $week = Week::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE point_result AS (
                SELECT employees.WorkID, Sum(IFNULL(w_f_h_w_f_a_jobs.AcceptPoint,0)) AS AssigneeResult, 0 AS AssignorResult
                FROM employees INNER JOIN (w_f_h_w_f_a_assignments LEFT JOIN w_f_h_w_f_a_jobs ON w_f_h_w_f_a_assignments.id = w_f_h_w_f_a_jobs.assignment_id) ON employees.id = w_f_h_w_f_a_assignments.Assignee
                GROUP BY employees.WorkID, w_f_h_w_f_a_assignments.week_id
                HAVING (((w_f_h_w_f_a_assignments.week_id)=$id))
                UNION
                SELECT employees.WorkID, 0 AS AssigneeResult, Sum(IFNULL(w_f_h_w_f_a_jobs.AcceptPoint,0)/2) AS AssignorResult
                FROM employees INNER JOIN (w_f_h_w_f_a_assignments LEFT JOIN w_f_h_w_f_a_jobs ON w_f_h_w_f_a_assignments.id = w_f_h_w_f_a_jobs.assignment_id) ON employees.id = w_f_h_w_f_a_jobs.Assignor
                GROUP BY w_f_h_w_f_a_assignments.week_id, employees.WorkID
                HAVING (((w_f_h_w_f_a_assignments.week_id)=$id))
                );

            CREATE TEMPORARY TABLE point_week AS (
                SELECT point_result.WorkID, FORMAT(Sum(point_result.AssigneeResult+point_result.AssignorResult),2) AS WeekPoint
                FROM point_result
                GROUP BY point_result.WorkID
                );

            CREATE TEMPORARY TABLE point_detail AS (
                SELECT employees.WorkID, routine_jobs.RoutineJobName, routine_jobs.KPI, routine_jobs.Point, w_f_h_w_f_a_jobs.Detail, w_f_h_w_f_a_jobs.TargetPoint, w_f_h_w_f_a_jobs.AcceptPoint, employees_1.ThaiName AS Assignor, FORMAT(IF(point_week.WeekPoint/w_f_h_w_f_a_assignments.Point>2,5,1+2*(point_week.WeekPoint/w_f_h_w_f_a_assignments.Point)),2) AS KPIPoint
                FROM employees AS employees_1 RIGHT JOIN (routine_jobs RIGHT JOIN (point_week INNER JOIN (employees INNER JOIN (w_f_h_w_f_a_assignments LEFT JOIN w_f_h_w_f_a_jobs ON w_f_h_w_f_a_assignments.id = w_f_h_w_f_a_jobs.assignment_id) ON employees.id = w_f_h_w_f_a_assignments.Assignee) ON point_week.WorkID = employees.WorkID) ON routine_jobs.id = w_f_h_w_f_a_jobs.routine_job_id) ON employees_1.id = w_f_h_w_f_a_jobs.Assignor
                WHERE (((w_f_h_w_f_a_assignments.week_id)=$id))
                UNION
                SELECT employees.WorkID, routine_jobs.RoutineJobName, '' AS KPI, routine_jobs.Point, 'มอบหมายงานและตรวจสอบ' AS Detail, w_f_h_w_f_a_jobs.TargetPoint/2 AS TargetPoint, w_f_h_w_f_a_jobs.AcceptPoint/2 AS AcceptPoint, employees_1.ThaiName AS Assignor, FORMAT(IF(point_week.WeekPoint/w_f_h_w_f_a_assignments.Point>2,5,1+2*(point_week.WeekPoint/w_f_h_w_f_a_assignments.Point)),2) AS KPIPoint
                FROM employees AS employees_1 RIGHT JOIN ((point_week INNER JOIN employees ON point_week.WorkID = employees.WorkID) INNER JOIN (routine_jobs INNER JOIN (w_f_h_w_f_a_assignments RIGHT JOIN w_f_h_w_f_a_jobs ON w_f_h_w_f_a_assignments.id = w_f_h_w_f_a_jobs.assignment_id) ON routine_jobs.id = w_f_h_w_f_a_jobs.routine_job_id) ON employees.id = w_f_h_w_f_a_jobs.Assignor) ON employees_1.id = w_f_h_w_f_a_assignments.Assignee
                WHERE (((w_f_h_w_f_a_assignments.week_id)=$id))
                );

            CREATE TEMPORARY TABLE report AS (
                SELECT CONCAT(point_detail.WorkID,' // ',employees.ThaiName,' // Day - ',w_f_h_w_f_a_assignments.Day,' // Target - ',w_f_h_w_f_a_assignments.Point,' // Result - ',point_week.WeekPoint,' // KPI - ',point_detail.KPIPoint) AS Header, point_detail.RoutineJobName, point_detail.KPI, point_detail.Point, point_detail.Detail, point_detail.TargetPoint, point_detail.AcceptPoint, point_detail.Assignor
                FROM point_week INNER JOIN ((employees INNER JOIN point_detail ON employees.WorkID = point_detail.WorkID) INNER JOIN w_f_h_w_f_a_assignments ON employees.id = w_f_h_w_f_a_assignments.Assignee) ON point_week.WorkID = employees.WorkID
                );
            ")
        );

        $report = DB::table('report')->orderBy('Header','asc')->get()->groupBy('Header');

        //$test = DB::table('point_detail')->get();
        //dd($test);

        return view('print.WFHWFAactual',compact('week','report'));
    }

    public function WFHWFAplan(Request $request)
    {
        $id = $request->get('week_id');
        $workid = $request->get('WorkID');

        $week = DB::select('SELECT weeks.StartOfWeek, weeks.EndOfWeek, employees.WorkID, employees.ThaiName
            FROM weeks INNER JOIN (employees INNER JOIN w_f_h_w_f_a_assignments ON employees.id = w_f_h_w_f_a_assignments.Assignee) ON weeks.id = w_f_h_w_f_a_assignments.week_id
            GROUP BY weeks.StartOfWeek, weeks.EndOfWeek, employees.WorkID, employees.ThaiName, w_f_h_w_f_a_assignments.week_id
            HAVING (((employees.WorkID)='.$workid.') AND ((w_f_h_w_f_a_assignments.week_id)='.$id.'))');

        $report = DB::select('SELECT routine_jobs.RoutineJobName, routine_jobs.KPI, routine_jobs.Point, w_f_h_w_f_a_jobs.Detail, w_f_h_w_f_a_jobs.TargetPoint, employees.WorkID, employees_1.ThaiName AS Assignor
            FROM employees AS employees_1 INNER JOIN (employees INNER JOIN (w_f_h_w_f_a_assignments INNER JOIN (routine_jobs INNER JOIN w_f_h_w_f_a_jobs ON routine_jobs.id = w_f_h_w_f_a_jobs.routine_job_id) ON w_f_h_w_f_a_assignments.id = w_f_h_w_f_a_jobs.assignment_id) ON employees.id = w_f_h_w_f_a_assignments.Assignee) ON employees_1.id = w_f_h_w_f_a_jobs.Assignor
            GROUP BY routine_jobs.RoutineJobName, routine_jobs.KPI, routine_jobs.Point, w_f_h_w_f_a_jobs.Detail, w_f_h_w_f_a_jobs.TargetPoint, employees.WorkID, employees_1.ThaiName, w_f_h_w_f_a_assignments.week_id
            HAVING (((employees.WorkID)='.$workid.') AND ((w_f_h_w_f_a_assignments.week_id)='.$id.'))
            ORDER BY routine_jobs.RoutineJobName');

        //$test = DB::table('timesheet')->get();
        //dd($report);

        return view('print.WFHWFAplan',compact('week','report'));
    }

    public function workpermit($id)
    {
        $workpermit = WorkPermit::find($id);
        $requester = Employee::find($workpermit->Requester);
        $department = Department::find($requester->department_id);
        //dd($report);

        return view('print.workpermit',compact('workpermit','requester','department'));
    }

    public function worklist($id)
    {
        $project = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, employees.ThaiName AS Planner, employees_1.ThaiName AS AreaManager
        FROM employees AS employees_1 RIGHT JOIN (employees RIGHT JOIN projects ON employees.id = projects.Planner) ON employees_1.id = projects.AreaManager
        WHERE (((projects.id)='.$id.'))');

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE worklist AS (
                SELECT projectdetailx.LocationName, projectdetailx.ProductName, projectdetailx.MachineName, projectdetailx.SystemName, projectdetailx.SpecificName, projectdetailx.Order, projectdetailx.ActivityName, projectdetailx.Detail, projectdetailx.Remark, count_system.CountOfSystemName, count_system.SystemCode, count_equipment.EquipmentCode, count_equipment.CountOfEquipmentName
                FROM ((SELECT locations.LocationName, products.ProductName, CONCAT(machines.MachineName,'//',machine_sets.Remark) AS MachineName, systems.SystemName, items.SpecificName, activities.Order, activities.ActivityName, activities.Detail, jobs.Remark, jobs.project_id
                    FROM locations
                        INNER JOIN (machines
                            INNER JOIN (machine_sets
                                INNER JOIN (equipment
                                    INNER JOIN (systems
                                        INNER JOIN (products
                                            INNER JOIN (item_sets
                                                INNER JOIN ((items
                                                    INNER JOIN jobs
                                                    ON items.id = jobs.item_id)
                                                    INNER JOIN activities
                                                    ON items.id = activities.item_id)
                                                ON item_sets.id = items.item_set_id)
                                            ON products.id = item_sets.product_id)
                                        ON systems.id = item_sets.system_id)
                                    ON equipment.id = item_sets.equipment_id)
                                ON machine_sets.id = items.machine_set_id)
                            ON machines.id = machine_sets.machine_id)
                        ON locations.id = machine_sets.location_id
                    WHERE (((jobs.project_id)=$id))
                    ORDER BY locations.LocationName, products.ProductName, CONCAT(machines.MachineName,'//',machine_sets.Remark), systems.SystemName, items.SpecificName, activities.Order) AS projectdetailx
                    INNER JOIN (SELECT projectdetailx.LocationName, projectdetailx.ProductName, projectdetailx.MachineName, projectdetailx.SystemName, Count(projectdetailx.SystemName) AS CountOfSystemName, CONCAT_WS('-',projectdetailx.LocationName, projectdetailx.ProductName, projectdetailx.MachineName, projectdetailx.SystemName) AS SystemCode
                        FROM (SELECT locations.LocationName, products.ProductName, CONCAT(machines.MachineName,'//',machine_sets.Remark) AS MachineName, systems.SystemName, items.SpecificName, activities.Order, activities.ActivityName, activities.Detail, jobs.Remark, jobs.project_id
                            FROM locations
                                INNER JOIN (machines
                                    INNER JOIN (machine_sets
                                        INNER JOIN (equipment
                                            INNER JOIN (systems
                                                INNER JOIN (products
                                                    INNER JOIN (item_sets
                                                        INNER JOIN ((items
                                                            INNER JOIN jobs
                                                            ON items.id = jobs.item_id)
                                                            INNER JOIN activities
                                                            ON items.id = activities.item_id)
                                                        ON item_sets.id = items.item_set_id)
                                                    ON products.id = item_sets.product_id)
                                                ON systems.id = item_sets.system_id)
                                            ON equipment.id = item_sets.equipment_id)
                                        ON machine_sets.id = items.machine_set_id)
                                    ON machines.id = machine_sets.machine_id)
                                ON locations.id = machine_sets.location_id
                            WHERE (((jobs.project_id)=$id))
                            ORDER BY locations.LocationName, products.ProductName, CONCAT(machines.MachineName,'//',machine_sets.Remark), systems.SystemName, items.SpecificName, activities.Order) AS projectdetailx
                        GROUP BY projectdetailx.LocationName, projectdetailx.ProductName, projectdetailx.MachineName, projectdetailx.SystemName) AS count_system
                    ON (projectdetailx.SystemName = count_system.SystemName) AND (projectdetailx.MachineName = count_system.MachineName) AND (projectdetailx.ProductName = count_system.ProductName) AND (projectdetailx.LocationName = count_system.LocationName))
                    INNER JOIN (SELECT projectdetailx.LocationName, projectdetailx.ProductName, projectdetailx.MachineName, projectdetailx.SystemName, projectdetailx.SpecificName, Concat_WS('-',LocationName,ProductName,MachineName,SystemName,SpecificName) AS EquipmentCode, Count(projectdetailx.SpecificName) AS CountOfEquipmentName
                        FROM (SELECT locations.LocationName, products.ProductName, CONCAT(machines.MachineName,'//',machine_sets.Remark) AS MachineName, systems.SystemName, items.SpecificName, activities.Order, activities.ActivityName, activities.Detail, jobs.Remark, jobs.project_id
                            FROM locations
                                INNER JOIN (machines
                                    INNER JOIN (machine_sets
                                        INNER JOIN (equipment
                                            INNER JOIN (systems
                                                INNER JOIN (products
                                                    INNER JOIN (item_sets
                                                        INNER JOIN ((items
                                                            INNER JOIN jobs
                                                            ON items.id = jobs.item_id)
                                                            INNER JOIN activities
                                                            ON items.id = activities.item_id)
                                                        ON item_sets.id = items.item_set_id)
                                                    ON products.id = item_sets.product_id)
                                                ON systems.id = item_sets.system_id)
                                            ON equipment.id = item_sets.equipment_id)
                                        ON machine_sets.id = items.machine_set_id)
                                    ON machines.id = machine_sets.machine_id)
                                ON locations.id = machine_sets.location_id
                            WHERE (((jobs.project_id)=$id))
                            ORDER BY locations.LocationName, products.ProductName, CONCAT(machines.MachineName,'//',machine_sets.Remark), systems.SystemName, items.SpecificName, activities.Order) AS projectdetailx
                        GROUP BY projectdetailx.LocationName, projectdetailx.ProductName, projectdetailx.MachineName, projectdetailx.SystemName, projectdetailx.SpecificName) AS count_equipment
                    ON (projectdetailx.SpecificName = count_equipment.SpecificName) AND (projectdetailx.SystemName = count_equipment.SystemName) AND (projectdetailx.MachineName = count_equipment.MachineName) AND (projectdetailx.ProductName = count_equipment.ProductName) AND (projectdetailx.LocationName = count_equipment.LocationName)
                ORDER BY projectdetailx.LocationName, projectdetailx.ProductName, projectdetailx.MachineName, projectdetailx.SystemName, projectdetailx.SpecificName, projectdetailx.Order
                );
            ")
        );

        $worklist = DB::table('worklist')->get()->groupBy(['LocationName','MachineName','ProductName']);

        //$test = DB::table('worklist')->get();
        //dd($project);

        return view('print.worklist',compact('project','worklist'));
    }
}
