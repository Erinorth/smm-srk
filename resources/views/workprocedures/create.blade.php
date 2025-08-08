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
        <th>Order</th>
        <th>Activity</th>
        <th>Detail</th>
        <th>No.</th>
        <th>Procedure</th>
        <th>Controlled Point</th>
        <th>Class</th>
        <th>Man</th>
        <th>Hour</th>
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
        <label class="control-label">Activity</label>
        <div>
            <select class="form-control dynamicactivity" name="activity_id" id="activity_id">
                <option value=""></option>
                @foreach ($activity as $value)
                    <option value="{{$value->id}}">{{$value->ActivityName}}</option>
                @endforeach
            </select>
        </div>

        <x-input.dropdown title="Order" name-id="Order">
            <option></option>
        </x-input.dropdown>

        <x-input.text title="Procedure" name-id="Procedure"/>

        <x-input.text-area title="ControlledPoint" name-id="ControlledPoint"/>

        <x-input.dropdown title="Class" name-id="Class">
            <option></option>
            <option>A</option>
            <option>B</option>
            <option>C</option>
        </x-input.dropdown>

        <x-input.text title="Man" name-id="Man"/>

        <x-input.text title="Hour" name-id="Hour"/>

        <x-slot name="othervalue">
            <input type="hidden" name="item_id" id="item_id" value="{{$item->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="AOrder"/>
                <x-data-table.column-script column-name="ActivityName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Detail">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="POrder"/>
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
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc'],[3,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Procedure"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/workprocedures') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url :"{{ url('/workprocedures/') }}"+id+"/edit", //
                    dataType:"json",
                    success:function(data)
                    {
                        <x-data-table.edit-value-script name="activity_id"/>
                        <x-data-table.edit-value-script name="Procedure"/>
                        <x-data-table.edit-value-script name="ControlledPoint"/>
                        <x-data-table.edit-value-script name="Class"/>
                        <x-data-table.edit-value-script name="Man"/>
                        <x-data-table.edit-value-script name="Hour"/>
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Procedure'); //
                        $('#action_button').val('Edit');
                        $('#action').val('Edit');
                        $('#formModal').modal('show');

                        var activityid = $('#activity_id').val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url:"{{ route('dynamicdependent.fetchactivity') }}",
                            method:"POST",
                            data:{activityid:activityid, _token:_token},
                            success:function(result)
                            {
                                $('#Order').html(result);
                                $('#Order').val(data.result.Order);
                            }
                        })
                    }
                })
            });

            <x-data-table.delete-script delete-name="" url="{{ url('/workprocedures') }}"/>

            $('.dynamicactivity').change(function(){
                if($(this).val() != '')
                {
                    var activityid = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('dynamicdependent.fetchactivity') }}",
                        method:"POST",
                        data:{activityid:activityid, _token:_token},
                        success:function(result)
                        {
                            $('#Order').html(result);
                        }
                    })
                }
            });

            $('#activity_id').change(function(){
                $('#Order').val('');
            });
        });
    </script>
@endsection
