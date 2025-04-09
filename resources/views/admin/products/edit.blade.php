@extends('admin.layouts.master')
@section('title') Dashboard @endsection

@section('css')
    <link href="{{ URL::asset('admin/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin/assets/plugins/timepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('admin/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

@endsection

@section('content')

  <div class="row my-3">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body" id="form_filter" style="text-transform: uppercase">
                <form id="product-update" class="row"  enctype="multipart/form-data">
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
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
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
            let formData1 = new FormData($('#product-update')[0]);

            editProduct(formData1);
        });

        function editProduct (formData) {
            const modelTitle = 'Confirmation';
            const actionMsg = 'Do you want to save this product changes?';
            const ajaxSuccess  = function (message) {
                $('#modal_msg').html(message.success);
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

            const actionReferesh  = function () {
                window.location.href = "{{ route('admin.product') }}";
            }

            const actionNo = function () {
                $('#btn-product').show();
            };
            confirmAction(modelTitle, actionMsg, 1, actionFunction, actionNo, actionReferesh, '');
        }

    </script>
@endsection








