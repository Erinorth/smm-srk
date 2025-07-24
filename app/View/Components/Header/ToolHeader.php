<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class ToolHeader extends Component
{
    public $toolId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($toolId)
    {
        $this->toolId = $toolId;
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
                        @foreach ($toolheader as $value)
                            <h6>Catagory Name : {{$value->CatagoryName}}</h6>
                            <h6>Unit : {{$value->Unit}}</h6>
                            <h6>Price : {{ number_format($value->Price, 2) }}</h6>
                            <h6>Measuring Tool : {{$value->MeasuringTool}}</h6>
                            <h6>Min : {{$value->Min}}</h6>
                            <h6>Max : {{$value->Max}}</h6>
                            <h6>Code : {{$value->Code}}</h6>
                            <h6>Serial Number : {{$value->SerialNumber}}</h6>
                            <h6>รหัสครุภัณฑ์/รหัสพัสดุ : {{$value->DurableSupplieCode}}</h6>
                            <h6>รหัสสินทรัพย์/รหัสเครื่องมือเครื่องใช้ : {{$value->AssetToolCode}}</h6>
                            <h6>Remark : {{$value->Remark}}</h6>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function toolheader()
    {
        $toolheader = DB::select('SELECT tools.id, tool_catagories.CatagoryName, tool_catagories.Unit, tools.Price, tool_catagories.MeasuringTool, tool_catagories.Min, tool_catagories.Max, tools.Code, tools.Remark, tools.SerialNumber, tools.DurableSupplieCode, tools.AssetToolCode
            FROM tools LEFT JOIN tool_catagories ON tools.tool_catagory_id = tool_catagories.id
            WHERE (((tools.id)='.$this->toolId.'))');
        
        return $toolheader;
    }
}
