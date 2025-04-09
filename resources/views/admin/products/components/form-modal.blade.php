<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@if($cmp_det->id>0)EDIT COMPANY - {{strtoupper($cmp_det->com_name)}}@else ADD NEW COMPANY @endif</h4> </div>
<div class="modal-body" id="crm_content">
    @include ('crm.components.form', ['formMode' => 'create'])
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger waves-effect waves-light" id="save_crm">Save</button>
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
</div>