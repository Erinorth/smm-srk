<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Project;
use App\Models\ConsumableSite;
use App\Models\ToolUpdate;

class PackingController extends Controller
{
    public function project(Request $request, $id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE packing AS (
                SELECT consumable_sites.id, consumables.ConsumableName AS Name, consumables.Detail, consumables.Unit, consumable_sites.Pick AS Quantity, consumable_sites.Remark, consumable_sites.Packing, Sum(consumables.Cost*consumable_sites.Pick) AS Price, Sum(consumables.Weight*consumable_sites.Pick) AS Weight, 'consumable' AS Type
                FROM p_m_orders INNER JOIN (consumables INNER JOIN consumable_sites ON consumables.id = consumable_sites.consumable_id) ON p_m_orders.id = consumable_sites.p_m_order_id
                GROUP BY consumable_sites.id, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumable_sites.Pick, consumable_sites.Remark, consumable_sites.Packing, p_m_orders.project_id
                HAVING (((p_m_orders.project_id)=$id))
                UNION
                SELECT tool_updates.id, CONCAT(tool_catagories.CatagoryName, tool_catagories.RangeCapacity) AS Name, CONCAT(tools.Brand, tools.Model, tools.SerialNumber, tools.LocalCode, tools.DurableSupplieCode, tools.AssetToolCode) AS Detail, tool_catagories.Unit, 1 AS Quantity, tool_updates.Remark, tool_updates.Packing, tools.Price, tools.Weight, 'tool' AS Type
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
                WHERE tool_catagory_sites.project_id=$id
                );
            ")
        );

        $packinglist = DB::select('SELECT packing.Packing
            FROM packing
            GROUP BY packing.Packing
            ORDER BY packing.Packing');

        if($request->ajax())
        {
            $data = DB::table('packing')->get();
            return DataTables::of($data)
                ->editColumn('Quantity', function($data) {
                    return '<div class="text-center">'.$data->Quantity.'</div>';
                })
                ->editColumn('Unit', function($data) {
                    return '<div class="text-center">'.$data->Unit.'</div>';
                })
                ->editColumn('Price', function($data) {
                    return '<div class="text-center">'.$data->Price.'</div>';
                })
                ->editColumn('Weight', function($data) {
                    return '<div class="text-center">'.$data->Weight.'</div>';
                })
                ->editColumn('Packing', function($data) {
                    return '<div class="text-center">'.$data->Packing.'</div>';
                })
                ->addColumn('action', function($data) {
                    if ( $data->Type == "consumable" ) {
                        return '
                            <div class="text-center">
                                <button class="edit consumable btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            </div>
                        ';
                    } else {
                        return '
                            <div class="text-center">
                                <button class="edit tool btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="'.$data->id.'" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            </div>
                        ';
                    }
                })
                ->rawColumns(['Quantity','Unit','Price','Weight','Packing','action'])
                ->make(true);
        }

        /*$test = DB::table('packing')->get();
        dd($test);*/

        return view('packings.project',compact('project','packinglist'));
    }

    public function consumableedit($id)
    {
        if(request()->ajax())
        {
            $data = ConsumableSite::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function tooledit($id)
    {
        if(request()->ajax())
        {
            $data = ToolUpdate::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function consumableupdate(Request $request, ConsumableSite $id)
    {
        $form_data = array(
            'Packing' => $request->Packing,
        );

        ConsumableSite::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function toolupdate(Request $request, ToolUpdate $id)
    {
        $form_data = array(
            'Packing' => $request->Packing,
        );

        ToolUpdate::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }
}
