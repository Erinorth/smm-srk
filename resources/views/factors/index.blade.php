@extends('adminlte::page')

@section('title','Hazard')

@section('css')

@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Consumable</h1>
@stop

@section('content')
    <h3 class="text-center">Hazard</h3>
    <br>
    <div class="text-right">
        <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Hazard</button> <!-- -->
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="data_table">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Hazard Name</th>
                    <th class="text-center">ประเภท</th>
                    <th class="text-center">จำนวนคนที่ปฏิบัติ</th>
                    <th class="text-center">การสัมผัสแหล่งอันตราย</th>
                    <th class="text-center">ขั้นตอนการปฏิบัติงาน</th>
                    <th class="text-center">การอบรม</th>
                    <th class="text-center">อุปกรณ์ป้องกันภัยส่วนบุคคล (PPE)</th>
                    <th class="text-center">อุปกรณ์/เครื่องมือความปลอดภัย</th>
                    <th class="text-center">การตรวจการทำงาน/ความปลอดภัย</th>
                    <th class="text-center">การเตือนอันตราย</th>
                    <th class="text-center">Action</th>
                <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

<x-modal.input-form name-i-d="" modal-title="Add New Hazard">
                        <div class="form-group">
                            <label class="control-label">Hazard Name</label>
                            <div>
                                <input type="text" class="form-control" name="HazardName" id="HazardName">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">ประเภท</label>
                            <div>
                                <select class="form-control" name="Type" id="Type">
                                    <option></option>
                                    <option>Activity</option>
                                    <option>Tool</option>
                                    <option>Place</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <h5>ความเกี่ยวข้อง</h5>
                        <div class="form-group">
                            <label class="control-label">จำนวนคนที่ปฏิบัติ</label>
                            <div>
                                <select class="form-control" name="ManPower" id="ManPower">
                                    <option></option>
                                    <option>No</option>
                                    <option>Yes</option>
                                </x-input.dropdown>
                        <div class="form-group">
                            <label class="control-label">การสัมผัสแหล่งอันตราย</label>
                            <div>
                                <select class="form-control" name="Contact" id="Contact">
                                    <option></option>
                                    <option>No</option>
                                    <option>Yes</option>
                                </x-input.dropdown>
                        <div class="form-group">
                            <label class="control-label">ขั้นตอนการปฏิบัติงาน</label>
                            <div>
                                <select class="form-control" name="Procedure" id="Procedure">
                                    <option></option>
                                    <option>No</option>
                                    <option>Yes</option>
                                </x-input.dropdown>
                        <div class="form-group">
                            <label class="control-label">การอบรม</label>
                            <div>
                                <select class="form-control" name="Training" id="Training">
                                    <option></option>
                                    <option>No</option>
                                    <option>Yes</option>
                                </x-input.dropdown>
                        <div class="form-group">
                            <label class="control-label">อุปกรณ์ป้องกันภัยส่วนบุคคล (PPE)</label>
                            <div>
                                <select class="form-control" name="PPE" id="PPE">
                                    <option></option>
                                    <option>No</option>
                                    <option>Yes</option>
                                </x-input.dropdown>
                        <div class="form-group">
                            <label class="control-label">อุปกรณ์/เครื่องมือความปลอดภัย</label>
                            <div>
                                <select class="form-control" name="SafetyEquipment" id="SafetyEquipment">
                                    <option></option>
                                    <option>No</option>
                                    <option>Yes</option>
                                </x-input.dropdown>
                        <div class="form-group">
                            <label class="control-label">การตรวจการทำงาน/ความปลอดภัย</label>
                            <div>
                                <select class="form-control" name="Verification" id="Verification">
                                    <option></option>
                                    <option>No</option>
                                    <option>Yes</option>
                                </x-input.dropdown>
                        <div class="form-group">
                            <label class="control-label">การเตือนอันตราย</label>
                            <div>
                                <select class="form-control" name="SafetySign" id="SafetySign">
                                    <option></option>
                                    <option>No</option>
                                    <option>Yes</option>
                                </x-input.dropdown>
                        <x-slot name="othervalue">
                            </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="data_table</x-slot>
                <x-slot name="url"></x-slot>
                    <x-data-table.column-script column-name=">id',
                        name: 'id</x-slot>
                </x-data-table.column-script>
                    <x-data-table.column-script column-name=">HazardName',
                        name: 'HazardName</x-slot>
                </x-data-table.column-script>
                    <x-data-table.column-script column-name=">Type',
                        name: 'Type',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">ManPower',
                        name: 'ManPower',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">Contact',
                        name: 'Contact',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">Procedure',
                        name: 'Procedure',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">Training',
                        name: 'Training',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">PPE',
                        name: 'PPE',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">SafetyEquipment',
                        name: 'SafetyEquipment',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">Verification',
                        name: 'Verification',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">SafetySign',
                        name: 'SafetySign',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">action',
                        name: 'action',
                        orderable: false
                    }
                ],
                "order":[[1,'asc']]
            });

        <x-data-table.create-script name-i-d="" title="Add Hazard"/>

        <x-data-table.submit-script name-i-d="">
                <x-slot name="url">hazardshazards/update</x-slot>
                        <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

        <x-data-table.edit-script edit-name="" >
                <x-slot name="url">hazards</x-slot>
                <x-slot name="title">Consumable</x-slot>
                    $('#HazardName<x-data-table.edit-value-script name="HazardName);
                    $('#Type<x-data-table.edit-value-script name="Type);
                    $('#ManPower<x-data-table.edit-value-script name="ManPower);
                    $('#Contact<x-data-table.edit-value-script name="Contact);
                    $('#Procedure<x-data-table.edit-value-script name="Procedure);
                    $('#Training<x-data-table.edit-value-script name="Training);
                    $('#PPE<x-data-table.edit-value-script name="PPE);
                    $('#SafetyEquipment<x-data-table.edit-value-script name="SafetyEquipment);
                    $('#Verification<x-data-table.edit-value-script name="Verification);
                    $('#SafetySign<x-data-table.edit-value-script name="SafetySign);

                    PM Order</x-data-table.edit-script>

        <x-data-table.edit-script edit-name="" >
                <x-slot name="url">/hazards/>
        });
    </script>
@endsection
