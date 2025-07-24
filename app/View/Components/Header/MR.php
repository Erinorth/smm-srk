<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class MR extends Component
{
    public $mRId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mRId)
    {
        $this->mRId = $mRId;
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
                        @foreach ($mrdetail as $value)
                            <h6>Job ID : {{$value->job_id}}</h6>
                            <h6>Project : {{$value->ProjectName}}</h6>
                            <h6>Location : {{$value->LocationName}}</h6>
                            <h6>Product : {{$value->ProductName}}</h6>
                            <h6>Machine : {{$value->MachineName}}</h6>
                            <h6>System : {{$value->SystemName}}</h6>
                            <h6>Equipment : {{$value->EquipmentName}}</h6>
                            <h6>Scope of Work : {{$value->ScopeName}}</h6>
                            <h6>Remark : {{$value->Remark}}</h6>
                        @endforeach
                    </div>
                </div>
                <br/>
                <div class="container-sm">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                        @foreach ($mrdetail as $value)
                            <h6>Activity : {{$value->ActivityName}}</h6>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function mrdetail()
    {
        $mrdetail = DB::select('SELECT jobs.id AS job_id, projects.ProjectName, locations.LocationName, products.ProductName, machines.MachineName, systems.SystemName, equipment.EquipmentName, scopes.ScopeName, jobs.Remark, activities.ActivityName, maintenance_reports.id
            FROM (((equipment INNER JOIN (products INNER JOIN (systems INNER JOIN item_sets ON systems.id = item_sets.system_id) ON products.id = item_sets.product_id) ON equipment.id = item_sets.equipment_id) INNER JOIN ((machines INNER JOIN (locations INNER JOIN machine_sets ON locations.id = machine_sets.location_id) ON machines.id = machine_sets.machine_id) INNER JOIN ((scopes INNER JOIN (items INNER JOIN jobs ON items.id = jobs.item_id) ON scopes.id = items.scope_id) INNER JOIN projects ON jobs.project_id = projects.id) ON machine_sets.id = items.machine_set_id) ON item_sets.id = items.item_set_id) INNER JOIN activities ON items.id = activities.item_id) INNER JOIN maintenance_reports ON activities.id = maintenance_reports.activity_id
            WHERE (((maintenance_reports.id)='.$this->mRId.'))');
        
        return $mrdetail;
    }
}