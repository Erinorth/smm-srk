@extends('adminlte::page')

@section('title', 'Mile Stone')

@section('content_header')
    <h1 class="m-0 text-dark">Mile Stone</h1>
@stop

@section('content')
    <x-header.office-job officeId="{{$office->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.office-job>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Create/Update" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/milestone_offices') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >List</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="List" id="List">
                                <option></option>
                                <option>บำรุงรักษาพลังน้ำในประเทศ</option>
                                <option>บำรุงรักษาพลังน้ำต่างประเทศ</option>
                                <option>บำรุงรักษาพลังลมในประเทศ</option>
                                <option>บำรุงรักษาเครนในประเทศ</option>
                                <option>บำรุงรักษาใต้น้ำ</option>
                                <option>Governor Performance Test</option>
                                <option>สนับสนุนผู้ปฏิบัติงานแบบฝากสายบังคับบัญชา(คด.17)</option>
                                <option>สนับสนุนผู้ปฏิบัติงานแบบไม่ฝากสายบังคับบัญชา(คด.16)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-2 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Create/Update</button>
                </div>
            </div>
        </form>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Mile Stone"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @if ( count($milestone) == 0 )
                <form class="form-horizontal" method="POST" action="{{ URL('/milestone_offices') }}">
                    @csrf
                    @foreach ($milestonestandard as $value)
                        <input type="text" class="form-control" name="office_id[]" value="{{$office->id}}" hidden>
                        <input type="text" class="form-control" name="mile_stone_activity_id[]" value="{{$value->id}}" hidden>
                    @endforeach
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block delete_form" title="Create Mile Stone"><i class="fa fa-lg fa-fw fa-plus-square"></i></button>
                    </div>
                </form>
            @endif
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
            <input type="hidden" name="office_id" id="office_id" value="{{$office->id}}" />
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
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            var office_id = $('#office_id').attr('value');

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

            <x-data-table.submit-script name-i-d="" action-url="milestone_offices">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="milestone_offices"/>

            var show_id;

            $(document).on('click', '.history', function(){
                var show_id = $(this).attr('id');
                $('#form_result2').html('');
                $.ajax({
                    url :"/milestone_record/"+show_id,
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
