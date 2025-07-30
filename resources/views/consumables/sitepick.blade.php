@extends('adminlte::page')

@section('title', 'Consumable')

@section('content_header')
    <h1 class="m-0 text-dark">Consumable</h1>
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
        <form class="form-horizontal" method="POST" action="{{ url('/consumable/sitepick') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <select class="form-control select2-bootstrap4" id="pmorderreport" name="pmorderreport">
                            <option>All</option>
                            @foreach ($pmorderreport as $value)
                                <option value="{{$value->p_m_order_id}}">{{$value->PMOrder}} // {{$value->PMOrderName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >Group</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="group" id="group">
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

    <x-data-table.default-data-table color="" collapse-card="" title="Consumable"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('supervisor|foreman|admin|head_store_keeper|store_keeper')
                <x-button.create-record name-i-d=""/>
            @endrole
            @role('store_keeper|head_store_keeper|admin')
                <a href="{{ url('consumable_confirms/'.$project->id)}}" class="btn btn-xs text-info" title="Confirm"><i class="fa fa-lg fa-fw fa-clipboard-check"></i></a>
                <a href="{{ url('consumable_returns/'.$project->id)}}" class="btn btn-xs text-info" title="Return"><i class="fa fa-lg fa-fw fa-undo"></i></a>
            @endrole
        </x-slot>
        <th>Pick Date</th>
        <th>PM Order</th>
        <th>Consumable Name</th>
        <th>Detail</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Group</th>
        <th>Remark</th>
        <th>Confirmed</th>
        <th>Returned</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />

    <x-modal.input-form name-i-d="" modal-title="Pick Consumable">
        <x-adminlte-select2 name="p_m_order_id" label="PM Order // PM Order Name" data-placeholder="Select an option...">
            <option/>
            @foreach ($pmorder as $value)
                <option value="{{$value->id}}">{{$value->PMOrder}} // {{$value->PMOrderName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="consumable_id" label="Consumable Name // Unit" data-placeholder="Select an option...">
            <option/>
            @foreach ($consumable as $value)
                <option value="{{$value->id}}">{{$value->ConsumableName}} @isset($value->Detail) &nbsp;//&nbsp; {{$value->Detail}} @endisset &nbsp;//&nbsp; {{$value->Unit}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="Pick" label="Pick" placeholder="number" type="number">
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
            <input type="hidden" name="Confirmed" id="Confirmed" value="No" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การเบิก คืน consumable.pdf').'">การเบิก คืน Consumable</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="created_at"/>
                <x-data-table.column-script column-name="PMOrder"/>
                <x-data-table.column-script column-name="ConsumableName"/>
                <x-data-table.column-script column-name="Detail">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Pick">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Unit">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Group"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Confirmed"/>
                <x-data-table.column-script column-name="Return"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Pick Consumable"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/consumable_picks') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/consumable_picks') }}">
                <x-data-table.edit-value-script name="p_m_order_id"/>
                <x-data-table.edit-value-script name="consumable_id"/>
                <x-data-table.edit-value-script name="Pick"/>
                <x-data-table.edit-value-script name="Group"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/consumable_picks') }}"/>
        });
    </script>
@endsection
