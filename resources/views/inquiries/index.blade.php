@extends('admin.layouts.master')
@section('title')
    Inquiries Inbox
@endsection

@section('css')
    <link href="{{ URL::asset('admin/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('admin/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"/>

    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-selection {
            width: 100% !important;
        }
        #inquiriesList .card.active {
            background-color: #f0f8ff; /* Light blue background for the active card */
            border: 1px solid #007bff; /* Blue border for the active card */
        }
    </style>

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mt-2">
            <!-- Left Section -->
            <div class="col-lg-4 col-md-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Inquiries</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; max-height: 600px;">
                        <div id="inquiriesList">
                            @foreach($inquiries as $inquiry)
                                <div class="card mb-2" data-id="{{$inquiry->id}}" style="cursor: pointer;">
                                    <div class="card-body">
                                        <h6 class="card-title">{{$inquiry->customer->first_name}}</h6>
                                        <p class="card-text text-truncate">{{$inquiry->inquirie_message}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-lg-8 col-md-7">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Inquiry Details</h5>
                    </div>
                    <div class="card-body">
                        <div id="inquiryDetails">
                            <p class="text-muted">Select an inquiry to view details.</p>
                        </div>

                        <div id="inquiry-manager" style="display: none">
                            <form id="filtersForm">
                                <div class="row align-items-end">

                                    <div class="col-md-5">
                                    <select id="VehicleBrand" name="brand"
                                            class="form-control clone-elem select2 custom-select select2-hidden-accessible input-group-sm VehicleBrand"
                                            style="width: 100%;">
                                        <option value=""></option>
                                    </select>
                                    </div>

                                    <div class="col-md-5">
                                        <select id="VehiclePart" name="parts"
                                                class="form-control clone-elem select2 custom-select select2-hidden-accessible input-group-sm VehiclePart"
                                                style="width: 100%;">
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-info" id="filterButton">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </form>


                           {{-- <div class="card mt-3" id="shopsCard" style="display: none;">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Available Shops</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div id="shopsList">
                                        <div class="card mb-2">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <h6 class="card-title mb-0">DELKANDA AUTO PARTS</h6>
                                                <i class="fa fa-eye text-primary" style="cursor: pointer;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}

                            <div class="card mt-3" id="shopsCard" style="display: none;">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Available Shops</h5>
                                    <div>
                                        <input type="checkbox" id="selectAllShops" /> Select All
                                    </div>
                                </div>
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div id="shopsList">
                                    </div>
                                </div>
                                <div class="card-footer text-end" id="sendButtonContainer" style="display: none;">
                                    <button type="button" class="btn btn-success" id="sendButton">
                                        Send
                                    </button>
                                </div>
                            </div>

                        </div>
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

        $(document).ready(function () {
            loadInquiries();
            $('#inquiry-manager').hide();


            $('#shopsList').on('change', '.shopCheckbox', function () {
                toggleSendButton();
                updateSelectAllCheckbox();
            });

            // Select All checkbox functionality
            $('#selectAllShops').on('change', function () {
                const isChecked = $(this).is(':checked');
                $('.shopCheckbox').prop('checked', isChecked);
                toggleSendButton();
            });

            // Send button click event
            $('#sendButton').on('click', function () {
                const selectedShops = [];
                $('.shopCheckbox:checked').each(function () {
                    selectedShops.push($(this).data('id'));
                });

                alert('Selected Shop IDs: ' + selectedShops.join(', '));
                // Implement your send logic here, e.g., an AJAX call
            });

        });

        $('#sendButton').on('click', function () {
            const inquiryId = $('#inquiriesList .card.active').data('id');
            console.log(inquiryId);
            const selectedVendors = [];

            $('.shopCheckbox:checked').each(function () {
                selectedVendors.push($(this).data('id'));
            });

            if (selectedVendors.length === 0) {
                alert('Please select at least one vendor.');
                return;
            }

            $.ajax({
                url: `{{ route('admin.inquiries.mapVendors') }}`,
                method: 'POST',
                data: {
                    inquiry_id: inquiryId,
                    vendor_ids: selectedVendors,
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        $('.shopCheckbox:checked').each(function () {
                            const parentCard = $(this).closest('.card');
                            $(this).prop('disabled', true).prop('checked', false); // Disable the checkbox and uncheck it
                            if (!parentCard.find('.badge').length) {
                                parentCard.find('.card-body').append('<span class="badge bg-success ms-2">Sent</span>'); // Add "Sent" badge
                            }
                        });
                        alert('Vendors have been successfully mapped to the inquiry.');
                    }
                },
                error: function (xhr) {
                    alert('An error occurred: ' + xhr.responseJSON.message);
                }
            });
        });


        function loadInquiries() {
            loadSelect2Data('VehicleBrand', 'Select Brand', '{{route('admin.brand.details')}}', false, 'filtersForm', 'class');
            loadSelect2Data('VehiclePart', 'Part Type', '{{route('admin.part.details')}}', false, 'filtersForm', 'class');

            // Add click event to inquiry cards
            $('#inquiriesList .card').click(function () {

                $('#inquiriesList .card').removeClass('active');
                $(this).addClass('active');

                // Get the inquiry ID
                const inquiryId = $(this).data('id');
                console.log(inquiryId);
                showInquiryDetails(inquiryId);

                $('#filtersCard').show();
                $('#inquiry-manager').show();
                $('#shopsCard').show();

               // loadShops();
            });
        }

        function showInquiryDetails(inquiryId) {
            $.ajax({
                url: `{{ route('admin.inquiries.details') }}`,
                data: {inquiryId: inquiryId},
                method: 'GET',
                success: function (response) {
                    console.log(response)
                    $('#inquiryDetails').html(response);
                },
                error: function () {
                    alert('Failed to load inquiry details.');
                }
            });
        }

        function toggleSendButton() {
            const anyChecked = $('.shopCheckbox:checked').length > 0;
            $('#sendButtonContainer').toggle(anyChecked);
        }

        // Update "Select All" checkbox based on individual checkboxes
        function updateSelectAllCheckbox() {
            const allChecked = $('.shopCheckbox').length === $('.shopCheckbox:checked').length;
            $('#selectAllShops').prop('checked', allChecked);
        }

        $(document).on('click', '#filterButton', function () {
            $.ajax({
                url: `{{ route('admin.get.vendors') }}`,
                method: 'POST',
                data: {
                    'f': $('#filtersForm').serialize(),
                },
                success: function (response) {
                    console.log(response)

                    $('#shopsList').html(response);
                },
                error: function (xhr) {
                    alert('An error occurred: ' + xhr.responseJSON.message);
                }
            });
        });
    </script>
@endsection
