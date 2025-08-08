@extends('adminlte::page')

@section('title','Progress')

@section('content')
    <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Progress List"
        collapse-button="plus" table-id="_progress">
        <x-slot name="tool"></x-slot>
        <th>Job ID</th>
        <th>Location</th>
        <th>Product</th>
        <th>Machine</th>
        <th>System</th>
        <th>Equipment</th>
        <th>Scope</th>
        <th>Plan</th>
        <th>Actual</th>
        <x-slot name="othertable">
        </x-slot>
    </x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="" title="Progress"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
            <button class="btn btn-xs text-success" name="create_record2" id="create_record2" title="Import"><i class="fa fa-lg fa-fw fa-file-import"></i></button>
        </x-slot>
        <th>Progress Date</th>
        <th>Job ID</th>
        <th>Plan</th>
        <th>Actual</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Progress">
        <x-input.date title="Progress Date" name-id="ProgressDate"/>

        <x-input.dropdown title="Job ID" name-id="job_id">
            <option></option>
            @foreach ($job as $value)
                <option value="{{$value->id}}">{{$value->LocationName}}//{{$value->MachineName}}//{{$value->ProductName}}//{{$value->SystemName}}//{{$value->SpecificName}}//{{$value->id}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.text title="Plan" name-id="Plan"/>

        <x-input.text title="Actual" name-id="Actual"/>

        <x-input.text title="Remark" name-id="Remark"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <div id="formModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import Excel File</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result2"></span>
                    <form method="post" id="create_form2" class="form-horizontal" enctype="multipart/form-data" action="javascript:void(0)">
                        @csrf
                        <div class="form-group">
                            <label class="control-label" >Select File for Upload</label>
                            <div>
                                <input type="file" name="select_file" id="select_file">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-success" value="Upload" />
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

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="ProgressDate"/>
                <x-data-table.column-script column-name="job_id"/>
                <x-data-table.column-script column-name="Plan"/>
                <x-data-table.column-script column-name="Actual"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc'],[1,'asc'],[2,'asc']</x-slot>
            </x-data-table.data-table-script>

            var projectid = $('#project_id').attr('value');

            $('#data_table_progress').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "/progress_project/"+projectid,
                },
                columns: [
                    <x-data-table.column-script column-name="id"/>
                    <x-data-table.column-script column-name="LocationName"/>
                    <x-data-table.column-script column-name="ProductName"/>
                    <x-data-table.column-script column-name="MachineName"/>
                    <x-data-table.column-script column-name="SystemName"/>
                    <x-data-table.column-script column-name="EquipmentName"/>
                    <x-data-table.column-script column-name="ScopeName"/>
                    <x-data-table.column-script column-name="SumOfPlan"/>
                    <x-data-table.column-script column-name="SumOfActual"/>
                ],
                "order":[[1,'desc'],[2,'asc'],[3,'asc']],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });

            <x-data-table.create-script name-i-d="" title="Add Progress"/>

            <x-data-table.submit-script name-i-d="" action-url="progress">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/progress') }}">
                <x-data-table.edit-value-script name="ProgressDate"/>
                <x-data-table.edit-value-script name="job_id"/>
                <x-data-table.edit-value-script name="Plan"/>
                <x-data-table.edit-value-script name="Actual"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="progress"/>

            $('#create_record2').click(function(){
                $('#create_form2')[0].reset();
                $('#formModal2').modal('show');
            });

            $('#create_form2').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var projectid = $('#project_id').attr('value');

                $.ajax({
                    type:'POST',
                    url: "/progress_import_excel/"+projectid,
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
                            $('#data_table').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#create_form')[0].reset();
                            $('#data_table').DataTable().ajax.reload();
                        }
                        $('#form_result2').html(html);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });
        });
    </script>
@endsection
