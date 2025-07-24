<x-data-table.data-table-script table-name="_expectation_factor" ajax-url="{{ url('/QSH_expectation_factors') }}">
    <x-data-table.column-script column-name="id"/>
    <x-data-table.column-script column-name="Expectation"/>
    <x-data-table.column-script column-name="Factor"/>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'desc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_expectation_factor" title="Add New Expectation-Factor"/>

<x-data-table.submit-script name-i-d="_expectation_factor" action-url="{{ url('/QSH_expectation_factors') }}">
    <x-data-table.ajax-reload-script table-id="_expectation_factor"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_expectation_factor" edit-url="{{ url('/QSH_expectation_factors') }}">
    <x-data-table.edit-value-script name="expectation_id"/>
    <x-data-table.edit-value-script name="factor_id"/>
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_expectation_factor" url="{{ url('/QSH_expectation_factors') }}"/>

<x-j-s.expectation/>

<x-j-s.factor/>
