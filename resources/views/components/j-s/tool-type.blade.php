<x-data-table.data-table-script table-name="_tooltype" ajax-url="{{ url('/tool_types') }}">
    <x-data-table.column-script column-name="ActivityType"/>
    <x-data-table.column-script column-name="MainType"/>
    <x-data-table.column-script column-name="SubType"/>
    <x-data-table.column-script column-name="ToolName"/>
    <x-data-table.column-script column-name="Remark">
        orderable: false
    </x-data-table.column-script>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'asc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_tooltype" title="Tool Type"/>

<x-data-table.submit-script name-i-d="_tooltype" action-url="{{ url('/tool_types') }}">
    <x-data-table.ajax-reload-script table-id="_tooltype"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_tooltype" edit-url="{{ url('/tool_types') }}">
    <x-data-table.edit-value-script name="ActivityType"/>
    <x-data-table.edit-value-script name="MainType"/>
    <x-data-table.edit-value-script name="SubType"/>
    <x-data-table.edit-value-script name="ToolName"/>
    <x-data-table.edit-value-script name="Remark"/>
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_tooltype" url="{{ url('/tool_types') }}"/>
