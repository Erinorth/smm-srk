<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Product"
    collapse-button="plus" table-id="_product">
    <x-slot name="tool">
        @role('admin|head_engineering')
            <x-button.create-record name-i-d="_product"/>
        @endrole
    </x-slot>
    <th>ID</th>
    <th>Product Code</th>
    <th>Product Name</th>
    <th>Service</th>
    <th>Department</th>
    <th>Action</th>
    <x-slot name="othertable">
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_product" modal-title="Add New Location">
    <x-input.text title="Product Code" name-id="ProductCode"/>

    <x-input.text title="Product Name" name-id="ProductName"/>

    <x-input.text title="Service" name-id="Service"/>

    <x-input.dropdown title="Department" name-id="department_id">
        <option></option>
        @foreach ($department as $value)
            <option value="{{$value->id}}">{{$value->DepartmentName}}</option>
        @endforeach
    </x-input.dropdown>

    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_product"/>
