<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class Item extends Component
{
    public $itemId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div class="row">
    <div class="col-12">
        <div class="card {{$collapseCard}}">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
                <div class="card-tools">
                    {{$tool}}
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-{{$collapseButton}}"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-sm">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                    @foreach ($itemdetail as $value)
                        <h6>Product : {{$value->ProductName}}</h6>
                        <h6>Location : {{$value->LocationName}}</h6>
                        <h6>Machine : 
                            @if ( $value->Remark == "" )
                                {{$value->MachineName}}
                            @else
                                {{$value->MachineName}}//{{$value->Remark}}
                            @endif
                        </h6>
                        <h6>System : {{$value->SystemName}}</h6>
                        <h6>Equipment : {{$value->EquipmentName}}</h6>
                        <h6>Specific Name : {{$value->SpecificName}}</h6>
                        <h6>Scope of Work : {{$value->ScopeName}}</h6>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function itemdetail()
    {
        $itemdetail = DB::select('SELECT items.id, products.ProductName, locations.LocationName, machines.MachineName, machine_sets.Remark, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, items.SpecificName
            FROM machines INNER JOIN (locations INNER JOIN (machine_sets INNER JOIN (equipment INNER JOIN (systems INNER JOIN (products INNER JOIN (item_sets INNER JOIN (scopes INNER JOIN items ON scopes.id = items.scope_id) ON item_sets.id = items.item_set_id) ON products.id = item_sets.product_id) ON systems.id = item_sets.system_id) ON equipment.id = item_sets.equipment_id) ON machine_sets.id = items.machine_set_id) ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id
            WHERE (((items.id)='.$this->itemId.'))');
        
        return $itemdetail;
    }
}
