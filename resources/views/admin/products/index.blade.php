@extends('admin.layouts.master')
@section('title') Dashboard @endsection

@section('css')
    <link href="{{ URL::asset('admin/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
@endsection

@section('content')


    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div>
                <a class="btn btn-success my-2" style="float:right;" href="{{route('admin.product.create')}}"><i class="icon-plus"></i> NEW PRODUCT</a>
            </div>
            <div class="col-lg-12 col-md-12">
                <div>
                    <div>
                        <div class="row my-1">
                            <form id="form_filter">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="com_name" class="mb-2">NAME</label>
                                        <input type="text" id="pr_name" name="pr_name" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="com_code" class="mb-2">PRICE</label>
                                        <input type="text" id="pr_price" name="pr_price" class="form-control">
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-12 my-2">
                                <button class="btn btn-info filter_rec" style="float:right;"><i class="fa fa-filter"></i> FILTER</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="resultTable" class="table table-striped table-bordered dt-responsive nowrap" style="text-transform: uppercase">
                            <thead>
                                <tr>
                                    <th class="no-w"></th>
                                    <th>NAME</th>
                                    <th>PRICE</th>
                                    <th>PRODUCT INDEX</th>
                                    <th width="5px"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
@section('script')

    <script>
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            loadData();
        });

        $('.filter_rec').click(function () {
            $('#resultTable').DataTable().destroy();
            loadData();
        });

        function loadData(){
            table = $('#resultTable').DataTable({
            targets: 'no-sort',
            bSort: false,
            serverSide: true,
            searching:false,
            pageLength: 25,
            lengthChange: false,
            ajax: {
                url:'{{route('admin.product.data')}}',
                method: 'POST',
                data: {'f':$('#form_filter').serialize()}
            },
            columns: [
                { data: 'DT_RowIndex',name: 'DT_RowIndex',orderable:false,className:'text-center'},
                { data: 'name',name: 'name'},
                { data: 'price',name: 'price'},
                { data: 'product_index',name: 'product_index'},
                // { data: 'company_type.type_name',name: 'com_type',className:'text-center'},
                { data: 'action',name: 'action',className:'text-center'},
                // { data: 'edit',name: 'edit',className:'text-center'},
            ],
            fnDrawCallback: function () {
            }
            });
        }

        $(document).on('click', '.delete-product', function(){
            let productId    = $(this).data('product-id');
             deleteProduct(productId);
        });


        function deleteProduct (productId) {
            const modelTitle = 'Confirmation';
            const actionMsg = 'Do you want to delete this product?';
            const ajaxSuccess  = function (message) {
                $('#modal_msg').html(message.success);
                $('#action_refresh').show();
                $('#resultTable').DataTable().destroy();
                loadData();
            };
            const ajaxError = function (errorData) {
                $('#err_action_refresh').show();
                $('#modal_msg').html(errorData.responseJSON.message);
                errorDisplay(errorData);

            };
            let data = {'product_id':productId};
            const actionFunction = function () {
                ajaxCall('{{route('admin.product.delete')}}',data, ajaxSuccess, ajaxError);
            };
            confirmAction(modelTitle, actionMsg, 1, actionFunction, function () {}, function () {}, '');
        }


    </script>
@endsection
