<x-data-table.data-table-script table-name="_product_stakeholder" ajax-url="{{ url('/QSH_product_stakeholders') }}">
    <x-data-table.column-script column-name="id"/>
    <x-data-table.column-script column-name="ProductName">
        orderable: false
    </x-data-table.column-script>
    <x-data-table.column-script column-name="StakeholderName">
        orderable: false
    </x-data-table.column-script>
    <x-data-table.column-script column-name="action">
        orderable: false
    </x-data-table.column-script>
    <x-slot name="order">[0,'desc']</x-slot>
</x-data-table.data-table-script>

<x-data-table.create-script name-i-d="_product_stakeholder" title="Add New Product-Stakeholder"/>

<x-data-table.submit-script name-i-d="_product_stakeholder" action-url="{{ url('/QSH_product_stakeholders') }}">
    <x-data-table.ajax-reload-script table-id="_product_stakeholder"/>
</x-data-table.submit-script>

<x-data-table.edit-script edit-name="_product_stakeholder" edit-url="{{ url('/QSH_product_stakeholders') }}">
    <x-data-table.edit-value-script name="product_id"/>
    <x-data-table.edit-value-script name="stakeholder_id"/>
</x-data-table.edit-script>

<x-data-table.delete-script delete-name="_product_stakeholder" url="{{ url('/QSH_product_stakeholders') }}"/>

<x-j-s.product/>

<x-j-s.stakeholder/>
