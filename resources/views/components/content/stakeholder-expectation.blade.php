<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Stakeholder-Expectation"
    collapse-button="plus" table-id="_stakeholder_expectation">
    <x-slot name="tool">
        <x-button.create-record name-i-d="_stakeholder_expectation"/>
    </x-slot>
    <th>ID</th>
    <th>ผู้มีส่วนได้เสีย</th>
    <th>ความคาดหวัง</th>
    <th>Action</th>
    <x-slot name="othertable">
        <br>
        <x-content.stakeholder2/>
        <x-content.expectation/>
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_stakeholder_expectation" modal-title="Add New Stakeholder-Expectation">
    <x-input.dropdown title="ผู้มีส่วนได้เสีย" name-id="stakeholder_id3">
        <option></option>
        @foreach ($stakeholder as $value)
            <option value="{{$value->id}}">{{$value->StakeholderName}}</option>
        @endforeach
    </x-input.dropdown>

    <x-input.dropdown title="ความคาดหวัง" name-id="expectation_id">
        <option></option>
        @foreach ($expectation as $value)
            <option value="{{$value->id}}">{{$value->Expectation}}</option>
        @endforeach
    </x-input.dropdown>

    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_stakeholder_expectation"/>
