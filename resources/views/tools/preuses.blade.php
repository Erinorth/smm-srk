@extends('adminlte::page')

@section('title','Tool')

@section('content_header')
    <h1 class="m-0 text-dark">Tool</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-card.default-card color="" collapse-card="" title="Report" collapse-button="minus">
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/tool_preuse') }}">
            @csrf
            <div class="row">
                <div class="col">
                    @if ( $errors->any() )
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >Year</label> <!-- -->
                        <div class="col">
                            <input type="text" class="form-control" name="year" id="year" placeholder="ตัวเลขปี ค.ศ. 4 หลัก">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >Month</label> <!-- -->
                        <div class="col">
                            <input type="text" class="form-control" name="month" id="month" placeholder="ตัวเลขเดือน 2 หลัก">
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>Selected Tool</h5>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th>CatagoryName</th>
                                <th>LocalCode</th>
                                <th>Durable/SupplieCode</th>
                                <th>Asset/ToolCode</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>SerialNumber</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tool as $value)
                                <tr>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="selected_tool" id="selected_tool" value="{{ $value->id }}">
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $value->CatagoryName }}</td>
                                    <td>{{ $value->LocalCode }}</td>
                                    <td>{{ $value->DurableSupplieCode }}</td>
                                    <td>{{ $value->AssetToolCode }}</td>
                                    <td>{{ $value->Brand }}</td>
                                    <td>{{ $value->Model }}</td>
                                    <td>{{ $value->SerialNumber }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </x-card.default-card>
@endsection
