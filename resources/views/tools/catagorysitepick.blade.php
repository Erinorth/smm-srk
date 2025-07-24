@extends('adminlte::page')

@section('title','Tool')

@section('content_header')
    <h1 class="m-0 text-dark">Tool</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-adminlte-card title="Report" theme="primary" icon="" collapsible="collapsed" removable maximizable>
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/tool_site_report') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >Type of Report</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="type" id="type">
                                <option>Picked</option>
                                <option>Used</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >Group</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="Group" id="Group">
                                <option>All</option>
                                <option>No Group</option>
                                @foreach ($group as $value)
                                    <option>{{ $value->Group }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                </div>
            </div>
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </form>
    </x-adminlte-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Tool Catagory"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Pick Date</th>
        <th>Tool Catagory Name</th>
        <th>Range/Capacity</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Group</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Tool Catagory">
        <x-adminlte-select2 name="tool_catagory_id" label="Tool Catagory" data-placeholder="Select an option...">
            <option/>
            @foreach ($toolcatagory as $value)
                <option value="{{$value->id}}">{{$value->CatagoryName}} @isset($value->RangeCapacity) &nbsp;//&nbsp;{{$value->RangeCapacity}} @endisset &nbsp;//&nbsp;{{$value->Unit}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="PickQuantity" label="Quantity" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Group" label="เบิกครั้งที่" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การจัดทำ tool list.pdf').'">การจัดทำ Tool List</a>',null],
            ['<a href="'. url('storage/user_manual/การจัดทำรายการเครื่องมือที่จะนำไปใช้งาน.pdf').'">การจัดทำรายการเครื่องมือที่จะนำไปใช้งาน</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="updated_at"/>
                <x-data-table.column-script column-name="CatagoryName"/>
                <x-data-table.column-script column-name="RangeCapacity">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="PickQuantity">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Unit">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Group"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Tool Catagory"/>

            <x-data-table.submit-script name-i-d="" action-url="tool_catagory_sites">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="tool_catagory_sites">
                <x-data-table.edit-value-script name="tool_catagory_id"/>
                <x-data-table.edit-value-script name="PickQuantity"/>
                <x-data-table.edit-value-script name="Group"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="tool_catagory_sites"/>
        });
    </script>
@endsection
