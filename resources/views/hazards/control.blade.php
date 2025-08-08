@extends('adminlte::page')

@section('title','Hazard')

@section('content_header')
    <h1 class="m-0 text-dark">Hazard</h1>
@stop

@section('content')
    <div class="container-sm">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
            <h5>{{$hazard->HazardName}}</h5>
        </div>
    </div>

    <x-data-table.default-data-table color="" collapse-card="" title="Hazard Control"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ลักษณะการเกิดอันตราย</th>
        <th>ผลกระทบ</th>
        <th>ความรุนแรง</th>
        <th>มาตรการควบคุม</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Consumable">
        <x-adminlte-input name="KindofHazard" label="ลักษณะการเกิดอันตราย" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Effect" label="ผลกระทบ" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-select2 name="Severity" label="ความรุนแรง" data-placeholder="Select an option...">
            <option/>
            <option>น้อย</option>
            <option>ปานกลาง</option>
            <option>มาก</option>
        </x-adminlte-select2>

        <x-adminlte-text-editor name="HazardControl" label="มาตรการควบคุม"/>

        <x-slot name="othervalue">
            <input type="hidden" name="hazard_id" id="hazard_id" value="{{$hazard->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน hazard.pdf').'">การใช้งาน Hazard</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="KindofHazard"/>
                <x-data-table.column-script column-name="Effect">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Severity"/>
                <x-data-table.column-script column-name="HazardControl">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title=" Add Hazard Controls"/>

            <x-data-table.submit-script name-i-d="" action-url="hazard_controls">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/hazard_controls') }}">
                <x-data-table.edit-value-script name="KindofHazard"/>
                <x-data-table.edit-value-script name="Effect"/>
                <x-data-table.edit-value-script name="Severity"/>
                $('#Result').summernote("code", data.result.HazardControl);
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="hazard_controls"/>
        });
    </script>
@endsection
