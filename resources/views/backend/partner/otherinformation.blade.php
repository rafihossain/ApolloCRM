@extends('backend.layouts.app')
@section('css')
 
@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
	<a href="{{ url('/partner') }}" class="btn btn-primary">  Partners List </a>
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
    
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap w-100">
                    <thead>         
                        <tr>  
                            <th></th>
                            <th> Title</th>
                            <th>Attachment</th>  
                            <th>Status</th>  
                            <th>Action</th>  
                      
                        </tr>
                    </thead>  
                    <tbody> 
                       
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<!-- Right modal content -->
<div id="addtask" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Create New Task</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Title </label>
                        <input type="text" class="form-control" name="">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Category </label>
                        <select class="form-control">
                            <option>Choose Category</option>
                            <option value="1">Reminder</option>
                            <option value="2">Call</option>
                            <option value="3">Follow Up</option>
                            <option value="4">Email</option>
                            <option value="5">Meeting</option>
                            <option value="6">Support</option>
                            <option value="7">Others</option> 
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Assignee </label>
                        <select class="form-control">
                            <option>Choose Assignee</option>
                            <option value="1">User 1</option>
                            <option value="2">User 2</option>
                            <option value="3">User 3</option> 
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Priority </label>
                        <select class="form-control">
                            <option>Choose Assignee</option>
                            <option value="1">Low</option>
                            <option value="2">Normal</option>
                            <option value="3">High</option> 
                            <option value="4">Urgent</option> 
                        </select>
                    </div> 
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Due Date </label>
                        <input type="text" id="datetime-datepicker" class="form-control" placeholder="Date and Time">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Description </label>
                        <textarea class="form-control" rows="4"></textarea>
                    </div>
                      <div class="col-md-6 mb-2">
                        <label class="form-label">  Attachments:   </label>
                        <input type="file" class="dropify" name="" data-height="90">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Followers </label>
                        <select class="form-control">
                            <option>Choose Assignee</option>
                            <option value="1">User 1</option>
                            <option value="2">User 2</option>
                            <option value="3">User 3</option> 
                        </select>
                    </div>
                  

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save  </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Standard modal content -->
 
@endsection

@section('script')
<!-- Datatables init --> 
 <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
 
 <script>
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
 </script>
@endsection