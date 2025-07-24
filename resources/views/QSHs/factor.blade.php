@extends('adminlte::page')

@section('title','Quality Safety and Health')

@section('content_header')
    <h1 class="m-0 text-dark">Quality Safety and Health</h1>
@stop

@section('content')
    <x-header.department-header departmentId="{{$departmentid}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Department</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.department-header>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Menu" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <div class="container">
            <div class="row align-items-center justify-content-around">
                <div class="col-xl-2 text-center">
                    <form class="form-horizontal" method="POST" action="{{ url('/update_product_expectation_factor') }}">
                        @csrf
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-success btn-block btn-sm">Create/Update</button>
                            </div>
                        </div>
                        <input type="hidden" name="department_id_update" id="department_id_update" value="{{$departmentid}}" />
                    </form>
                </div>
                <div class="col-xl-2 text-center">
                    <a href="{{ url('factor/'.$departmentid) }}" class="btnprn btn btn-info btn-block btn-sm">Print</a>
                </div>
                <div class="col-xl-8 text-center">
                    <a class="btnprn btn btn-info btn-block btn-sm" href="{{url('QSH_assesments/'.$departmentid)}}">Risk Assessment</a>
                </div>
            </div>
        </div>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="บัญชีระบุปัจจัยที่มีผลต่อคุณภาพ อาชีวอนามัยและความปลอดภัยของผลิตภัณฑ์และบริการ"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>รหัสผลิตภัณฑ์</th>
        <th>ภารกิจ/ผลิตภัณฑ์และบริการ</th>
        <th>ความต้องการ/ความคาดหวัง</th>
        <th>ปัจจัยที่มีผลต่อคุณภาพอาชีวอนามัยและความปลอดภัย</th>
        <th>Related</th>
        <x-slot name="othertable">
        </x-slot>
    </x-data-table.default-data-table>

    <x-content.expectation-factor/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            $('#data_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax:{
                        url: "",
                    },
                columns: [
                    <x-data-table.column-script column-name="ProductCode"/>
                    <x-data-table.column-script column-name="ProductName">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Expectation"/>
                    <x-data-table.column-script column-name="Factor">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Related">
                        orderable: false
                    </x-data-table.column-script>
                ],
                "order":[[0,'asc'],[2,'asc']],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,

                drawCallback: function(){
                    $('.toggle-class').bootstrapSwitch();
                    $('.toggle-class').on('switchChange.bootstrapSwitch', function (event, state) {
                        var Related = $(this).prop('checked') == true ? 'Yes' : 'No';
                        var product_expectation_factor_id = $(this).data('id');
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '/product_expectation_factor_related',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            data: {'Related': Related, 'product_expectation_factor_id': product_expectation_factor_id},
                            success: function(data){
                                console.log(data.success)
                            }
                        });
                    });
                }
            });

            <x-j-s.expectation-factor/>
        });
    </script>
@endsection
