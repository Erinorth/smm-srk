@extends('adminlte::page')

@section('title','Support Request')

@section('content_header')
    <h1 class="m-0 text-dark">Support Request</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Support Request"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>วันที่ต้องถึง Site</th>
        <th>หน่วยงาน</th>
        <th>จำนวน(คน)</th>
        <th>ประเภทคำสั่งเดินทาง</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Consumable">
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="AtSite" label="วันที่ต้องถึง Site" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-select2 name="department_id" label="หน่วยงาน" data-placeholder="Select an option...">
            <option/>
            @foreach ($department as $value)
                <option value="{{ $value->id }}">{{ $value->DepartmentName }}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="Amount" label="จำนวน(คน)" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-select2 name="Type" label="ประเภทคำสั่งเดินทาง" data-placeholder="Select an option...">
            <option/>
            <option>ฝากสายบังคับบัญชา</option>
            <option>ไม่ฝากสายบังคับบัญชา</option>
        </x-adminlte-select2>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="AtSite"/>
                <x-data-table.column-script column-name="DepartmentName"/>
                <x-data-table.column-script column-name="Amount"/>
                <x-data-table.column-script column-name="Type"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Support Request"/>

            <x-data-table.submit-script name-i-d="" action-url="support_request">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/support_request') }}">
                <x-data-table.edit-value-script name="AtSite"/>
                <x-data-table.edit-value-script name="department_id"/>
                <x-data-table.edit-value-script name="Amount"/>
                <x-data-table.edit-value-script name="Type"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="support_request"/>
        });
    </script>
@endsection
