@extends('adminlte::page')

@section('title','Maintenance Report')

@section('content_header')
    <h1 class="m-0 text-dark">Maintenance Report</h1>
@stop

@section('content')
    <x-header.job jobId="{{$job->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.job>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Report" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <div class="container text-center">
            <a class="btnprn btn btn-secondary btn-sm" href="{{url('MR/'.$job->id)}}">Print</a>
        </div>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Maintenance Report"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <form class="form-horizontal" method="POST" action="{{ URL('/maintenance_reports_create') }}">
                @csrf
                @foreach ($activity as $value)
                    <input type="text" name="job_id[]" value="{{$value->job_id}}" hidden>
                    <input type="text" name="activity_id[]" value="{{$value->id}}" hidden>
                    <input type="text" name="Done[]" value="No" hidden>
                @endforeach
                <button type="submit" class="btn btn-success btn-sm">Create Maintenance Report</button>
            </form>
        </x-slot>
        <th>Done</th>
        <th>Order</th>
        <th>Activity</th>
        <th>Condition</th>
        <th>Counter Measure</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add Activity">
        <x-input.text-area title="Condition" name-id="Condition"/>

        <x-input.text-area title="Countermeasure" name-id="Countermeasure"/>

        <x-input.text title="Remark" name-id="Remark"/>

        <x-slot name="othervalue">

        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
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
                    <x-data-table.column-script column-name="Done">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Order">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="ActivityName">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Condition">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Countermeasure">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Remark">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="action">
                        orderable: false
                    </x-data-table.column-script>
                ],
                "order":[],
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
                        var Done = $(this).prop('checked') == true ? 'Yes' : 'No';
                        var maintenance_report_id = $(this).data('id');
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '/maintenance_reports/done',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            data: {'Done': Done, 'maintenance_report_id': maintenance_report_id},
                            success: function(data){
                                console.log(data.success)
                            }
                        });
                    });
                }
            });

            <x-data-table.create-script name-i-d="" title="Add Activity"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/maintenance_reports') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/maintenance_reports') }}">
                <x-data-table.edit-value-script name="Condition"/>
                <x-data-table.edit-value-script name="Countermeasure"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/maintenance_reports') }}"/>
        });
    </script>
@endsection
