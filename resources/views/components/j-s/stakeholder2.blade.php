var table = 2;

$('#data_table_stakeholder2').DataTable({
    processing: true,
    serverSide: true,
    ajax:{
        url: "{{ url('/QSH_stakeholders') }}",
        data: {'table': table}
    },
    columns: [
        <x-data-table.column-script column-name="id"/>
        <x-data-table.column-script column-name="StakeholderName"/>
        <x-data-table.column-script column-name="TypeName"/>
        <x-data-table.column-script column-name="LocationThaiName"/>
        <x-data-table.column-script column-name="action">
            orderable: false
        </x-data-table.column-script>
    ],
    "order":[[0,'desc']],
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true
});

<x-data-table.create-script name-i-d="_stakeholder2" title="Add New Stakeholder"/>

<x-data-table.submit-script name-i-d="_stakeholder2" action-url="{{ url('/QSH_stakeholders') }}">
    <x-data-table.ajax-reload-script table-id="_stakeholder"/>
    <x-data-table.ajax-reload-script table-id="_stakeholder2"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_stakeholder2" edit-url="{{ url('/QSH_stakeholders') }}">
    $('#StakeholderName2').val(data.result.StakeholderName);
    $('#StakeholderName2').trigger('change');
    $('#stakeholder_type_id2').val(data.result.stakeholder_type_id);
    $('#stakeholder_type_id2').trigger('change');
    $('#location_id2').val(data.result.location_id);
    $('#location_id2').trigger('change');
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_stakeholder2" url="{{ url('/QSH_stakeholders') }}"/>
