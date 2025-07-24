<x-data-table.data-table-script table-name="_department" ajax-url="{{ url('/departments') }}">
    <x-data-table.column-script column-name="id"/>
    <x-data-table.column-script column-name="Code"/>
    <x-data-table.column-script column-name="DepartmentName"/>
    <x-data-table.column-script column-name="Section"/>
    <x-data-table.column-script column-name="Department"/>
    <x-data-table.column-script column-name="Division"/>
    <x-data-table.column-script column-name="Business"/>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'desc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_department" title="Department"/>

<x-data-table.submit-script name-i-d="_department" action-url="{{ url('/departments') }}">
    <x-data-table.ajax-reload-script table-id="_department"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_department" edit-url="{{ url('/departments') }}">
    <x-data-table.edit-value-script name="Code"/>
    <x-data-table.edit-value-script name="DepartmentName"/>
    <x-data-table.edit-value-script name="Section"/>
    <x-data-table.edit-value-script name="Department"/>
    <x-data-table.edit-value-script name="Division"/>
    <x-data-table.edit-value-script name="Business"/>
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_department" url="{{ url('/departments') }}"/>
