@extends('adminlte::page')

@section('title','Consumable')

@section('content_header')
    <h1 class="m-0 text-dark">Consumable</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Consumable"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('store_keeper|head_store_keeper|admin')
                <x-button.create-record name-i-d=""/>
                <x-button.add-to-store/>
            @endrole
        </x-slot>
        <th>ชื่อวัสดุ</th>
        <th>ขนาด</th>
        <th>หน่วย</th>
        <th>ราคา</th>
        <th>รหัสอุปกรณ์</th>
        <th>รหัสจัดซื้อ</th>
        <th>น้ำหนัก (kg.)</th>
        <th>Min</th>
        <th>In Store</th>
        <th>Max</th>
        <th>Prepare</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Consumable">
        <x-adminlte-input name="ConsumableName" label="ชื่อวัสดุ" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Detail" label="ขนาด" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Unit" label="หน่วย" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Cost" label="ราคา" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="ConsumableCode" label="รหัสอุปกรณ์" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="PurchaseCode" label="รหัสจัดซื้อ" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Weight" label="น้ำหนัก" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Min" label="Min" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Max" label="Max" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน project.pdf').'">การใช้งาน Project</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="ConsumableName"/>
                <x-data-table.column-script column-name="Detail">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Unit">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Cost">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ConsumableCode"/>
                <x-data-table.column-script column-name="PurchaseCode"/>
                <x-data-table.column-script column-name="Weight">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Min">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Store">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Max">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Prepare">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="consumables"/>

            <x-data-table.submit-script name-i-d="" action-url="consumables">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="consumables">
                <x-data-table.edit-value-script name="ConsumableName"/>
                <x-data-table.edit-value-script name="Detail"/>
                <x-data-table.edit-value-script name="Unit"/>
                <x-data-table.edit-value-script name="Cost"/>
                <x-data-table.edit-value-script name="Weight"/>
                <x-data-table.edit-value-script name="ConsumableCode"/>
                <x-data-table.edit-value-script name="PurchaseCode"/>
                <x-data-table.edit-value-script name="Min"/>
                <x-data-table.edit-value-script name="Max"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="consumables"/>
        });
    </script>
@endsection
