@extends('adminlte::page')

@section('title','Law Assesment')

@section('content_header')
    <h1 class="m-0 text-dark">Law Assesment</h1>
@stop

@section('content')
    <x-header.department-header departmentId="{{$department->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Department</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.department-header>

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
                <x-slot name="order">[2,'desc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
