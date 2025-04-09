@extends('admin.layouts.master')
@section('title', 'Our Services')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
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

        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 22px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #28a745;
        }

        input:checked + .slider:before {
            transform: translateX(18px);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12 d-flex justify-content-end mb-3">
                <button class="btn btn-primary float-end mt-2" onclick="showModal()">Add Service</button>
            </div>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{!! $service->title_one !!} {!! $service->title_two !!}</td>
                        <td>{!! $service->description !!}</td>
                        <td>
                            @if($service->image)
                                <img src="{{ asset('storage/'.$service->image) }}" width="50">
                            @endif
                        </td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" onchange="toggleStatus({{ $service->id }})" {{ $service->status ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>

                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editService({{ $service->id }})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteService({{ $service->id }})">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">No record found</td></tr>
                @endforelse
                </tbody>
            </table>

            @if ($services->hasPages())
                <nav class="d-flex mt-3">
                    <ul class="pagination">
                        <!-- Previous Page Link -->
                        @if ($services->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $services->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        <!-- Page Numbers -->
                        @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $services->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <!-- Next Page Link -->
                        @if ($services->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $services->nextPageUrl() }}" rel="next">&raquo;</a>
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

    @include('service.component.service-modal')
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function showModal() {
            $('#service_id').val('');
            $('#title').val('');
            $('#description').val('');
            $('#image').val('');
            $('#modalTitle').text('Add Service');
            $('#serviceModal').modal('show');
        }

        function saveService() {
            console.log($('#title_one_color').is(':checked'));
            console.log($('#title_two_color').is(':checked'));
            var formData = new FormData();
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("title_one", $('#title_one').val());
            formData.append("title_two", $('#title_two').val());

            formData.append("title_one_color", $('#title_one_color').is(':checked') ? 1 : 0);
            formData.append("title_two_color", $('#title_two_color').is(':checked') ? 1 : 0);

            formData.append("description", $('#description').val());

            var imageInput = $('#image')[0].files;
            if (imageInput.length > 0) {
                formData.append("image", imageInput[0]);
            }

            var id = $('#service_id').val();
            var url = id ? "{{ route('admin.our-services.update', '') }}/" + id : "{{ route('admin.our-services.store') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire('Success', response.message, 'success').then(() => location.reload());
                },
                error: function(response) {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            });
        }

        function editService(id) {
            $.get("{{ route('admin.our-services.edit', '') }}/" + id, function(data) {
                $('#service_id').val(data.id);
                $('#title_one').val(data.title_one);
                $('#title_two').val(data.title_two);

                $('#title_one_color').prop('checked', data.title_one_color == 1);
                $('#title_two_color').prop('checked', data.title_two_color == 1);

                $('#description').val(data.description);
                $('#modalTitle').text('Edit Service');

                if (data.image) {
                    $('#imagePreview').attr('src', '/storage/' + data.image).show();
                } else {
                    $('#imagePreview').hide();
                }

                $('#serviceModal').modal('show');
            });
        }

        function deleteService(id) {
            Swal.fire({
                title: 'Are you sure?',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.our-services.destroy', '') }}/" + id,
                        type: 'POST',
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success').then(() => location.reload());
                        }
                    });
                }
            });
        }

        function toggleStatus(id) {
            $.ajax({
                url: "{{ route('admin.our-services.toggle-status', '') }}/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire("Success", response.message, "success");
                },
                error: function() {
                    Swal.fire("Error", "Failed to update status", "error");
                }
            });
        }
    </script>
@endsection
