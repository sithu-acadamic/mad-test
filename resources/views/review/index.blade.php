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
                    <i class="fa fa-plus"></i> Add Review
                </button>
            </div>

            <!-- Reviews Table -->
            <div class="col-12">
                @if ($reviews->isEmpty())
                    <div class="alert alert-warning text-center">No Reviews Found!</div>
                @else
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Review</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td>{{ $review->username }}</td>
                                <td>{{ Str::limit($review->review_message, 50) }}</td>
                                <td>{{ $review->star_rating }} ⭐</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" onchange="toggleStatus({{ $review->id }})"
                                            {{ $review->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="viewReview({{ $review }})">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="editReview({{ $review }})">
                                        <i class="fa fa-edit" aria-hidden="true"></i>Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteReview({{ $review->id }})">
                                        <i class="fa fa-times" aria-hidden="true"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
{{--                  {{ $reviews->links() }}--}}
                    @if ($reviews->hasPages())
                        <nav class="d-flex mt-3">
                            <ul class="pagination">
                                <!-- Previous Page Link -->
                                @if ($reviews->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $reviews->previousPageUrl() }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                <!-- Page Numbers -->
                                @foreach ($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $reviews->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($reviews->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $reviews->nextPageUrl() }}" rel="next">&raquo;</a>
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
                    <form id="reviewForm">
                        <input type="hidden" id="reviewId">
                        <input type="text" id="username" class="form-control mb-2" placeholder="Username">
                        <textarea id="review_message" class="form-control mb-2" placeholder="Review Message"></textarea>
                        <input type="number" id="star_rating" class="form-control mb-2" placeholder="Rating (1-5)">
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Review Modal -->
    <div class="modal fade" id="viewReviewModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Review Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Username:</strong> <span id="viewUsername"></span></p>
                    <p><strong>Review:</strong> <span id="viewReviewMessage"></span></p>
                    <p><strong>Rating:</strong> <span id="viewStarRating"></span> ⭐</p>
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
                $('#reviewForm')[0].reset();
                $('#reviewId').val('');
            };

            // Add/Edit Review (Form Submit)
            $('#reviewForm').submit(function (e) {
                e.preventDefault();

                let reviewId = $('#reviewId').val();
                let url = reviewId ? "{{ route('admin.reviews.update', ':id') }}".replace(':id', reviewId) : "{{ route('admin.reviews.store') }}";
                let method = reviewId ? 'POST' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        _token: '{{ csrf_token() }}',
                        username: $('#username').val(),
                        review_message: $('#review_message').val(),
                        star_rating: $('#star_rating').val()
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

            // View Review (Show Full Details)
            window.viewReview = function (review) {
                $('#viewUsername').text(review.username);
                $('#viewReviewMessage').text(review.review_message);
                $('#viewStarRating').text(review.star_rating);
                $('#viewReviewModal').modal('show');
            };

            // Edit Review (Prefill Form)
            window.editReview = function (review) {
                $('#reviewId').val(review.id);
                $('#username').val(review.username);
                $('#review_message').val(review.review_message);
                $('#star_rating').val(review.star_rating);
                $('#reviewModal').modal('show');
            };

            // Delete Review
            window.deleteReview = function (id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This review will be deleted permanently!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.reviews.destroy', ':id') }}".replace(':id', id),
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                Swal.fire('Deleted!', response.message, 'success').then(() => location.reload());
                            }
                        });
                    }
                });
            };

            // Toggle Review Status
            window.toggleStatus = function (id) {
                $.ajax({
                    url: "{{ route('admin.reviews.toggleStatus', ':id') }}".replace(':id', id),
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        Swal.fire('Updated!', response.message, 'success').then(() => location.reload());
                    }
                });
            };
        });
    </script>
@endsection
