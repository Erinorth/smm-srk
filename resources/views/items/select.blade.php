@extends('adminlte::page')

@section('title', 'Item')

@section('content_header')
    <h1 class="m-0 text-dark">Item</h1>
@stop

@section('content')
    <x-header.machine-set-h machineSetId="{{$machineset->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.machine-set-h>

    <x-data-table.default-data-table color="" collapse-card="" title="Item"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|head_engineering|planner')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>Item ID</th>
        <th>Product Name</th>
        <th>System Name</th>
        <th>Equipment Name</th>
        <th>SpecificName</th>
        <th>Scope of Work</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="System"
        collapse-button="plus" table-id="_system">
        <x-slot name="tool">
            @role('admin|head_engineering')
                <x-button.create-record name-i-d="_system"/>
            @endrole
        </x-slot>
        <th>ID</th>
        <th>System Name</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Equipment"
        collapse-button="plus" table-id="_equipment">
        <x-slot name="tool">
            @role('admin|head_engineering')
                <x-button.create-record name-i-d="_equipment"/>
            @endrole
        </x-slot>
        <th>ID</th>
        <th>Equipment Name</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Item Set"
        collapse-button="plus" table-id="_item_set">
        <x-slot name="tool">
            @role('admin|head_engineering')
                <x-button.create-record name-i-d="_item_set"/>
            @endrole
        </x-slot>
        <th>Item Set ID</th>
        <th>Product Name</th>
        <th>System Name</th>
        <th>Equipment Name</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Scope"
        collapse-button="plus" table-id="_scope">
        <x-slot name="tool">
            @role('admin|head_engineering')
                <x-button.create-record name-i-d="_scope"/>
            @endrole
        </x-slot>
        <th>ID</th>
        <th>Scope Name</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Item">
        <x-input.dropdown title="Item Set" name-id="item_set_id">
            <option></option>
            @foreach ($itemset as $value)
                <option value="{{$value->id}}">{{$value->ProductName}} / {{$value->SystemName}} / {{$value->EquipmentName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.text title="Specific Name" name-id="SpecificName"/>

        <x-input.dropdown title="Scope" name-id="scope_id">
            <option></option>
            @foreach ($scope as $value)
                <option value="{{$value->id}}">{{$value->ScopeName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-slot name="othervalue">
            <input type="hidden" name="machine_set_id" id="machine_set_id" value="{{ $machineset->id }}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="_system" modal-title="Add New System">
        <x-input.text title="System Name" name-id="SystemName"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="_equipment" modal-title="Add New Location">
        <x-input.text title="Equipment Name" name-id="EquipmentName"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="_item_set" modal-title="Create Consumable">
        <x-input.dropdown title="Product" name-id="product_id">
            <option></option>
            @foreach ($product as $value)
                <option value="{{$value->id}}">{{$value->ProductName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="System" name-id="system_id">
            <option></option>
            @foreach ($system as $value)
                <option value="{{$value->id}}">{{$value->SystemName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="Equipment" name-id="equipment_id">
            <option></option>
            @foreach ($equipment as $value)
                <option value="{{$value->id}}">{{$value->EquipmentName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="_scope" modal-title="Add New Location">
        <x-input.text title="Scope Name" name-id="ScopeName"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-modal.confirm-delete delete-name="_system"/>

    <x-modal.confirm-delete delete-name="_equipment"/>

    <x-modal.confirm-delete delete-name="_item_set"/>

    <x-modal.confirm-delete delete-name="_scope"/>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="ProductName"/>
                <x-data-table.column-script column-name="SystemName"/>
                <x-data-table.column-script column-name="EquipmentName"/>
                <x-data-table.column-script column-name="SpecificName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ScopeName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_system" ajax-url="{{ url('/systems') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="SystemName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_equipment" ajax-url="{{ url('/equipment') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="EquipmentName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_item_set" ajax-url="{{ url('/item_sets') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="ProductName"/>
                <x-data-table.column-script column-name="SystemName"/>
                <x-data-table.column-script column-name="EquipmentName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_scope" ajax-url="{{ url('/scopes') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="ScopeName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add New Item"/>

            <x-data-table.create-script name-i-d="_system" title="Add New System"/>

            <x-data-table.create-script name-i-d="_equipment" title="Add New Equipment"/>

            <x-data-table.create-script name-i-d="_item_set" title="Add New Item Set"/>

            <x-data-table.create-script name-i-d="_scope" title="Add New Scope"/>

            <x-data-table.submit-script name-i-d="" action-url="items">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.submit-script name-i-d="_system" action-url="systems">
                <x-data-table.ajax-reload-script table-id="_system"/>
            </x-data-table.submit-script>

            <x-data-table.submit-script name-i-d="_equipment" action-url="equipment">
                <x-data-table.ajax-reload-script table-id="_equipment"/>
            </x-data-table.submit-script>

            <x-data-table.submit-script name-i-d="_item_set" action-url="item_sets">
                <x-data-table.ajax-reload-script table-id="_item_set"/>
            </x-data-table.submit-script>

            <x-data-table.submit-script name-i-d="_scope" action-url="scopes">
                <x-data-table.ajax-reload-script table-id="_scope"/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="items">
                <x-data-table.edit-value-script name="item_set_id"/>
                <x-data-table.edit-value-script name="scope_id"/>
                <x-data-table.edit-value-script name="SpecificName"/>
            </x-data-table.edit-script>

            <x-data-table.edit-script edit-name="_system"  edit-url="systems">
                <x-data-table.edit-value-script name="SystemName"/>
            </x-data-table.edit-script>

            <x-data-table.edit-script edit-name="_equipment"  edit-url="equipment">
                <x-data-table.edit-value-script name="EquipmentName"/>
            </x-data-table.edit-script>

            <x-data-table.edit-script edit-name="_item_set"  edit-url="item_sets">
                <x-data-table.edit-value-script name="product_id"/>
                <x-data-table.edit-value-script name="system_id"/>
                <x-data-table.edit-value-script name="equipment_id"/>
            </x-data-table.edit-script>

            <x-data-table.edit-script edit-name="_scope"  edit-url="scopes">
                <x-data-table.edit-value-script name="ScopeName"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="items"/>

            <x-data-table.delete-script delete-name="_system" url="systems"/>

            <x-data-table.delete-script delete-name="_equipment" url="equipment"/>

            <x-data-table.delete-script delete-name="_item_set" url="item_sets"/>

            <x-data-table.delete-script delete-name="_scope" url="scopes"/>
        });
    </script>
@endsection
