<x-data-table.default-data-table color="" collapse-card="" title="Plan Overtime"
    collapse-button="minus" table-id="_planot">
    <x-slot name="tool">
        <x-button.create-record name-i-d="_planot"/>
        <button class="btn btn-xs text-success" name="create_record_planot_import" id="create_record_planot_import" title="Import"><i class="fa fa-lg fa-fw fa-file-import"></i></button>
    </x-slot>
    <th>Plan Date</th>
    <th>Name</th>
    <th>Plan Hour</th>
    <th>Remark</th>
    <th>Action</th>
    <x-slot name="othertable">
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_planot_import" modal-title="Import Plan Overtime">
    <x-adminlte-input-file name="select_file" label="Select File for Upload" igroup-size="" placeholder="Choose a file...">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-lightblue">
                <i class="fas fa-upload"></i>
            </div>
        </x-slot>
    </x-adminlte-input-file>
    
    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_planot"/>
