@extends('admin.layouts.master')
@section('title', 'Partnership Logos')

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
    <div class="container">
        <div class="col-12 d-flex justify-content-end mt-3">
            <button class="btn btn-primary" onclick="showModal()">Add Logo</button>
        </div>

        <table class="table mt-3">
            <thead>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($logos as $logo)
                <tr>
                    <td>{{ $logo->title }}</td>
                    <td><img src="{{ asset('storage/'.$logo->image) }}" width="50"></td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" onchange="toggleStatus({{ $logo->id }})" {{ $logo->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        <button class="btn btn-warning" onclick="editLogo({{ $logo->id }})">Edit</button>
                        <button class="btn btn-danger" onclick="deleteLogo({{ $logo->id }})">Delete</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No record found</td></tr>
            @endforelse
            </tbody>
        </table>


        @if ($logos->hasPages())
            <nav class="d-flex mt-3">
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    @if ($logos->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $logos->previousPageUrl() }}" rel="prev">&laquo;</a>
                        </li>
                    @endif

                    <!-- Page Numbers -->
                    @foreach ($logos->getUrlRange(1, $logos->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $logos->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <!-- Next Page Link -->
                    @if ($logos->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $logos->nextPageUrl() }}" rel="next">&raquo;</a>
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

    <!-- Modal -->
        @include('partnershipLogo.image-modal')
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function showModal() {
            $('#logo_id').val('');
            $('#title').val('');
            $('#image').val('');
            $('#preview').hide();
            $('#modalTitle').text('Add Logo');
            $('#logoModal').modal('show'); // Show the modal
        }


        /*function saveLogo() {
            var formData = new FormData();
            formData.append("title", $('#title').val());
            if ($('#image')[0].files.length) {
                formData.append("image", $('#image')[0].files[0]);
            }

            var id = $('#logo_id').val();
            var url = id ? "{{ route('admin.partnership-logos.update', '') }}/" + id : "{{ route('admin.partnership-logos.store') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire('Success', response.message, 'success').then(() => location.reload());
                }
            });
        }*/
        function saveLogo() {
            var formData = new FormData();
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("title", $('#title').val());

            var imageInput = $('#image')[0].files;
            if (imageInput.length > 0) {
                formData.append("image", imageInput[0]); // Append new image if selected
            } else {
                formData.append("existing_image", $('#existing_image').val()); // Use existing image
            }

            var id = $('#logo_id').val();
            var url = id ? "{{ route('admin.partnership-logos.update', '') }}/" + id : "{{ route('admin.partnership-logos.store') }}";

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


        {{--function editLogo(id) {--}}
        {{--    $.get("{{ route('admin.partnership-logos.edit', '') }}/" + id, function(data) {--}}
        {{--        $('#logo_id').val(data.id);--}}
        {{--        $('#title').val(data.title);--}}
        {{--        $('#preview').attr('src', '/storage/app/public/' + data.image).show();--}}
        {{--        showModal();--}}
        {{--    });--}}
        {{--}--}}

        function editLogo(id) {
            $.get("{{ route('admin.partnership-logos.edit', '') }}/" + id, function(data) {
                $('#logo_id').val(data.id);
                $('#title').val(data.title);
                if (data.image) {
                    $('#preview').attr('src', '/storage/' + data.image).show();
                    $('#existing_image').val(data.image);
                } else {
                    $('#preview').hide();
                    $('#existing_image').val('');
                }

                $('#modalTitle').text('Edit Logo');
                $('#logoModal').modal('show'); // Open modal
            });
        }


        function deleteLogo(id) {
            Swal.fire({
                title: 'Are you sure?',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.partnership-logos.destroy', '') }}/" + id,
                        type: 'POST',
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success').then(() => location.reload());
                        }
                    });
                }
            });
        }

        function toggleStatus(id) {
            $.post("{{ route('admin.partnership-logos.toggle-status', '') }}/" + id, function(response) {
                Swal.fire('Success', response.message, 'success');
            });
        }
    </script>
@endsection
