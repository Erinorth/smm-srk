<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Expectation"
    collapse-button="plus" table-id="_expectation">
    <x-slot name="tool">
        <x-button.create-record name-i-d="_expectation"/>
    </x-slot>
    <th>ID</th>
    <th>ความคาดหวัง</th>
    <th>รายละเอียดเพิ่มเติม</th>
    <th>Action</th>
    <x-slot name="othertable">
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_expectation" modal-title="Add Expectation">
    <x-input.text title="ความคาดหวัง" name-id="Expectation"/>

    <x-input.text-area title="รายละเอียดเพิ่มเติม" name-id="MoreDetail"/>

    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_expectation"/>
