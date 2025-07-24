@extends('adminlte::page')

@section('title','PM Order')

@section('content_header')
    <h1 class="m-0 text-dark">PM Order</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="PM Order"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>ID</th>
        <th>Project Name</th>
        <th>Finish Date</th>
        <th>Supper PM Order</th>
        <th>PM Order</th>
        <th>PM Order Name</th>
        <th>Status</th>
        <th>Remark</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="ProjectName"/>
                <x-data-table.column-script column-name="FinishDate"/>
                <x-data-table.column-script column-name="Sup"/>
                <x-data-table.column-script column-name="PMOrder"/>
                <x-data-table.column-script column-name="PMOrderName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Status"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
