@extends('adminlte::page')

@section('title', 'Packing')

@section('content_header')
    <h1 class="m-0 text-dark">Packing</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Report" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/packing') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <select class="form-control" id="PackingList" name="PackingList">
                            @foreach ($packinglist as $value)
                                <option>{{$value->Packing}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-sm">Print</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </form>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Packing"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Name</th>
        <th>Detail</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Price</th>
        <th>Weight</th>
        <th>Remark</th>
        <th>Packing</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Update Packing">
        <x-input.text title="Packing" name-id="Packing"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Name"/>
                <x-data-table.column-script column-name="Detail">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Quantity">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Unit">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Price">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Weight">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Packing"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            $('#create_form').on('submit', function(event){
                event.preventDefault();
                var action_url = '';

                if($('#action').val() == 'consumable')
                {
                    action_url = "/packing_consumables/update";
                }

                if($('#action').val() == 'tool')
                {
                    action_url = "/packing_tools/update";
                }

                $.ajax({
                    url: action_url,
                    method:"POST",
                    data:$(this).serialize(),
                    dataType:"json",
                    success:function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('.select2-bootstrap4').val(null).trigger('change');
                            $('#create_form')[0].reset();
                            $('#data_table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                    }
                });
            });

            $(document).on('click', '.consumable', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url :"/packing_consumables/"+id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        $('#Packing').val(data.result.Packing);
                        $('#Packing').trigger('change');
                        $('#hidden_id').val(id);
                        $('#action_button').val('Edit Consumable Packing');
                        $('#action').val('consumable');
                        $('#formModal').modal('show');
                    }
                })
            });

            $(document).on('click', '.tool', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url :"/packing_tools/"+id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        $('#Packing').val(data.result.Packing);
                        $('#Packing').trigger('change');
                        $('#hidden_id').val(id);
                        $('#action_button').val('Edit Tool Packing');
                        $('#action').val('tool');
                        $('#formModal').modal('show');
                    }
                })
            });
        });
    </script>
@endsection
