@extends('adminlte::page')

@section('title','Section')

@section('content_header')
    <h1 class="m-0 text-dark">Section</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="หน่วยงาน"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>สายรอง</th>
        <th>ฝ่าย</th>
        <th>กอง</th>
        <th>แผนก</th>
        <th>action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Business"/>
                <x-data-table.column-script column-name="Division"/>
                <x-data-table.column-script column-name="Department"/>
                <x-data-table.column-script column-name="Section"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc'],[1,'asc'],[2,'asc'],[3,'asc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
