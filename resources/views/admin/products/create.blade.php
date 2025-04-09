@extends('admin.layouts.master')
@section('title') Dashboard @endsection
@section('content')
    {{-- @component('components.breadcrumb')
        @slot('li_1') @endslot
        @slot('title') COMPANY DETAILS @endslot
    @endcomponent --}}
@section('css')
    <link href="{{ URL::asset('admin/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin/assets/plugins/timepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('admin/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
@endsection



<div class="row my-3">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="header-content" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="left-content" style="display: flex; align-items: center;">
                        <h3 class="card-title">Product</h3>
                    </div>
                <!-- <a href="{{url('company')}}" class="btn btn-info" style="margin-right: 5px;"><i class="dripicons-arrow-left" style="display: inline-flex;justify-content: center;align-items: center;width: 100%;height: 100%;"></i></a> -->
                </div>
            </div>

            <div class="card-body" id="form_filter" style="text-transform: uppercase">
                <form id="product-save"  method="post" class="row"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @include ('admin.products.components.form', ['formMode' => 'create'])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ URL::asset('admin/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/plugins/timepicker/bootstrap-material-datetimepicker.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/pages/jquery.forms-advanced.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/plugins/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        tinymce.init({
            selector: '#product_description',
            content_css: 'https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap',  // Load the custom font in the editor
            plugins: 'advlist autolink lists link charmap print preview hr anchor',
            font_formats: "Rubik=rubik, sans-serif; Arial=arial, helvetica, sans-serif; Courier New=courier new, courier, monospace;",
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            height: 300
        });

        tinymce.init({
            selector: '#product_additional_information',
            plugins: 'advlist autolink lists link charmap print preview hr anchor',
            font_formats: "Rubik=rubik, sans-serif; Arial=arial, helvetica, sans-serif; Courier New=courier new, courier, monospace;",
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            height: 300
        });

        $("#btn-product").on("click", function (e) {
            e.preventDefault();
            $('#btn-product').hide();
            tinymce.triggerSave();
            let formData = new FormData($('#product-save')[0]);
        saveProduct(formData);
        });

        function saveProduct (formData) {
            const modelTitle = 'Confirmation';
            const actionMsg = 'Are you sure want to save this product details?';
            const ajaxSuccess  = function (message) {
                $('#modal_msg').html(message.success);
                $('#product-save')[0].reset();
                $('#btn-product').show();
                $('#action_refresh').show();
            };
            const ajaxError = function (errorData) {
                $('#err_action_refresh').show();
                $('#modal_msg').html(errorData.responseJSON.message);
                $('#btn-product').show();
                errorDisplay(errorData);
            };
            const actionFunction = function () {
                ajaxCall('{{route('admin.product.save')}}',formData, ajaxSuccess, ajaxError);
            };

            const actionNo = function () {
                $('#btn-product').show();
            };

            const actionReferesh  = function () {
                window.location.href = "{{ route('admin.product') }}";
            }

            confirmAction(modelTitle, actionMsg, 1, actionFunction, actionNo, actionReferesh, '');
        }
    </script>
@endsection








