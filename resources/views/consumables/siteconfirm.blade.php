@extends('adminlte::page')

@section('title', 'Consumable')

@section('content_header')
    <h1 class="m-0 text-dark">Consumable</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Consumable"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Pick Date</th>
        <th>PM Order</th>
        <th>Consumable Name</th>
        <th>Detail</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Remark</th>
        <th>Confirmed</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การเบิก คืน consumable.pdf').'">การเบิก คืน Consumable</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            $('#data_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax:{
                        url: "",
                    },
                columns: [
                    <x-data-table.column-script column-name="created_at"/>
                    <x-data-table.column-script column-name="PMOrder"/>
                    <x-data-table.column-script column-name="ConsumableName"/>
                    <x-data-table.column-script column-name="Detail">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Pick">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Unit">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Remark">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Confirmed"/>
                ],
                "order":[[0,'desc']],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,

                drawCallback: function(){
                    $('.toggle-class').bootstrapSwitch();
                    $('.toggle-class').on('switchChange.bootstrapSwitch', function (event, state) {
                        var status = $(this).prop('checked') == true ? 'Yes' : 'No';
                        var consumable_site_id = $(this).data('id');
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '/consumable_confirms/update',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            data: {'status': status, 'consumable_site_id': consumable_site_id},
                            success: function(data){
                                console.log(data.success)
                            }
                        });
                    });
                }
            });
        });
    </script>
@endsection
