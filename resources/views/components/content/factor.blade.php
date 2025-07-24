<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Factor"
    collapse-button="plus" table-id="_factor">
    <x-slot name="tool">
        <x-button.create-record name-i-d="_factor"/>
    </x-slot>
    <th>ID</th>
    <th>ปัจจัยที่ทำให้เกิดความเสี่ยง</th>
    <th>Action</th>
    <x-slot name="othertable">
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_factor" modal-title="Add New Factor">
    <x-input.text title="ปัจจัยที่ทำให้เกิดความเสี่ยง" name-id="Factor"/>

    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_factor"/>
