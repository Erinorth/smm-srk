@extends('adminlte::page')

@section('title','Tool Breakdown')

@section('content_header')
    <h1 class="m-0 text-dark">Tool Breakdown</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Tool Breakdown"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Create Date</th>
        <th>CatagoryName</th>
        <th>RangeCapacity</th>
        <th>LocalCode</th>
        <th>DurableSupplieCode</th>
        <th>AssetToolCode</th>
        <th>Brand</th>
        <th>Model</th>
        <th>SerialNumber</th>
        <th>สถานะ</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Tool Catagory">
        <x-adminlte-select2 name="tool_id" label="Tool" data-placeholder="Select an option...">
            <option/>
            @foreach ($tool as $value)
                <option value="{{ $value->id }}">
                    {{ $value->CatagoryName }}
                    @isset($value->RangeCapacity)
                        &nbsp;//&nbsp;{{ $value->RangeCapacity }}
                    @endisset
                    @isset($value->LocalCode)
                        &nbsp;//&nbsp;{{ $value->LocalCode }}
                    @endisset
                    @isset($value->DurableSupplieCode)
                        &nbsp;//&nbsp;{{ $value->DurableSupplieCode }}
                    @endisset
                    @isset($value->AssetToolCode)
                        &nbsp;//&nbsp;{{ $value->AssetToolCode }}
                    @endisset
                    @isset($value->Brand)
                        &nbsp;//&nbsp;{{ $value->Brand }}
                    @endisset
                    @isset($value->Model)
                        &nbsp;//&nbsp;{{ $value->Model }}
                    @endisset
                    @isset($value->SerialNumber)
                        &nbsp;//&nbsp;{{ $value->SerialNumber }}
                    @endisset
                </option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-text-editor name="Report" label="รายงานข้อขัดข้องเสียหาย"/>

        <x-adminlte-text-editor name="Cause" label="สาเหตุหลัก"/>

        <x-adminlte-input name="Value" label="มูลค่าความเสียหาย" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-text-editor name="Guideline" label="แนวทางการแก้ไข"/>

        <x-adminlte-text-editor name="Operation" label="การดำเนินการซ่อม"/>

        <x-adminlte-input name="Operator" label="หน่วยงาน/ผู้ดำเนินการซ่อม" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-text-editor name="Result" label="ผลการซ่อม"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน tool breakdown.pdf').'">การใช้งาน Tool Breakdown</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="created_at"/>
                <x-data-table.column-script column-name="CatagoryName"/>
                <x-data-table.column-script column-name="RangeCapacity"/>
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="DurableSupplieCode"/>
                <x-data-table.column-script column-name="AssetToolCode"/>
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="SerialNumber">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Status"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            $('#create_record').click(function(){
                $('#Operation').summernote('disable');
                $('#Operator').prop('disabled', true);
                $('#Result').summernote('disable');
                $('.select2-bootstrap4').val(null).trigger('change');
                $('.select2-hidden-accessible').val(null).trigger('change');
                $('#create_form')[0].reset();
                $('.modal-title').text('Add New Tool Breakdown');
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#formModal').modal('show');
            });

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/tool_breakdowns') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/tool_breakdowns') }}">
                $('#Operation').summernote('enable');
                $('#Operator').prop('disabled', false);
                $('#Result').summernote('enable');
                <x-data-table.edit-value-script name="tool_id"/>
                $('#Report').summernote("code", data.result.Report);
                $('#Cause').summernote("code", data.result.Cause);
                <x-data-table.edit-value-script name="Value"/>
                $('#Guideline').summernote("code", data.result.Guideline);
                $('#Operation').summernote("code", data.result.Operation);
                <x-data-table.edit-value-script name="Operator"/>
                $('#Result').summernote("code", data.result.Result);
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/tool_breakdowns') }}"/>
        });
    </script>
@endsection
