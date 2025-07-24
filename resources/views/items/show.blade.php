@extends('adminlte::page')

@section('title', 'Item')

@section('content_header')
    <h1 class="m-0 text-dark">Item</h1>
@stop

@section('content')
    <x-header.item itemId="{{$item->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.item>

    <x-card.default-card color="" collapse-card="" title="Activity" collapse-button="minus">
        <x-slot name="tool"></x-slot>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center">Activity</th>
                    <th class="text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activity as $value)
                    <tr>
                        <td class="text-center">{{ $value->ActivityName }}</td>
                        <td class="text-center">{{ $value->Detail }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="text-center">
            @role('supervisor|foreman|head_operation|admin')
                <a class="btn btn-secondary btn-sm" href="{{url('item_consumables/'.$item->id)}}">Consumable</a>
                <a class="btn btn-secondary btn-sm" href="{{url('item_hazards/'.$item->id)}}">Hazard</a>
                <a class="btn btn-secondary btn-sm" href="{{url('safetytags/'.$item->id)}}">Safety Tag</a>
                <a class="btn btn-secondary btn-sm" href="{{url('specialtools/'.$item->id)}}">Special Tool</a>
                <a class="btn btn-secondary btn-sm" href="{{url('item_tool_catagories/'.$item->id)}}">Tool</a>
                <a class="btn btn-secondary btn-sm" href="{{url('workprocedures/'.$item->id)}}">Work Procedure</a>
            @endrole
            @role('site_engineer|admin')
                <a class="btn btn-secondary btn-sm" href="{{url('item_activities/'.$item->id)}}">Activity</a>
                <a class="btn btn-secondary btn-sm" href="{{url('documents/'.$item->id)}}">Document</a>
                <a class="btn btn-secondary btn-sm" href="{{url('qualitycontrols/'.$item->id)}}">Quality Control</a>
                <a class="btn btn-secondary btn-sm" href="{{url('item_spareparts/'.$item->id)}}">Spare Part</a>
            @endrole
        </div>
    </x-card.default-card>
@endsection
