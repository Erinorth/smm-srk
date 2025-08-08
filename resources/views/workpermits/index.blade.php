@extends('adminlte::page')

@section('title', 'Work Permit')

@section('content_header')
    <h1 class="m-0 text-dark">Work Permit</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Work Permit"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>วันที่</th>
        <th>งานวิกฤต</th>
        <th>ผู้ขออนุญาต</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Project">
        <x-input.date title="วันที่" name-id="Date"/>

        <div class="form-group">
            <label class="control-label" >งานวิกฤต</label> <!-- -->

            <x-input.check-box title="งานที่คาดว่าอาจทำให้เกิดความร้อนหรือมีประกายไฟ" id-value="HotWork" name-value="HotWork" check-value="1"/>

            <x-input.check-box title="งานในสถานที่อับอากาศ" id-value="ConfinedSpace" name-value="ConfinedSpace" check-value="1"/>

            <x-input.check-box title="งานเกี่ยวกับสารเคมีอันตราย" id-value="Chemical" name-value="Chemical" check-value="1"/>

            <x-input.check-box title="งานยกของด้วยอุปกรณ์ยกของหนัก" id-value="Lifting" name-value="Lifting" check-value="1"/>

            <x-input.check-box title="งานในสถานที่สูง(นั่งร้าน)" id-value="Scaffloding" name-value="Scaffloding" check-value="1"/>

            <x-input.check-box title="งานเกี่ยวกับไฟฟ้า" id-value="Electrical" name-value="Electrical" check-value="1"/>

            <x-input.check-box title="งานเกี่ยวกับอุปกรณ์ไฟฟ้าแรงสูง" id-value="HighVoltage" name-value="HighVoltage" check-value="1"/>

            <x-input.check-box title="งานเกี่ยวกับงานขุดเจาะ" id-value="Drilling" name-value="Drilling" check-value="1"/>

            <x-input.check-box title="งานเกี่ยวกับกัมมันตภาพรังสี" id-value="Radio" name-value="Radio" check-value="1"/>

            <x-input.check-box title="งานประดาน้ำ" id-value="Diving" name-value="Diving" check-value="1"/>

            <x-input.text title="งานอื่นๆ" name-id="Other"/>
        </div>

        <x-input.dropdown title="ผู้ขออนุญาต" name-id="Requester">
            <option></option>
            @foreach ($employee as $value)
                <option value="{{$value->id}}" >{{$value->ThaiName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-content.upload-file-project name="work_permit" project-i-d="{{$project->id}}"/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="Date"/>
                <x-data-table.column-script column-name="CriticalJob">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Work Permit"/>

            <x-data-table.submit-script name-i-d="" action-url="work_permits">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/work_permits') }}">
                <x-data-table.edit-value-script name="Date"/>
                <x-data-table.edit-check-box-script name="HotWork"/>
                <x-data-table.edit-check-box-script name="ConfinedSpace"/>
                <x-data-table.edit-check-box-script name="Chemical"/>
                <x-data-table.edit-check-box-script name="Lifting"/>
                <x-data-table.edit-check-box-script name="Scaffloding"/>
                <x-data-table.edit-check-box-script name="Electrical"/>
                <x-data-table.edit-check-box-script name="HighVoltage"/>
                <x-data-table.edit-check-box-script name="Drilling"/>
                <x-data-table.edit-check-box-script name="Radio"/>
                <x-data-table.edit-check-box-script name="Diving"/>
                <x-data-table.edit-check-box-script name="Other"/>
                <x-data-table.edit-value-script name="Requester"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="work_permits"/>

            <x-j-s.upload-file-project name="work_permit"/>
        });
    </script>
@endsection
