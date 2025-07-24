<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class DefaultDataTable extends Component
{
    public $collapseCard;
    public $title;
    public $collapseButton;
    public $tableId;
    public $color;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($collapseCard, $title, $collapseButton, $tableId, $color)
    {
        $this->collapseCard = $collapseCard;
        $this->title = $title;
        $this->collapseButton = $collapseButton;
        $this->tableId = $tableId;
        $this->color = $color;
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
        <div class="card {{$color}} {{$collapseCard}}">
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
                <table id="data_table{{$tableId}}" class="table table-bordered table-striped table-sm">
                    <thead>
                        {{$slot}}
                    </thead>
                </table>
                {{$othertable}}
            </div>
        </div>
    </div>
</div>
blade;
    }
}
