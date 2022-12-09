@extends('backend.layouts.app')
@section('css')
 
@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
	<a href="{{ route('backend.manage-partner') }}" class="btn btn-primary">  Partners List </a>
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
        <div class="text-end mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcontact">+ Add</button>
        </div>  

        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                    <thead>      
                        <tr>  
                            <th> Invoice No. </th>
                            <th> Issue Date </th> 
                            <th> Service </th>
                            <th> Invoice Amount </th> 
                            <th> Paid amount </th>
                            <th> Status </th>
                            <th> Actions </th>
                        </tr>
                    </thead>  
                    <tbody> 
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Standard modal content -->
<div id="addcontact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Selected Documents</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <input type="file" class="dropify" name="">
                    </div> 
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Datatables init --> 
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.dropify').dropify();
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
</script>
@endsection