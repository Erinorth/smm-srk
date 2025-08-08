@extends('adminlte::page')

@section('title','PM Order')

@section('content_header')
    <h1 class="m-0 text-dark">PM Order</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="PM Order"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>Super PM Order</th>
        <th>PM Order</th>
        <th>PM Order Name</th>
        <th>Status</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New PM Order">
        <x-adminlte-select2 name="SupPMOrder" label="Super PM Order" data-placeholder="Select an option...">
            <option/>
            <option value="1">999999 / Main</option>
            @foreach ($superpmorder as $value)
                <option value="{{$value->id}}">{{$value->PMOrder}} / {{$value->PMOrderName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="PMOrder" label="PM Order" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="PMOrderName" label="PM Order Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-select2 name="Status" label="Status" data-placeholder="Select an option...">
            <option/>
            <option>ใช้งาน</option>
            <option>ปิดงาน</option>
        </x-adminlte-select2>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน pmorder.pdf').'">การใช้งาน PM Order</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="SupPMOrder"/>
                <x-data-table.column-script column-name="PMOrder">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="PMOrderName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Status"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[1,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="PM Order"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/pmorders') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/pmorders') }}">
                <x-data-table.edit-value-script name="SupPMOrder"/>
                <x-data-table.edit-value-script name="PMOrder"/>
                <x-data-table.edit-value-script name="PMOrderName"/>
                <x-data-table.edit-value-script name="Status"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/pmorders') }}"/>
        });
    </script>
@endsection
