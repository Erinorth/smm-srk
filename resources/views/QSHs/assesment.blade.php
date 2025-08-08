@extends('adminlte::page')

@section('title','Risk Assessment')

@section('content_header')
    <h1 class="m-0 text-dark">Typy of Risk</h1>
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
                <div class="col-xl text-center">
                    <form class="form-horizontal" method="POST" action="{{ url('/update_assesment') }}">
                        @csrf
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-success btn-block btn-sm">Create/Update</button>
                            </div>
                        </div>
                        <input type="hidden" name="department_id_update" id="department_id_update" value="{{$departmentid}}" />
                    </form>
                </div>
                <div class="col-xl text-center">
                    <a href="{{ url('riskqualityhmrs/'.$departmentid) }}" class="btnprn btn btn-info btn-block btn-sm">Print</a>
                </div>
            </div>
        </div>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="ประเมินปัจจัยที่ทำให้เกิดความเสี่ยง"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th class="text-center">ปัจจัยที่ทำให้เกิดความเสี่ยง</th>
        <th class="text-center">Related</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="ประเมินปัจจัยที่ทำให้เกิดความเสี่ยง"
        collapse-button="plus" table-id="_type_of_risk">
        <x-slot name="tool">
            <x-button.create-record name-i-d="_type_of_risk"/>
        </x-slot>
        <th class="text-center">ปัจจัยที่ทำให้เกิดความเสี่ยง</th>
        <th class="text-center">ลักษณะความเสี่ยงที่อาจทำให้ไม่เป็นตามข้อกำหนด</th>
        <th class="text-center">ลักษณะของผลกระทบ</th>
        <th class="text-center">ระดับของผลกระทบ</th>
        <th class="text-center">มาตรการควบคุม</th>
        <th class="text-center">การติดตามประเมินผล</th>
        <th class="text-center">Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="_type_of_risk" modal-title="Add New Risk Assessment">
        <x-input.dropdown title="ปัจจัยที่ทำให้เกิดความเสี่ยง" name-id="factor_id">
            <option></option>
            @foreach ($factor as $value)
                <option value="{{$value->id}}">{{$value->Factor}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.text-area title="ลักษณะความเสี่ยงที่อาจทำให้ไม่เป็นตามข้อกำหนด" name-id="TypeofRisk"/>

        <x-input.text-area title="ลักษณะของผลกระทบ" name-id="Effect"/>

        <x-input.dropdown title="ระดับของผลกระทบ" name-id="EffectValue">
            <option></option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
        </x-input.dropdown>

        <x-input.text-area title="มาตรการควบคุม" name-id="Measure"/>

        <x-input.text-area title="การติดตามประเมินผล" name-id="Followup"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name="_type_of_risk"/>
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
                    <x-data-table.column-script column-name="Factor"/>
                    <x-data-table.column-script column-name="Related">
                        orderable: false
                    </x-data-table.column-script>
                ],
                "order":[[0,'asc']],
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
                        var department_factor_id = $(this).data('id');
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '/assesment_related',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            data: {'Related': Related, 'department_factor_id': department_factor_id},
                            success: function(data){
                                console.log(data.success)
                            }
                        });
                    });
                }
            });

            <x-data-table.data-table-script table-name="_type_of_risk" ajax-url="{{ url('/QSH_typeofrisks') }}">
                <x-data-table.column-script column-name="Factor"/>
                <x-data-table.column-script column-name="TypeofRisk"/>
                <x-data-table.column-script column-name="Effect"/>
                <x-data-table.column-script column-name="EffectValue"/>
                <x-data-table.column-script column-name="Measure"/>
                <x-data-table.column-script column-name="Followup"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="_type_of_risk" title="Add New Risk Assessment"/>

            <x-data-table.submit-script name-i-d="_type_of_risk" action-url="QSH_typeofrisks">
                <x-data-table.ajax-reload-script table-id="_type_of_risk"/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name="_type_of_risk"  edit-url="QSH_typeofrisks">
                <x-data-table.edit-value-script name="TypeofRisk"/>
                <x-data-table.edit-value-script name="factor_id"/>
                <x-data-table.edit-value-script name="Effect"/>
                <x-data-table.edit-value-script name="EffectValue"/>
                <x-data-table.edit-value-script name="Measure"/>
                <x-data-table.edit-value-script name="Followup"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="_type_of_risk" url="QSH_typeofrisks"/>
        });
    </script>
@endsection
