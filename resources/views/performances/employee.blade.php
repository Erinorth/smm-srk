@extends('adminlte::page')

@section('title','Performance Evaluation')

@section('content_header')
    <h1 class="m-0 text-dark">Performance</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Performance"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <tr style="font-size:80%;">
            <th rowspan="2" class="text-center align-middle">ผู้ถูกประเมิน</th>
            <th rowspan="2" class="text-center align-middle">จำนวนวัน</th>
            <th colspan="2" class="text-center align-middle">ปฏิบัติตามกฏ และมาตรฐานทางด้านอาชีวอนามัยและความปลอดภัย</th>
            <th colspan="2" class="text-center align-middle">ปฏิบัติตามมาตรฐานทางด้านคุณภาพ</th>
            <th colspan="2" class="text-center align-middle">การทำงานเป็นทีม</th>
            <th colspan="2" class="text-center align-middle">การวางแผน แก้ไขปัญหาและตัดสินใจเชิงรุก</th>
            <th colspan="2" class="text-center align-middle">คุณธรรมและธรรมาภิบาล</th>
            <th colspan="2" class="text-center align-middle">ความเชี่ยวชาญและความเป็นมืออาชีพ</th>
            <th colspan="2" class="text-center align-middle">ความคิดสร้างสรรค์และนวัตกรรม</th>
            <th colspan="2" class="text-center align-middle">การประยุกต์ใช้เทคโลยีดิจิทัล</th>
            <th rowspan="2" class="text-center align-middle">ค่าเฉลี่ย</th>
            <th rowspan="2" class="text-center align-middle">Action</th>
        </tr>
        <tr style="font-size:80%;">
            <th class="text-center align-middle">คะแนน</th>
            <th class="text-center align-middle">รายละเอียดเพิ่มเติม</th>
            <th class="text-center align-middle">คะแนน</th>
            <th class="text-center align-middle">รายละเอียดเพิ่มเติม</th>
            <th class="text-center align-middle">คะแนน</th>
            <th class="text-center align-middle">รายละเอียดเพิ่มเติม</th>
            <th class="text-center align-middle">คะแนน</th>
            <th class="text-center align-middle">รายละเอียดเพิ่มเติม</th>
            <th class="text-center align-middle">คะแนน</th>
            <th class="text-center align-middle">รายละเอียดเพิ่มเติม</th>
            <th class="text-center align-middle">คะแนน</th>
            <th class="text-center align-middle">รายละเอียดเพิ่มเติม</th>
            <th class="text-center align-middle">คะแนน</th>
            <th class="text-center align-middle">รายละเอียดเพิ่มเติม</th>
            <th class="text-center align-middle">คะแนน</th>
            <th class="text-center align-middle">รายละเอียดเพิ่มเติม</th>
        </tr>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Evaluation">
        <x-input.dropdown title="ผู้ถูกประเมิน" name-id="employee_id">
            <option></option>
            @foreach ($employee as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.text title="Day" name-id="Day"/>

        <x-input.text title="ปฏิบัติตามกฏ และมาตรฐานทางด้านอาชีวอนามัยและความปลอดภัย (ใส่คะแนนตั้งแต่ 1.00 - 5.00 ทศนิยม 2 ตำแหน่ง)" name-id="SafetyHealth"/>

        <x-input.text title="หากใส่คะแนนน < 2.00 หรือ > 4.00 จะต้องมีเหตุผลประกอบ" name-id="SafetyHealthRemark"/>

        <x-input.text title="ปฏิบัติตามมาตรฐานทางด้านคุณภาพ (ใส่คะแนนตั้งแต่ 1.00 - 5.00 ทศนิยม 2 ตำแหน่ง)" name-id="Quality"/>

        <x-input.text title="หากใส่คะแนนน < 2.00 หรือ > 4.00 จะต้องมีเหตุผลประกอบ" name-id="QualityRemark"/>

        <x-input.text title="ความสามัคคี (ใส่คะแนนตั้งแต่ 1.00 - 5.00 ทศนิยม 2 ตำแหน่ง)" name-id="TeamWork"/>

        <x-input.text title="หากใส่คะแนนน < 2.00 หรือ > 4.00 จะต้องมีเหตุผลประกอบ" name-id="TeamWorkRemark"/>

        <x-input.text title="การวางแผน แก้ไขปัญหาและตัดสินใจเชิงรุก (ใส่คะแนนตั้งแต่ 1.00 - 5.00 ทศนิยม 2 ตำแหน่ง)" name-id="Planing"/>

        <x-input.text title="หากใส่คะแนนน < 2.00 หรือ > 4.00 จะต้องมีเหตุผลประกอบ" name-id="PlaningRemark"/>

        <x-input.text title="คุณธรรมและธรรมาภิบาล (ใส่คะแนนตั้งแต่ 1.00 - 5.00 ทศนิยม 2 ตำแหน่ง)" name-id="MoralGoodGovernance"/>

        <x-input.text title="หากใส่คะแนนน < 2.00 หรือ > 4.00 จะต้องมีเหตุผลประกอบ" name-id="MoralGoodGovernanceRemark"/>

        <x-input.text title="ความเชี่ยวชาญและความเป็นมืออาชีพ (ใส่คะแนนตั้งแต่ 1.00 - 5.00 ทศนิยม 2 ตำแหน่ง)" name-id="Professional"/>

        <x-input.text title="หากใส่คะแนนน < 2.00 หรือ > 4.00 จะต้องมีเหตุผลประกอบ" name-id="ProfessionalRemark"/>

        <x-input.text title="ความคิดสร้างสรรค์และนวัตกรรม (ใส่คะแนนตั้งแต่ 1.00 - 5.00 ทศนิยม 2 ตำแหน่ง)" name-id="Innovation"/>

        <x-input.text title="หากใส่คะแนนน < 2.00 หรือ > 4.00 จะต้องมีเหตุผลประกอบ" name-id="InnovationRemark"/>

        <x-input.text title="การประยุกต์ใช้เทคโลยีดิจิทัล (ใส่คะแนนตั้งแต่ 1.00 - 5.00 ทศนิยม 2 ตำแหน่ง)" name-id="Digital"/>

        <x-input.text title="หากใส่คะแนนน < 2.00 หรือ > 4.00 จะต้องมีเหตุผลประกอบ" name-id="DigitalRemark"/>

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
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="Day"/>
                <x-data-table.column-script column-name="SafetyHealth"/>
                <x-data-table.column-script column-name="SafetyHealthRemark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Quality"/>
                <x-data-table.column-script column-name="QualityRemark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="TeamWork"/>
                <x-data-table.column-script column-name="TeamWorkRemark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Planing"/>
                <x-data-table.column-script column-name="PlaningRemark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="MoralGoodGovernance"/>
                <x-data-table.column-script column-name="MoralGoodGovernanceRemark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Professional"/>
                <x-data-table.column-script column-name="ProfessionalRemark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Innovation"/>
                <x-data-table.column-script column-name="InnovationRemark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Digital"/>
                <x-data-table.column-script column-name="DigitalRemark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="AVR"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Performance Evaluation"/>

            <x-data-table.submit-script name-i-d="" action-url="performance_employees">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="performance_employees">
                <x-data-table.edit-value-script name="employee_id"/>
                <x-data-table.edit-value-script name="Day"/>
                <x-data-table.edit-value-script name="SafetyHealth"/>
                <x-data-table.edit-value-script name="SafetyHealthRemark"/>
                <x-data-table.edit-value-script name="Quality"/>
                <x-data-table.edit-value-script name="QualityRemark"/>
                <x-data-table.edit-value-script name="TeamWork"/>
                <x-data-table.edit-value-script name="TeamWorkRemark"/>
                <x-data-table.edit-value-script name="Planing"/>
                <x-data-table.edit-value-script name="PlaningRemark"/>
                <x-data-table.edit-value-script name="MoralGoodGovernance"/>
                <x-data-table.edit-value-script name="MoralGoodGovernanceRemark"/>
                <x-data-table.edit-value-script name="Professional"/>
                <x-data-table.edit-value-script name="ProfessionalRemark"/>
                <x-data-table.edit-value-script name="Innovation"/>
                <x-data-table.edit-value-script name="InnovationRemark"/>
                <x-data-table.edit-value-script name="Digital"/>
                <x-data-table.edit-value-script name="DigitalRemark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="performance_employees"/>
        });
    </script>
@endsection
