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
        

        <ul class="nav nav-pills navtab-bg nav-justified">
            <li class="nav-item">
                <a href="#emailconversation" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                    Email
                </a>
            </li>
            <li class="nav-item">
                <a href="#smsconversation" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                    SMS
                </a>
            </li>
       
        </ul>
        <div class="tab-content">
           
            <div class="tab-pane show active" id="emailconversation">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap w-100">
                            <thead>         
                                <tr>  
                                    <th> Title  </th>
                                    <th> Issue Date </th> 
                                    <th> Description </th>  
                                    <th> Actions </th>
                                </tr>
                            </thead>  
                            <tbody> 
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="smsconversation">
                <div class="card">
                    <div class="card-body">
                        <table id="responsive-datatable" class="table table-bordered dt-responsive table-responsive nowrap w-100">
                            <thead>         
                                <tr>  
                                    <th> Title  </th>
                                    <th> Issue Date </th> 
                                    <th> Description </th>  
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
        


    </div>
</div>

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