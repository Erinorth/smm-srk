@extends('adminlte::page')

@section('title','Procedure')

@section('content_header')
    <h1 class="m-0 text-dark">Procedure</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Procedure"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Location Name</th>
        <th>Product Name</th>
        <th>Machine Name</th>
        <th>System Name</th>
        <th>Equipment Name</th>
        <th>Activity Name</th>
        <th>Procedure</th>
        <th>Controlled Point</th>
        <th>Class</th>
        <th>Man</th>
        <th>Hour</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="LocationName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ProductName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="MachineName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="SystemName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="SpecificName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ActivityName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Procedure">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ControlledPoint">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Class">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Man">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Hour">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc'],[1,'asc'],[2,'asc'],[3,'asc'],[4,'asc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
