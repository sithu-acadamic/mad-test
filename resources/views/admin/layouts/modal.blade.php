<!-- /.modal -->
<div id="sys_prompt" class="modal fade main_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content row" id="mod_content">
            <div id="mod_loading"><div class="loader text-center"><img src="{{asset('admin/plugins/images/loading.gif')}}"/></div></div>
            <div id="modal_res_div" class="">

            </div>
        </div>
    </div>
</div>
<!-- ajax  modal -->

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="sys_prompt_sm">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="row">
                <div id="modal_res_div_sm" class="col-md-12">

                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{--
<div class="modal fade bd-example-modal-sm" id="sys_prompt" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="mySmallModalLabel">Small Modal</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->
            <div class="modal-body text-center">
                <img src="{{ URL::asset('assets/images/users/user-5.jpg') }}" alt="" class="thumb-lg rounded-circle">
                <h5 class="mb-1">Good Morning!</h5>
                <p class="mb-0 text-muted">Hi, Aaron Gish ! Congratulations.</p>
            </div><!--end modal-body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-soft-primary btn-sm">Save changes</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div><!--end modal-footer-->
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->--}}
