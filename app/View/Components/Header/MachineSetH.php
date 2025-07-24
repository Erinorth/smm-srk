<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;


class MachineSetH extends Component
{
    public $machineSetId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($machineSetId)
    {
        $this->machineSetId = $machineSetId;
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
                        @foreach ($machineset as $value)
                            <h6>Location : {{ $value->LocationName }}</h6>
                            <h6>Machine : 
                                @if ( $value->Remark == "" )
                                    {{$value->MachineName}}
                                @else
                                    {{$value->MachineName}}//{{$value->Remark}}
                                @endif
                            </h6>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function machineset()
    {
        $machineset = DB::select('SELECT machine_sets.id, locations.LocationName, machines.MachineName, machine_sets.Remark
            FROM locations INNER JOIN (machines INNER JOIN machine_sets ON machines.id = machine_sets.machine_id) ON locations.id = machine_sets.location_id
            WHERE (((machine_sets.id)='.$this->machineSetId.'))');
        
        return $machineset;
    }
}
