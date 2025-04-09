@extends('admin.layouts.master')
@section('title', 'Our Team')

@section('css')
    <link href="{{ URL::asset('admin/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('admin/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

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
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mt-2">
            <!-- Right-aligned Add Button -->
            <div class="col-12 d-flex justify-content-end mb-3">
                <button class="btn btn-primary float-right" onclick="openTeamModal()">Add Team Member</button>
            </div>

            {{--<table class="table table-bordered mt-3">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Designation</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                    <tr>
                        <td><img src="{{ asset('storage/' . $team->image) }}" width="50" height="50"></td>
                        <td>{{ $team->first_name }}</td>
                        <td>{{ $team->last_name }}</td>
                        <td>{{ $team->designation }}</td>
                        <td>
                            <input type="checkbox" onchange="toggleStatus({{ $team->id }})" {{ $team->status ? 'checked' : '' }}>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editTeam({{ $team }})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteTeam({{ $team->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>--}}

            <table class="table table-bordered mt-3" id="teamTable">
                <thead>
                <tr>
                    <th>#</th> <!-- Index Column -->
                    <th>Image</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Designation</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="sortable">
                @foreach($teams as $team)
                    <tr data-id="{{ $team->id }}">
                        <td class="index">{{ $team->index }}</td> <!-- Show the index column -->
                        <td><img src="{{ asset('storage/' . $team->image) }}" width="50" height="50"></td>
                        <td>{{ $team->first_name }}</td>
                        <td>{{ $team->last_name }}</td>
                        <td>{{ $team->designation }}</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" onchange="toggleStatus({{ $team->id }})" {{ $team->status ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editTeam({{ $team }})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteTeam({{ $team->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>


            {{ $teams->links() }}
        </div>






    </div>

    <!-- Modal -->
    <!-- MODAL - Make sure this is inside the content section -->
    <div id="teamModal" class="modal fade" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teamModalLabel">Add/Edit Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="teamForm">
                        @csrf
                        <input type="hidden" id="team_id" name="team_id">

                        <div class="mb-3">
                            <label class="form-label">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Designation:</label>
                            <input type="text" class="form-control" id="designation" name="designation" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image:</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <img id="imagePreview" src="" width="100" height="100" style="display: none; margin-top: 10px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="teamForm">Save</button>
                </div>
            </div>
        </div>
    </div>

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

        $(function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    var order = [];
                    $("#sortable tr").each(function(index) {
                        var id = $(this).attr("data-id");
                        $(this).find(".index").text(index + 1); // Update UI index
                        order.push({ id: id, index: index + 1 });
                    });

                    // Send new order to backend
                    $.ajax({
                        url: "{{ route('admin.teams.reorder') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function(response) {
                            Swal.fire("Success", "Order updated successfully!", "success");
                        },
                        error: function() {
                            Swal.fire("Error", "Something went wrong!", "error");
                        }
                    });
                }
            });
        });

        function openTeamModal() {
            var modalElement = document.getElementById('teamModal');
            if (!modalElement) {
                console.error("Modal element not found!");
                return;
            }

            // Clear the form fields
            document.getElementById('teamForm').reset();
            document.getElementById('team_id').value = ''; // Clear hidden input

            var modal = new bootstrap.Modal(modalElement);
            modal.show();
        }


        function editTeam(team) {
            $('#team_id').val(team.id);
            $('#first_name').val(team.first_name);
            $('#last_name').val(team.last_name);
            $('#designation').val(team.designation);

            if (team.image) {
                $('#imagePreview').attr('src', '/storage/' + team.image).show();
            } else {
                $('#imagePreview').hide();
            }

            $('#teamModal').modal('show');
        }

        $('#teamForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            var id = $('#team_id').val();
            var url = id ? "{{ route('admin.teams.update', '') }}/" + id : "{{ route('admin.teams.store') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                  //  Swal.fire("Success", response.message, "success").then(() => location.reload());
                    Swal.fire("Success", response.message, "success").then(() => {
                        $('#teamForm')[0].reset(); // Clear form
                        $('#teamModal').modal('hide'); // Hide modal
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire("Error", "Something went wrong!", "error");
                }
            });
        });

        function deleteTeam(id) {
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.teams.destroy', '') }}/" + id,
                        type: "DELETE",
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
        }

        function toggleStatus(id) {
            $.post("{{ route('admin.teams.toggle-status', '') }}/" + id);
        }
    </script>
@endsection
