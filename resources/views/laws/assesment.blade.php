@extends('adminlte::page')

@section('title','Law Assesment')

@section('content_header')
    <h1 class="m-0 text-dark">Law Assesment</h1>
@stop

@section('content')
    <x-header.department-header departmentId="{{$department->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Department</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.department-header>

    <x-header.laws lawId="{{$law->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Law</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.laws>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Create/Update" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/law_assesments') }}">
            @csrf
            <div class="row">
                <div class="col text-center">
                    <button type="submit" class="btn btn-success btn-block btn-sm">Create/Update</button>
                </div>
            </div>
            <input type="hidden" name="law_id" id="law_id" value="{{$law->id}}" />
            <input type="hidden" name="department_id" id="department_id" value="{{$department->id}}" />
        </form>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Law Assesment"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>ID</th>
        <th>Law Detail</th>
        <th>Related</th>
        <th>Evident</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Edit Evident">
        <x-input.text-area title="Evident" name-id="Evident"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>
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
                    <x-data-table.column-script column-name="id"/>
                    <x-data-table.column-script column-name="LawDetail"/>
                    <x-data-table.column-script column-name="Related"/>
                    <x-data-table.column-script column-name="Evident">
                        orderable: false
                    </x-data-table.column-script>
                ],
                "order":[[1,'asc']],
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
                        var law_assesment_id = $(this).data('id');
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '/law_assesments_related',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            data: {'Related': Related, 'law_assesment_id': law_assesment_id},
                            success: function(data){
                                console.log(data.success)
                            }
                        });
                    });
                }
            });

            <x-data-table.submit-script name-i-d="" action-url="law_assesments">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/law_assesments_evident') }}">
                <x-data-table.edit-value-script name="Evident"/>
            </x-data-table.edit-script>
        });
    </script>
@endsection
