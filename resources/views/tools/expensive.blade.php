@extends('adminlte::page')

@section('title','Expensive Tool')

@section('content_header')
    <h1 class="m-0 text-dark">Expensive Tool</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-card.default-card color="" collapse-card="collapsed-card" title="List & Report" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <a class="btn btn-primary btn-sm" href="{{ URL('tool_expensives/'.$project->id) }}">Report</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <br>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Catagory Name</th>
                                <th>Range/Capacity</th>
                                <th>LocalCode</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>SerialNumber</th>
                                <th>DurableSupplieCode</th>
                                <th>AssetToolCode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tool as $value)
                                <tr>
                                    <td>{{ $value->CatagoryName }}</td>
                                    <td>{{ $value->RangeCapacity }}</td>
                                    <td>{{ $value->LocalCode }}</td>
                                    <td>{{ $value->Brand }}</td>
                                    <td>{{ $value->Model }}</td>
                                    <td>{{ $value->SerialNumber }}</td>
                                    <td>{{ $value->DurableSupplieCode }}</td>
                                    <td>{{ $value->AssetToolCode }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Time Confirmed"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Date</th>
        <th>Job ID</th>
        <th>Catagory Name</th>
        <th>Range/Capacity</th>
        <th>LocalCode</th>
        <th>Brand</th>
        <th>Model</th>
        <th>SerialNumber</th>
        <th>DurableSupplieCode</th>
        <th>AssetToolCode</th>
        <th>Activity</th>
        <th>Hour</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Time Confirmed">
        <x-input.date title="Date" name-id="Date"/>

        <x-input.dropdown title="Job ID" name-id="job_id">
            <option></option>
            @foreach ($job as $value)
                <option value="{{ $value->id }}">{{ $value->LocationName }} // {{ $value->MachineName }} // {{ $value->ProductName }} // {{ $value->SystemName }} // {{ $value->SpecificName }} // {{ $value->ScopeName }} // {{ $value->id }}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="Tool" name-id="tool_id">
            <option></option>
            @foreach ($tool as $value)
                <option value="{{ $value->id }}">{{ $value->CatagoryName }} // {{ $value->RangeCapacity }} // {{ $value->LocalCode }} // {{ $value->Brand }} // {{ $value->Model }} // {{ $value->SerialNumber }} // {{ $value->DurableSupplieCode }} // {{ $value->AssetToolCode }}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="Activity" name-id="Activity">
            <option></option>
            <option>Travel</option>
            <option>Used</option>
        </x-input.dropdown>

        <x-input.text title="Hour" name-id="Hour"/>

        <x-input.text title="Remark" name-id="Remark"/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Date"/>
                <x-data-table.column-script column-name="job_id"/>
                <x-data-table.column-script column-name="CatagoryName"/>
                <x-data-table.column-script column-name="RangeCapacity"/>
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="DurableSupplieCode"/>
                <x-data-table.column-script column-name="AssetToolCode"/>
                <x-data-table.column-script column-name="Activity"/>
                <x-data-table.column-script column-name="Hour"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'deas']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="tool_expensive"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/tool_expensive') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/tool_expensive') }}">
                <x-data-table.edit-value-script name="Date"/>
                <x-data-table.edit-value-script name="job_id"/>
                <x-data-table.edit-value-script name="tool_id"/>
                <x-data-table.edit-value-script name="Activity"/>
                <x-data-table.edit-value-script name="Hour"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/tool_expensive') }}"/>
        });
    </script>
@endsection
