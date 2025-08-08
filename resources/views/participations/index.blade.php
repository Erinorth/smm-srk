@extends('adminlte::page')

@section('title', 'Paticipation')

@section('content_header')
    <h1 class="m-0 text-dark">Paticipation</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Job"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>วันที่</th>
        <th>แบบฟอร์ม</th>
        <th>หัวหน้างาน</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Project">
        <x-input.date title="Date" name-id="Date"/>

        <x-input.dropdown title="Form" name-id="Form">
            <option></option>
            <option>แบบฟอร์มการลงชื่อรับทราบ</option>
            <option>แบบฟอร์มชี้แจงและทำความเข้าใจมาตรการความปลอดภัย และกฎระเบียบความปลอดภัยก่อนเริ่มงาน สายงาน รวธ.</option>
        </x-input.dropdown>

        <x-input.dropdown title="Foreman" name-id="Foreman">
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

    <x-content.upload-file-project name="participation" project-i-d="{{$project->id}}"/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="Date"/>
                <x-data-table.column-script column-name="Form"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Participation"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/participations') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/participations') }}">
                <x-data-table.edit-value-script name="Date"/>
                <x-data-table.edit-value-script name="Form"/>
                <x-data-table.edit-value-script name="Foreman"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/participations') }}"/>

            <x-j-s.upload-file-project name="participation"/>
        });
    </script>
@endsection
