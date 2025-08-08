@extends('adminlte::page')

@section('title','Hoist Testing')

@section('content_header')
    <h1 class="m-0 text-dark">Hoist Testing</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Hoist Testing"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Brand</th>
        <th>Capacity (Tons)</th>
        <th>Model</th>
        <th>Serial Number</th>
        <th>Local Code</th>
        <th>Durable Supplie Code</th>
        <th>Asset Tool Code</th>
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
        <th>Report</th>
        <th>Attachment</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Hoist Testing">
        <x-adminlte-select2 name="hoist_list_id" label="Hoist" data-placeholder="Select an option...">
            <option/>
            @foreach ($hoist as $value)
                <option value="{{$value->id}},{{$value->Type}}">
                    {{$value->Brand}}
                    @isset($value->Capacity)
                        &nbsp;//&nbsp;{{ $value->Capacity }}
                    @endisset
                    @isset($value->Model)
                        &nbsp;//&nbsp;{{ $value->Model }}
                    @endisset
                    @isset($value->SerialNumber)
                        &nbsp;//&nbsp;{{ $value->SerialNumber }}
                    @endisset
                    @isset($value->LocalCode)
                        &nbsp;//&nbsp;{{ $value->LocalCode }}
                    @endisset
                    @isset($value->DurableSupplieCode)
                        &nbsp;//&nbsp;{{ $value->DurableSupplieCode }}
                    @endisset
                    @isset($value->AssetToolCode)
                        &nbsp;//&nbsp;{{ $value->AssetToolCode }}
                    @endisset
                </option>
            @endforeach
        </x-adminlte-select2>

        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="TestDate" label="Test Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <div class="container">
            <h5>Chain Hoist Inspection & Test</h5>
            <x-adminlte-select2 name="TopHook" label="Top Hook Assembly" data-placeholder="Select an option...">
                <option/>
                <option>Accept</option>
                <option>Not Accept</option>
            </x-adminlte-select2>

            <x-adminlte-select2 name="BottomHook" label="Bottom Hook Assembly" data-placeholder="Select an option...">
                <option/>
                <option>Accept</option>
                <option>Not Accept</option>
            </x-adminlte-select2>

            <x-adminlte-select2 name="SafetyLatch" label="Safety Latch" data-placeholder="Select an option...">
                <option/>
                <option>Accept</option>
                <option>Not Accept</option>
            </x-adminlte-select2>

            <x-adminlte-select2 name="Condition" label="Chain Condition" data-placeholder="Select an option...">
                <option/>
                <option>Accept</option>
                <option>Not Accept</option>
            </x-adminlte-select2>

            <x-adminlte-select2 name="Pin" label="Chain Pin" data-placeholder="Select an option...">
                <option/>
                <option>Accept</option>
                <option>Not Accept</option>
            </x-adminlte-select2>

            <x-adminlte-select2 name="Testing" label="Chain Hoist Test" data-placeholder="Select an option...">
                <option/>
                <option>Accept</option>
                <option>Not Accept</option>
            </x-adminlte-select2>

            <x-adminlte-text-editor name="Remark" label="Remark"/>
        </div>

        <div class="container">
            <h5>Load Chain Inspection Point</h5>
            <x-adminlte-input name="LoadP" label="Standard Dimension (P) mm." placeholder="Input a text..."
                disable-feedback/>

            <x-adminlte-input name="LoadD" label="Chain Dimension (D) mm." placeholder="Input a text..."
                disable-feedback/>

            <x-adminlte-input name="Load10Link" label="10 Links Dimension for Load Chain (mm.)" placeholder="Input a text..."
                disable-feedback/>

            <x-adminlte-select2 name="LoadTesting" label="Acceptable" data-placeholder="Select an option...">
                <option/>
                <option>Accept</option>
                <option>Not Accept</option>
            </x-adminlte-select2>

            <x-adminlte-select2 name="Twist" label="A bend or Twist of the Hook" data-placeholder="Select an option...">
                <option/>
                <option>Accept</option>
                <option>Not Accept</option>
            </x-adminlte-select2>
        </div>

        <div class="container">
            <h5>Hook Inspection</h5>
            <x-adminlte-input name="HookTop" label="Top Opening Throat" placeholder="Input a text..."
                disable-feedback/>

            <x-adminlte-input name="HookBottom" label="Bottom Opening Throat" placeholder="Input a text..."
                disable-feedback/>
        </div>

        <div class="container">
            <h5>Inspection Result</h5>
            <x-adminlte-select2 name="Result" label="Result" data-placeholder="Select an option...">
                <option/>
                <option>Accept</option>
                <option>Not Accept</option>
            </x-adminlte-select2>

            <x-adminlte-input name="Note" label="Note" placeholder="Input a text..."
                disable-feedback/>
        </div>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}"/>
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-content.upload-file-project name="hoist" project-i-d="{{$project->id}}"/>

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
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Capacity"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="DurableSupplieCode"/>
                <x-data-table.column-script column-name="AssetToolCode"/>
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
                <x-data-table.column-script column-name="Report">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Attachment">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            $('#create_record').click(function(){
                $('#hoist_list_id').prop('disabled', false);
                $('.select2-bootstrap4').val(null).trigger('change');
                $('.select2-hidden-accessible').val(null).trigger('change');
                $('#create_form')[0].reset();
                $('.modal-title').text('Add New Hoist Testing');
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#formModal').modal('show');
            });

            <x-data-table.submit-script name-i-d="" action-url="hoist">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/hoist') }}">
                $('#hoist_list_id').prop('disabled', true);
                <x-data-table.edit-value-script name="TestDate"/>
                <x-data-table.edit-value-script name="TopHook"/>
                <x-data-table.edit-value-script name="BottomHook"/>
                <x-data-table.edit-value-script name="SafetyLatch"/>
                <x-data-table.edit-value-script name="Condition"/>
                <x-data-table.edit-value-script name="Pin"/>
                <x-data-table.edit-value-script name="Testing"/>
                $('#Remark').summernote("code", data.result.Remark);
                <x-data-table.edit-value-script name="LoadP"/>
                <x-data-table.edit-value-script name="LoadD"/>
                <x-data-table.edit-value-script name="Load10Link"/>
                <x-data-table.edit-value-script name="LoadTesting"/>
                <x-data-table.edit-value-script name="Twist"/>
                <x-data-table.edit-value-script name="HookTop"/>
                <x-data-table.edit-value-script name="HookBottom"/>
                <x-data-table.edit-value-script name="Result"/>
                <x-data-table.edit-value-script name="Note"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="hoist"/>

            <x-j-s.upload-file-project name="hoist"/>
        });
    </script>
@endsection
