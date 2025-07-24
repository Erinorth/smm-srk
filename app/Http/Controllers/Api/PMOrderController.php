<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PMOrder;
use DB;
use Illuminate\Http\Request;

class PMOrderController extends Controller
{
    public function manhour()
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE pmorder AS (
                SELECT p_m_orders.id, p_m_orders.project_id, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.Remark
                FROM p_m_orders
                INNER JOIN projects
                ON p_m_orders.project_id = projects.id
                WHERE p_m_orders.Status = 'ใช้งาน' AND NOW() >= DATE_ADD(projects.StartDate,INTERVAL -3 MONTH) AND NOW() <= DATE_ADD(projects.FinishDate,INTERVAL 3 MONTH) AND projects.project_type_id IN (1,2,3,4,5,6,7,11,13,14)
                );
            ")
        );

        $pmorder = DB::table('pmorder')->get();

        return response()->json($pmorder);
    }
}
