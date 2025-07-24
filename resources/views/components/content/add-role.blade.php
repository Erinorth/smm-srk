<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Add Role"
    collapse-button="plus" table-id="_add_role">
    <x-slot name="tool">
        <x-button.create-record name-i-d="_add_role"/>
    </x-slot>
    <th>User Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Action</th>
    <x-slot name="othertable">
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_add_role" modal-title="Create Consumable">
    <x-input.dropdown title="User Name" name-id="model_id">
        <option></option>
        @foreach ($user as $value)
            <option value="{{$value->id}}">{{$value->name}}</option>
        @endforeach
    </x-input.dropdown>

    <x-input.dropdown title="Role" name-id="role_id">
        <option></option>
        @foreach ($role as $value)
            <option value="{{$value->id}}">{{$value->name}}</option>
        @endforeach
    </x-input.dropdown>

    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_add_role"/>
