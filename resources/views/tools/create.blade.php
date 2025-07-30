@extends('adminlte::page')

@section('title','Tool')

@section('content_header')
    <h1 class="m-0 text-dark">Tool</h1>
@stop

@section('content')
    <x-header.tool-catagory-header toolCatagoryId="{{$toolcatagory->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.tool-catagory-header>

    <x-data-table.default-data-table color="" collapse-card="" title="Tool"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|store_keeper')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>LocalCode</th>
        <th>Serial Number</th>
        <th>ยี่ห้อ</th>
        <th>รุ่น</th>
        <th>รหัสครุภัณฑ์/รหัสพัสดุ</th>
        <th>รหัสสินทรัพย์/รหัสเครื่องมือเครื่องใช้</th>
        <th>น้ำหนัก (kg.)</th>
        <th>Price</th>
        <th>อายุการใช้งาน (วัน)</th>
        <th>วันขึ้นทะเบียน</th>
        <th>มูลค่าปัจจุบัน</th>
        <th>ผู้รับผิดชอบ</th>
        <th>Status</th>
        <th>Remark</th>
        <th>Action</th>
        <th>PM</th>
        <th>Pre use</th>
        <th>Accepted</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Tool">
        <x-adminlte-input name="LocalCode" label="Local Code" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="SerialNumber" label="Serial Number" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Brand" label="ยี่ห้อ" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Model" label="รุ่น" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="DurableSupplieCode" label="รหัสครุภัณฑ์/รหัสพัสดุ" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="AssetToolCode" label="รหัสสินทรัพย์/รหัสเครื่องมือเครื่องใช้" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Weight" label="น้ำหนัก" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Price" label="Price" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="LifeTime" label="อายุการใช้งาน (วัน)" placeholder="Input a text..."
            disable-feedback/>

        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="RegisterDate" label="วันที่ขึ้นทะเบียน" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-select2 name="Responsible" label="ผู้รับผิดชอบ" data-placeholder="Select an option...">
            <option/>
            @foreach ($responsible as $value)
                <option value="{{ $value->id }}">{{ $value->ThaiName }}</option>
            @endforeach
        </x-adminlte-select2>

        <x-slot name="othervalue">
            <input type="hidden" name="tool_catagory_id" id="tool_catagory_id" value="{{$toolcatagory->id}}" />
        </x-slot>
    </x-modal.input-form>

    <div id="formModal2" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
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
                                <th>Location</th>
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

    <div id="formModal3" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4> <!-- -->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result3"></span>
                    <form method="post" id="update_form" class="form-horizontal">
                        @csrf

                        <x-input.dropdown title="Status" name-id="Status">
                            <option></option>
                            <option>Available</option>
                            <option>Lend</option>
                            <option>Calibrating</option>
                            <option>Broken</option>
                            <option>Degenerate</option>
                            <option>Lost</option>
                            <option>Cut Off</option>
                        </x-input.dropdown>

                        <x-input.text title="Remark" name-id="Remark"/>

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

    <x-content.upload-file-tool name="accepted"/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน tool.pdf').'">การใช้งาน Tool</a>',null]
        ];
    @endphp
    @php
        $tabledata = [
            ['<a href="'. asset('storage/user_manual/การใช้งาน tool.pdf').'">การใช้งาน Tool</a>',null]
        ];
    @endphp
    @php
        $tabledata = [
            ['<a href="'. Storage::url('user_manual/การใช้งาน tool.pdf').'">การใช้งาน Tool</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="DurableSupplieCode"/>
                <x-data-table.column-script column-name="AssetToolCode"/>
                <x-data-table.column-script column-name="Weight"/>
                <x-data-table.column-script column-name="Price"/>
                <x-data-table.column-script column-name="LifeTime"/>
                <x-data-table.column-script column-name="RegisterDate"/>
                <x-data-table.column-script column-name="PV"/>
                <x-data-table.column-script column-name="Responsible"/>
                <x-data-table.column-script column-name="Status"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="PM">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="PreUse">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Accept">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'deas']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Tool"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/tools') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/tools') }}">
                <x-data-table.edit-value-script name="department_id"/>
                <x-data-table.edit-value-script name="LocalCode"/>
                <x-data-table.edit-value-script name="Brand"/>
                <x-data-table.edit-value-script name="Model"/>
                <x-data-table.edit-value-script name="DurableSupplieCode"/>
                <x-data-table.edit-value-script name="AssetToolCode"/>
                <x-data-table.edit-value-script name="Weight"/>
                <x-data-table.edit-value-script name="SerialNumber"/>
                <x-data-table.edit-value-script name="Price"/>
                <x-data-table.edit-value-script name="LifeTime"/>
                <x-data-table.edit-value-script name="RegisterDate"/>
                <x-data-table.edit-value-script name="Responsible"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/tools') }}"/>

            var show_id;

            $(document).on('click', '.history', function(){
                var show_id = $(this).attr('id');
                $('#form_result2').html('');
                $.ajax({
                    url :"{{ url('/tool_historys/') }}"+show_id,
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
                            bodyData+="<td class='text-center'>"+formatted_date+"</td>";
                            if ( row.ProjectName !== null ) {
                                bodyData+="<td class='text-center'>"+row.ProjectName+"</td>";
                            } else {
                                bodyData+="<td class='text-center'>In Store</td>";
                            }
                            bodyData+="<td class='text-center'>"+row.Status+"</td>";
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

            var update_id;

            $(document).on('click', '.update', function(){
                var update_id = $(this).attr('id');
                $('.select2-bootstrap4').val(null).trigger('change');
                $('#update_form')[0].reset();
                $('.modal-title').text('Update History');
                $('#update_id').val(update_id);
                $('#action_button2').val('Update');
                $('#action2').val('Update');
                $('#form_result3').html('');
                $('#formModal3').modal('show');
            });

            $('#update_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url: "{{ url('/tool_historys') }}",
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
                        $('#form_result3').html(html);
                    }
                });
            });

            <x-j-s.upload-file-tool name="accepted"/>
        });
    </script>
@endsection
