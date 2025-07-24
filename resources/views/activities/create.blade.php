@extends('adminlte::page')

@section('title', '
    Activity
')

@section('css')
    
@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Job</h1>
@stop

@section('content')
    @include('layouts.errors')
    @include('layouts.success')
    <x-header.item itemId="{{$item->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.item>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center">Activity</th>
                    <th class="text-center">Detail</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activity as $value)
                    <tr>
                        <td class="text-center">{{ $value->ActivityName }}</td>
                        <td class="text-center">{{ $value->Detail }}</td>
                        <td class="text-center">
                            <form class="form-horizontal delete_form" method="POST" action="{{ URL('activities/'.$value->id) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-warning btn-sm" href="{{url('activities/'.$value->id.'/edit')}}">Edit</a>
                                <button type="submit" class="btn btn-danger delete_form btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @role('planner|admin')
        <form class="form-horizontal" method="POST" action="{{ URL('activities') }}">
            @csrf
            <div class="form-group">
                <label for="p_m_order_id"><h6>Activity</h6></label>
                <select name="ActivityName" class="form-control">
                    <option></option>
                    <option>Clean</option>
                    <option>Visual Inspection</option>
                    <option>Leakage Check</option>
                    <option>Loosen Check</option>
                    <option>Lubricate</option>
                    <option>NDT</option>
                    <option>Thickness Check</option>
                    <option>Centering Check</option>
                    <option>Leveling Check</option>
                    <option>Deformation Check</option>
                    <option>Dimension Check</option>
                    <option>Gap Check</option>
                    <option>Run Out Check</option>
                    <option>Squeez Check</option>
                    <option>Purify</option>
                    <option>Dismantle/Uninstall</option>
                    <option>Assemble/Install</option>
                    <option>Repair/Replace</option>
                    <option>Adjust/Correct</option>
                    <option>Move</option>
                    <option>Function & Capacity Test</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Detail"><h6>Detail</h6></label>
                <input type="text" class="form-control" name="Detail">
            </div>
            <input type="text" name="item_id" value="{{$item->id}}" hidden>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block btn-sm">Add</button>
            </div>
        </form>
    @endrole

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.delete_form').on('submit',function () {
                if (confirm("Do you want to delete?")) {
                    return true;
                }
                else {
                    return false;
                }
            });
        });
    </script>
@endsection
