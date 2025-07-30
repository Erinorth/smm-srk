@extends('adminlte::page')

@section('title','Tool')

@section('content_header')
    <h1 class="m-0 text-dark">PM Tool</h1>
@stop

@section('content')
    <x-card.default-card color="" collapse-card="collapsed-card" title="Report" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <div class="container">
            <div class="row align-items-center justify-content-around">
                <div class="col-xl text-center">
                    <div class="form-group">
                        <label>PM Plan</label>
                        <form class="form-horizontal" method="POST" action="{{ url('/tool_pm_plan') }}">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row">
                                        <label class="control-label" >Year</label> <!-- -->
                                        <div class="col">
                                            <input type="text" class="form-control" name="year" id="year">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-center">
                                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="PM Tool"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Catagory Name</th>
        <th>Range/Capacity</th>
        <th>LocalCode</th>
        <th>Brand</th>
        <th>Model</th>
        <th>SerialNumber</th>
        <th>Activity</th>
        <th>Lastest PM Date</th>
        <th>Next PM Date</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">History</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>PM Date</th>
                                <th>หน่วยงาน / ผู้ดำเนินการ</th>
                                <th>ค่าใช้จ่าย</th>
                                <th>ผลการดำเนินการ</th>
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

    <div id="formModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4> <!-- -->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result2"></span>
                    <form method="post" id="update_form" class="form-horizontal">
                        @csrf

                        <x-input.date title="PM Date" name-id="PMDate"/>

                        <x-input.text title="หน่วยงาน / ผู้ดำเนินการ" name-id="Operator"/>

                        <x-input.text title="ค่าใช้จ่าย" name-id="Cost"/>

                        <x-input.text-area title="ผลการดำเนินการ" name-id="Result"/>

                        <x-input.text-area title="Remark" name-id="Remark"/>

                        <div class="form-group text-center">
                            <input type="hidden" name="action2" id="action2" value="Update History" />
                            <input type="hidden" name="update_id" id="update_id" />
                            <input type="submit" name="action_button2" id="action_button2" class="btn btn-success" value="Update History" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            function nl2br (str, replaceMode, isXhtml) {
                var breakTag = (isXhtml) ? '<br />' : '<br>';
                var replaceStr = (replaceMode) ? '$1'+ breakTag : '$1'+ breakTag +'$2';
                return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
            }

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="CatagoryName"/>
                <x-data-table.column-script column-name="RangeCapacity"/>
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="Activity"/>
                <x-data-table.column-script column-name="PMDate"/>
                <x-data-table.column-script column-name="NextPM"/>
                <x-data-table.column-script column-name="Remark"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            var show_id;

            $(document).on('click', '.history', function(){
                var show_id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url :"{{ url('/tool_PMs/') }}"+show_id,
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
                            bodyData+="<td class='text-center'>"+row.PMDate+"</td>";
                            bodyData+="<td class='text-center'>"+row.Operator+"</td>";
                            bodyData+="<td class='text-center'>"+row.Cost+"</td>";
                            bodyData+="<td>"+nl2br(row.Result)+"</td>";
                            if ( row.Remark !== null ) {
                                bodyData+="<td>"+nl2br(row.Remark)+"</td>";
                            } else {
                                bodyData+="<td></td>";
                            }
                            bodyData+="</tr>";
                        })
                        $('#bodyData').html(bodyData);
                        $('#formModal').modal('show');
                        bodyData = null;
                    }
                })
            });

            var update_id;

            $(document).on('click', '.update', function(){
                var update_id = $(this).attr('id');
                $('.select2-bootstrap4').val(null).trigger('change');
                $('#update_form')[0].reset();
                $('.modal-title').text('Update History');
                $('#update_id').val(update_id);
                $('#action_button2').val('Update');
                $('#action2').val('Update');
                $('#form_result2').html('');
                $('#formModal2').modal('show');
            });

            $('#update_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url: "{{ url('/tool_PMs') }}",
                    method:"POST",
                    data:$(this).serialize(),
                    dataType:"json",
                    success:function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('.select2-bootstrap4').val(null).trigger('change');
                            $('#update_form')[0].reset();
                            <x-data-table.ajax-reload-script table-id=""/>
                        }
                        $('#form_result2').html(html);
                    }
                });
            });
        });
    </script>
@endsection
