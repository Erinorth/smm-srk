<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Product-Stakeholder"
    collapse-button="plus" table-id="_product_stakeholder">
    <x-slot name="tool">
        <x-button.create-record name-i-d="_product_stakeholder"/>
    </x-slot>
    <th>ID</th>
    <th>Product Name</th>
    <th>ผู้มีส่วนได้เสีย</th>
    <th>Action</th>
    <x-slot name="othertable">
        <br>
        <x-content.product/>
        <x-content.stakeholder/>
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_product_stakeholder" modal-title="Add New Product-Stakeholder">
    <x-input.dropdown title="Product Name" name-id="product_id">
        <option></option>
        @foreach ($product as $value)
            <option value="{{$value->id}}">{{$value->ProductName}}</option>
        @endforeach
    </x-input.dropdown>

    <x-input.dropdown title="ผู้มีส่วนได้เสีย" name-id="stakeholder_id">
        <option></option>
        @foreach ($stakeholder as $value)
            <option value="{{$value->id}}">{{$value->StakeholderName}}</option>
        @endforeach
    </x-input.dropdown>

    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_product_stakeholder"/>
