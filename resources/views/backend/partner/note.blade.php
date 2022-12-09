@extends('backend.layouts.app')
@section('content')
<h4 class="mt-0 header-title text-end">
    <a href="{{ route('backend.manage-partner') }}" class="btn btn-primary"> Partners List </a>
</h4>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                @include('backend.partner.include.partner-sidebar')
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                @include('backend.partner.include.partner-header')
            </div>
        </div>

        <div class="row">
            
            @if(Session::has('success'))
                <div class="alert alert-success" style="text-align: center;">
                    {{ Session::get('success') }}
                </div>
            @endif

            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" id="addnote">+ Add</button>
            </div>

            @foreach($notes as $note)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" data-id="{{ $note->id }}" data-partner="{{ $note->partner_id }}" class="dropdown-item editNoteModel">Edit</a>
                                <a href="{{ route('backend.deletepartner-note', ['id' => $note->id, 'partner_id'=> $note->partner_id ] ) }}" id="delete" class="dropdown-item">Delete</a>
                            </div>
                        </div>
                        <div class=" mb-3 ">
                            <h5 class="media-heading mt-0 mb-0">{{ $note->note_title }}</h5>
                        </div>
                        <p> <small>{!! $note->note_description !!}</small></p>
                    </div>
                    <div class="card-footer p-2">
                        <div class="d-flex align-items-center">
                            <a href="#"><img class="flex-shrink-0 me-1 rounded-circle avatar-sm" alt="64x64" src="{{ asset('assets/images/users/user-3.jpg') }}"></a>
                            <div class="flex-grow-1">
                                <p class="mb-0">Last Modified:</p>
                                <p class="mb-0"><small>{{ $note->updated_at }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>


    </div>
</div>

<!-- Standard modal content -->
<div id="addNoteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="noteForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Create Note</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="note_title">
                        <span class="text-danger" id="note-titleError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="summernote" name="note_description"></textarea>
                        <span class="text-danger" id="note-descriptionError"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveNote">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateNote" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateNoteForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Update Contact</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateNoteContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#addnote').on("click", function() {
            $('#addNoteModal').modal("show");
        });

        $('#saveNote').click(function(e) {
            e.preventDefault();

            var serialize = $('#noteForm').serialize();
            // console.log(serialize);

            $.ajax({
                url: "{{ route('backend.addpartner-note') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#addNoteModal').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    // console.log(response);
                    $('#note-titleError').text(response.responseJSON.errors.note_title);
                    $('#note-descriptionError').text(response.responseJSON.errors.note_description);
                }
            });

        });

        $('.editNoteModel').on("click", function() {

            $('#updateNote').modal("show");
            var noteId = $(this).data('id');
            var partnerId = $(this).data('partner');
            // console.log(contactId);

            $.ajax({
                url: "{{ route('backend.editpartner-note') }}",
                type: "POST",
                data: {
                    note_id: noteId,
                    partner_id: partnerId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var html = '';
                    html += '<input type="hidden" name="note_id" value="' + response.id + '"><input type="hidden" name="partner_id" value="' + response.partner_id + '"><div class="mb-2"><label class="form-label">Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="note_title" value="' + response.note_title + '"><span class="text-danger note-titleError"></span></div><div class="mb-2"><label class="form-label">Description <span class="text-danger">*</span></label><textarea class="summernote" name="note_description">' + response.note_description + '</textarea><span class="text-danger note-descriptionError"></span></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';
                    $('.updateNoteContent').html(html);

                    $('.summernote').summernote();

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            // alert('hello');

            var serialize = $('#updateNoteForm').serialize();
            // console.log(serialize);

            $.ajax({
                url: "{{ route('backend.updatepartner-note') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#updateNote').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.note-titleError').text(response.responseJSON.errors.note_title);
                    $('.note-descriptionError').text(response.responseJSON.errors.note_description);
                }
            });

        });

        //delete sweetalert
        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            var Id = $(this).attr('href');

            swal({
                    title: "Are you sure?",
                    text: "You want to delete!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Successfully deleted!", {
                            icon: "success",
                        });

                        window.location.href = Id;

                    } else {
                        swal("safe!");
                    }

                });
        });
        
        //delete sweetalert
        $(document).on('click', '#partner-delete', function(e) {
            e.preventDefault();
            var Id = $(this).attr('href');

            swal({
                    title: "Are you sure?",
                    text: "You want to delete!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Successfully deleted!", {
                            icon: "success",
                        });

                        window.location.href = Id;

                    } else {
                        swal("safe!");
                    }

                });
        });


        $('.summernote').summernote({
            callbacks: {
                onChange: function(contents, $editable) {
                    console.log('onChange:', contents, $editable);
                    // $("#textfield4").val(contents); //populate text area
                }
            }
        });
    });
</script>
@endsection