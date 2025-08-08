@extends('adminlte::page')

@section('title','Quality Control')

@section('css')

@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Quality Control</h1>
@stop

@section('content')
    <x-header.item itemId="{{$item->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.item>

    <x-data-table.default-data-table color="" collapse-card="" title="Quality Control"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Controlled Operation</th>
        <th>Controlled Quality</th>
        <th>Acceptance Criteria</th>
        <th>Recorded Document</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Quality Control">
        <x-adminlte-input name="ControlledOperation" label="Controlled Operation" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="ControlledQuality" label="ControlledQuality" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="AcceptanceCriteria" label="Acceptance Criteria" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="RecordedDocument" label="Recorded Document" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="item_id" id="item_id" value="{{$item->id}}" />
        </x-slot>
    </x-modal.input-form>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน quality control.pdf').'">การใช้งาน Quality Control</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="ControlledOperation">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ControlledQuality">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="AcceptanceCriteria">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="RecordedDocument">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Quality Control"/>

            <x-data-table.submit-script name-i-d="" action-url="qualitycontrols">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/qualitycontrols') }}">
                <x-data-table.edit-value-script name="ControlledOperation"/>
                <x-data-table.edit-value-script name="ControlledQuality"/>
                <x-data-table.edit-value-script name="AcceptanceCriteria"/>
                <x-data-table.edit-value-script name="RecordedDocument"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="qualitycontrols"/>
        });
    </script>
@endsection
