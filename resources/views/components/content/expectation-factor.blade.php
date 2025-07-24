<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Expectation-Factor"
    collapse-button="plus" table-id="_expectation_factor">
    <x-slot name="tool">
        <x-button.create-record name-i-d="_expectation_factor"/>
    </x-slot>
    <th>ID</th>
    <th>ความคาดหวัง</th>
    <th>ปัจจัยที่ทำให้เกิดความเสี่ยง</th>
    <th>Action</th>
    <x-slot name="othertable">
        <br>
        <x-content.expectation/>
        <x-content.factor/>
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_expectation_factor" modal-title="Add New Expectation-Factor">
    <x-input.dropdown title="ความคาดหวัง" name-id="expectation_id">
        <option></option>
        @foreach ($expectation as $value)
            <option value="{{$value->id}}">{{$value->Expectation}}</option>
        @endforeach
    </x-input.dropdown>

    <x-input.dropdown title="ปัจจัยที่ทำให้เกิดความเสี่ยง" name-id="factor_id">
        <option></option>
        @foreach ($factor as $value)
            <option value="{{$value->id}}">{{$value->Factor}}</option>
        @endforeach
    </x-input.dropdown>

    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_expectation_factor"/>
