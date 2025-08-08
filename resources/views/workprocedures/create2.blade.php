@extends('adminlte::page')

@section('title','Work Procedure')

@section('content_header')
    <h1 class="m-0 text-dark">Work Procedure</h1>
@stop

@section('content')
    <x-header.item itemId="{{$item->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.item>

    <x-data-table.default-data-table color="" collapse-card="" title="Work Procedure"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>No.</th>
        <th>Procedure</th>
        <th>Controlled Point</th>
        <th>Class</th>
        <th>Man</th>
        <th>Hour</th>
        <th>Activity</th>
        <th>Actions</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Class Detail" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center">Class</th>
                    <th class="text-center">Meaning</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">A</td>
                    <td>เป็นกิจกรรมที่ต้องใช้ความรู้ ทักษะ และความเชี่ยวชาญเป็นอย่างมาก จะต้องเป็นผู้ปฏิบัติงาน กฟผ. เท่านั้น เช่น งานตรวจสอบ ทดสอบ วัดค่า</td>
                </tr>
                <tr>
                    <td class="text-center">B</td>
                    <td>เป็นกิจกรรมที่สามารถให้ผู้ช่วยช่างปฏิบัติงานได้ แต่ Inspector หรือ Foreman จะต้องควบคุมอย่างใกล้ชิด เช่น งานถอด-ประกอบ การเคลื่อนย้ายอุปกรณ์</td>
                </tr>
                <tr>
                    <td class="text-center">C</td>
                    <td>เป็นกิจกรรมที่สามารถปล่อยให้ผู้ช่วยช่างปฏิบัติงาน และ Inspector หรือ Foreman ตรวจสอบเมื่องานแล้วเสร็จ เช่น งานทำความสะอาด </td>
                </tr>
            </tbody>
        </table>
    </x-card.default-card>

    <x-modal.input-form name-i-d="" modal-title="Create Consumable">
        <x-adminlte-select2 name="Order2" label="Order" data-placeholder="Select an option...">
            <option/>
        </x-adminlte-select2>

        <x-adminlte-input name="Procedure" label="Procedure" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-text-editor name="ControlledPoint" label="Controlled Point"/>

        <x-adminlte-select2 name="Class" label="Class" data-placeholder="Select an option...">
            <option/>
            <option>A</option>
            <option>B</option>
            <option>C</option>
        </x-adminlte-select2>

        <x-adminlte-input name="Man" label="Man" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Hour" label="Hour" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-select2 name="activity_id" label="Activity" data-placeholder="Select an option...">
            <option/>
            @foreach ($activity as $value)
                <option value="{{ $value->id }}">{{ $value->ActivityName }}</option>
            @endforeach
        </x-adminlte-select2>

        <x-slot name="othervalue">
            <input type="hidden" name="item_id" id="item_id" value="{{$item->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน work procedure.pdf').'">การใช้งาน Work Procedure</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Order2"/>
                <x-data-table.column-script column-name="Procedure">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ControlledPoint">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Class"/>
                <x-data-table.column-script column-name="Man">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Hour">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ActivityName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc'],[3,'asc']</x-slot>
            </x-data-table.data-table-script>

            $('#create_record').click(function(){
                $('.select2-bootstrap4').val(null).trigger('change');
                $('#create_form')[0].reset();
                $('.modal-title').text('Add New Procedure');
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result').html('');
                var itemid = $('#item_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('dynamicdependent.fetchcreate') }}",
                    method:"POST",
                    data:{itemid:itemid, _token:_token},
                    success:function(result)
                    {
                        $('#Order2').html(result);
                        $('#Order2').val(data.result.Order2);
                    }
                })
                $('#formModal').modal('show');
            });

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/workprocedures2') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url :"{{ url('/workprocedures2/') }}"+id+"/edit", //
                    dataType:"json",
                    success:function(data)
                    {
                        <x-data-table.edit-value-script name="Procedure"/>
                        $('#ControlledPoint').summernote("code", data.result.ControlledPoint);
                        <x-data-table.edit-value-script name="Class"/>
                        <x-data-table.edit-value-script name="Man"/>
                        <x-data-table.edit-value-script name="Hour"/>
                        <x-data-table.edit-value-script name="activity_id"/>
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Procedure'); //
                        $('#action_button').val('Edit');
                        $('#action').val('Edit');
                        $('#formModal').modal('show');

                        var itemid = $('#item_id').val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url:"{{ route('dynamicdependent.fetchedit') }}",
                            method:"POST",
                            data:{itemid:itemid, _token:_token},
                            success:function(result)
                            {
                                $('#Order2').html(result);
                                $('#Order2').val(data.result.Order2);
                            }
                        })
                    }
                })
            });

            <x-data-table.delete-script delete-name="" url="{{ url('/workprocedures2') }}"/>
        });
    </script>
@endsection
