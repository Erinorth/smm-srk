<x-data-table.data-table-script table-name="_link_employee" ajax-url="{{ url('/user_employees') }}">
    <x-data-table.column-script column-name="WorkID"/>
    <x-data-table.column-script column-name="ThaiName"/>
    <x-data-table.column-script column-name="UserName"/>
    <x-data-table.column-script column-name="email"/>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'asc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.submit-script name-i-d="_link_employee" action-url="{{ url('/user_employees') }}">
    <x-data-table.ajax-reload-script table-id="_link_employee"/>
    <x-data-table.ajax-reload-script table-id=""/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_link_employee" edit-url="{{ url('/user_employees') }}">
    <x-data-table.edit-value-script name="user_id"/>
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_link_employee" url="{{ url('/user_employees') }}"/>
