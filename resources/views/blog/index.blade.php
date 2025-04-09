@extends('admin.layouts.master')
@section('title', 'Blog Management')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"/>

    <style>
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

        .tag-badge {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            margin: 2px;
        }

    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mt-2">


            <div class="col-12 d-flex justify-content-end mb-3">
                <button class="btn btn-primary float-right" onclick="openBlogModal()">
                    <i class="fa fa-plus"></i>
                    Add Blog Post</button>
            </div>

            <table class="table table-bordered mt-3">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Added Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($blogs as $blog)
                    <tr>
                        <td><img src="{{ asset('storage/' . $blog->image) }}" width="50"></td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->created_at }}</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" onchange="toggleStatus({{ $blog->id }})" {{ $blog->status ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="viewBlog({{ $blog }})">View</button>
                            <button class="btn btn-warning btn-sm" onclick="editBlog({{ $blog }})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteBlog({{ $blog->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $blogs->links() }}
        </div>



    </div>

    <!-- Blog Modal -->
   {{-- <div id="blogModal" class="modal fade" tabindex="-1">
        <form id="blogForm">
            @csrf
            <input type="hidden" id="blog_id" name="blog_id">

            <label>Title:</label>
            <input type="text" id="title" name="title" required>

            <label>Description:</label>
            <textarea id="description" name="description" class="wysiwyg-editor"></textarea>

            <label>Tags:</label>
            <input type="text" id="tags" name="tags">

            <label>Image:</label>
            <input type="file" id="image" name="image">

            <button type="submit">Save</button>
        </form>
    </div>--}}

    <!-- Blog Modal -->
    <div id="blogModal" class="modal fade" tabindex="-1" aria-labelledby="blogModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blogModalLabel">Add/Edit Blog Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="blogForm">
                        @csrf
                        <input type="hidden" id="blog_id" name="blog_id">

                        <div class="form-group">
                            <label>Title:</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Description:</label>
                            <textarea id="description" name="description" class="form-control wysiwyg-editor"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Tags:</label>
                            <input type="text" id="tags" name="tags[]" class="form-control">
{{--                            <input type="text" id="tags" name="tags[]" class="form-control" data-role="tagsinput">--}}
                        </div>

                        <div class="form-group">
                            <label>Image:</label>
                            <input type="file" id="image" name="image" class="form-control">
                            <img id="imagePreview" src="" width="100" height="100" style="display: none; margin-top: 10px;">
                        </div>

                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalButton">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Blog</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- View Blog Modal -->
    <div id="viewBlogModal" class="modal fade" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true" data-target=".bd-example-modal-lg">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Blog Details</h5>

                </div>
                <div class="modal-body">
                    <p><strong>Title:</strong> <span id="view_title"></span></p>
                    <p><strong>Description:</strong></p>
                    <div id="view_description" style="text-align: justify"></div>
                    <p><strong>Tags:</strong> <div id="view_tags"></div></p>
                    <p><strong>Status:</strong> <span id="view_status"></span></p>
                    <p><strong>Created At:</strong> <span id="view_created_at"></span></p>
                    <div id="view_image_container">
                        <img id="view_image" src="" alt="Blog Image" width="100%">
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput-revisited/1.4.2/jquery.tagsinput-revisited.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.wysiwyg-editor').summernote({
                height: 200,
                toolbar: [['style', ['bold', 'italic', 'underline', 'clear']], ['font', ['color']]]
            });
            // $('#tags').tagsinput();
            $('#tags').tagsinput({
                'delimiter': [','], // Separate tags by commas
                'height': 'auto',
                'width': '100%',
                'defaultText': 'Add a tag'
            });

        });

        $('#closeModalButton').click(function () {
            $('#blogModal').modal('hide');
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       /* function openBlogModal() {
            $('#blogForm')[0].reset();
            $('#blog_id').val('');
            $('#blogModal').modal('show');
        }*/

        function openBlogModal() {
            $('#blogForm')[0].reset();
            $('#blog_id').val('');
            $('#description').summernote('code', ''); // Reset WYSIWYG editor
            $('#blogModal').modal('show'); // Open modal properly
        }

        function viewBlog(blog) {
            $('#view_title').text(blog.title);
            $('#view_description').html(blog.description);

            // Show Tags with Bootstrap Badges
            if (blog.tags && blog.tags.length > 0) {
                let tagBadges = blog.tags.map(tag => `<span class="badge badge-primary mr-1 tag-badge">${tag.tags}</span>`).join(' ');
                console.log(tagBadges);
                $('#view_tags').html(tagBadges);
            } else {
                $('#view_tags').html('<span class="text-muted">No tags</span>');
            }


            // Show Status
            $('#view_status').text(blog.status ? "Active" : "Inactive");

            // Show Created Date
            $('#view_created_at').text(blog.created_at);

            // Show Image
            if (blog.image) {
                $('#view_image').attr('src', "{{ asset('storage/') }}/" + blog.image);
                $('#view_image_container').show();
            } else {
                $('#view_image_container').hide();
            }

            $('#viewBlogModal').modal('show');
        }


        function editBlog(blog) {
            console.log(blog);
            $('#blog_id').val(blog.id);
            $('#title').val(blog.title);
            $('#description').summernote('code', blog.description);
            // $('#tags').val(blog.tags);
            $('#tags').tagsinput('removeAll');

            if (blog.tags && Array.isArray(blog.tags)) {
                blog.tags.forEach(tag => {
                    console.log(tag.tags);
                    $('#tags').tagsinput('add', tag.tags);
                });
            }

            if (blog.image) {
                $('#imagePreview').attr('src', '/storage/' + blog.image).show();
            } else {
                $('#imagePreview').hide();
            }


            $('#blogModal').modal('show');
        }

        $('#image').change(function (event) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(event.target.files[0]);
        });


        $('#blogForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var id = $('#blog_id').val();
            var url = id ? "{{ route('admin.blogs.update', '') }}/" + id : "{{ route('admin.blogs.store') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire("Success", response.message, "success").then(() => location.reload());
                },
                error: function() {
                    Swal.fire("Error", "Something went wrong!", "error");
                }
            });
        });

        function deleteBlog(id) {
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.blogs.destroy', '') }}/" + id,
                        type: "DELETE",
                        success: function() { location.reload(); }
                    });
                }
            });
        }

        function toggleStatus(id) {
            $.post("{{ route('admin.blogs.toggle-status', '') }}/" + id);
        }
    </script>
@endsection
