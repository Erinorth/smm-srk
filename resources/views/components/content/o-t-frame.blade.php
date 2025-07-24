<x-data-table.default-data-table color="" collapse-card="collapsed" title="Overtime Frame"
    collapse-button="plus" table-id="_otframe">
    <x-slot name="tool">
        <form class="form-horizontal" method="POST" action="{{ url('/otframe_project') }}">
            @csrf
            <button type="submit" class="btn btn-xs text-success" title="Create/Update"><i class="fa fa-lg fa-fw fa-file-import"></i></button>
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </form>
    </x-slot>
    <th>ID</th>
    <th>Name</th>
    <th>Year</th>
    <th>Month</th>
    <th>Frame</th>
    <th>Remark</th>
    <th>Action</th>
    <x-slot name="othertable">
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_otframe" modal-title="Update Overtime Frame">
    <x-adminlte-select2 name="Frame" label="Frame" data-placeholder="Select an option...">
        <option></option>
        <option>0</option>
        <option>30</option>
        <option>45</option>
        <option>60</option>
        <option>90</option>
        <option>120</option>
    </x-adminlte-select2>

    <x-adminlte-input name="Remark2" label="Remark" placeholder="Input a text..."
        disable-feedback/>

    <x-slot name="othervalue">
        <input type="hidden" name="employee_id2" id="employee_id2"/>
        <input type="hidden" name="Year" id="Year"/>
        <input type="hidden" name="Month" id="Month"/>
    </x-slot>
</x-modal.input-form>
