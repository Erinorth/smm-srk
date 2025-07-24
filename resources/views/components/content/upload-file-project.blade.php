<div id="formModal_{{ $name }}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload File</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <span id="form_result_{{ $name }}"></span>
                <form method="post" id="create_form_{{ $name }}" class="form-horizontal" enctype="multipart/form-data" action="javascript:void(0)">
                    @csrf
                    
                    <x-adminlte-input-file name="select_file" label="Select File for Upload" igroup-size="" placeholder="Choose a file...">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-lightblue">
                                <i class="fas fa-upload"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>

                    <input type="hidden" name="action_{{ $name }}" id="action_{{ $name }}" value="Upload" />
                    <input type="submit" name="action_button_{{ $name }}" id="action_button_{{ $name }}" class="btn btn-success" value="Upload" />
                    <input type="hidden" name="attachment_id" id="attachment_id" value="0" />
                    <input type="hidden" name="attachment_type" id="attachment_type" value="{{ $name }}" />
                    <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}" />
                </form>
            </div>
        </div>
    </div>
</div>

<div id="confirmModal_{{ $name }}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmation</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 class="text-center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button_{{ $name }}" id="ok_button_{{ $name }}" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
