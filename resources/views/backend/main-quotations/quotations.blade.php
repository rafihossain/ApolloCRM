@extends('backend.layouts.app')
@section('content')
 
<div class="card">
    <div class="card-body"> 
        <h4 class="m-0 header-title text-end float-end">
            <a href="{{ route('backend.quotations-template-add') }}" class="btn btn-primary">+ Create Template</a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcontact">+ Create Template</button>
        </h4>
        <ul class="nav nav-tabs nav-bordered border-0"> 
            <li class="nav-item">
                <a href="{{ route('backend.quotations-template-list') }}" class="nav-link active">
                    Quotation Templates
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.quotations-active-list') }}" class="nav-link">
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
<div class="card">
	<div class="card-body">  
        <table class="table table-bordered dt-responsive table-responsive nowrap yajra-datatable">
            <thead>
                <tr>                                                 
                    <th></th>
                    <th>Template Name</th>
                    <th>Products</th>
                    <th>Total Fee </th>
                    <th>Created By</th>
                    <th>Office</th>
                    <th>Created On</th> 
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
	</div>
</div>

<!-- Standard modal content -->
<div id="addTemplateModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addTemplateFrom">
                <div class="modal-header">
                    <input type="hidden" class="templateid" name="template_id" />
                    <h4 class="modal-title" id="addcontact-modalLabel">Create Template</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Choose Client</label>
                        <select class="form-control" name="client_id" id="Applicationselect" data-width="100%"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTemplate">Create</button>
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

        $(document).delegate('.template', 'click', function (){
            var templateid = $('.templateid').val($(this).data('id'));
            // console.log(templateid);
            $('#addTemplateModel').modal("show");
        });

        $("#saveTemplate").click(function(e) {
            e.preventDefault();
            var serialize = $("#addTemplateFrom").serialize();
            $.ajax({
                url: "{{ route('backend.quotations-template-create') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#addQuatationModel').modal("hide");
                    var templateId = response.template_id;
                    var clientId = response.client_id;
                    window.location.href = "{{ url('admin/quotations/template/use') }}"+"/"+templateId+"/"+clientId;
                },
            });
        });


        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backend.quotations-template-list') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'template_name', name: 'template_name'},
                {data: 'product_item', name: 'product_item'},
                {data: 'total_fee', name: 'total_fee'},
                {data: 'create_by', name: 'create_by'},
                {data: 'office.office_name', name: 'office.office_name'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'action', 
                    name: 'action',
                    orderable: true, 
                    searchable: true
                },
            ]
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
    $("#Applicationselect").select2({
      data: clientdata,
      dropdownParent: $('#addTemplateModel'),
      templateResult: function (d) { return $(d.text); },
      templateSelection: function (d) { return $(d.text); },
    })
</script>
@endsection