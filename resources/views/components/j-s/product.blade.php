<x-data-table.data-table-script table-name="_product" ajax-url="{{ url('/products') }}">
    <x-data-table.column-script column-name="id"/>
    <x-data-table.column-script column-name="ProductCode"/>
    <x-data-table.column-script column-name="ProductName"/>
    <x-data-table.column-script column-name="Service"/>
    <x-data-table.column-script column-name="DepartmentName"/>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'desc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_product" title="Add New Product"/>

<x-data-table.submit-script name-i-d="_product" action-url="{{ url('/products') }}">
    <x-data-table.ajax-reload-script table-id="_product"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_product" edit-url="{{ url('/products') }}">
    <x-data-table.edit-value-script name="ProductCode"/>
    <x-data-table.edit-value-script name="ProductName"/>
    <x-data-table.edit-value-script name="Service"/>
    <x-data-table.edit-value-script name="department_id"/>
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_product" url="{{ url('/products') }}"/>
