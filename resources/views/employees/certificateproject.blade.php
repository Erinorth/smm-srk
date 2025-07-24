@extends('adminlte::page')

@section('title','Certificate')

@section('content_header')
    <h1 class="m-0 text-dark">Certificate</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Certificate"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>WorkID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Expire Date</th>
        <th>Certificate</th>
        <x-slot name="othertable">
        </x-slot>
    </x-data-table.default-data-table>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งานใบรับรองของผู้ปฏิบัติงาน.pdf').'">การใช้งานใบรับรองของผู้ปฏิบัติงาน</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="WorkID"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="TypeName"/>
                <x-data-table.column-script column-name="ExpireDate"/>
                <x-data-table.column-script column-name="Attachment">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
