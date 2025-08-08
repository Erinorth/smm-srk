@extends('adminlte::page')

@section('title','Hazard')

@section('content_header')
    <h1 class="m-0 text-dark">Hazard</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Hazard"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
            <x-button.printb url="hazard"/>
        </x-slot>
        <th>ID</th>
        <th>Hazard Name</th>
        <th>ประเภท</th>
        <th>จำนวนคนที่ปฏิบัติ</th>
        <th>การสัมผัสแหล่งอันตราย</th>
        <th>ขั้นตอนการปฏิบัติงาน</th>
        <th>การอบรม</th>
        <th>อุปกรณ์ป้องกันภัยส่วนบุคคล (PPE)</th>
        <th>อุปกรณ์/เครื่องมือความปลอดภัย</th>
        <th>การตรวจการทำงาน/ความปลอดภัย</th>
        <th>การเตือนอันตราย</th>
        <th>โอกาสเกิด</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Hazard">
        <x-adminlte-input name="HazardName" label="Hazard Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-select2 name="Type" label="ประเภท" data-placeholder="Select an option...">
            <option/>
            <option>Activity</option>
            <option>Tool</option>
            <option>Place</option>
        </x-adminlte-select2>

        <h5>ความเกี่ยวข้อง</h5>

        <x-adminlte-select2 name="ManPower" label="จำนวนคนที่ปฏิบัติ" data-placeholder="Select an option...">
            <option/>
            <option>No</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
        </x-adminlte-select2>

        <x-adminlte-select2 name="Contact" label="การสัมผัสแหล่งอันตราย" data-placeholder="Select an option...">
            <option/>
            <option>No</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
        </x-adminlte-select2>

        <x-adminlte-select2 name="Procedure" label="ขั้นตอนการปฏิบัติงาน" data-placeholder="Select an option...">
            <option/>
            <option>No</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
        </x-adminlte-select2>

        <x-adminlte-select2 name="Training" label="การอบรม" data-placeholder="Select an option...">
            <option/>
            <option>No</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
        </x-adminlte-select2>

        <x-adminlte-select2 name="PPE" label="อุปกรณ์ป้องกันภัยส่วนบุคคล (PPE)" data-placeholder="Select an option...">
            <option/>
            <option>No</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
        </x-adminlte-select2>

        <x-adminlte-select2 name="SafetyEquipment" label="อุปกรณ์/เครื่องมือความปลอดภัย" data-placeholder="Select an option...">
            <option/>
            <option>No</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
        </x-adminlte-select2>

        <x-adminlte-select2 name="Verification" label="การตรวจการทำงาน/ความปลอดภัย" data-placeholder="Select an option...">
            <option/>
            <option>No</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
        </x-adminlte-select2>

        <x-adminlte-select2 name="SafetySign" label="การเตือนอันตราย" data-placeholder="Select an option...">
            <option/>
            <option>No</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
        </x-adminlte-select2>

        <x-adminlte-input name="Opportunity" label="โอกาสเกิด" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน hazard.pdf').'">การใช้งาน Hazard</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="HazardName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Type">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ManPower">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Contact">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Procedure">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Training">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="PPE">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="SafetyEquipment">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Verification">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="SafetySign">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Opportunity">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[1,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Hazard"/>

            <x-data-table.submit-script name-i-d="" action-url="hazards">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/hazards') }}">
                <x-data-table.edit-value-script name="HazardName"/>
                <x-data-table.edit-value-script name="Type"/>
                <x-data-table.edit-value-script name="ManPower"/>
                <x-data-table.edit-value-script name="Contact"/>
                <x-data-table.edit-value-script name="Procedure"/>
                <x-data-table.edit-value-script name="Training"/>
                <x-data-table.edit-value-script name="PPE"/>
                <x-data-table.edit-value-script name="SafetyEquipment"/>
                <x-data-table.edit-value-script name="Verification"/>
                <x-data-table.edit-value-script name="SafetySign"/>
                <x-data-table.edit-value-script name="Opportunity"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="hazards"/>
        });
    </script>
@endsection
