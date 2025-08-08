@extends('adminlte::page')

@section('title','WFH/WFA Assignment')

@section('content_header')
    <h1 class="m-0 text-dark">Assignment</h1>
@stop

@section('content')
    {{-- <x-header.week-detail weekId="{{$week->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.week-detail> --}}

    {{-- <x-card.default-card color="" collapse-card="collapsed-card" title="Report" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/WFHWFA_plan') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report as $value)
                                <tr>
                                    <td class="text-center"><input type="radio" class="form-check-input" name="WorkID" value="{{ $value->WorkID }}"/></td>
                                    <td class="text-center">{{ $value->WorkID }}</td>
                                    <td>{{ $value->ThaiName }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-1 text-center">
                    <input type="hidden" name="week_id" id="week_id" value="{{$week->id}}"/>
                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                </div>
            </div>
        </form>
    </x-card.default-card> --}}

    <x-data-table.default-data-table color="" collapse-card="" title="Assignment"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @php
                $n = date('Y-m-d', strtotime( $endofweek->EndofWeek . "+1 days"));
            @endphp
            @if ( $n > NOW() )
                <x-button.create-record name-i-d=""/>
            @else
                @role('admin|head_operation|head_engineering')
                    <x-button.create-record name-i-d=""/>
                @endrole
            @endif
        </x-slot>
        <th>ผู้รับมอบหมายงาน</th>
        <th>ผู้มอบหมายงาน</th>
        <th>จำนวนวันที่ไม่ได้ออก Site/ไม่ได้ลา</th>
        <th>จำนวนคะแนนเต็ม</th>
        <th>จำนวนคะแนนที่ได้</th>
        <th>คิดเป็นระดับคะแนน</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="WFH/WFA Assignment">
        <x-input.dropdown title="ผู้รับมอบหมายงาน" name-id="Assignee">
            <option></option>
            @foreach ($employee as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.text title="จำนวนวันที่ไม่ได้ออก Site/ไม่ได้ลา" name-id="Day"/>

        <x-input.text title="จำนวนคะแนนเต็ม" name-id="Point"/>

        @role('admin|head_operation|head_engineering')
            <x-input.text title="KPI" name-id="KPI"/>
        @endrole

        <x-slot name="othervalue">
            <input type="hidden" name="Date" id="Date" value="{{$date->Date}}"/>
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Assignor"/>
                <x-data-table.column-script column-name="Assignee"/>
                <x-data-table.column-script column-name="Day"/>
                <x-data-table.column-script column-name="Point"/>
                <x-data-table.column-script column-name="SumOfAcceptPoint"/>
                <x-data-table.column-script column-name="KPI"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Assingment"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/WFH_WFA_assignments') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/WFH_WFA_assignments') }}">
                <x-data-table.edit-value-script name="Assignee"/>
                <x-data-table.edit-value-script name="Assignor"/>
                <x-data-table.edit-value-script name="Day"/>
                <x-data-table.edit-value-script name="Point"/>
                <x-data-table.edit-value-script name="KPI"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/WFH_WFA_assignments') }}"/>
        });
    </script>
@endsection
