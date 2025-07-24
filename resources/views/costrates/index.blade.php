@extends('layouts.app')

@section('title')
    Cost Rate
@endsection

@section('content')
    @include('layouts.success')
    <div class="table-responsive">
        <table class="table table-strips table-bordered table-sm">
            <thead>
                <th class="text-center">Cost Rate Version</th>
                <th class="text-center">Info</th>
            </thead>
            <tbody>
                @foreach ($costrate as $value)
                    <tr>
                        <td class="text-center">{{$value->DateVersion}}</td>
                        <td>{{$value->Remark}}</td>
                        <td class="text-center">
                            <a class="btn btn-info" href="{{ url('costrates/'.$value->id)}}">Info</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection