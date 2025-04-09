@extends('admin.layouts.master')
@section('title')
    Settings
@endsection

@section('css')
    <link href="{{ URL::asset('admin/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('admin/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <style>
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
        }

        .page-item {
            margin: 0 3px;
        }

        .page-item .page-link {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 5px;
            color: #333;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            text-decoration: none;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            color: white;
        }

        .page-item .page-link:hover {
            background-color: #007bff;
            color: white;
        }

        .page-item.disabled .page-link {
            color: #ccc;
            pointer-events: none;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mt-2">
            <!-- Right-aligned Add Button -->
            <div class="col-12 d-flex justify-content-end mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fa fa-plus"></i> Add
                </button>
            </div>

            <!-- 🔹 Image Table -->
            <div class="col-lg-12">
                <table class="table table-bordered mt-3" >
                    <thead>
                    <tr>
                        <th>Section</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="imageTableBody">
                    @foreach($sections as $section)
                        <tr>
                            <td>{{ $section->section_code }}</td>
                            <td>
                                @if($section->image)
                                    <img src="{{ asset('storage/'.$section->image) }}" class="img-thumbnail" style="max-width: 80px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                @if($section->image)
                                    <button class="btn btn-info btn-sm view-image" data-image="{{ asset($section->image) }}" data-bs-toggle="modal" data-bs-target="#viewModal">
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>No Image</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if ($sections->hasPages())
                    <nav class="d-flex mt-3">
                        <ul class="pagination">
                            <!-- Previous Page Link -->
                            @if ($sections->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $sections->previousPageUrl() }}" rel="prev">&laquo;</a>
                                </li>
                            @endif

                            <!-- Page Numbers -->
                            @foreach ($sections->getUrlRange(1, $sections->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $sections->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <!-- Next Page Link -->
                            @if ($sections->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $sections->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>

    <!-- 🔹 Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" enctype="multipart/form-data">
                        <!-- Section Select -->
                        <div class="mb-3">
                            <label for="sectionSelect" class="form-label">Select Section</label>
                            <select class="form-select" id="sectionSelect">
                                <option value="">Choose Section</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->section_code }}">{{ $section->section_code }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="imageUpload" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" id="imageUpload" accept="image/*">
                            <img id="imagePreview" src="" class="mt-2 img-thumbnail" style="max-width: 100px; display: none;"/>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 View Image Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="fullImage" src="" class="img-fluid"/>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::asset('admin/assets/plugins/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2();

            // Image preview
            $('#imageUpload').change(function () {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(this.files[0]);
            });

            // Handle form submission (AJAX)
            $('#addForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData();
                formData.append('section', $('#sectionSelect').val());
                formData.append('image', $('#imageUpload')[0].files[0]);

                $.ajax({
                    url: '{{ route("admin.section.image") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                            }).then(() => {
                                $('#addModal').modal('hide');
                                $('#imageUpload').val('');
                                $('#imagePreview').attr('src', '').hide();
                                location.reload();
                            });
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr);
                       // alert('Something went wrong!');
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';

                            $.each(errors, function (key, value) {
                                errorMessage += value[0] + '\n';
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error!',
                                text: errorMessage,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'Something went wrong!',
                            });
                        }
                    }
                });
            });

            // View full image
            $(document).on('click', '.view-image', function () {
                let imageSrc = $(this).data('image');
                $('#fullImage').attr('src', imageSrc);
            });
        });
    </script>
@endsection
