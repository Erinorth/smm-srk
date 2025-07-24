<x-data-table.data-table-script table-name="_factor" ajax-url="{{ url('/QSH_factors') }}">
    <x-data-table.column-script column-name="id"/>
    <x-data-table.column-script column-name="Factor"/>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'desc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_factor" title="Add New Factor"/>

<x-data-table.submit-script name-i-d="_factor" action-url="{{ url('/QSH_factors') }}">
    <x-data-table.ajax-reload-script table-id="_factor"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_factor" edit-url="{{ url('/QSH_factors') }}">
    <x-data-table.edit-value-script name="Factor"/>
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_factor" url="{{ url('/QSH_factors') }}"/>
