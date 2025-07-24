<x-data-table.data-table-script table-name="_add_role" ajax-url="{{ url('/user_roles') }}">
    <x-data-table.column-script column-name="UserName"/>
    <x-data-table.column-script column-name="email">
        orderable: false
    </x-data-table.column-script>
    <x-data-table.column-script column-name="Role"/>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'asc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_add_role" title="Add New Role"/>

<x-data-table.submit-script name-i-d="_add_role" action-url="{{ url('/user_roles') }}">
    <x-data-table.ajax-reload-script table-id="_add_role"/>
    <x-data-table.ajax-reload-script table-id=""/>
</x-data-table.submit-script>

var user_id;
var role_id;

$(document).on('click', '.delete_add_role', function(){
    user_id = $(this).attr('user_id');
    role_id = $(this).attr('role_id');
    $('.modal-title').text('Confirmation');
    $('#ok_button_add_role').text('Delete');
    $('#confirmModal_add_role').modal('show');
});

$('#ok_button_add_role').click(function(){
    $.ajax({
        url:"{{ url('/user_roles/destroy') }}/" + user_id + "/" + role_id,
        beforeSend:function(){
            $('#ok_button_add_role').text('Deleting...');
        },
        success:function(data)
        {
            setTimeout(function(){
                $('#confirmModal_add_role').modal('hide');
                $('#data_table_add_role').DataTable().ajax.reload();
                <x-data-table.ajax-reload-script table-id=""/>
                alert('Data Deleted');
            }, 2000);
        }
    })
});
