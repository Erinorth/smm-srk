@extends('adminlte::page')

@section('title','Man Hour')

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    @if ( count($manhourdata) != 0 )
        <div class="row">
            <div class="col-6">
                <x-chart.man-hour collapse-card="" title="Man-Hour(Skill)"
                collapse-button="minus" chart-id="manhour"/>
            </div>
            <div class="col-6">
                <x-chart.man-hour collapse-card="" title="Man-Hour(All)"
                collapse-button="minus" chart-id="other"/>
            </div>
        </div>
        @php
            $m = 1;
        @endphp
    @else
        @php
            $m = 0;
        @endphp
    @endif

    <x-adminlte-card title="Report" theme="primary" icon="" collapsible="collapsed" removable maximizable>
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/timesheet_report') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >From</label> <!-- -->
                        <div class="col">
                            <input type="date" class="form-control" name="startDate" id="startDate">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >To</label> <!-- -->
                        <div class="col">
                            <input type="date" class="form-control" name="endDate" id="endDate">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >PM Order from</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="pmorderreport" id="pmorderreport">
                                <option>Job</option>
                                <option>Specific</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                </div>
            </div>
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
            <div class="row">
                <div class="col">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Select All <input type="checkbox" id="checkAll"/></th>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report as $value)
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="checkBoxClass" name="WorkID[]" value="{{ $value->WorkID }}"/></td>
                                    <td class="text-center">{{ $value->WorkID }}</td>
                                    <td>{{ $value->ThaiName }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </x-adminlte-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Man-Hour"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
            <button class="btn btn-xs text-success" name="create_record_import" id="create_record_import" title="Import"><i class="fa fa-lg fa-fw fa-file-import"></i></button>
        </x-slot>
        <th>Working Date</th>
        <th>Name</th>
        <th>Job ID</th>
        <th>Specific PM Order</th>
        <th>Job Position</th>
        <th>Normal</th>
        <th>OT from</th>
        <th>OT to</th>
        <th>OT 1</th>
        <th>OT 1.5</th>
        <th>OT 2</th>
        <th>OT 3</th>
        <th>Remark</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Job Position"
        collapse-button="plus" table-id="_jobposition">
        <x-slot name="tool">
            <x-button.create-record name-i-d="_jobposition"/>
        </x-slot>
        <th>ID</th>
        <th>Job Name</th>
        <th>Type of Job</th>
        <th>Craft Name</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Confined Space Measurement">
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="WorkingDate" label="Working Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-select2 name="employee_id" label="Name" data-placeholder="Select an option...">
            <option/>
        </x-adminlte-select2>

        <a href="{{ url('/mobilizationplans/'.$project->id.'') }}">*เลือก Working Date ก่อนหากไม่พบรายชื่อผู้ปฏิบัติงานต้องไปเพิ่มรายชื่อใน mobilization plan ให้ครอบคลุมวันที่จะลง man-hour ก่อน</a>

        <x-adminlte-select2 name="job_id" label="Job ID" data-placeholder="Select an option...">
            <option/>
            @foreach ($job as $value)
                <option value="{{$value->id}}">{{$value->LocationName}}//{{$value->MachineName}}//{{$value->Remark}}//{{$value->ProductName}}//{{$value->SystemName}}//{{$value->SpecificName}}//{{$value->id}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="p_m_order_id" label="Specific PM Order" data-placeholder="Select an option...">
            <option/>
            @foreach ($pmorder as $value)
                <option value="{{$value->id}}">{{$value->PMOrder}}//{{$value->PMOrderName}}//{{$value->Remark}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="job_position_id" label="Job Position" data-placeholder="Select an option...">
            <option/>
            @foreach ($jobposition as $value)
                <option value="{{$value->id}}">{{$value->JobPositionName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="Normal" label="Normal" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        @php
            $config = ['format' => 'HH:mm'];
        @endphp
        <x-adminlte-input-date name="OTfrom" label="OT from" :config="$config" placeholder="Choose a time...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-gradient-info">
                    <i class="fas fa-clock"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input-date name="OTto" label="OT to" :config="$config" placeholder="Choose a time...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-gradient-info">
                    <i class="fas fa-clock"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <div class="row">
            <x-adminlte-input name="OT1" label="OT 1" placeholder="number"
                fgroup-class="col-md" disable-feedback/>
        </div>

        <div class="row">
            <x-adminlte-input name="OT15" label="OT 1.5" placeholder="number"
                fgroup-class="col-md" disable-feedback/>
        </div>

        <div class="row">
            <x-adminlte-input name="OT2" label="OT 2" placeholder="number"
                fgroup-class="col-md" disable-feedback/>
        </div>

        <div class="row">
            <x-adminlte-input name="OT3" label="OT 3" placeholder="number"
                fgroup-class="col-md" disable-feedback/>
        </div>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="_import" modal-title="Import Excel File">
        <x-adminlte-input-file name="select_file" label="Select File for Upload" igroup-size="" placeholder="Choose a file...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
        </x-adminlte-input-file>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="_jobposition" modal-title="Add New Job Position">
        <x-input.text title="Job Position Name" name-id="JobPositionName"/>

        <x-input.text title="Type of Job" name-id="TypeofJob"/>

        <x-input.dropdown title="Craft Name" name-id="craft_id">
            <option></option>
            @foreach ($craft as $value)
                <option value="{{$value->id}}">{{$value->CraftName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-modal.confirm-delete delete-name="_jobposition"/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="WorkingDate"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="job_id"/>
                <x-data-table.column-script column-name="PMOrder"/>
                <x-data-table.column-script column-name="JobPositionName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Normal">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="OTfrom">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="OTto">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="OT1">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="OT15">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="OT2">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="OT3">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc'],[1,'asc'],[2,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_jobposition" ajax-url="{{ url('/jobpositions') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="JobPositionName"/>
                <x-data-table.column-script column-name="TypeofJob">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="CraftName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[1,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Man-Hour"/>

            <x-data-table.create-script name-i-d="_jobposition" title="Add Job Position"/>

            <x-data-table.submit-script name-i-d="" action-url="manhours">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.submit-script name-i-d="_jobposition" action-url="jobpositions">
                <x-data-table.ajax-reload-script table-id="_jobposition"/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="manhours">
                <x-data-table.edit-value-script name="employee_id"/>
                <x-data-table.edit-value-script name="WorkingDate"/>
                <x-data-table.edit-value-script name="job_id"/>
                <x-data-table.edit-value-script name="p_m_order_id"/>
                <x-data-table.edit-value-script name="job_position_id"/>
                <x-data-table.edit-value-script name="Normal"/>
                <x-data-table.edit-value-script name="OTfrom"/>
                <x-data-table.edit-value-script name="OTto"/>
                <x-data-table.edit-value-script name="OT1"/>
                <x-data-table.edit-value-script name="OT15"/>
                <x-data-table.edit-value-script name="OT2"/>
                <x-data-table.edit-value-script name="OT3"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.edit-script edit-name="_jobposition"  edit-url="jobpositions">
                <x-data-table.edit-value-script name="JobPositionName"/>
                <x-data-table.edit-value-script name="TypeofJob"/>
                <x-data-table.edit-value-script name="craft_id"/>
            </x-data-table.edit-script>

            $('#create_record_import').click(function(){
                $('#create_form_import')[0].reset();
                $('#formModal_import').modal('show');
            });

            $('#create_form_import').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var projectid = $('#project_id').attr('value');

                $.ajax({
                    type:'POST',
                    url: "/manhour_import_excel/"+projectid,
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
                            $('#create_form_import')[0].reset();
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
                            $('#create_form_import')[0].reset();
                            $('#data_table').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#create_form_import')[0].reset();
                            $('#data_table').DataTable().ajax.reload();
                        }
                        $('#form_result_import').html(html);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

            $(function(e){
                $('#checkAll').click(function(){
                    $('.checkBoxClass').prop('checked',$(this).prop('checked'));
                });
            });

            <x-data-table.delete-script delete-name="" url="manhours"/>

            <x-data-table.delete-script delete-name="_jobposition" url="jobpositions"/>

            $('input[name="WorkingDate"]').focusout(function(){
                if($(this).val() != '')
                {
                    var workingdate = $(this).val();
                    var project_id = $('input[name="project_id"]').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('manhours.fetchcreate') }}",
                        method:"POST",
                        data:{workingdate:workingdate, project_id:project_id, _token:_token},
                        success:function(result)
                        {
                            $('#employee_id').html(result);
                        }
                    })
                    console.log(workingdate);
                    console.log(project_id);
                }
            });

            var m = "<?php echo $m ?>";

            if ( m != 0 ){
                var ctx = document.getElementById('manhour').getContext('2d');
                var mixedChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                    labels:  {!!json_encode($manhourchart->labels)!!} ,
                    datasets: [
                        {
                            label: 'Man Hour',
                            backgroundColor: {!! json_encode($manhourchart->colours)!!},
                            data:  {!! json_encode($manhourchart->manhour)!!},
                            borderColor: {!! json_encode($manhourchart->colours)!!},
                        },{
                            label: 'Plan M-H',
                            data: {!! json_encode($manhourchart->plan)!!},
                            type: 'line',
                            borderColor: ['rgba(54, 162, 235, 1)'],
                            backgroundColor: ['rgba(0, 0, 0, 0)'],
                        },{
                            label: 'Running Sum',
                            data: {!! json_encode($manhourchart->csum)!!},
                            type: 'line',
                            borderColor: ['rgba(255, 206, 86, 1)'],
                            backgroundColor: ['rgba(0, 0, 0, 0)'],
                        }
                    ]},

                });

                var ctx2 = $('#other');
                var mixedChart2 = new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($otherchart->labels)!!},
                        datasets: [
                            {
                                backgroundColor: {!! json_encode($otherchart->colours)!!},
                                data:  {!! json_encode($otherchart->manhour)!!},
                            }
                        ]
                    },
                });
            }
        });
    </script>
@endsection
