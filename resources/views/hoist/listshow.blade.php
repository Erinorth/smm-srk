@extends('adminlte::page')

@section('title','Hoist')

@section('content_header')
    <h1 class="m-0 text-dark">Hoist</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hoist</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-sm">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                            <h6>Customer :
                                @if ($toolcatagory)
                                    กฟนม-ธ.</h6>
                                @else
                                    {{$hoist->Customer}}</h6>
                                @endif
                            <h6>Brand : {{$hoist->Brand}}</h6>
                            <h6>Capacity :
                                @if ($toolcatagory)
                                    {{$toolcatagory->RangeCapacity}}</h6>
                                @else
                                    {{$hoist->Capacity}} Ton(s)</h6>
                                @endif
                            <h6>Model : {{$hoist->Model}}</h6>
                            <h6>SerialNumber : {{$hoist->SerialNumber}}</h6>
                            <h6>LocalCode : {{$hoist->LocalCode}}</h6>
                            <h6>DurableSupplieCode : {{$hoist->DurableSupplieCode}}</h6>
                            <h6>AssetToolCode : {{$hoist->AssetToolCode}}</h6>
                            <h6>RegisterDate : {{$hoist->RegisterDate}}</h6>
                            <h6>StandardP : {{$hoist->StandardP}}</h6>
                            <h6>StandardD : {{$hoist->StandardD}}</h6>
                            <h6>Standard10Link : {{$hoist->Standard10Link}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-data-table.default-data-table color="" collapse-card="" title="Hoist"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Test Date</th>
        <th>Top Hook Assembly</th>
        <th>Bottom Hook Assembly</th>
        <th>Safety Latch</th>
        <th>Chain Condition</th>
        <th>Chain Pin</th>
        <th>Chain Hoist Test</th>
        <th>Remark</th>
        <th>Standard Dimension (P) mm.</th>
        <th>Chain Dimension (D) mm.</th>
        <th>10 Links Dimension for Load Chain (mm.)</th>
        <th>Acceptable</th>
        <th>A bend or Twist of the Hook</th>
        <th>Top Opening Throat</th>
        <th>Bottom Opening Throat</th>
        <th>Result</th>
        <th>Note</th>
        <th>Attachment</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน hoist testing.pdf').'">การใช้งาน Hoist Testing</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="TestDate"/>
                <x-data-table.column-script column-name="TopHook"/>
                <x-data-table.column-script column-name="BottomHook"/>
                <x-data-table.column-script column-name="SafetyLatch"/>
                <x-data-table.column-script column-name="Condition"/>
                <x-data-table.column-script column-name="Pin"/>
                <x-data-table.column-script column-name="Testing"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="LoadP"/>
                <x-data-table.column-script column-name="LoadD"/>
                <x-data-table.column-script column-name="Load10Link"/>
                <x-data-table.column-script column-name="LoadTesting"/>
                <x-data-table.column-script column-name="Twist"/>
                <x-data-table.column-script column-name="HookTop"/>
                <x-data-table.column-script column-name="HookBottom"/>
                <x-data-table.column-script column-name="Result"/>
                <x-data-table.column-script column-name="Note"/>
                <x-data-table.column-script column-name="Attachment">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
