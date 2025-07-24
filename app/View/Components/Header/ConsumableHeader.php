<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use App\Models\Consumable;

class ConsumableHeader extends Component
{
    public $consumableId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($consumableId)
    {
        $this->consumableId = $consumableId;
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
                        <h6>ชื่อวัสดุ : {{ $consumabledetail->ConsumableName }}</h6>
                        <h6>ขนาด : {{ $consumabledetail->Detail }}</h6>
                        <h6>หน่วย : {{ $consumabledetail->Unit }}</h6>
                        <h6>ราคา : {{ $consumabledetail->Cost }}</h6>
                        <h6>รหัสอุปกรณ์ : {{ $consumabledetail->ConsumableCode }}</h6>
                        <h6>รหัสจัดซื้อ : {{ $consumabledetail->PurchaseCode }}</h6>
                        <h6>Min : {{ $consumabledetail->Min }}</h6>
                        <h6>Max : {{ $consumabledetail->Mix }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function consumabledetail()
    {
        $consumabledetail = Consumable::find($this->consumableId);
        
        return $consumabledetail;
    }
}
