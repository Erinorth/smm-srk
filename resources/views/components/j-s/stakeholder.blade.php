<x-data-table.data-table-script table-name="_stakeholder" ajax-url="{{ url('/QSH_stakeholders') }}">
    <x-data-table.column-script column-name="id"/>
    <x-data-table.column-script column-name="StakeholderName"/>
    <x-data-table.column-script column-name="TypeName"/>
    <x-data-table.column-script column-name="LocationThaiName"/>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'desc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_stakeholder" title="Add New Stakeholder"/>

<x-data-table.submit-script name-i-d="_stakeholder" action-url="{{ url('/QSH_stakeholders') }}">
    <x-data-table.ajax-reload-script table-id="_stakeholder"/>
    <x-data-table.ajax-reload-script table-id="_stakeholder2"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_stakeholder" edit-url="{{ url('/QSH_stakeholders') }}">
    <x-data-table.edit-value-script name="StakeholderName"/>
    <x-data-table.edit-value-script name="stakeholder_type_id"/>
    <x-data-table.edit-value-script name="location_id"/>
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_stakeholder" url="{{ url('/QSH_stakeholders') }}"/>
