<x-data-table.data-table-script table-name="_planot" ajax-url="{{ url('/plan_ot') }}">
    <x-data-table.column-script column-name="PlanDate"/>
    <x-data-table.column-script column-name="ThaiName"/>
    <x-data-table.column-script column-name="PlanHour"/>
    <x-data-table.column-script column-name="Remark">
        orderable: false
    </x-data-table.column-script>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'desc'],[1,'asc'],[2,'asc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_planot" title="Add Plan Overtime"/>

<x-data-table.submit-script name-i-d="_planot" action-url="{{ url('/plan_ot') }}">
    <x-data-table.ajax-reload-script table-id="_planot"/>
    <x-data-table.ajax-reload-script table-id="_otframe"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_planot" edit-url="{{ url('/plan_ot') }}">
    <x-data-table.edit-value-script name="PlanDate"/>
    <x-data-table.edit-value-script name="employee_id"/>
    <x-data-table.edit-value-script name="PlanHour"/>
    <x-data-table.edit-value-script name="Remark"/>
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_planot" url="{{ url('/plan_ot') }}"/>

$('#create_record_planot_import').click(function(){
    $('#create_form_planot_import')[0].reset();
    $('#formModal_planot_import').modal('show');
});

$('#create_form_planot_import').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var projectid = $('#project_id').attr('value');

    $.ajax({
        type:'POST',
        url: "{{ url('/plan_ot_excel') }}/" + projectid,
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
                $('#create_form_planot_import')[0].reset();
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
                $('#create_form_planot_import')[0].reset();
                $('#data_table_planot').DataTable().ajax.reload();
            }
            if(data.success)
            {
                html = '<div class="alert alert-success">' + data.success + '</div>';
                $('#create_form_planot_import')[0].reset();
                $('#data_table_planot').DataTable().ajax.reload();
                $('#data_table_otframe').DataTable().ajax.reload();
            }
            $('#form_result_planot_import').html(html);
        },
        error: function(data){
            console.log('error');
        }
    });
});
