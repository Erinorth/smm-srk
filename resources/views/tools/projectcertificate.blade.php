@extends('adminlte::page')

@section('title','Measurement Tool Certificate')

@section('content_header')
    <h1 class="m-0 text-dark">Measurement Tool Certificate</h1>
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
        <th>Catagory Name</th>
        <th>Range/Capacity</th>
        <th>Unit</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Serial Number</th>
        <th>Local Code</th>
        <th>Durable Supplie Code</th>
        <th>Asset Tool Code</th>
        <th>Expire Date</th>
        <th>Certificate</th>
        <x-slot name="othertable">
        </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Certificate">
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp

        <x-adminlte-input-date name="EffectiveDate" id="EffectiveDate" label="Effective Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input-file name="Attachment" id="Attachment" label="Upload files" igroup-size="" placeholder="Choose a file...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
        </x-adminlte-input-file>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}" />
            <input type="hidden" name="employee_id" id="employee_id" value="0" />
            <input type="hidden" name="certificate_type_id" id="certificate_type_id" value="0" />
            <input type="hidden" name="job_position_id" id="job_position_id" value="0" />
        </x-slot>
    </x-modal.input-form>

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
                <x-data-table.column-script column-name="Unit"/>
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="DurableSupplieCode"/>
                <x-data-table.column-script column-name="AssetToolCode"/>
                <x-data-table.column-script column-name="ExpireDate"/>
                <x-data-table.column-script column-name="Attachment">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            $('#create_form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var action_url = "/employees_certificate_project";
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
                            $('#create_form')[0].reset();
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
                            $('#create_form')[0].reset();
                            <x-data-table.ajax-reload-script table-id=""/>
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#create_form')[0].reset();
                            <x-data-table.ajax-reload-script table-id=""/>
                        }
                        $('#form_result').html(html);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

            $(document).on('click','.add', function(){
                var employeeid = $(this).attr('employeeid');
                var certificatetypeid = $(this).attr('certificatetypeid');
                var jobpositionid = $(this).attr('jobpositionid');
                $('#form_result').html('');
                $('#employee_id').val(employeeid);
                $('#certificate_type_id').val(certificatetypeid);
                $('#job_position_id').val(jobpositionid);
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#formModal').modal('show');
                console.log(employeeid);
                console.log(certificatetypeid);
                console.log(jobpositionid);
            });
        });
    </script>
@endsection
