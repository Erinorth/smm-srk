<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Validator;
use App\Models\Consumable;
use App\Models\ConsumableSite;
use App\Models\ConsumableStore;
use App\Models\Item;
use App\Models\ItemConsumable;
use App\Models\Project;
use App\Models\PMOrder;

class ConsumableController extends Controller
{
    public function index(Request $request)
    {
        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE consumable AS (
                SELECT consumable_sites.consumable_id, Sum(consumable_sites.Pick) AS Pick, Sum(consumable_sites.Return) AS 'Return', Sum(0) AS 'In', Sum(0) AS 'Out', consumable_sites.Confirmed
                FROM projects INNER JOIN (p_m_orders INNER JOIN consumable_sites ON p_m_orders.id = consumable_sites.p_m_order_id) ON projects.id = p_m_orders.project_id
                GROUP BY consumable_sites.consumable_id, consumable_sites.Confirmed
                UNION
                SELECT consumable_stores.consumable_id, Sum(0) AS Pick, Sum(0) AS 'Return', Sum(consumable_stores.Quantity) AS 'In', Sum(0) AS 'Out', 'Yes' AS Confirmed
                FROM consumable_stores
                GROUP BY consumable_stores.consumable_id, 'Yes', consumable_stores.InOut
                HAVING (((consumable_stores.InOut)='In'))
                UNION
                SELECT consumable_stores.consumable_id, Sum(0) AS Pick, Sum(0) AS 'Return', Sum(0) AS 'In', Sum(consumable_stores.Quantity) AS 'Out', 'Yes' AS Confirmed
                FROM consumable_stores
                GROUP BY consumable_stores.consumable_id, 'Yes', consumable_stores.InOut
                HAVING (((consumable_stores.InOut)='Out'))
                );

            CREATE TEMPORARY TABLE consume_store AS (
                SELECT consumable.consumable_id, Sum(consumable.In-consumable.Pick+consumable.Return-consumable.Out) AS Store
                FROM consumable
                GROUP BY consumable.consumable_id, consumable.Confirmed
                HAVING (((consumable.Confirmed)='Yes'))
                );

            CREATE TEMPORARY TABLE consume_prepare AS (
                SELECT consumable.consumable_id, Sum(consumable.Pick-consumable.Return) AS Prepare
                FROM consumable
                GROUP BY consumable.consumable_id, consumable.Confirmed
                HAVING (((consumable.Confirmed)='No'))
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::select('SELECT consumables.id, consumables.ConsumableCode, consumables.PurchaseCode, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumables.Weight, consumables.Cost, consumables.Min, consumables.Max, consume_store.Store, consume_prepare.Prepare
                FROM consume_prepare RIGHT JOIN (consumables LEFT JOIN consume_store ON consumables.id = consume_store.consumable_id) ON consume_prepare.consumable_id = consumables.id
                ORDER BY consumables.ConsumableName');
            return DataTables::of($data)
                    ->editColumn('ConsumableName', function($data) {
                        $consumable = '<div class="d-none">'.$data->ConsumableName.'</div><a href="consumables/'.$data->id.'">'.$data->ConsumableName.'</a>';
                        return $consumable;
                    })
                    ->editColumn('Unit', function($data) {
                        return '<div class="text-center">'.$data->Unit.'</div>';
                    })
                    ->editColumn('Cost', function($data) {
                        return '<div class="text-center">'.$data->Cost.'</div>';
                    })
                    ->editColumn('ConsumableCode', function($data) {
                        return '<div class="text-center">'.$data->ConsumableCode.'</div>';
                    })
                    ->editColumn('PurchaseCode', function($data) {
                        return '<div class="text-center">'.$data->PurchaseCode.'</div>';
                    })
                    ->editColumn('Weight', function($data) {
                        return '<div class="text-center">'.$data->Weight.'</div>';
                    })
                    ->editColumn('Min', function($data) {
                        return '<div class="text-center">'.$data->Min.'</div>';
                    })
                    ->editColumn('Store', function($data) {
                        if ( $data->Store < $data->Min )
                        return '<div class="text-center text-danger">'.$data->Store.'</div>';
                        return '<div class="text-center">'.$data->Store.'</div>';
                    })
                    ->editColumn('Max', function($data) {
                        return '<div class="text-center">'.$data->Max.'</div>';
                    })
                    ->editColumn('Prepare', function($data) {
                        return '<div class="text-center">'.$data->Prepare.'</div>';
                    })
                    ->addColumn('action','
                    <div class="text-center">
                        @role('."'admin|head_store_keeper|store_keeper'".')
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        @else N/A
                        @endrole
                    </div>
                    ')
                    ->rawColumns(['ConsumableName','Unit','Cost','ConsumableCode','PurchaseCode','Weight','Min','Max','Prepare','Store','action'])
                    ->make(true);
        }
        return view('consumables.index');
    }

    public function store(Request $request)
    {
        $rules = array(
            'ConsumableName'=>'required',
            'Unit'=>'required',
            'Cost'=>'required|numeric',
            'ConsumableCode'=>'required',
            'PurchaseCode'=>'required',
            'Weight'=>'required',
            'Min'=>'required',
            'Max'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ConsumableName' => $request->ConsumableName,
            'Unit' => $request->Unit,
            'Detail' => $request->Detail,
            'Cost' => $request->Cost,
            'ConsumableCode' => $request->ConsumableCode,
            'PurchaseCode' => $request->PurchaseCode,
            'Weight' => $request->Weight,
            'Min' => $request->Min,
            'Max' => $request->Max
        );

        Consumable::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function show(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT consumable_sites.consumable_id, consumable_sites.created_at, projects.ProjectName, consumable_sites.Pick, consumable_sites.Return, 0 AS "In", 0 AS "Out", consumable_sites.Remark, consumable_sites.Confirmed
                FROM projects INNER JOIN (p_m_orders INNER JOIN consumable_sites ON p_m_orders.id = consumable_sites.p_m_order_id) ON projects.id = p_m_orders.project_id
                WHERE (((consumable_sites.consumable_id)='.$id.'))
                UNION
                SELECT consumable_stores.consumable_id, consumable_stores.created_at, "In/Out" AS ProjectName, 0 AS Pick, 0 AS "Return", consumable_stores.Quantity AS "In", 0 AS "Out", consumable_stores.Remark, "Yes" AS Confirmed
                FROM consumable_stores
                WHERE (((consumable_stores.consumable_id)='.$id.') AND ((consumable_stores.InOut)="In"))
                UNION
                SELECT consumable_stores.consumable_id, consumable_stores.created_at, "In/Out" AS ProjectName, 0 AS Pick, 0 AS "Return", 0 AS "In", consumable_stores.Quantity AS "Out", consumable_stores.Remark, "Yes" AS Confirmed
                FROM consumable_stores
                WHERE (((consumable_stores.consumable_id)='.$id.') AND ((consumable_stores.InOut)="Out"))');
            return DataTables::of($data)
                    ->editColumn('created_at', function($data) {
                        return '<div class="text-center">'.$data->created_at.'</div>';
                    })
                    ->editColumn('Pick', function($data) {
                        return '<div class="text-center">'.$data->Pick.'</div>';
                    })
                    ->editColumn('Return', function($data) {
                        return '<div class="text-center">'.$data->Return.'</div>';
                    })
                    ->editColumn('In', function($data) {
                        return '<div class="text-center">'.$data->In.'</div>';
                    })
                    ->editColumn('Out', function($data) {
                        return '<div class="text-center">'.$data->Out.'</div>';
                    })
                    ->editColumn('Confirmed', function($data) {
                        return '<div class="text-center">'.$data->Confirmed.'</div>';
                    })
                    ->rawColumns(['created_at','Pick','Return','In','Out','Confirmed'])
                    ->make(true);
        }

        $consumable = Consumable::find($id);
        return view('consumables.show',compact('consumable'));
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Consumable::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, Consumable $consumable)
    {
        $rules = array(
            'ConsumableName'=>'required',
            'Unit'=>'required',
            'Cost'=>'required|numeric',
            'ConsumableCode'=>'required',
            'PurchaseCode'=>'required',
            'Weight'=>'required',
            'Min'=>'required',
            'Max'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ConsumableName' => $request->ConsumableName,
            'Unit' => $request->Unit,
            'Detail' => $request->Detail,
            'Cost' => $request->Cost,
            'ConsumableCode' => $request->ConsumableCode,
            'PurchaseCode' => $request->PurchaseCode,
            'Weight' => $request->Weight,
            'Min' => $request->Min,
            'Max' => $request->Max
        );

        Consumable::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Consumable::findOrFail($id);
        $data->delete();
    }

    public function item(Request $request, $id)
    {
        $item = Item::find($id);
        $consumable = Consumable::orderBy('ConsumableName','asc')->get();

        if($request->ajax())
        {
            $data = DB::select('SELECT item_consumables.id, item_consumables.item_id, consumables.ConsumableName, consumables.Detail, consumables.Unit, item_consumables.Quantity, item_consumables.Remark
                FROM consumables INNER JOIN item_consumables ON consumables.id = item_consumables.consumable_id
                WHERE (((item_consumables.item_id)='.$id.'))
                ORDER BY consumables.ConsumableName');
            return DataTables::of($data)
                    ->editColumn('Unit', function($data) {
                        return '<div class="text-center">'.$data->Unit.'</div>';
                    })
                    ->editColumn('Quantity', function($data) {
                        return '<div class="text-center">'.$data->Quantity.'</div>';
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </div>
                    ')
                    ->rawColumns(['Unit','Quantity','action'])
                    ->make(true);
        }
        return view('consumables.itemcreate',compact('item','consumable'));
    }

    public function itemstore(Request $request)
    {
        $rules = array(
            'consumable_id'=>'required',
            'Quantity'=>'required|Integer'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'consumable_id' => $request->consumable_id,
            'Quantity' => $request->Quantity,
            'Remark' => $request->Remark,
            'item_id' => $request->item_id
        );

        ItemConsumable::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function itemedit($id)
    {
        if(request()->ajax())
        {
            $data = ItemConsumable::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function itemupdate(Request $request,ItemConsumable $id)
    {
        $rules = array(
            'consumable_id'=>'required',
            'Quantity'=>'required|numeric'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'consumable_id' => $request->consumable_id,
            'Quantity' => $request->Quantity,
            'Remark' => $request->Remark,
            'item_id' => $request->item_id
        );

        ItemConsumable::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function itemdestroy($id)
    {
        $data = ItemConsumable::findOrFail($id);
        $data->delete();
    }

    public function storeadd(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT consumable_stores.created_at, consumables.ConsumableName, consumables.Detail, consumable_stores.InOut, consumable_stores.Quantity, consumables.Unit, consumable_stores.Remark, consumable_stores.id
                FROM consumable_stores INNER JOIN consumables ON consumable_stores.consumable_id = consumables.id');
            return DataTables::of($data)
                    ->editColumn('created_at', function($data) {
                        return '<div class="text-center">'.$data->created_at.'</div>';
                    })
                    ->editColumn('InOut', function($data) {
                        return '<div class="text-center">'.$data->InOut.'</div>';
                    })
                    ->editColumn('Quantity', function($data) {
                        return '<div class="text-center">'.$data->Quantity.'</div>';
                    })
                    ->editColumn('Unit', function($data) {
                        return '<div class="text-center">'.$data->Unit.'</div>';
                    })
                    ->addColumn('action','
                        @role('."'admin|store_keeper|head_store_keeper'".')
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        @else <div class="text-center">N/A</div>
                        @endrole
                    ')
                    ->rawColumns(['created_at','InOut','Quantity','Unit','action'])
                    ->make(true);
        }
        $consumable = Consumable::orderBy('ConsumableName','asc')->get();
        return view('consumables.storeadd',compact('consumable'));
    }

    public function storeaddstore(Request $request)
    {
        $rules = array(
            'consumable_id'=>'required',
            'InOut'=>'required',
            'Quantity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'consumable_id' => $request->consumable_id,
            'InOut' => $request->InOut,
            'Quantity' => $request->Quantity,
            'Remark' => $request->Remark
        );

        ConsumableStore::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function storeaddedit($id)
    {
        if(request()->ajax())
        {
            $data = ConsumableStore::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function storeaddupdate(Request $request, ConsumableStore $consumablestoreid)
    {
        $rules = array(
            'consumable_id'=>'required',
            'InOut'=>'required',
            'Quantity'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'consumable_id' => $request->consumable_id,
            'InOut' => $request->InOut,
            'Quantity' => $request->Quantity,
            'Remark' => $request->Remark
        );

        ConsumableStore::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function storeadddestroy($id)
    {
        $data = ConsumableStore::findOrFail($id);
        $data->delete();
    }

    public function pmorder(Request $request, $id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE planner AS (
                SELECT employees.id, employees.ThaiName AS PlannerName, employees.Planner
                FROM employees
                WHERE (((employees.Planner)='Yes'))
                );

            CREATE TEMPORARY TABLE siteengineer AS (
                SELECT employees.id, employees.ThaiName AS SiteEngineerName, employees.SiteEngineer
                FROM employees
                WHERE (((employees.SiteEngineer)='Yes'))
                );

            CREATE TEMPORARY TABLE areamanager AS (
                SELECT employees.id, employees.ThaiName AS AreaManagerName, employees.AreaManager
                FROM employees
                WHERE (((employees.AreaManager)='Yes'))
                );
            ")
        );

        $projectdetail = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, planner.PlannerName, siteengineer.SiteEngineerName, areamanager.AreaManagerName, projects.Status
            FROM siteengineer INNER JOIN (planner INNER JOIN (areamanager INNER JOIN projects ON areamanager.id = projects.AreaManager) ON planner.id = projects.Planner) ON siteengineer.id = projects.SiteEngineer
            WHERE (((projects.id)='.$id.'))');

        if($request->ajax())
        {
            $data = DB::select('SELECT p_m_orders.id, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.Remark
            FROM p_m_orders
            WHERE (((p_m_orders.project_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('PMOrder', function($data) {
                        return '<div class="text-center">'.$data->PMOrder.'</div>';
                    })
                    ->addColumn('action',function($data) {
                        return '<div class="text-center">
                                    <a class="btn btn-sm btn-info" href="'.url('consumable_picks/'.$data->id.'/pick').'">Pick Consumable</a>
                                </div>';
                    })
                    ->rawColumns(['PMOrder','action'])
                    ->make(true);
        }
        return view('consumables.pmorder',compact('project','projectdetail'));
    }

    public function project(Request $request, $id)
    {
        $project = Project::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, jobs.item_id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id
                FROM (locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id
                WHERE (((jobs.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('LocationName', function($data) {
                    return '<div class="text-center">'.$data->LocationName.'</div>';
                })
                ->editColumn('ProductName', function($data) {
                    return '<div class="text-center">'.$data->ProductName.'</div>';
                })
                ->editColumn('MachineName', function($data) {
                    if ( $data->MachineNameDetail == "" ) {
                        return '<div class="text-center">'.$data->MachineName.'</div>';
                    } else {
                        return '<div class="text-center">'.$data->MachineName.'//'.$data->MachineNameDetail.'</div>';
                    }
                })
                ->editColumn('SystemName', function($data) {
                    return '<div class="text-center">'.$data->SystemName.'</div>';
                })
                ->editColumn('EquipmentName', function($data) {
                    return '<div class="text-center">'.$data->EquipmentName.'('.$data->SpecificName.')</div>';
                })
                ->editColumn('ScopeName', function($data) {
                    return '<div class="text-center">'.$data->ScopeName.'</div>';
                })
                ->addColumn('action','
                    <div class="text-center">
                        @role('."'admin|head_engineering|head_operation|supervisor|foreman|skill|site_engineer|store_keeper'".')
                            <a href="'. url('item_consumables/{{$item_id}}').'" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                        @else N/A
                        @endrole
                    </div>
                ')
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','action'])
                ->make(true);
        }

        return view('consumables.project',compact('project'));
    }

    public function amount(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark AS MachineNameDetail, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id, Count(item_consumables.consumable_id) AS CountOfconsumable_id
                FROM ((locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id) INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) LEFT JOIN item_consumables ON items.id = item_consumables.item_id
                GROUP BY jobs.id, locations.LocationName, products.ProductName, machines.MachineName, machine_sets.Remark, jobs.Remark, systems.SystemName, equipment.EquipmentName, items.SpecificName, scopes.ScopeName, jobs.project_id
                HAVING (((jobs.project_id)='.$id.'))');
            return DataTables::of($data)
                ->editColumn('id', function($data) {
                    return '<div class="text-center">'.$data->id.'</div>';
                })
                ->editColumn('LocationName', function($data) {
                    return '<div class="text-center">'.$data->LocationName.'</div>';
                })
                ->editColumn('ProductName', function($data) {
                    return '<div class="text-center">'.$data->ProductName.'</div>';
                })
                ->editColumn('MachineName', function($data) {
                    if ( $data->MachineNameDetail == "" ) {
                        return '<div class="text-center">'.$data->MachineName.'</div>';
                    } else {
                        return '<div class="text-center">'.$data->MachineName.'//'.$data->MachineNameDetail.'</div>';
                    }
                })
                ->editColumn('SystemName', function($data) {
                    return '<div class="text-center">'.$data->SystemName.'</div>';
                })
                ->editColumn('EquipmentName', function($data) {
                    return '<div class="text-center">'.$data->EquipmentName.'('.$data->SpecificName.')</div>';
                })
                ->editColumn('ScopeName', function($data) {
                    return '<div class="text-center">'.$data->ScopeName.'</div>';
                })
                ->editColumn('CountOfconsumable_id', function($data) {
                    return '<div class="text-center">'.$data->CountOfconsumable_id.'</div>';
                })
                ->rawColumns(['id','LocationName','ProductName','MachineName','SystemName','EquipmentName','ScopeName','CountOfconsumable_id'])
                ->make(true);
        }
    }

    public function sitepick(Request $request, $id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE consumablequantityx AS (
                SELECT consumable_sites.id, consumable_sites.created_at, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumable_sites.Pick, consumable_sites.Group, consumable_sites.Remark, consumable_sites.Return, consumable_sites.consumable_id, consumable_sites.Confirmed, p_m_orders.project_id, p_m_orders.PMOrder
                FROM p_m_orders
                INNER JOIN consumable_sites
                    INNER JOIN consumables
                    ON consumable_sites.consumable_id = consumables.id
                        ON p_m_orders.id = consumable_sites.p_m_order_id
                WHERE p_m_orders.project_id=$id
                ORDER BY consumable_sites.created_at DESC
                );
            ")
        );

        $pmorder = DB::select('SELECT p_m_orders.id, p_m_orders.PMOrder, p_m_orders.PMOrderName
            FROM p_m_orders
            WHERE (((p_m_orders.project_id)='.$id.'))
            ORDER BY p_m_orders.PMOrder');
        $consumable = Consumable::orderBy('ConsumableName','asc')->get();
        $pmorderreport = DB::select('SELECT consumable_sites.p_m_order_id, p_m_orders.PMOrder, p_m_orders.PMOrderName
            FROM p_m_orders INNER JOIN consumable_sites ON p_m_orders.id = consumable_sites.p_m_order_id
            GROUP BY consumable_sites.p_m_order_id, p_m_orders.PMOrder, p_m_orders.PMOrderName, p_m_orders.project_id
            HAVING (((p_m_orders.project_id)='.$id.'))');
        $group = ConsumableSite::select('consumable_sites.Group')
            ->join('p_m_orders','consumable_sites.p_m_order_id','p_m_orders.id')
            ->where('p_m_orders.project_id','=',$id)
            ->whereNotNull('Group')
            ->groupBy('consumable_sites.Group')
            ->orderBy('consumable_sites.Group')
            ->get();

        if($request->ajax())
        {
            $data = DB::table('consumablequantityx')->get();
            return DataTables::of($data)
                    ->editColumn('created_at', function($data) {
                        return '<div class="text-center">'.$data->created_at.'</div>';
                    })
                    ->editColumn('PMOrder', function($data) {
                        return '<div class="text-center">'.$data->PMOrder.'</div>';
                    })
                    ->editColumn('Pick', function($data) {
                        return '<div class="text-center">'.$data->Pick.'</div>';
                    })
                    ->editColumn('Unit', function($data) {
                        return '<div class="text-center">'.$data->Unit.'</div>';
                    })
                    ->editColumn('Group', function($data) {
                        return '<div class="text-center">'.$data->Group.'</div>';
                    })
                    ->editColumn('Confirmed', function($data) {
                        return '<div class="text-center">'.$data->Confirmed.'</div>';
                    })
                    ->editColumn('Return', function($data) {
                        return '<div class="text-center">'.$data->Return.'</div>';
                    })
                    ->addColumn('action',function($data) {
                        if ( $data->Confirmed == 'Yes')
                        return '<div class="text-center">N/A</div>';
                        return view('consumables.sitepickaction',compact('data'));
                    })
                    ->rawColumns(['created_at','PMOrder','Pick','Unit','Group','Confirmed','Return','action'])
                    ->make(true);
        }
        return view('consumables.sitepick',compact('project','pmorder','consumable','group','pmorderreport'));
    }

    public function sitepickstore(Request $request)
    {
        $rules = array(
            'p_m_order_id'=>'required',
            'consumable_id'=>'required',
            'Pick'=>'required|numeric'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'p_m_order_id' => $request->p_m_order_id,
            'consumable_id' => $request->consumable_id,
            'Pick' => $request->Pick,
            'Return' => 0,
            'Group' => $request->Group,
            'Remark' => $request->Remark,
            'Confirmed' => $request->Confirmed
        );

        ConsumableSite::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function sitepickedit($id)
    {
        if(request()->ajax())
        {
            $data = ConsumableSite::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function sitepickupdate(Request $request,ConsumableSite $ConsumableSite)
    {
        $rules = array(
            'p_m_order_id'=>'required',
            'consumable_id'=>'required',
            'Pick'=>'required|numeric'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'p_m_order_id' => $request->p_m_order_id,
            'consumable_id' => $request->consumable_id,
            'Pick' => $request->Pick,
            'Group' => $request->Group,
            'Remark' => $request->Remark,
            'Confirmed' => $request->Confirmed
        );

        ConsumableSite::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function sitepickdestroy($id)
    {
        $data = ConsumableSite::findOrFail($id);
        $data->delete();
    }

    public function siteconfirm(Request $request, $id)
    {
        $project = Project::find($id);

        if($request->ajax())
        {
            $data = DB::select('SELECT consumable_sites.id, consumable_sites.created_at, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumable_sites.Pick, consumable_sites.Remark, consumable_sites.Return, consumable_sites.consumable_id, consumable_sites.Confirmed, p_m_orders.project_id, p_m_orders.PMOrder
                FROM p_m_orders INNER JOIN (consumable_sites INNER JOIN consumables ON consumable_sites.consumable_id = consumables.id) ON p_m_orders.id = consumable_sites.p_m_order_id
                WHERE (((p_m_orders.project_id)='.$id.'))');
            return DataTables::of($data)
                    ->editColumn('created_at', function($data) {
                        return '<div class="text-center">'.$data->created_at.'</div>';
                    })
                    ->editColumn('PMOrder', function($data) {
                        return '<div class="text-center">'.$data->PMOrder.'</div>';
                    })
                    ->editColumn('Pick', function($data) {
                        return '<div class="text-center">'.$data->Pick.'</div>';
                    })
                    ->editColumn('Unit', function($data) {
                        return '<div class="text-center">'.$data->Unit.'</div>';
                    })
                    ->addColumn('Confirmed','
                        <div class="text-center">
                            <input data-id="{{$id}}" class="toggle-class" type="checkbox" data-on-color="success" data-off-color="danger" data-toggle="toggle" data-on-text="Yes" data-off-text="No" {{ $Confirmed == "Yes" ? '."'checked'".' : '."''".' }}>
                        </div>
                    ')
                    ->rawColumns(['created_at','PMOrder','Pick','Unit','Confirmed'])
                    ->make(true);
        }
        return view('consumables.siteconfirm',compact('project'));
    }

    public function siteconfirmupdate(Request $request)
    {
        $consumable = ConsumableSite::find($request->consumable_site_id);
        $consumable->Confirmed = $request->status;
        $consumable->save();

        return response()->json(['success'=>'Status change successfully.']);
    }

    public function sitereturn(Request $request, $id)
    {
        $project = Project::find($id);

        $createTempTables = DB::unprepared(DB::raw("
            CREATE TEMPORARY TABLE consumablequantityx AS (
                SELECT consumable_sites.id, consumable_sites.created_at, consumables.ConsumableName, consumables.Detail, consumables.Unit, consumable_sites.Pick, consumable_sites.Remark, consumable_sites.Return, consumable_sites.consumable_id, consumable_sites.Confirmed, p_m_orders.project_id, p_m_orders.PMOrder
                FROM p_m_orders INNER JOIN (consumable_sites INNER JOIN consumables ON consumable_sites.consumable_id = consumables.id) ON p_m_orders.id = consumable_sites.p_m_order_id
                WHERE (((p_m_orders.project_id)=$id))
                ORDER BY consumable_sites.created_at DESC
                );
            ")
        );

        if($request->ajax())
        {
            $data = DB::table('consumablequantityx')->get();
            return DataTables::of($data)
                    ->editColumn('created_at', function($data) {
                        return '<div class="text-center">'.$data->created_at.'</div>';
                    })
                    ->editColumn('PMOrder', function($data) {
                        return '<div class="text-center">'.$data->PMOrder.'</div>';
                    })
                    ->editColumn('Pick', function($data) {
                        return '<div class="text-center">'.$data->Pick.'</div>';
                    })
                    ->editColumn('Unit', function($data) {
                        return '<div class="text-center">'.$data->Unit.'</div>';
                    })
                    ->editColumn('Return', function($data) {
                        return '<div class="text-center">'.$data->Return.'</div>';
                    })
                    ->addColumn('action','
                        <div class="text-center">
                            <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        </div>
                        ')
                    ->rawColumns(['created_at','PMOrder','Pick','Unit','Confirmed','Return','action'])
                    ->make(true);
        }
        return view('consumables.sitereturn',compact('project'));
    }

    public function sitereturnedit($id)
    {
        if(request()->ajax())
        {
            $data = ConsumableSite::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function sitereturnupdate(Request $request,ConsumableSite $ConsumableSite)
    {
        $rules = array(
            'Return'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Remark' => $request->Remark,
            'Return' => $request->Return
        );

        ConsumableSite::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }
}
