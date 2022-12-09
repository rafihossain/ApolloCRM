@extends('backend.layouts.app')
@section('content')

<div class="card">
    <div class="card-body"> 
        <h4 class="m-0 header-title text-end float-end">
            <a href="{{ url('/quotations/createtemplate') }}" class="btn btn-primary">+ Create Template</a>

            <button type="button" class="btn btn-primary" id="addQuatations">+ Create Quotation</button>
        </h4>
        <ul class="nav nav-tabs nav-bordered border-0">
            <li class="nav-item">
                <a href="{{ route('backend.quotations-template-list') }}" class="nav-link">
                    Quotation Templates
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.quotations-active-list') }}" class="nav-link active">
                    Active Quotations
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.quotations-archived-list') }}" class="nav-link">
                    Archived Quotations
                </a>
            </li>
        </ul>
    </div>
</div>

@if(Session::has('success'))
<div class="alert alert-success">
	{{ Session::get('success') }}
</div>
@endif

<div class="card">
	<div class="card-body">  
        <table class="table table-bordered dt-responsive table-responsive nowrap yajra-datatable">
            <thead>
                <tr>                                                            
                    <th>No.</th>
                    <th>Client Name</th>
                    <th>Products</th>
                    <th>Total Fee </th>
                    <th>Status </th>
                    <th>Due Date  </th>
                    <th>Created On</th> 
                    <th>Created By</th> 
                    <th>Actions</th> 
                </tr>
            </thead>  
            <tbody>

            </tbody>
        </table>
	</div>
</div>
<!-- Standard modal content -->
<div id="addQuatationModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addQuatationFrom">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Create Quotation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Choose Client <span class="text-danger">*</span></label>
                        <select class="form-control" name="client_id" id="applicationSelect" data-width="100%"></select>
                        <span class="text-danger" id="clientError"></span>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveQuotation">Create</button>
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
    $(document).ready(function (){
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backend.quotations-active-list') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'client_name', name: 'client_name'},
                {data: 'product_item', name: 'product_item'},
                {data: 'total_fee', name: 'total_fee'},
                {data: 'status', name: 'status'},
                {data: 'due_date', name: 'due_date'},
                {data: 'created_at', name: 'created_at'},
                {data: 'user_name', name: 'user_name'},
                {
                    data: 'action',
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ]
        });

        $('#addQuatations').on("click", function() {
            $('#addQuatationModel').modal("show");
        });

        $("#saveQuotation").click(function(e) {
            e.preventDefault();
            var serialize = $("#addQuatationFrom").serialize();
            $.ajax({
                url: "{{ route('backend.quotations-active-create') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#addQuatationModel').modal("hide");
                    var quotationId = response.quotation_id;
                    window.location.href = "{{ url('admin/quotations/active/edit/') }}"+"/"+quotationId;
                },
            });
        });

        //delete sweetalert
        $(document).on('click', '.archive', function(e) {
            e.preventDefault();
            var Id = $(this).attr('href');

            swal({
                    title: "Are you sure?",
                    text: "You want to archive!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Successfully archived!", {
                            icon: "success",
                        });
                        window.location.href = Id;
                    } else {
                        swal("safe!");
                    }
                });
        });

        //delete sweetalert
        $(document).on('click', '.decline', function(e) {
            e.preventDefault();
            var Id = $(this).attr('href');

            swal({
                    title: "Are you sure?",
                    text: "You want to decline!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Successfully declined!", {
                            icon: "success",
                        });
                        window.location.href = Id;
                    } else {
                        swal("safe!");
                    }
                });
        });


        var clients = <?php echo json_encode($clients); ?>;        
        var clientdata = [];
        for(var i=0; i<clients.length; i++){
            clientdata.push(
                {
                    id:clients[i].id, text:'<div>'+clients[i].first_name+' '+clients[i].first_name+'</div><div><small>'+clients[i].email+'</small></div>'
                }
            );
        }
        
        $("#applicationSelect").select2({
            data: clientdata,
            dropdownParent: $('#addQuatationModel'),
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); },
        });
        
    });
</script>
@endsection