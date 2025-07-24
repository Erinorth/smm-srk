<x-data-table.data-table-script table-name="_expectation" ajax-url="{{ url('/QSH_expectations') }}">
    <x-data-table.column-script column-name="id"/>
    <x-data-table.column-script column-name="Expectation"/>
    <x-data-table.column-script column-name="MoreDetail">
        orderable: false
    </x-data-table.column-script>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'desc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_expectation" title="Add New Expectation"/>

<x-data-table.submit-script name-i-d="_expectation" action-url="{{ url('/QSH_expectations') }}">
    <x-data-table.ajax-reload-script table-id="_expectation"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_expectation" edit-url="{{ url('/QSH_expectations') }}">
    <x-data-table.edit-value-script name="Expectation"/>
    <x-data-table.edit-value-script name="MoreDetail"/>
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_expectation" url="{{ url('/QSH_expectations') }}"/>
