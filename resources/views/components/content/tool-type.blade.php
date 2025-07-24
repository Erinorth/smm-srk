<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Tool Type"
    collapse-button="plus" table-id="_tooltype">
    <x-slot name="tool">
        @role('admin|store_keeper')
            <x-button.create-record name-i-d="_tooltype"/>
        @endrole
    </x-slot>
    <th>Activity Type</th>
    <th>Main Type</th>
    <th>Sub Type</th>
    <th>Tool Name</th>
    <th>Remark</th>
    <th>Action</th>
    <x-slot name="othertable">
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_tooltype" modal-title="Create Tool Catagory">
    <x-input.text title="Activity Type" name-id="ActivityType"/>

    <x-input.text title="Main Type" name-id="MainType"/>

    <x-input.text title="Sub Type" name-id="SubType"/>

    <x-input.text title="Tool Name" name-id="ToolName"/>

    <x-input.text title="Remark" name-id="Remark"/>

    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_tooltype"/>
