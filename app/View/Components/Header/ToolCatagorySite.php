<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class ToolCatagorySite extends Component
{
    public $toolCatagorySiteId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($toolCatagorySiteId)
    {
        $this->toolCatagorySiteId = $toolCatagorySiteId;
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
                        @foreach ($toolcatagorysite as $value)
                            <h6>Project : {{ $value->ProjectName }}</h6>
                            <h6>Start Date : {{ $value->StartDate }}</h6>
                            <h6>Finish Date : {{ $value->FinishDate }}</h6>
                            <h6>Catagory Name : {{$value->CatagoryName}}</h6>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function toolcatagorysite()
    {
        $toolcatagorysite = DB::select('SELECT projects.ProjectName, projects.StartDate, projects.FinishDate, tool_catagories.CatagoryName
            FROM tool_catagory_sites
            INNER JOIN projects
            ON tool_catagory_sites.project_id = projects.id
            INNER JOIN tool_catagories
            ON tool_catagory_sites.tool_catagory_id = tool_catagories.id
            WHERE tool_catagory_sites.id='.$this->toolCatagorySiteId.'');

        return $toolcatagorysite;
    }
}
