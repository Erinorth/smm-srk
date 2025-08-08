@extends('adminlte::page')

@section('title','Lifting')

@section('content_header')
    <h1 class="m-0 text-dark">Lifting</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Lifting"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Created At</th>
        <th>หน่วยงาน/บริษัทที่ปฏิบัติงาน</th>
        <th>พื้นที่ปฏิบัติงาน</th>
        <th>ชื่องาน</th>
        <th>จำนวนผู้ปฏิบัติงาน</th>
        <th>วันที่เริ่มงานตามแผน</th>
        <th>เอกสารอ้างอิงการปฏิบัติ</th>
        <th>ผู้ควบคุมปั้นจั่น</th>
        <th>ผู้ให้สัญญาณ และควบคุมการผูกมัด ยึดโยง</th>
        <th>ผู้ขออนุญาต</th>
        <th>หัวหน้างาน/ผู้ควบคุมงาน</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Confined Space Measurement">
        <x-input.text title="หน่วยงาน/บริษัทที่ปฏิบัติงาน" name-id="CompanyName"/>

        <x-input.text title="พื้นที่ปฏิบัติงาน" name-id="WorkingArea"/>

        <x-input.text title="ชื่องาน" name-id="JobName"/>

        <x-input.text title="จำนวนผู้ปฏิบัติงาน" name-id="Amount"/>

        <x-input.date title="วันที่เริ่มงานตามแผน" name-id="PlanedDate"/>

        <x-input.text title="เอกสารอ้างอิงการปฏิบัติ" name-id="Reference"/>

        <x-input.text title="ผู้ควบคุมปั้นจั่น" name-id="Operator"/>

        <x-input.text title="ผู้ให้สัญญาณ และควบคุมการผูกมัด ยึดโยง" name-id="Foreman"/>

        <x-input.text title="ผู้ขออนุญาต" name-id="Applicant"/>

        <x-input.text title="หัวหน้างาน/ผู้ควบคุมงาน" name-id="Supervisor"/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}"/>
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-content.upload-file-project name="lifting" project-i-d="{{$project->id}}"/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="created_at"/>
                <x-data-table.column-script column-name="CompanyName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="WorkingArea">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="JobName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Amount">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="PlanedDate">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Reference">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Applicant">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Operator">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Foreman">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Supervisor">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add New Lifting Measurement"/>

            <x-data-table.submit-script name-i-d="" action-url="liftings">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/liftings') }}">
                <x-data-table.edit-value-script name="CompanyName"/>
                <x-data-table.edit-value-script name="WorkingArea"/>
                <x-data-table.edit-value-script name="JobName"/>
                <x-data-table.edit-value-script name="Amount"/>
                <x-data-table.edit-value-script name="PlanedDate"/>
                <x-data-table.edit-value-script name="Reference"/>
                <x-data-table.edit-value-script name="Operator"/>
                <x-data-table.edit-value-script name="Foreman"/>
                <x-data-table.edit-value-script name="Applicant"/>
                <x-data-table.edit-value-script name="Supervisor"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="liftings"/>

            <x-j-s.upload-file-project name="lifting"/>
        });
    </script>
@endsection
