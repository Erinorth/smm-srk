@extends('adminlte::page')

@section('title','Tool')

@section('content_header')
    <h1 class="m-0 text-dark">Tool Calibration</h1>
@stop

@section('content')
    <x-card.default-card color="" collapse-card="collapsed-card" title="Report" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <div class="container">
            <div class="row align-items-center justify-content-around">
                <div class="col-xl text-center">
                    <a class="btn btn-primary btn-sm" href="{{ URL('tool_calibrate_list') }}">List</a>
                </div>
                <div class="col-xl text-center">
                    <div class="form-group">
                        <label>Calibrate Plan</label>
                        <form class="form-horizontal" method="POST" action="{{ url('/tool_calibrate_plan') }}">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row">
                                        <label class="control-label" >Year</label> <!-- -->
                                        <div class="col">
                                            <input type="text" class="form-control" name="year" id="year" placeholder="ใส่ปี ค.ศ. 4 หลัก">
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

    <x-data-table.default-data-table color="" collapse-card="" title="Tool Calibration"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Catagory Name</th>
        <th>Range/Capacity</th>
        <th>LocalCode</th>
        <th>Brand</th>
        <th>Model</th>
        <th>SerialNumber</th>
        <th>Calibrate Date</th>
        <th>Expire Date</th>
        <th>Remark</th>
        <th>Attachment</th>
        <th>Update</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Tool Calibration ALL"
        collapse-button="plus" table-id="_tool_calibrate_all">
        <x-slot name="tool">
        </x-slot>
        <th>ID</th>
        <th>Catagory Name</th>
        <th>Range/Capacity</th>
        <th>LocalCode</th>
        <th>Brand</th>
        <th>Model</th>
        <th>SerialNumber</th>
        <th>Calibrate Date</th>
        <th>Calibrator</th>
        <th>Result</th>
        <th>Certificate</th>
        <th>Accuracy</th>
        <th>AcceptError</th>
        <th>Expire Date</th>
        <th>Cost</th>
        <th>Remark</th>
        <th>Responible</th>
        <th>Attachment</th>
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
                                <th>Calibrate Date</th>
                                <th>Calibrator</th>
                                <th>Result</th>
                                <th>Certificate No.</th>
                                <th>Accuracy</th>
                                <th>AcceptError</th>
                                <th>Cost</th>
                                <th>Remark</th>
                                <th>Responsible</th>
                            </tr>
                        </thead>
                        <tbody id="bodyData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal.input-form name-i-d="_update" modal-title="Add New Certificate">
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp

        <x-adminlte-input-date name="CalibrateDate" label="Calibrate Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input name="Calibrator" label="หน่วยงานสอบเทียบ" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-select2 name="Result" label="Result Type" data-placeholder="Select an option...">
            <option></option>
            <option>Pass</option>
            <option>Not Pass</option>
        </x-adminlte-select2>

        <x-adminlte-input name="Certificate" label="Certificate No." placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Accuracy" label="Accuracy" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="AcceptError" label="ค่าความผิดพลาดที่ยอมรับได้" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input-date name="ExpireDate" label="Expire Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input name="Cost" label="ค่าใช้จ่าย" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input-file name="Attachment" label="Upload files (if pass)" igroup-size="" placeholder="Choose a file...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
        </x-adminlte-input-file>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน tool calibrate.pdf').'">การใช้งาน Tool Calibrate</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="CatagoryName"/>
                <x-data-table.column-script column-name="RangeCapacity"/>
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="CalibrateDate"/>
                <x-data-table.column-script column-name="ExpireDate"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Attachment2">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[7,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_tool_calibrate_all" ajax-url="{{ url('/tool_calibrates_all') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="CatagoryName"/>
                <x-data-table.column-script column-name="RangeCapacity"/>
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="CalibrateDate"/>
                <x-data-table.column-script column-name="Calibrator"/>
                <x-data-table.column-script column-name="Result"/>
                <x-data-table.column-script column-name="Certificate"/>
                <x-data-table.column-script column-name="Accuracy"/>
                <x-data-table.column-script column-name="AcceptError"/>
                <x-data-table.column-script column-name="ExpireDate"/>
                <x-data-table.column-script column-name="Cost"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="Attachment3">
                    orderable: false
                </x-data-table.column-script>
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
                    url :"{{ url('/tool_calibrates/') }}"+show_id,
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
                            bodyData+="<td class='text-center'>"+row.CalibrateDate+"</td>";
                            bodyData+="<td class='text-center'>"+row.Calibrator+"</td>";
                            bodyData+="<td class='text-center'>"+row.Result+"</td>";
                            bodyData+="<td class='text-center'>"+row.Certificate+"</td>";
                            bodyData+="<td class='text-center'>"+row.Accuracy+"</td>";
                            bodyData+="<td class='text-center'>"+row.AcceptError+"</td>";
                            bodyData+="<td class='text-center'>"+row.Cost+"</td>";
                            if ( row.Remark !== null ) {
                                bodyData+="<td>"+row.Remark+"</td>";
                            } else {
                                bodyData+="<td></td>";
                            }
                            bodyData+="<td class='text-center'>"+row.Responsible+"</td>";
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
                $('#create_form_update')[0].reset();
                $('.modal-title').text('Update History');
                $('#hidden_id_update').val(update_id);
                $('#action_button_update').val('Update');
                $('#action_update').val('Update');
                $('#form_result_update').html('');
                $('#formModal_update').modal('show');
                console.log(update_id);
            });

            $('#create_form_update').on('submit', function(event){
                event.preventDefault();
                var formData = new FormData(this);
                var action_url = "{{ url('/tool_calibrates') }}";

                $.ajax({
                    type:'POST',
                    url: action_url,
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
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
                            $('#create_form_update')[0].reset();
                        }
                        if(data.failures)
                        {
                            console.log('failures');

                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.failures.length; count++)
                            {
                                html += '<p> Row:' + data.failures[count].row +
                                ' ' + data.failures[count].errors + '</p>';
                            }
                            html += '</div>';
                            $('#create_form_update')[0].reset();
                            <x-data-table.ajax-reload-script table-id=""/>
                            <x-data-table.ajax-reload-script table-id="_tool_calibrate_all"/>
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#create_form_update')[0].reset();
                            <x-data-table.ajax-reload-script table-id=""/>
                            <x-data-table.ajax-reload-script table-id="_tool_calibrate_all"/>
                        }
                        $('#form_result_update').html(html);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

            <x-data-table.delete-script delete-name="" url="{{ url('/tool_calibrates') }}"/>
        });
    </script>
@endsection
