@extends('adminlte::page')

@section('title','Activity')

@section('css')

@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Activity</h1>
@stop

@section('content')
    <x-header.item itemId="{{$item->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.item>

    <x-data-table.default-data-table color="" collapse-card="" title="Consumable"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|head_engineering|planner')
                @if ( count($activity) == 0 )
                    <form class="form-horizontal" method="POST" action="{{ URL('/item_activity_standards') }}">
                        @csrf
                        @foreach ($standardactivity as $value)
                            <input type="text" class="form-control" name="Orders[]" value="{{$value->Order}}" hidden>
                            <input type="text" class="form-control" name="ActivityName[]" value="{{$value->ActivityName}}" hidden>
                            <input type="text" class="form-control" name="Detail[]" value="Standard Activity" hidden>
                            <input type="text" class="form-control" name="item_id[]" value="{{$item->id}}" hidden>
                        @endforeach
                        <div class="text-right">
                            <button type="submit" class="btn btn-success btn-sm">Create Standard Activity</button>
                        </div>
                    </form>
                @else
                    <x-button.create-record name-i-d=""/>
                @endif
            @endrole
        </x-slot>
        <th>Order</th>
        <th>Activity</th>
        <th>Detail</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
    <input type="hidden" name="item_id" id="item_id" value="{{$item->id}}" />

    <x-modal.input-form name-i-d="" modal-title="Create Activity">
        <x-input.dropdown title="Order" name-id="Order">
            <option></option>
            @for ($i = 1; $i <= count($activity)+1; $i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </x-input.dropdown>

        <x-input.text title="Activity" name-id="ActivityName"/>

        <x-input.text title="Detail" name-id="Detail"/>

        <x-slot name="othervalue">
            @foreach ($activity as $value)
                <input type="text" class="form-control" name="Orderx[]" value="{{$value->Order}}" hidden>
                <input type="text" class="form-control" name="idx[]" value="{{$value->id}}" hidden>
            @endforeach
            <input type="hidden" name="item_id" id="item_id" value="{{$item->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Order"/>
                <x-data-table.column-script column-name="ActivityName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Detail">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Activity"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/item_activities') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/item_activities') }}">
                <x-data-table.edit-value-script name="Order"/>
                <x-data-table.edit-value-script name="ActivityName"/>
                <x-data-table.edit-value-script name="Detail"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/item_activities') }}"/>
        });
    </script>
@endsection
