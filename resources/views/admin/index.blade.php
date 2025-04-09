@extends('admin.layouts.master')
@section('title', 'Google Reviews')

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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal" onclick="clearForm()">
                    <i class="fa fa-plus"></i> Add Users
                </button>
            </div>

            <!-- Reviews Table -->
            <div class="col-12">
                @if ($users->isEmpty())
                    <div class="alert alert-warning text-center">No Users Found!</div>
                @else
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm" onclick="editReview({{ $user }})">
                                        <i class="fa fa-edit" aria-hidden="true"></i>Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteReview({{ $user->id }})">
                                        <i class="fa fa-times" aria-hidden="true"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    {{--{{ $reviews->links() }}--}}
                    @if ($users->hasPages())
                        <nav class="d-flex mt-3">
                            <ul class="pagination">
                                <!-- Previous Page Link -->
                                @if ($users->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                            <!-- Page Numbers -->
                                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                            <!-- Next Page Link -->
                                @if ($users->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif

                @endif
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" id="userId">
                        <input type="text" id="firstName" class="form-control mb-2" placeholder="First Name">
                        <input type="text" id="lastName" class="form-control mb-2" placeholder="Last Name">
                        <input type="email" id="email" class="form-control mb-2" placeholder="Email">
                        <input type="password" id="password" class="form-control mb-2" placeholder="password">
                        <input type="password" id="confirmPassword" class="form-control mb-2" placeholder="confirm password">

                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // Clear form when opening modal
            window.clearForm = function() {
                $('#userForm')[0].reset();
                $('#userId').val('');
            };

            // Add/Edit Review (Form Submit)
            $('#userForm').submit(function (e) {
                e.preventDefault();

                let userId = $('#userId').val();
                let url = userId ? "{{ route('admin.user.update', ':id') }}".replace(':id', userId) : "{{ route('admin.user.store') }}";
                let method = userId ? 'POST' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        _token: '{{ csrf_token() }}',
                        first_name: $('#firstName').val(),
                        last_name: $('#lastName').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                        password_confirmation: $('#confirmPassword').val()
                    },
                    success: function (response) {
                        Swal.fire('Success!', response.message, 'success').then(() => {
                            $('#reviewModal').modal('hide');
                            clearForm();
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = Object.values(errors).map(error => error[0]).join('<br>');
                        Swal.fire('Validation Error!', errorMessages, 'error');
                    }
                });
            });
            // Edit Review (Prefill Form)
            window.editReview = function (user) {
                $('#userId').val(user.id);
                $('#firstName').val(user.first_name);
                $('#lastName').val(user.last_name);
                $('#email').val(user.email);
                $('#password').val(user.password);
                $('#confirmPassword').val(user.confirm_password);
                $('#reviewModal').modal('show');
            };

            // Delete Review
            window.deleteReview = function (id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do You want to delete this user account!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.user.destroy', ':id') }}".replace(':id', id),
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                Swal.fire('Deleted!', response.message, 'success').then(() => location.reload());
                            }
                        });
                    }
                });
            };
        });
    </script>
@endsection
