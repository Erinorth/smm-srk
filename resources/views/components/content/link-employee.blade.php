<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Link Employee"
    collapse-button="plus" table-id="_link_employee">
    <x-slot name="tool">
    </x-slot>
    <th>Work ID</th>
    <th>Name</th>
    <th>User Name</th>
    <th>Email</th>
    <th>Action</th>
    <x-slot name="othertable">
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_link_employee" modal-title="Add New Employee">
    <x-input.dropdown title="User Name" name-id="user_id">
        <option></option>
        @foreach ($user as $value)
            <option value="{{$value->id}}">{{$value->name}}</option>
        @endforeach
    </x-input.dropdown>

    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_link_employee"/>
