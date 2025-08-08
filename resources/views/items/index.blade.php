@extends('adminlte::page')

@section('title', 'Item')

@section('content_header')
    <h1 class="m-0 text-dark">Item</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Location / Machine"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Location Name</th>
        <th>Machine Name</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Location"
        collapse-button="plus" table-id="_location">
        <x-slot name="tool">
            @role('admin|head_engineering|planner')
                <x-button.create-record name-i-d="_location"/>
            @endrole
        </x-slot>
        <th>ID</th>
        <th>Location KKS</th>
        <th>English Name</th>
        <th>Thai Name</th>
        <th>Allowance</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Machine"
        collapse-button="plus" table-id="_machine">
        <x-slot name="tool">
            @role('admin|head_engineering|planner')
                <x-button.create-record name-i-d="_machine"/>
            @endrole
        </x-slot>
        <th>ID</th>
        <th>Machine Name</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Machine Set"
        collapse-button="plus" table-id="_machine_set">
        <x-slot name="tool">
            @role('admin|head_engineering|planner')
                <x-button.create-record name-i-d="_machine_set"/>
            @endrole
        </x-slot>
        <th>Machine Set ID</th>
        <th>Location Name</th>
        <th>Location Thai Name</th>
        <th>Machine Name</th>
        <th>Remark</th>
        <th>Serial Number</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="_location" modal-title="Add New Location">
        <x-adminlte-input name="LocationKKS" label="Location KKS" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="LocationName" label="English Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="LocationThaiName" label="Thai Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-select2 name="Allowance" label="Allowance" data-placeholder="Select an option...">
            <option/>
            <option>ไม่ได้</option>
            <option>ปกติ</option>
            <option>เหมาจ่าย</option>
            <option>ต่างประเทศ</option>
        </x-adminlte-select2>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="_machine" modal-title="Add New Machine">
        <x-adminlte-input name="MachineName" label="Machine Name" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="_machine_set" modal-title="Create Machine Set">
        <x-adminlte-select2 name="location_id" label="Location" data-placeholder="Select an option...">
            <option/>
            @foreach ($location as $value)
                <option value="{{$value->id}}">{{$value->LocationName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="machine_id" label="Machine" data-placeholder="Select an option...">
            <option/>
            @foreach ($machine as $value)
                <option value="{{$value->id}}">{{$value->MachineName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="SerialNumber" label="Serial Number" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name="_location"/>

    <x-modal.confirm-delete delete-name="_machine"/>

    <x-modal.confirm-delete delete-name="_machine_set"/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="LocationName"/>
                <x-data-table.column-script column-name="MachineName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc'],[1,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_location" ajax-url="{{ url('/locations') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="LocationKKS"/>
                <x-data-table.column-script column-name="LocationName"/>
                <x-data-table.column-script column-name="LocationThaiName"/>
                <x-data-table.column-script column-name="Allowance"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_machine" ajax-url="{{ url('/machines') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="MachineName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_machine_set" ajax-url="{{ url('/machine_sets') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="LocationName"/>
                <x-data-table.column-script column-name="LocationThaiName"/>
                <x-data-table.column-script column-name="MachineName"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="_location" title="Add New Location"/>

            <x-data-table.create-script name-i-d="_machine" title="Add New Machine"/>

            <x-data-table.create-script name-i-d="_machine_set" title="Add New Machine Set"/>

            <x-data-table.submit-script name-i-d="_location" action-url="locations">
                <x-data-table.ajax-reload-script table-id="_location"/>
            </x-data-table.submit-script>

            <x-data-table.submit-script name-i-d="_machine" action-url="{{ url('/machines') }}">
                <x-data-table.ajax-reload-script table-id="_machine"/>
            </x-data-table.submit-script>

            <x-data-table.submit-script name-i-d="_machine_set" action-url="{{ url('/machine_sets') }}">
                <x-data-table.ajax-reload-script table-id="_machine_set"/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name="_location"  edit-url="{{ url('/locations') }}">
                <x-data-table.edit-value-script name="LocationKKS"/>
                <x-data-table.edit-value-script name="LocationName"/>
                <x-data-table.edit-value-script name="LocationThaiName"/>
                <x-data-table.edit-value-script name="Allowance"/>
            </x-data-table.edit-script>

            <x-data-table.edit-script edit-name="_machine"  edit-url="{{ url('/machines') }}">
                <x-data-table.edit-value-script name="MachineName"/>
            </x-data-table.edit-script>

            <x-data-table.edit-script edit-name="_machine_set"  edit-url="{{ url('/machine_sets') }}">
                <x-data-table.edit-value-script name="location_id"/>
                <x-data-table.edit-value-script name="machine_id"/>
                <x-data-table.edit-value-script name="Remark"/>
                <x-data-table.edit-value-script name="SerialNumber"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="_location" url="{{ url('/locations') }}"/>

            <x-data-table.delete-script delete-name="_machine" url="{{ url('/machines') }}"/>

            <x-data-table.delete-script delete-name="_machine_set" url="{{ url('/machine_sets') }}"/>
        });
    </script>
@endsection
