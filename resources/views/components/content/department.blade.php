<x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Department"
    collapse-button="plus" table-id="_department">
    <x-slot name="tool">
        @role('admin|head_operation|head_engineering')
            <x-button.create-record name-i-d="_department"/>
        @endrole
    </x-slot>
    <th>ID</th>
    <th>Code</th>
    <th>หน่วยงาน</th>
    <th>แผนก</th>
    <th>กอง</th>
    <th>ฝ่าย</th>
    <th>สายงาน</th>
    <th>Action</th>
    <x-slot name="othertable">
    </x-slot>
</x-data-table.default-data-table>

<x-modal.input-form name-i-d="_department" modal-title="Add New Department">
    <x-adminlte-input name="Code" label="Code" placeholder="Input a text..."
            disable-feedback/>

    <x-adminlte-input name="DepartmentName" label="Department Name" placeholder="Input a text..."
            disable-feedback/>

    <x-adminlte-input name="Section" label="Section" placeholder="Input a text..."
            disable-feedback/>

    <x-adminlte-input name="Department" label="Department" placeholder="Input a text..."
            disable-feedback/>

    <x-adminlte-input name="Division" label="Division" placeholder="Input a text..."
            disable-feedback/>

    <x-adminlte-input name="Business" label="Business" placeholder="Input a text..."
            disable-feedback/>

    <x-slot name="othervalue">
    </x-slot>
</x-modal.input-form>

<x-modal.confirm-delete delete-name="_department"/>
