<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Stakeholder"
    collapse-button="plus" table-id="_stakeholder2">
    <x-slot name="tool">
        <x-button.create-record name-i-d="_stakeholder2"/>
    </x-slot>
    <th>ID</th>
    <th>ผู้มีส่วนได้เสีย</th>
    <th>Type Name</th>
    <th>Location Name</th>
    <th>Action</th>
    <x-slot name="othertable">
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_stakeholder2" modal-title="Add New Stakeholder">
    <x-input.text title="ผู้มีส่วนได้เสีย" name-id="StakeholderName2"/>

    <x-input.dropdown title="Type Name" name-id="stakeholder_type_id2">
        <option></option>
        @foreach ($type as $value)
            <option value="{{ $value->id }}">{{ $value->TypeName }}</option>
        @endforeach
    </x-input.dropdown>

    <x-input.dropdown title="Location Name" name-id="location_id2">
        <option></option>
        @foreach ($location as $value)
            <option value="{{ $value->id }}">{{ $value->LocationThaiName }}</option>
        @endforeach
    </x-input.dropdown>

    <x-slot name="othervalue">
        <input type="hidden" name="table_number" id="table_number" value="2" />
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_stakeholder2"/>
