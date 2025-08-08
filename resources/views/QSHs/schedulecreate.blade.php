@extends('adminlte::page')

@section('title','Quality Safety & Health Schedule')

@section('content_header')
    <h1 class="m-0 text-dark">Risk Schedule</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Risk Schedule"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Created At</th>
        <th>Date</th>
        <th>กิจกรรม</th>
        <th>ลักษณะความเสี่ยง</th>
        <th>ผลกระทบ</th>
        <th>มาตรการควบคุม</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Confined Space Measurement">
        <x-input.date title="Date" name-id="Date"/>

        <x-input.text title="กิจกรรม" name-id="Activity"/>

        <x-input.text title="ลักษณะความเสี่ยง" name-id="TypeOfRisk"/>

        <x-input.text title="ผลกระทบ" name-id="Effect"/>

        <x-input.text title="มาตรการควบคุม" name-id="CounterMeasure"/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}"/>
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="created_at"/>
                <x-data-table.column-script column-name="Date">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Activity">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="TypeOfRisk">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Effect">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="CounterMeasure">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add New Schedule"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/QSH_schedules') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/QSH_schedules') }}">
                <x-data-table.edit-value-script name="Date"/>
                <x-data-table.edit-value-script name="Activity"/>
                <x-data-table.edit-value-script name="TypeOfRisk"/>
                <x-data-table.edit-value-script name="Effect"/>
                <x-data-table.edit-value-script name="CounterMeasure"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/QSH_schedules') }}"/>
        });
    </script>
@endsection
