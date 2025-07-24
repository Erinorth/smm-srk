@extends('adminlte::page')

@section('title','On the Job Training Plan')

@section('content_header')
    <h1 class="m-0 text-dark">On the Job Training Plan</h1>
@stop

@section('content')
    <x-card.default-card color="" collapse-card="collapsed-card" title="Master Plan" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <div class="container text-center">
            <a href="{{ url('OJTmaster/2') }}" class="btnprn btn btn-info btn-sm">หบนม-ธ.</a>
        </div>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="ตารางการอบรมในงาน (On the Job Training)"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>ปี</th>
        <th>หน่วยงาน</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Year"/>
                <x-data-table.column-script column-name="DepartmentName"/>
                <x-data-table.column-script column-name="print">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
