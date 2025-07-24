<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class Tool extends Component
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
                        @foreach ( $tooldetail as $value )
                            <h6>Catagory Name : {{$value->CatagoryName}}</h6>
                            <h6>LocalCode : {{$value->LocalCode}}</h6>
                            <h6>Brand : {{$value->Brand}}</h6>
                            <h6>Model : {{$value->Model}}</h6>
                            <h6>SerialNumber : {{$value->SerialNumber}}</h6>
                            <h6>รหัสครุภัณฑ์/รหัสพัสดุ : {{$value->DurableSupplieCode}}</h6>
                            <h6>รหัสสินทรัพย์/รหัสเครื่องมือเครื่องใช้ : {{$value->AssetToolCode}}</h6>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function tooldetail()
    {
        $tooldetail = DB::select('SELECT tool_catagories.CatagoryName, tools.LocalCode, tools.Brand, tools.Model, tools.SerialNumber, tools.DurableSupplieCode, tools.AssetToolCode
            FROM tool_catagories INNER JOIN tools ON tool_catagories.id = tools.tool_catagory_id
            WHERE (((tools.id)='.$this->toolId.'))');
        
        return $tooldetail;
    }
}
