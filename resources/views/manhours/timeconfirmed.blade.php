@extends('adminlte::page')

@section('title','Man Hour')

@section('content')
    <x-card.default-card color="" collapse-card="" title="Report" collapse-button="minus">
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/time_confirmed_report') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >From</label> <!-- -->
                        <div class="col">
                            <input type="date" class="form-control" name="startDate" id="startDate">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >To</label> <!-- -->
                        <div class="col">
                            <input type="date" class="form-control" name="endDate" id="endDate">
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Select All <input type="checkbox" id="checkAll"/></th>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee as $value)
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="checkBoxClass" name="WorkID[]" value="{{ $value->WorkID }}"/></td>
                                    <td class="text-center">{{ $value->WorkID }}</td>
                                    <td>{{ $value->ThaiName }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </x-card.default-card>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            $(function(e){
                $('#checkAll').click(function(){
                    $('.checkBoxClass').prop('checked',$(this).prop('checked'));
                });
            });
        });
    </script>
@endsection
