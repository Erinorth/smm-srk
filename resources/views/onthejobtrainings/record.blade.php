@extends('adminlte::page')

@section('title','Employee')

@section('content_header')
    <h1 class="m-0 text-dark">Employee</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Employee Detail"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>ID</th>
        <th>Thai Name</th>
        <th>Detail</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="WorkID"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="Detail">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
