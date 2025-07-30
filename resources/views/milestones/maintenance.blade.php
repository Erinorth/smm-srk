@extends('adminlte::page')

@section('title', 'Mile Stone')

@section('content_header')
    <h1 class="m-0 text-dark">Mile Stone</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Mile Stone"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Mile Stone</th>
        <th>Activity</th>
        <th>Document</th>
        <th>Link</th>
        <th>Folder</th>
        <th>Responsible</th>
        <th>Status / Date</th>
        <th>KPI</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Update Mile Stone Status">
        <x-input.dropdown title="Status" name-id="Status">
            <option></option>
            <option>Not Relevant</option>
            <option>Not Start</option>
            <option>In Progress</option>
            <option>Completed</option>
        </x-input.dropdown>

        <x-input.text title="Remark" name-id="Remark"/>

        <x-slot name="othervalue">
            <input type="hidden" name="item_id" id="item_id" value="{{$project->id}}" />
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    <div id="formModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">History</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result2"></span>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Updated At</th>
                                <th>Status</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody id="bodyData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน milestone.pdf').'">การใช้งาน Milestone</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            var project_id = $('#project_id').attr('value');

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="MileStoneDate"/>
                <x-data-table.column-script column-name="Activity">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Document">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Link">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Folder">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="JobPositionName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="StatusDate">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="KPI"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/projects_milestone') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/projects_milestone') }}"/>

            var show_id;

            $(document).on('click', '.history', function(){
                var show_id = $(this).attr('id');
                $('#form_result2').html('');
                $.ajax({
                    url :"{{ url('/milestone_record/') }}"+show_id,
                    data:{
                        _token:'{{ csrf_token() }}'
                    },
                    cache: false,
                    dataType:"json",
                    success:function(dataResult)
                    {
                        console.log(dataResult);
                        var resultData = dataResult.data;
                        var bodyData = '';
                        function appendLeadingZeroes(n){
                            if(n <= 9){
                                return "0" + n;
                            }
                            return n
                        }
                        $.each(resultData,function(index,row){
                            let datetime = new Date(row.created_at)
                            let formatted_date = datetime.getFullYear() + "-" + appendLeadingZeroes(datetime.getMonth() + 1) + "-" + appendLeadingZeroes(datetime.getDate()) + " " + appendLeadingZeroes(datetime.getHours()) + ":" + appendLeadingZeroes(datetime.getMinutes()) + ":" + appendLeadingZeroes(datetime.getSeconds())
                            //console.log(formatted_date)
                            bodyData+="<tr>";
                            bodyData+="<td>"+formatted_date+"</td><td class='text-center'>"+row.Status+"</td>";
                            if ( row.Remark !== null ) {
                                bodyData+="<td>"+row.Remark+"</td>";
                            } else {
                                bodyData+="<td></td>";
                            }
                            bodyData+="</tr>";
                        })
                        $('#bodyData').html(bodyData);
                        $('#formModal2').modal('show');
                        bodyData = null;
                    }
                })
            });
        });
    </script>
@endsection
