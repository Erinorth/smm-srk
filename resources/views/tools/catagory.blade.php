@extends('adminlte::page')

@section('title','Tool')

@section('content_header')
    <h1 class="m-0 text-dark">Tool</h1>
@stop

@section('content')
    <x-card.default-card color="" collapse-card="collapsed-card" title="Report" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <div class="container">
            <div class="row align-items-center justify-content-around">
                <div class="col-1 text-center">
                    <a class="btn btn-primary btn-sm" href="{{ URL('tool_list') }}">List</a>
                </div>
                <div class="col-2 text-center">
                    <a class="btn btn-primary btn-sm" href="{{ URL('tool_breakdowns') }}">Breakdown</a>
                </div>
                <div class="col text-center">
                    <div class="form-group">
                        <label>Monthly Report</label>
                        <form class="form-horizontal" method="POST" action="{{ url('/tool_report') }}">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row">
                                        <label class="control-label" >Year</label> <!-- -->
                                        <div class="col">
                                            <input type="text" class="form-control" name="year" id="year" placeholder="ค.ศ. 4 หลัก">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group row">
                                        <label class="control-label" >Month</label> <!-- -->
                                        <div class="col">
                                            <input type="text" class="form-control" name="month" id="month" placeholder="เดือน 2 หลัก(ใส่ 0 ด้านหน้า)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-center">
                                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-2 text-center">
                    <a class="btn btn-primary btn-sm" href="{{ URL('dashboard_expensive_tool') }}">Expensive</a>
                </div>
            </div>
        </div>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Tool Catagory"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|store_keeper')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>Tool Name</th>
        <th>Range/Capacity</th>
        <th>Unit</th>
        <th>Type</th>
        <th>Have to Calibrate</th>
        <th>Min</th>
        <th>Max</th>
        <th>In Store</th>
        <th>On Site</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Tool Catagory">
        <x-adminlte-input name="CatagoryName" label="Catagory Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="RangeCapacity" label="Range/Capacity" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Unit" label="Unit" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-select2 name="tool_type_id" label="Type" data-placeholder="Select an option...">
            <option/>
            @foreach ($type as $value)
                <option value="{{ $value->id }}">{{ $value->MainType }} // {{ $value->SubType }} // {{ $value->ToolName }}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="MeasuringTool" label="Have to Calibrate" data-placeholder="Select an option...">
            <option/>
            <option>No</option>
            <option>Yes</option>
        </x-adminlte-select2>

        <x-adminlte-input name="Min" label="Min" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Max" label="Max" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-content.tool-type/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน tool.pdf').'">การใช้งาน Tool</a>',null]
        ];
    @endphp
    @php
        $tabledata = [
            ['<a href="'. asset('storage/user_manual/การใช้งาน tool.pdf').'">การใช้งาน Tool</a>',null]
        ];
    @endphp
    {{-- @php
        $tabledata = [
            ['<a href="'. Storage::url('user_manual/การใช้งาน tool.pdf').'">การใช้งาน Tool</a>',null]
        ];
    @endphp --}}
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="CatagoryName"/>
                <x-data-table.column-script column-name="RangeCapacity"/>
                <x-data-table.column-script column-name="Unit">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Type"/>
                <x-data-table.column-script column-name="MeasuringTool"/>
                <x-data-table.column-script column-name="Min">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Max">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="InStore">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="OnSite">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Tool Catagory"/>

            <x-data-table.submit-script name-i-d="" action-url="tool_catagories">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="tool_catagories">
                <x-data-table.edit-value-script name="CatagoryName"/>
                <x-data-table.edit-value-script name="RangeCapacity"/>
                <x-data-table.edit-value-script name="Unit"/>
                <x-data-table.edit-value-script name="tool_type_id"/>
                <x-data-table.edit-value-script name="MeasuringTool"/>
                <x-data-table.edit-value-script name="Min"/>
                <x-data-table.edit-value-script name="Max"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="tool_catagories"/>

            <x-j-s.tool-type/>
        });
    </script>
@endsection
