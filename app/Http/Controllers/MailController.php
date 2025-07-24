<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\Certificate;
use App\Mail\Facility;
use App\Mail\FinishProject;
use App\Mail\Milestone;
use App\Mail\Overtime;
use App\Mail\Plan;
use App\Mail\PMOrder;
use App\Mail\RequestMan;
use App\Mail\ToolCalibrate;
use App\Mail\ToolPM;
use PHPMailer\PHPMailer\PHPMailer;
use DB;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function certificate()
    {
        $dropTempTables = DB::unprepared(DB::raw("
                DROP TABLE IF EXISTS require_measuring ;
                DROP TABLE IF EXISTS current_measuring ;
                DROP TABLE IF EXISTS all_measuring ;
                DROP TABLE IF EXISTS mail_measuring_am ;
                DROP TABLE IF EXISTS mail_measuring_responsible ;
                DROP TABLE IF EXISTS mail_measuring_all ;
                DROP TABLE IF EXISTS require_man ;
                DROP TABLE IF EXISTS current_man ;
                DROP TABLE IF EXISTS all_man_cer ;
                DROP TABLE IF EXISTS mail_man_cer ;
                DROP TABLE IF EXISTS mail_man_cer_am ;
                DROP TABLE IF EXISTS mail_man_cer_responsible ;
                DROP TABLE IF EXISTS mail_man_cer_all ;
                DROP TABLE IF EXISTS all_recipient ;
            ")
        );

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE require_measuring AS (
                SELECT tools.id, tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tool_catagories.Unit, tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode, tool_catagory_sites.project_id
                FROM tool_catagory_sites
                INNER JOIN tool_catagories
                    INNER JOIN tools
                    ON tool_catagories.id = tools.tool_catagory_id
                ON tool_catagory_sites.tool_catagory_id = tool_catagories.id
                INNER JOIN projects
                ON tool_catagory_sites.project_id = projects.id
                WHERE tool_catagories.MeasuringTool = 'Yes' AND projects.FinishDate >= NOW() AND (DAYOFWEEK(NOW()) = 2 OR NOW() >= DATE_ADD(projects.StartDate,INTERVAL -7 DAY))
                );

            CREATE TEMPORARY TABLE current_measuring AS (
                SELECT tool_project_certificates.id, tool_calibrates.tool_id, tool_calibrates.ExpireDate, tool_calibrates.Attachment
                FROM tool_project_certificates
                INNER JOIN tool_calibrates
                ON tool_project_certificates.tool_calibrate_id = tool_calibrates.id
                INNER JOIN projects
                ON tool_project_certificates.project_id = projects.id
                WHERE projects.FinishDate >= NOW()
                );

            CREATE TEMPORARY TABLE all_measuring AS (
                SELECT require_measuring.id, require_measuring.CatagoryName, require_measuring.RangeCapacity, require_measuring.Unit, require_measuring.Brand, require_measuring.Model, require_measuring.SerialNumber, require_measuring.LocalCode, require_measuring.DurableSupplieCode, require_measuring.AssetToolCode, current_measuring.ExpireDate, current_measuring.Attachment, require_measuring.project_id
                FROM require_measuring
                LEFT JOIN current_measuring
                ON require_measuring.id = current_measuring.tool_id
                WHERE current_measuring.ExpireDate < NOW() OR current_measuring.ExpireDate IS NULL
                );

            CREATE TEMPORARY TABLE mail_measuring_am AS (
                SELECT all_measuring.*, employees.EGATEmail
                FROM all_measuring
                INNER JOIN projects
                    INNER JOIN employees
                    ON projects.AreaManager = employees.id
                ON all_measuring.project_id = projects.id
                );

            CREATE TEMPORARY TABLE mail_measuring_responsible AS (
                SELECT all_measuring.*, employees.EGATEmail
                FROM all_measuring
                INNER JOIN responsibles
                    INNER JOIN employees
                    ON responsibles.Responsible = employees.id
                ON all_measuring.project_id = responsibles.project_id
                WHERE responsibles.Duty IN (2,3,5,7)
                );

            CREATE TEMPORARY TABLE mail_measuring_all AS (
                SELECT *
                FROM mail_measuring_am
                UNION
                SELECT *
                FROM mail_measuring_responsible
                );

            CREATE TEMPORARY TABLE require_man AS (
                SELECT responsible_certificates.certificate_type_id, responsibles.Duty AS job_position_id, responsibles.Responsible AS employee_id, responsibles.project_id
                FROM responsibles
                INNER JOIN responsible_certificates
                ON responsibles.Duty = responsible_certificates.job_position_id
                INNER JOIN projects
                ON responsibles.project_id = projects.id
                WHERE projects.FinishDate >= NOW() AND (DAYOFWEEK(NOW()) = 2 OR NOW() >= DATE_ADD(projects.StartDate,INTERVAL -7 DAY))
                UNION
                SELECT 56 AS certificate_type_id, 4 AS job_position_id, mobilization_plans.employee_id, mobilization_plans.project_id
                FROM mobilization_plans
                INNER JOIN projects
                ON mobilization_plans.project_id = projects.id
                WHERE projects.FinishDate >= NOW() AND (DAYOFWEEK(NOW()) = 2 OR NOW() >= DATE_ADD(projects.StartDate,INTERVAL -7 DAY))
                GROUP BY certificate_type_id, job_position_id, employee_id
                );

            CREATE TEMPORARY TABLE current_man AS (
                SELECT employee_certificates.id, employee_certificates.certificate_type_id, employee_certificates.employee_id, employee_certificates.EffectiveDate, employee_certificates.Attachment
                FROM project_employee_certificates
                INNER JOIN employee_certificates
                ON project_employee_certificates.employee_certificate_id = employee_certificates.id
                INNER JOIN projects
                ON project_employee_certificates.project_id = projects.id
                WHERE projects.FinishDate >= NOW()
                );

            CREATE TEMPORARY TABLE all_man_cer AS (
                SELECT current_man.id, require_man.certificate_type_id, require_man.employee_id, employees.WorkID, employees.ThaiName, certificate_types.TypeName, DATE_ADD(current_man.EffectiveDate,INTERVAL certificate_types.Age DAY) AS ExpireDate, current_man.Attachment, require_man.job_position_id, require_man.project_id
                FROM require_man
                LEFT JOIN current_man
                ON require_man.certificate_type_id = current_man.certificate_type_id AND require_man.employee_id = current_man.employee_id
                INNER JOIN employees
                ON require_man.employee_id = employees.id
                INNER JOIN certificate_types
                ON require_man.certificate_type_id = certificate_types.id
                GROUP BY current_man.id, require_man.certificate_type_id, require_man.employee_id, employees.WorkID, employees.ThaiName, certificate_types.TypeName, DATE_ADD(current_man.EffectiveDate,INTERVAL certificate_types.Age DAY), current_man.Attachment, require_man.job_position_id, require_man.project_id
                HAVING ExpireDate < NOW() OR ExpireDate IS NULL
                );

            CREATE TEMPORARY TABLE mail_man_cer AS (
                SELECT all_man_cer.*, employees.EGATEmail
                FROM all_man_cer
                INNER JOIN employees
                ON all_man_cer.employee_id = employees.id
                );

            CREATE TEMPORARY TABLE mail_man_cer_am AS (
                SELECT all_man_cer.*, employees.EGATEmail
                FROM all_man_cer
                INNER JOIN projects
                    INNER JOIN employees
                    ON projects.AreaManager = employees.id
                ON all_man_cer.project_id = projects.id
                );

            CREATE TEMPORARY TABLE mail_man_cer_responsible AS (
                SELECT all_man_cer.*, employees.EGATEmail
                FROM all_man_cer
                INNER JOIN responsibles
                    INNER JOIN employees
                    ON responsibles.Responsible = employees.id
                ON all_man_cer.project_id = responsibles.project_id
                WHERE responsibles.Duty IN (2,3,5)
                );

            CREATE TEMPORARY TABLE mail_man_cer_all AS (
                SELECT *
                FROM mail_man_cer
                UNION
                SELECT *
                FROM mail_man_cer_am
                UNION
                SELECT *
                FROM mail_man_cer_responsible
                );

            CREATE TEMPORARY TABLE all_recipient AS (
                SELECT EGATEmail
                FROM mail_measuring_all
                UNION
                SELECT EGATEmail
                FROM mail_man_cer_all
                );
            ")
        );

        $recipient = DB::table('all_recipient')
            ->select('EGATEmail')
            ->groupBy('EGATEmail')
            ->pluck('EGATEmail')
            ->toArray();

        foreach ($recipient as $value) {
            $mail_measuring_all = DB::table('mail_measuring_all')
                ->where('EGATEmail', '=', $value)
                ->get();

            $mail_man_cer_all = DB::table('mail_man_cer_all')
                ->where('EGATEmail', '=', $value)
                ->get();

            Mail::to($value)->send(new Certificate($mail_measuring_all, $mail_man_cer_all));
        }
    }

    public function facility()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE facility AS (
                SELECT support_tools.*
                FROM support_tools
                INNER JOIN projects
                ON support_tools.project_id = projects.id
                WHERE support_tools.Type = 'Measuring Tools' AND support_tools.Attachment IS NULL AND projects.FinishDate >= NOW() AND (DAYOFWEEK(NOW()) = 2 OR NOW() >= DATE_ADD(support_tools.UseDate,INTERVAL -7 DAY))
                );

            CREATE TEMPORARY TABLE mail_facility_am AS (
                SELECT facility.*, employees.EGATEmail
                FROM facility
                INNER JOIN projects
                    INNER JOIN employees
                    ON projects.AreaManager = employees.id
                ON facility.project_id = projects.id
                );

            CREATE TEMPORARY TABLE mail_facility_responsible AS (
                SELECT facility.*, employees.EGATEmail
                FROM facility
                INNER JOIN responsibles
                    INNER JOIN employees
                    ON responsibles.Responsible = employees.id
                ON facility.project_id = responsibles.project_id
                WHERE responsibles.Duty IN (2,3,5)
                );

            CREATE TEMPORARY TABLE mail_facility_all AS (
                SELECT *
                FROM mail_facility_am
                UNION ALL
                SELECT *
                FROM mail_facility_responsible
                );

            CREATE TEMPORARY TABLE crane AS (
                SELECT project_cranes.*, locations.LocationName, machines.MachineName, CONCAT(machine_sets.Remark,IFNULL(CONCAT('//',machine_sets.SerialNumber),'')) AS Detail, DATE_ADD(crane_certificates.TestDate,INTERVAL 182 DAY) AS ExpireDate
                FROM project_cranes
                INNER JOIN projects
                ON project_cranes.project_id = projects.id
                INNER JOIN machine_sets
                    INNER JOIN locations
                    ON machine_sets.location_id = locations.id
                    INNER JOIN machines
                    ON machine_sets.machine_id = machines.id
                ON project_cranes.machine_set_id = machine_sets.id
                LEFT JOIN crane_certificates
                ON project_cranes.crane_certificate_id = crane_certificates.id
                WHERE (project_cranes.crane_certificate_id IS NULL OR DATE_ADD(crane_certificates.TestDate,INTERVAL 182 DAY) < projects.FinishDate) AND projects.FinishDate >= NOW() AND (DAYOFWEEK(NOW()) = 2 OR NOW() >= DATE_ADD(project_cranes.UseDate,INTERVAL -7 DAY))
                );

            CREATE TEMPORARY TABLE mail_crane_am AS (
                SELECT crane.*, employees.EGATEmail
                FROM crane
                INNER JOIN projects
                    INNER JOIN employees
                    ON projects.AreaManager = employees.id
                ON crane.project_id = projects.id
                );

            CREATE TEMPORARY TABLE mail_crane_responsible AS (
                SELECT crane.*, employees.EGATEmail
                FROM crane
                INNER JOIN responsibles
                    INNER JOIN employees
                    ON responsibles.Responsible = employees.id
                ON crane.project_id = responsibles.project_id
                WHERE responsibles.Duty IN (2,3,5)
                );

            CREATE TEMPORARY TABLE mail_crane_all AS (
                SELECT *
                FROM mail_crane_am
                UNION ALL
                SELECT *
                FROM mail_crane_responsible
                );

            CREATE TEMPORARY TABLE all_recipient AS (
                SELECT EGATEmail
                FROM (SELECT mail_facility_all.EGATEmail
                FROM mail_facility_all
                UNION ALL
                SELECT mail_crane_all.EGATEmail
                FROM mail_crane_all) t
                GROUP BY EGATEmail
                );
            ")
        );

        $recipient = DB::table('all_recipient')
            ->select('EGATEmail')
            ->groupBy('EGATEmail')
            ->pluck('EGATEmail')
            ->toArray();

        foreach ($recipient as $value) {
            $mail_facility_all = DB::table('mail_facility_all')
                ->where('EGATEmail', '=', $value)
                ->get();

            $mail_crane_all = DB::table('mail_crane_all')
                ->where('EGATEmail', '=', $value)
                ->get();

            Mail::to($value)->send(new Facility($mail_facility_all, $mail_crane_all));
        }
    }

    public function finishproject()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE finish_project AS (
                SELECT projects.ProjectName, project_types.TypeName, projects.StartDate, projects.FinishDate, projects.SiteEngineer
                FROM projects
                INNER JOIN project_types
                ON projects.project_type_id = project_types.id
                WHERE DATE_ADD(projects.FinishDATE,INTERVAL -3 DAY) <= NOW() AND projects.FinishDATE > NOW()
                );

            CREATE TEMPORARY TABLE mail_planner AS (
                SELECT finish_project.ProjectName, finish_project.TypeName, finish_project.StartDate, finish_project.FinishDate, employees.EGATEmail
                FROM finish_project
                INNER JOIN employees
                ON finish_project.SiteEngineer = employees.id
                );

            CREATE TEMPORARY TABLE mail_head AS (
                SELECT employees.EGATEmail, t.EGATEmail AS HeadEGATEmail
                FROM employees
                INNER JOIN employees AS t
                ON employees.department_id = t.department_id
                WHERE t.Admin = 'Head' AND employees.id != t.id
                );

            CREATE TEMPORARY TABLE mail_head_planner AS (
                SELECT mail_planner.ProjectName, mail_planner.TypeName, mail_planner.StartDate, mail_planner.FinishDate, mail_head.HeadEGATEmail AS EGATEmail
                FROM mail_planner
                INNER JOIN mail_head
                ON mail_planner.EGATEmail = mail_head.EGATEmail
                );

            CREATE TEMPORARY TABLE mail_all AS (
                SELECT *
                FROM mail_planner
                UNION ALL
                SELECT *
                FROM mail_head_planner
                );

            CREATE TEMPORARY TABLE mail_all_group AS (
                SELECT *
                FROM mail_all
                GROUP BY ProjectName, TypeName, StartDate, FinishDate, EGATEmail
                );
            ")
        );

        $recipient = DB::table('mail_all_group')
            ->select('EGATEmail')
            ->groupBy('EGATEmail')
            ->pluck('EGATEmail')
            ->toArray();

        foreach ($recipient as $value) {
            $near_finish = DB::table('mail_all_group')
                ->where('EGATEmail', '=', $value)
                ->orderBy('ProjectName', 'asc')
                ->orderBy('FinishDate', 'asc')
                ->get();

            Mail::to($value)->send(new FinishProject($near_finish));
        }
    }

    public function milestone()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE mile_stone_update AS (
                SELECT mile_stone_updates.mile_stone_id, mile_stone_updates.Status, mile_stone_updates.Remark
                FROM mile_stone_updates
                INNER JOIN(SELECT mile_stone_id, Max(created_at) AS MaxOfcreated_at
                    FROM mile_stone_updates
                    GROUP BY mile_stone_id) t
                ON mile_stone_updates.mile_stone_id = t.mile_stone_id AND mile_stone_updates.created_at = t.MaxOfcreated_at
                INNER JOIN mile_stones
                    INNER JOIN projects
                    ON mile_stones.project_id = projects.id
                ON mile_stone_updates.mile_stone_id = mile_stones.id
                WHERE NOW() <= DATE_ADD(projects.FinishDate,INTERVAL 30 DAY)
                );

            CREATE TEMPORARY TABLE not_complete_milestone AS (
                SELECT mile_stones.id, mile_stones.project_id, mile_stone_activity_id, IFNULL(mile_stone_update.Status,'Not Start') AS Status, mile_stone_update.Remark
                FROM mile_stones
                LEFT JOIN mile_stone_update
                ON mile_stones.id = mile_stone_update.mile_stone_id
                INNER JOIN mile_stone_activities
                ON mile_stones.mile_stone_activity_id = mile_stone_activities.id
                INNER JOIN projects
                ON mile_stones.project_id = projects.id
                WHERE (mile_stone_activities.BeforeStart IS NOT NULL OR mile_stone_activities.AfterStart IS NOT NULL OR mile_stone_activities.BeforeFinish IS NOT NULL OR mile_stone_activities.AfterFinish IS NOT NULL) AND NOW() <= DATE_ADD(projects.FinishDate,INTERVAL 30 DAY)
                HAVING Status IN ('Not Start','In Progress')
                );

            CREATE TEMPORARY TABLE one_time_milestone AS (
                SELECT not_complete_milestone.id, project_types.TypeName, not_complete_milestone.project_id, projects.ProjectName, mile_stone_activities.Activity, not_complete_milestone.Status, not_complete_milestone.Remark, mile_stone_activities.Link, mile_stone_activities.Dynamic, mile_stone_activities.Responsible,
                    IF(mile_stone_activities.BeforeStart IS NOT NULL,
                        DATE_ADD(projects.StartDate, INTERVAL -mile_stone_activities.BeforeStart DAY),
                        IF(mile_stone_activities.AfterStart IS NOT NULL,
                            DATE_ADD(projects.StartDate, INTERVAL mile_stone_activities.AfterStart DAY),
                            IF(mile_stone_activities.BeforeFinish IS NOT NULL,
                                DATE_ADD(projects.FinishDate, INTERVAL -mile_stone_activities.BeforeFinish DAY),
                                DATE_ADD(projects.FinishDate, INTERVAL mile_stone_activities.AfterFinish DAY)
                            )
                        )
                    ) AS DueDate
                FROM not_complete_milestone
                INNER JOIN projects
                    INNER JOIN project_types
                    ON projects.project_type_id = project_types.id
                ON not_complete_milestone.project_id = projects.id
                INNER JOIN mile_stone_activities
                ON not_complete_milestone.mile_stone_activity_id = mile_stone_activities.id
                );

            CREATE TEMPORARY TABLE daily_milestone AS (
                SELECT mile_stones.id, project_types.TypeName, mile_stones.project_id, projects.ProjectName, mile_stone_activities.Activity, 'Inprogress' AS Status, '' AS Remark, mile_stone_activities.Link, mile_stone_activities.Dynamic, mile_stone_activities.Responsible, NOW() AS DueDate
                FROM mile_stones
                INNER JOIN mile_stone_activities
                ON mile_stones.mile_stone_activity_id = mile_stone_activities.id
                INNER JOIN projects
                    INNER JOIN project_types
                    ON projects.project_type_id = project_types.id
                ON mile_stones.project_id = projects.id
                WHERE mile_stone_activities.BeforeStart IS NULL AND mile_stone_activities.AfterStart IS NULL AND mile_stone_activities.BeforeFinish IS NULL AND mile_stone_activities.AfterFinish IS NULL AND projects.StartDate <= NOW() AND projects.FinishDate >= NOW()
                );

            CREATE TEMPORARY TABLE all_milestone AS (
                SELECT *
                FROM one_time_milestone
                UNION
                SELECT *
                FROM daily_milestone
                );

            CREATE TEMPORARY TABLE mail_am AS (
                SELECT all_milestone.id, all_milestone.TypeName, all_milestone.project_id, all_milestone.ProjectName, all_milestone.Activity, all_milestone.Status, all_milestone.Remark, all_milestone.Link, all_milestone.Dynamic, all_milestone.DueDate, employees.EGATEmail
                FROM all_milestone
                INNER JOIN projects
                    INNER JOIN employees
                    ON projects.AreaManager = employees.id
                ON all_milestone.project_id = projects.id
                WHERE all_milestone.Responsible IN (1,2,3,4,5,7,8,9)
                );

            CREATE TEMPORARY TABLE mail_planer AS (
                SELECT all_milestone.id, all_milestone.TypeName, all_milestone.project_id, all_milestone.ProjectName, all_milestone.Activity, all_milestone.Status, all_milestone.Remark, all_milestone.Link, all_milestone.Dynamic, all_milestone.DueDate, employees.EGATEmail
                FROM all_milestone
                INNER JOIN projects
                    INNER JOIN employees
                    ON projects.SiteEngineer = employees.id
                ON all_milestone.project_id = projects.id
                WHERE all_milestone.Responsible IN (6,10)
                );

            CREATE TEMPORARY TABLE mail_responsible AS (
                SELECT all_milestone.id, all_milestone.TypeName, all_milestone.project_id, all_milestone.ProjectName, all_milestone.Activity, all_milestone.Status, all_milestone.Remark, all_milestone.Link, all_milestone.Dynamic, all_milestone.DueDate, employees.EGATEmail
                FROM all_milestone
                INNER JOIN responsibles
                    INNER JOIN employees
                    ON responsibles.Responsible = employees.id
                ON all_milestone.Responsible = responsibles.Duty AND all_milestone.project_id = responsibles.project_id
                );

            CREATE TEMPORARY TABLE mail_all AS (
                SELECT t.id, t.TypeName, t.project_id, t.ProjectName, t.Activity, t.Status, t.Remark, t.Link, t.Dynamic, t.DueDate, t.EGATEmail
                FROM (SELECT *
                FROM mail_am
                UNION
                SELECT *
                FROM mail_planer
                UNION
                SELECT *
                FROM mail_responsible) t
                WHERE NOW() >= DATE_ADD(t.DueDate,INTERVAL -7 DAY)
                GROUP BY t.id, t.TypeName, t.project_id, t.ProjectName, t.Activity, t.Status, t.Remark, t.Link, t.Dynamic, t.DueDate, t.EGATEmail
                );
            ")
        );

        $recipient = DB::table('mail_all')
            ->select('EGATEmail')
            ->groupBy('EGATEmail')
            ->pluck('EGATEmail')
            ->toArray();

        foreach ($recipient as $value) {
            $milestone = DB::table('mail_all')
                ->where('EGATEmail', '=', $value)
                ->orderBy('DueDate', 'asc')
                ->get();

            Mail::to($value)->send(new Milestone($milestone));
        }
    }

    public function overtime()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE date AS (
                SELECT Date AS OTDate
                FROM dates
                WHERE (Year = YEAR(NOW()) OR Year = YEAR(DATE_ADD(NOW(), INTERVAL 1 MONTH))) AND (Month = MONTH(NOW()) OR Month = MONTH(DATE_ADD(NOW(), INTERVAL 1 MONTH)))
                );

            CREATE TEMPORARY TABLE update_date AS (
                SELECT Date AS OTDate
                FROM dates
                WHERE YEAR(DATE_ADD(NOW(), INTERVAL -1 WEEK)) = Year AND WEEK(DATE_ADD(NOW(), INTERVAL -1 WEEK)) = Week AND DayofWeek = 7
                );

            CREATE TEMPORARY TABLE max_actual AS (
                SELECT MAX(WorkingDate) AS MaxActualDate, employee_id, SUM(IFNULL(OT1+OT15+OT2+OT3,0)) AS Actual
                FROM man_hours
                WHERE YEAR(NOW()) = Year(WorkingDate) AND MONTH(NOW()) = MONTH(WorkingDate)
                GROUP BY employee_id
                );

            CREATE TEMPORARY TABLE employee AS (
                SELECT employee_id
                FROM support_men
                INNER JOIN date
                ON DATE_ADD(support_men.StartDate, INTERVAL -1 DAY) = date.OTDate
                UNION
                SELECT employee_id
                FROM man_hours
                INNER JOIN date
                ON man_hours.WorkingDate = date.OTDate
                UNION
                SELECT employee_id
                FROM plan_o_t_s
                INNER JOIN date
                ON plan_o_t_s.PlanDate = date.OTDate
                );

            CREATE TEMPORARY TABLE employee_date AS (
                SELECT employee.employee_id, date.OTDate
                FROM employee
                CROSS JOIN date
                );

            CREATE TEMPORARY TABLE data AS (
                SELECT t.employee_id, t.OTDate, max_actual.Actual,
                    IF(IFNULL(max_actual.MaxActualDate,'1998-01-01') >= update_date.OTDate,
                        max_actual.MaxActualDate,
                        update_date.OTDate
                    )AS ActualDate,
                    IF(IFNULL(max_actual.MaxActualDate,'1998-01-01') >= update_date.OTDate,
                        IF(t.OTDate <= max_actual.MaxActualDate,
                            t.request+t.Actual,
                            t.PlanHour
                        ),
                        IF(t.OTDate <= update_date.OTDate,
                            t.request+t.Actual,
                            t.PlanHour
                        )
                    )AS OT
                FROM (SELECT employee_date.employee_id, employee_date.OTDate, IFNULL(support_men.OT,0) AS request, IFNULL(man_hours.OT1+man_hours.OT15+man_hours.OT2+man_hours.OT3,0) AS Actual, IFNULL(plan_o_t_s.PlanHour,0) AS PlanHour
                    FROM employee_date
                    LEFT JOIN support_men
                    ON employee_date.employee_id = support_men.employee_id AND employee_date.OTDate = DATE_ADD(support_men.StartDate, INTERVAL -1 DAY)
                    LEFT JOIN man_hours
                    ON employee_date.employee_id = man_hours.employee_id AND employee_date.OTDate = man_hours.WorkingDate
                    LEFT JOIN plan_o_t_s
                    ON employee_date.employee_id = plan_o_t_s.employee_id AND employee_date.OTDate = plan_o_t_s.PlanDate) t
                JOIN update_date
                LEFT JOIN max_actual
                ON t.employee_id = max_actual.employee_id
                ORDER BY t.employee_id, t.OTDate
                );

            CREATE TEMPORARY TABLE order_record AS (
                SELECT OTDate, OT, ActualDate, Actual,
                    @group_id := @group_id AS previous_employee_id,
                    @group_id := employee_id AS employee_id,
                    @group_year := @group_year AS previous_year,
                    @group_year := YEAR(OTDate) AS plan_year,
                    @group_month := @group_month AS previous_month,
                    @group_month := MONTH(OTDate) AS plan_month
                FROM data
                JOIN (SELECT @group_id:=0, @group_year:=0, @group_month:=0) r
                );

            CREATE TEMPORARY TABLE running_total_by_group AS (
                SELECT OTDate, employee_id, OT, ActualDate, Actual,
                IF(previous_employee_id != employee_id,
                    @running_total := 0,
                    IF(previous_year != plan_year,
                        @running_total := 0,
                        IF(previous_month != plan_month,
                            @running_total := 0,
                            1))) AS Reset,
                @running_total := @running_total + OT AS cumulative_sum
                FROM order_record
                JOIN (SELECT @running_total:=0) r
                );

            CREATE TEMPORARY TABLE combine AS (
                SELECT running_total_by_group.OTDate, running_total_by_group.employee_id, employees.WorkID, employees.ThaiName, employees.EGATEmail, employees.department_id, running_total_by_group.cumulative_sum, plan_o_t_s.project_id, IFNULL(o_t_frames.Frame,0) AS Frame, running_total_by_group.ActualDate, running_total_by_group.Actual
                FROM running_total_by_group
                INNER JOIN employees
                ON running_total_by_group.employee_id = employees.id
                INNER JOIN plan_o_t_s
                ON running_total_by_group.OTDate = plan_o_t_s.PlanDate AND running_total_by_group.employee_id = plan_o_t_s.employee_id
                LEFT JOIN o_t_frames
                ON YEAR(running_total_by_group.OTDate) = o_t_frames.Year AND MONTH(running_total_by_group.OTDate) = o_t_frames.Month AND running_total_by_group.employee_id = o_t_frames.employee_id
                );

            CREATE TEMPORARY TABLE min_this_month AS (
                SELECT MIN(OTDate) AS OTDate, employee_id
                FROM combine
                WHERE YEAR(OTDate) = YEAR(NOW()) AND MONTH(OTDate) = MONTH(NOW()) AND cumulative_sum > Frame
                GROUP BY employee_id
                );

            CREATE TEMPORARY TABLE min_next_month AS (
                SELECT MIN(OTDate) AS OTDate, employee_id
                FROM combine
                WHERE IF(MONTH(NOW()) = 12,YEAR(OTDate) = YEAR(NOW())+1 AND MONTH(OTDate) = 1,YEAR(OTDate) = YEAR(NOW()) AND MONTH(OTDate) = MONTH(NOW())+1) AND cumulative_sum > Frame
                GROUP BY employee_id
                );

            CREATE TEMPORARY TABLE all_man_x AS (
                SELECT combine.OTDate, combine.employee_id, combine.WorkID, combine.ThaiName, combine.EGATEmail, combine.department_id, combine.cumulative_sum, combine.project_id, combine.Frame, combine.ActualDate, combine.Actual
                FROM combine
                INNER JOIN min_this_month
                ON combine.OTDate = min_this_month.OTDate AND combine.employee_id = min_this_month.employee_id
                UNION ALL
                SELECT combine.OTDate, combine.employee_id, combine.WorkID, combine.ThaiName, combine.EGATEmail, combine.department_id, combine.cumulative_sum, combine.project_id, combine.Frame, combine.ActualDate, combine.Actual
                FROM combine
                INNER JOIN min_next_month
                ON combine.OTDate = min_next_month.OTDate AND combine.employee_id = min_next_month.employee_id
                );

            CREATE TEMPORARY TABLE all_man AS (
                SELECT OTDate, employee_id, WorkID, ThaiName, EGATEmail, department_id, cumulative_sum, project_id, Frame, ActualDate, Actual
                FROM all_man_x
                WHERE NOW() >= DATE_ADD(OTDate,INTERVAL -5 DAY)
                GROUP BY OTDate, employee_id, WorkID, ThaiName, EGATEmail, department_id, cumulative_sum, project_id, Frame, ActualDate, Actual
                );

            CREATE TEMPORARY TABLE mail_am AS (
                SELECT all_man.OTDate, all_man.employee_id, all_man.WorkID, all_man.ThaiName, employees.EGATEmail, all_man.department_id, all_man.cumulative_sum, all_man.project_id, all_man.Frame, all_man.ActualDate, all_man.Actual
                FROM all_man
                INNER JOIN projects
                    INNER JOIN employees
                    ON projects.AreaManager = employees.id
                ON all_man.project_id = projects.id
                );

            CREATE TEMPORARY TABLE mail_sup AS (
                SELECT all_man.OTDate, all_man.employee_id, all_man.WorkID, all_man.ThaiName, employees.EGATEmail, all_man.department_id, all_man.cumulative_sum, all_man.project_id, all_man.Frame, all_man.ActualDate, all_man.Actual
                FROM all_man
                INNER JOIN responsibles
                    INNER JOIN employees
                    ON responsibles.Responsible = employees.id
                ON all_man.project_id = responsibles.project_id
                WHERE responsibles.Duty = 2
                );

            CREATE TEMPORARY TABLE mail_admin AS (
                SELECT all_man.OTDate, all_man.employee_id, all_man.WorkID, all_man.ThaiName, t.EGATEmail, all_man.department_id, all_man.cumulative_sum, all_man.project_id, all_man.Frame, all_man.ActualDate, all_man.Actual
                FROM all_man
                JOIN (SELECT EGATEmail
                    FROM employees
                    WHERE Admin = 'Admin') t
                );

            CREATE TEMPORARY TABLE mail_head AS (
                SELECT employees.EGATEmail, t.EGATEmail AS HeadEGATEmail
                FROM employees
                INNER JOIN employees AS t
                ON employees.department_id = t.department_id
                WHERE t.Admin = 'Head' AND employees.id != t.id
                );

            CREATE TEMPORARY TABLE mail_head_am AS (
                SELECT mail_am.OTDate, mail_am.employee_id, mail_am.WorkID, mail_am.ThaiName, mail_head.HeadEGATEmail AS EGATEmail, mail_am.department_id, mail_am.cumulative_sum, mail_am.project_id, mail_am.Frame, mail_am.ActualDate, mail_am.Actual
                FROM mail_am
                INNER JOIN mail_head
                ON mail_am.EGATEmail = mail_head.EGATEmail
                );

            CREATE TEMPORARY TABLE mail_16 AS (
                SELECT all_man.OTDate, all_man.employee_id, all_man.WorkID, all_man.ThaiName, all_man.EGATEmail, all_man.department_id, all_man.cumulative_sum, all_man.project_id, all_man.Frame, all_man.ActualDate, all_man.Actual
                FROM all_man
                INNER JOIN support_requests
                    INNER JOIN support_men
                    ON support_requests.id = support_men.support_request_id
                ON all_man.project_id = support_requests.project_id
                WHERE support_requests.Type = 'ไม่ฝากสายบังคับบัญชา'
                );

            CREATE TEMPORARY TABLE mail_head_16 AS (
                SELECT mail_16.OTDate, mail_16.employee_id, mail_16.WorkID, mail_16.ThaiName, mail_head.HeadEGATEmail AS EGATEmail, mail_16.department_id, mail_16.cumulative_sum, mail_16.project_id, mail_16.Frame, mail_16.ActualDate, mail_16.Actual
                FROM mail_16
                INNER JOIN mail_head
                ON mail_16.EGATEmail = mail_head.EGATEmail
                );

            CREATE TEMPORARY TABLE mail_all AS (
                SELECT OTDate, employee_id, WorkID, ThaiName, EGATEmail, department_id, cumulative_sum, project_id, Frame, ActualDate, Actual
                FROM all_man
                UNION ALL
                SELECT OTDate, employee_id, WorkID, ThaiName, EGATEmail, department_id, cumulative_sum, project_id, Frame, ActualDate, Actual
                FROM mail_am
                UNION ALL
                SELECT OTDate, employee_id, WorkID, ThaiName, EGATEmail, department_id, cumulative_sum, project_id, Frame, ActualDate, Actual
                FROM mail_sup
                UNION ALL
                SELECT OTDate, employee_id, WorkID, ThaiName, EGATEmail, department_id, cumulative_sum, project_id, Frame, ActualDate, Actual
                FROM mail_admin
                UNION ALL
                SELECT OTDate, employee_id, WorkID, ThaiName, EGATEmail, department_id, cumulative_sum, project_id, Frame, ActualDate, Actual
                FROM mail_head_am
                UNION ALL
                SELECT OTDate, employee_id, WorkID, ThaiName, EGATEmail, department_id, cumulative_sum, project_id, Frame, ActualDate, Actual
                FROM mail_head_16
                );

            CREATE TEMPORARY TABLE mail_all_group AS (
                SELECT OTDate, employee_id, WorkID, ThaiName, EGATEmail, department_id, cumulative_sum, project_id, Frame, ActualDate, Actual
                FROM mail_all
                GROUP BY OTDate, employee_id, WorkID, ThaiName, EGATEmail, department_id, cumulative_sum, project_id, Frame, ActualDate, Actual
                );
            ")
        );

        $recipient = DB::table('mail_all_group')
            ->select('EGATEmail')
            ->groupBy('EGATEmail')
            ->pluck('EGATEmail')
            ->toArray();

        foreach ($recipient as $value) {
            $noti_this = DB::table('mail_all_group')
                ->where('EGATEmail', '=', $value)
                ->whereMonth('OTDate', '=', DATE("n"))
                ->whereYear('OTDate', '=', DATE("Y"))
                ->orderBy('OTDate', 'asc')
                ->get();

            $noti_next = DB::table('mail_all_group')
                ->where('EGATEmail', '=', $value)
                ->whereMonth('OTDate', '=', DATE("n") + 1)
                ->whereYear('OTDate', '=', DATE("Y"))
                ->orderBy('OTDate', 'asc')
                ->get();

            $noti_year = DB::table('mail_all_group')
                ->where('EGATEmail', '=', $value)
                ->whereMonth('OTDate', '=', 1)
                ->whereYear('OTDate', '=', DATE("Y") + 1)
                ->orderBy('OTDate', 'asc')
                ->get();

            Mail::to($value)->send(new Overtime($noti_this,$noti_next,$noti_year));
        }
    }

    public function plan()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE plan AS (
                SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, employees.EGATEMail, projects.Status
                FROM employees
                INNER JOIN projects
                ON employees.id = projects.SiteEngineer
                WHERE projects.StartDate < DATE_ADD(NOW(), INTERVAL 90 DAY) AND projects.Status='Not Confirmed'
                );

            CREATE TEMPORARY TABLE mail_head AS (
                SELECT employees.EGATEmail, t.EGATEmail AS HeadEGATEmail
                FROM employees
                INNER JOIN employees AS t
                ON employees.department_id = t.department_id
                WHERE t.Admin = 'Head' AND employees.id != t.id
                );

            CREATE TEMPORARY TABLE mail_head_planner AS (
                SELECT plan.ProjectName, plan.StartDate, plan.FinishDate, mail_head.HeadEGATEmail AS EGATEMail, plan.Status
                FROM plan
                INNER JOIN mail_head
                ON plan.EGATEmail = mail_head.EGATEmail
                );

            CREATE TEMPORARY TABLE mail_all AS (
                SELECT ProjectName, StartDate, FinishDate, EGATEMail, Status
                FROM plan
                UNION ALL
                SELECT ProjectName, StartDate, FinishDate, EGATEMail, Status
                FROM mail_head_planner
                );

            CREATE TEMPORARY TABLE mail_all_group AS (
                SELECT ProjectName, StartDate, FinishDate, EGATEMail, Status
                FROM mail_all
                WHERE EGATEmail <> ''
                GROUP BY ProjectName, StartDate, FinishDate, EGATEMail, Status
                );
            ")
        );

        $recipient = DB::table('mail_all_group')
            ->select('EGATEmail')
            ->groupBy('EGATEmail')
            ->pluck('EGATEmail')
            ->toArray();

        foreach ($recipient as $value) {
            $plan = DB::table('mail_all_group')
                ->where('EGATEmail', '=', $value)
                ->orderBy('StartDate', 'asc')
                ->get();

            Mail::to($value)->send(new Plan($plan));
        }
    }

    public function pmorder()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE all_NC_pmorder AS (
                SELECT projects.ProjectName, p_m_orders.project_id, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.Remark
                FROM p_m_orders
                INNER JOIN projects
                ON p_m_orders.project_id = projects.id
                WHERE p_m_orders.id <> 1 AND p_m_orders.Status = 'ใช้งาน' AND projects.FinishDate < NOW()
                );

            CREATE TEMPORARY TABLE close_last_week AS (
                SELECT projects.ProjectName, p_m_orders.project_id, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.Remark
                FROM p_m_orders
                INNER JOIN projects
                ON p_m_orders.project_id = projects.id
                WHERE p_m_orders.id <> 1 AND p_m_orders.Status = 'ปิดงาน' AND (p_m_orders.updated_at BETWEEN DATE_ADD(NOW(), INTERVAL -7 DAY) AND NOW())
                );

            CREATE TEMPORARY TABLE mail_planner AS (
                SELECT all_NC_pmorder.ProjectName, all_NC_pmorder.project_id, all_NC_pmorder.PMOrder, all_NC_pmorder.PMOrderName, all_NC_pmorder.Remark, employees.EGATEmail
                FROM all_NC_pmorder
                INNER JOIN projects
                    INNER JOIN employees
                    ON projects.SiteEngineer = employees.id
                ON all_NC_pmorder.project_id = projects.id
                );

            CREATE TEMPORARY TABLE mail_planner_close AS (
                SELECT close_last_week.ProjectName, close_last_week.project_id, close_last_week.PMOrder, close_last_week.PMOrderName, close_last_week.Remark, employees.EGATEmail
                FROM close_last_week
                INNER JOIN projects
                    INNER JOIN employees
                    ON projects.SiteEngineer = employees.id
                ON close_last_week.project_id = projects.id
                );

            CREATE TEMPORARY TABLE mail_admin AS (
                SELECT all_NC_pmorder.ProjectName, all_NC_pmorder.project_id, all_NC_pmorder.PMOrder, all_NC_pmorder.PMOrderName, all_NC_pmorder.Remark, t.EGATEmail
                FROM all_NC_pmorder
                JOIN (SELECT EGATEmail
                    FROM employees
                    WHERE Admin = 'Admin') t
                WHERE t.EGATEmail <> 'sunisa.suwas@egat.co.th'
                );

            CREATE TEMPORARY TABLE mail_admin_close AS (
                SELECT close_last_week.ProjectName, close_last_week.project_id, close_last_week.PMOrder, close_last_week.PMOrderName, close_last_week.Remark, t.EGATEmail
                FROM close_last_week
                JOIN (SELECT EGATEmail
                    FROM employees
                    WHERE Admin = 'Admin') t
                WHERE t.EGATEmail <> 'sunisa.suwas@egat.co.th'
                );

            CREATE TEMPORARY TABLE mail_head AS (
                SELECT employees.EGATEmail, t.EGATEmail AS HeadEGATEmail
                FROM employees
                INNER JOIN employees AS t
                ON employees.department_id = t.department_id
                WHERE t.Admin = 'Head' AND employees.id != t.id
                );

            CREATE TEMPORARY TABLE mail_head_planner AS (
                SELECT mail_planner.ProjectName, mail_planner.project_id, mail_planner.PMOrder, mail_planner.PMOrderName, mail_planner.Remark, mail_head.HeadEGATEmail AS EGATEmail
                FROM mail_planner
                INNER JOIN mail_head
                ON mail_planner.EGATEmail = mail_head.EGATEmail
                );

            CREATE TEMPORARY TABLE mail_head_planner_close AS (
                SELECT mail_planner_close.ProjectName, mail_planner_close.project_id, mail_planner_close.PMOrder, mail_planner_close.PMOrderName, mail_planner_close.Remark, mail_head.HeadEGATEmail AS EGATEmail
                FROM mail_planner_close
                INNER JOIN mail_head
                ON mail_planner_close.EGATEmail = mail_head.EGATEmail
                );

            CREATE TEMPORARY TABLE mail_all_NC AS (
                SELECT ProjectName, project_id, PMOrder, PMOrderName, Remark, EGATEmail
                FROM(SELECT ProjectName, project_id, PMOrder, PMOrderName, Remark, EGATEmail
                FROM mail_planner
                UNION
                SELECT ProjectName, project_id, PMOrder, PMOrderName, Remark, EGATEmail
                FROM mail_admin
                UNION
                SELECT ProjectName, project_id, PMOrder, PMOrderName, Remark, EGATEmail
                FROM mail_head_planner) t
                GROUP BY ProjectName, project_id, PMOrder, PMOrderName, Remark, EGATEmail
                );

            CREATE TEMPORARY TABLE mail_all_C_last_week AS (
                SELECT ProjectName, project_id, PMOrder, PMOrderName, Remark, EGATEmail
                FROM(SELECT ProjectName, project_id, PMOrder, PMOrderName, Remark, EGATEmail
                FROM mail_admin_close
                UNION
                SELECT ProjectName, project_id, PMOrder, PMOrderName, Remark, EGATEmail
                FROM mail_head_planner_close) t
                GROUP BY ProjectName, project_id, PMOrder, PMOrderName, Remark, EGATEmail
                );

            CREATE TEMPORARY TABLE mail_all AS (
                SELECT EGATEmail
                FROM(SELECT EGATEmail
                FROM mail_all_NC
                UNION
                SELECT EGATEmail
                FROM mail_all_C_last_week) t
                GROUP BY EGATEmail
                HAVING EGATEmail <> ''
                );
            ")
        );

        $recipient = DB::table('mail_all')
            ->select('EGATEmail')
            ->groupBy('EGATEmail')
            ->pluck('EGATEmail')
            ->toArray();

        foreach ($recipient as $value) {
            $mail_all_NC = DB::table('mail_all_NC')
                ->where('EGATEmail', '=', $value)
                ->orderBy('ProjectName', 'asc')
                ->orderBy('PMOrder', 'asc')
                ->orderBy('PMOrderName', 'asc')
                ->get();

            $mail_all_C_last_week = DB::table('mail_all_C_last_week')
                ->where('EGATEmail', '=', $value)
                ->orderBy('ProjectName', 'asc')
                ->orderBy('PMOrder', 'asc')
                ->orderBy('PMOrderName', 'asc')
                ->get();

            Mail::to($value)->send(new PMOrder($mail_all_NC,$mail_all_C_last_week));
        }
    }

    public function request_man()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE count_man AS (
                SELECT support_request_id, COUNT(id) AS count_man
                FROM support_men
                GROUP BY support_request_id
                );

            CREATE TEMPORARY TABLE request_man AS (
                SELECT support_requests.project_id, support_requests.department_id, support_requests.Amount, count_man.count_man, projects.AreaManager
                FROM support_requests
                INNER JOIN count_man
                ON support_requests.id = count_man.support_request_id
                INNER JOIN projects
                ON support_requests.project_id = projects.id
                WHERE count_man.count_man < support_requests.Amount
                );

            CREATE TEMPORARY TABLE mail_am AS (
                SELECT request_man.department_id, request_man.Amount, request_man.count_man, employees.EGATEmail
                FROM request_man
                INNER JOIN employees
                ON request_man.AreaManager = employees.id
                );

            CREATE TEMPORARY TABLE mail_responsible AS (
                SELECT request_man.department_id, request_man.Amount, request_man.count_man, employees.EGATEmail
                FROM request_man
                INNER JOIN responsibles
                    INNER JOIN employees
                    ON responsibles.Responsible = employees.id
                ON request_man.project_id = responsibles.project_id
                WHERE responsibles.Duty = 2
                );

            CREATE TEMPORARY TABLE mail_head AS (
                SELECT employees.EGATEmail, t.EGATEmail AS HeadEGATEmail
                FROM employees
                INNER JOIN employees AS t
                ON employees.department_id = t.department_id
                WHERE t.Admin = 'Head' AND employees.id != t.id
                );

            CREATE TEMPORARY TABLE mail_head_am AS (
                SELECT mail_am.department_id, mail_am.Amount, mail_am.count_man, mail_head.HeadEGATEmail AS EGATEmail
                FROM mail_am
                INNER JOIN mail_head
                ON mail_am.EGATEmail = mail_head.EGATEmail
                );

            CREATE TEMPORARY TABLE mail_all AS (
                SELECT *
                FROM mail_am
                UNION
                SELECT *
                FROM mail_responsible
                UNION
                SELECT *
                FROM mail_head_am
                );

            CREATE TEMPORARY TABLE mail_all_group AS (
                SELECT departments.DepartmentName, mail_all.Amount, mail_all.count_man, mail_all.EGATEmail
                FROM mail_all
                INNER JOIN departments
                ON mail_all.department_id = departments.id
                GROUP BY departments.DepartmentName, mail_all.Amount, mail_all.count_man, mail_all.EGATEmail
                );
            ")
        );

        $recipient = DB::table('mail_all_group')
            ->select('EGATEmail')
            ->groupBy('EGATEmail')
            ->pluck('EGATEmail')
            ->toArray();

        foreach ($recipient as $value) {
            $request_man = DB::table('mail_all_group')
                ->where('EGATEmail', '=', $value)
                ->whereMonth('OTDate', '=', DATE("n"))
                ->whereYear('OTDate', '=', DATE("Y"))
                ->orderBy('OTDate', 'asc')
                ->get();

            Mail::to($value)->send(new RequestMan($request_man));
        }
    }

    public function tool_calibrate()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE max_calibrate AS (
                SELECT tool_calibrates.tool_id, Max(tool_calibrates.ExpireDate) AS MaxOfExpireDate
                FROM tool_calibrates
                GROUP BY tool_calibrates.tool_id
                );

            CREATE TEMPORARY TABLE max_tool_update AS (
                SELECT tool_updates.tool_id, Max(tool_updates.created_at) AS MaxOfcreated_at
                FROM tool_updates
                GROUP BY tool_updates.tool_id
                );

            CREATE TEMPORARY TABLE tool_calibrate AS (
                SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.LocalCode, tools.Brand, tools.Model, tools.SerialNumber, IF(tool_updates.Status IN ('Available','Return'),'In Store',tool_updates.Status) AS Status, tool_calibrates.Remark, employees.EGATEmail, tool_calibrates.ExpireDate AS DueDate
                FROM employees
                INNER JOIN tool_catagories
                    INNER JOIN tools
                        INNER JOIN tool_calibrates
                            INNER JOIN max_calibrate
                            ON tool_calibrates.ExpireDate = max_calibrate.MaxOfExpireDate AND tool_calibrates.tool_id = max_calibrate.tool_id
                        ON tools.id = tool_calibrates.tool_id
                    ON tool_catagories.id = tools.tool_catagory_id ON employees.id = tools.Responsible
                    INNER JOIN tool_updates
                    ON tools.id = tool_updates.tool_id
                    INNER JOIN max_tool_update
                    ON tool_updates.created_at = max_tool_update.MaxOfcreated_at AND tool_updates.tool_id = max_tool_update.tool_id
                WHERE Status IN ('Available','On Site','Return') AND MeasuringTool = 'Yes'
                HAVING DueDate < DATE_ADD(NOW(), INTERVAL 90 DAY)
                );

            CREATE TEMPORARY TABLE mail_head AS (
                SELECT employees.EGATEmail, t.EGATEmail AS HeadEGATEmail
                FROM employees
                INNER JOIN employees AS t
                ON employees.department_id = t.department_id
                WHERE t.Admin = 'Head' AND employees.id != t.id
                );

            CREATE TEMPORARY TABLE mail_head_responsible AS (
                SELECT tool_calibrate.CatagoryName, tool_calibrate.RangeCapacity, tool_calibrate.LocalCode, tool_calibrate.Brand, tool_calibrate.Model, tool_calibrate.SerialNumber, tool_calibrate.Status, tool_calibrate.Remark, mail_head.HeadEGATEmail AS EGATEmail, tool_calibrate.DueDate
                FROM tool_calibrate
                INNER JOIN mail_head
                ON tool_calibrate.EGATEmail = mail_head.EGATEmail
                );

            CREATE TEMPORARY TABLE mail_all AS (
                SELECT *
                FROM tool_calibrate
                UNION ALL
                SELECT *
                FROM mail_head_responsible
                );

            CREATE TEMPORARY TABLE mail_all_group AS (
                SELECT CatagoryName, RangeCapacity, LocalCode, Brand, Model, SerialNumber, Status, Remark, EGATEmail, DueDate
                FROM mail_all
                WHERE EGATEmail <> ''
                GROUP BY CatagoryName, RangeCapacity, LocalCode, Brand, Model, SerialNumber, Status, Remark, EGATEmail, DueDate
                );
            ")
        );

        $recipient = DB::table('mail_all_group')
            ->select('EGATEmail')
            ->groupBy('EGATEmail')
            ->pluck('EGATEmail')
            ->toArray();

        foreach ($recipient as $value) {
            $calibrate = DB::table('mail_all_group')
                ->where('EGATEmail', '=', $value)
                ->orderBy('DueDate', 'asc')
                ->get();

            Mail::to($value)->send(new ToolCalibrate($calibrate));
        }
    }

    public function tool_pm()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE max_tool_pm AS (
                SELECT tool_p_m_s.tool_p_m_interval_id, Max(tool_p_m_s.PMDate) AS MaxOfPMDate
                FROM tool_p_m_s
                GROUP BY tool_p_m_s.tool_p_m_interval_id
                );

            CREATE TEMPORARY TABLE max_tool_update AS (
                SELECT tool_updates.tool_id, Max(tool_updates.created_at) AS MaxOfcreated_at
                FROM tool_updates
                GROUP BY tool_updates.tool_id
                );

            CREATE TEMPORARY TABLE tool_pm AS (
                SELECT tool_catagories.CatagoryName, tool_catagories.RangeCapacity, tools.LocalCode, tools.Brand,tools.Model, tools.SerialNumber, IF(tool_updates.Status IN ('Available','Return'),'In Store',tool_updates.Status) AS Status, tool_p_m_s.Remark, employees.EGATEmail,
                    DATE_ADD(tool_p_m_s.PMDate, INTERVAL tool_p_m_intervals.Interval DAY) AS DueDate, tool_p_m_intervals.Activity
                FROM employees
                INNER JOIN tool_catagories
                    INNER JOIN tools
                        INNER JOIN tool_p_m_intervals
                            INNER JOIN tool_p_m_s
                                INNER JOIN max_tool_pm
                                ON tool_p_m_s.PMDate = max_tool_pm.MaxOfPMDate AND tool_p_m_s.tool_p_m_interval_id = max_tool_pm.tool_p_m_interval_id
                            ON tool_p_m_intervals.id = tool_p_m_s.tool_p_m_interval_id
                        ON tools.id = tool_p_m_intervals.tool_id
                    ON tool_catagories.id = tools.tool_catagory_id
                    INNER JOIN tool_updates
                    ON tools.id = tool_updates.tool_id
                    INNER JOIN max_tool_update
                    ON tool_updates.created_at = max_tool_update.MaxOfcreated_at AND tool_updates.tool_id = max_tool_update.tool_id
                ON employees.id = tools.Responsible
                WHERE Status IN ('Available','On Site','Return')
                HAVING DueDate < DATE_ADD(NOW(), INTERVAL 7 DAY)
                );

            CREATE TEMPORARY TABLE mail_head AS (
                SELECT employees.EGATEmail, t.EGATEmail AS HeadEGATEmail
                FROM employees
                INNER JOIN employees AS t
                ON employees.department_id = t.department_id
                WHERE t.Admin = 'Head' AND employees.id != t.id
                );

            CREATE TEMPORARY TABLE mail_head_responsible AS (
                SELECT tool_pm.CatagoryName, tool_pm.RangeCapacity, tool_pm.LocalCode, tool_pm.Brand, tool_pm.Model, tool_pm.SerialNumber, tool_pm.Status, tool_pm.Remark, tool_pm.EGATEmail, tool_pm.DueDate, tool_pm.Activity
                FROM tool_pm
                INNER JOIN mail_head
                ON tool_pm.EGATEmail = mail_head.EGATEmail
                );

            CREATE TEMPORARY TABLE mail_all AS (
                SELECT *
                FROM tool_pm
                UNION ALL
                SELECT *
                FROM mail_head_responsible
                );

            CREATE TEMPORARY TABLE mail_all_group AS (
                SELECT CatagoryName, RangeCapacity, LocalCode, Brand, Model, SerialNumber, Status, Remark, EGATEmail, DueDate, Activity
                FROM mail_all
                WHERE EGATEmail <> ''
                GROUP BY CatagoryName, RangeCapacity, LocalCode, Brand, Model, SerialNumber, Status, Remark, EGATEmail, DueDate, Activity
                );
            ")
        );

        $recipient = DB::table('mail_all_group')
            ->select('EGATEmail')
            ->groupBy('EGATEmail')
            ->pluck('EGATEmail')
            ->toArray();

        foreach ($recipient as $value) {
            $pm = DB::table('mail_all_group')
                ->where('EGATEmail', '=', $value)
                ->orderBy('DueDate', 'asc')
                ->get();

            Mail::to($value)->send(new ToolPM($pm));
        }
    }
}
