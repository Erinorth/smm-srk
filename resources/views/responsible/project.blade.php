@extends('adminlte::page')

@section('title','Responsible')

@section('content_header')
    <h1 class="m-0 text-dark">Responsible</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Responsible"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Duty</th>
        <th>Type of Job</th>
        <th>Responsible</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add Responsible">
        <x-adminlte-select2 name="Duty" label="Duty" data-placeholder="Select an option...">
            <option/>
            @foreach ($duty as $value)
                <option value="{{$value->id}}">{{$value->JobPositionName}}/{{$value->TypeofJob}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="Responsible" label="Responsible" data-placeholder="Select an option...">
            <option/>
            @foreach ($employee as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งานมอบหมายหน้าที่ความรับผิดชอบ.pdf').'">การใช้งานมอบหมายหน้าที่ความรับผิดชอบ</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="JobPositionName"/>
                <x-data-table.column-script column-name="TypeofJob">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ThaiName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Responsible"/>

            <x-data-table.submit-script name-i-d="" action-url="responsibles">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/responsibles') }}">
                <x-data-table.edit-value-script name="Duty"/>
                <x-data-table.edit-value-script name="Responsible"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="responsibles"/>
        });
    </script>
@endsection
