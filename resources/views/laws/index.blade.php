@extends('adminlte::page')

@section('title','Law')

@section('content_header')
    <h1 class="m-0 text-dark">Law</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Law"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>Law Name</th>
        <th>Announcement Date</th>
        <th>Number of Pages</th>
        <th>Regulator</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Job Position">
        <x-input.text-area title="Law Name" name-id="LawName"/>

        <x-input.date title="Announcement Date" name-id="AnnouncementDate"/>

        <x-input.text title="Number of Pages" name-id="NumberOfPages"/>

        <x-input.text title="Regulator" name-id="Regulator"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="LawName"/>
                <x-data-table.column-script column-name="AnnouncementDate"/>
                <x-data-table.column-script column-name="NumberOfPages">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Regulator"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Law"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/laws') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/laws') }}">
                <x-data-table.edit-value-script name="LawName"/>
                <x-data-table.edit-value-script name="AnnouncementDate"/>
                <x-data-table.edit-value-script name="NumberOfPages"/>
                <x-data-table.edit-value-script name="Regulator"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/laws') }}"/>
        });
    </script>
@endsection
