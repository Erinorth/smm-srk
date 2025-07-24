<x-data-table.data-table-script table-name="_stakeholder_expectation" ajax-url="{{ url('/QSH_stakeholder_expectations') }}">
    <x-data-table.column-script column-name="id"/>
    <x-data-table.column-script column-name="StakeholderName"/>
    <x-data-table.column-script column-name="Expectation"/>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'desc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_stakeholder_expectation" title="Add New Stakeholder-Expectation"/>

<x-data-table.submit-script name-i-d="_stakeholder_expectation" action-url="{{ url('/QSH_stakeholder_expectations') }}">
    <x-data-table.ajax-reload-script table-id="_stakeholder_expectation"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_stakeholder_expectation" edit-url="{{ url('/QSH_stakeholder_expectations') }}">
    <x-data-table.edit-value-script name="expectation_id"/>
    $('#stakeholder_id3').val(data.result.stakeholder_id);
    $('#stakeholder_id3').trigger('change');
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_stakeholder_expectation" url="{{ url('/QSH_stakeholder_expectations') }}"/>

<x-j-s.stakeholder2/>

<x-j-s.expectation/>
