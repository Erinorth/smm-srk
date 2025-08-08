@extends('adminlte::page')

@section('title','Law Detail')

@section('content_header')
    <h1 class="m-0 text-dark">Law Detail</h1>
@stop

@section('content')
    <x-header.laws lawId="{{$law->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.laws>

    <x-data-table.default-data-table color="" collapse-card="" title="Law Assesment"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>Law Detail</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Job Position">
        <x-input.text-area title="Law Detail" name-id="LawDetail"/>

        <x-slot name="othervalue">
            <input type="hidden" name="law_id" id="law_id" value="{{$law->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="LawDetail"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Law Detail"/>

            <x-data-table.submit-script name-i-d="" action-url="law_details">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/law_details') }}">
                <x-data-table.edit-value-script name="LawDetail"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="law_details"/>
        });
    </script>
@endsection
