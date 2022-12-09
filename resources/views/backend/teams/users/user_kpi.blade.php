@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
    <a href="{{ url('/usersactive') }}" class="btn btn-outline-primary">  Users List </a>
</h4>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body"> 
                <div class="text-center">
                   
                    <div>
                        <img src="{{ asset('assets/images/users/user-2.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-xl">
                    </div>
                    <h4>{{$user['first_name'].' '.$user['last_name']}}</h4>
                    <div>
                        <a href="#" class=" me-2 left-user-info">
                            <i class="mdi mdi-email-outline mdi-18px"></i>
                        </a> 
                        <a href="#" class=" me-2 left-user-info">
                            <i class="mdi mdi-forum-outline mdi-18px"></i>
                        </a>
                        <a href="{{ route('backend.edit-users',$user['id'])}}" class=" me-2 left-user-info">
                            <i class="mdi mdi-square-edit-outline mdi-18px"></i>
                        </a>
                    </div>
                </div>
                <hr/>
                <h5>PERSONAL INFORMATION:</h5>
                <div class="mb-2">
                  <strong> Offices: </strong>  <a href="#">Change Office</a>
                </div>
                <div class="mb-2">
                  {{$user['office']['office_name']}}
                </div>
                <div class="mb-2">
                <strong> Email:  </strong> {{$user['email']}}
                </div>

                <div class="mb-2">
                  <strong>Phone:   </strong> - {{$user['mobile']}}
                </div>
                <div class="mb-2">
                  <strong> Role: </strong>  Team Leader - {{$user['role']['name']}}
                </div>
                <div class="mb-2">
                  <strong>Position: </strong> Manager - {{$user['position']}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body"> 
                <ul class="nav nav-tabs nav-bordered border-0">
                    <li class="nav-item">
                        <a href="{{route('backend.usersdetails',$user['id'])}}" class="nav-link">
                            Clients 
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('backend.user_datetime',$user['id'])}}" class="nav-link ">
                            Date & Time
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.usersdetails',$user['id'])}}" class="nav-link ">
                            Permission
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.user_kpi',$user['id'])}}" class="nav-link active">
                            KPI
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mb-3 text-end">
           <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#AddNewKPI">Add New KPI</button>
        </div>
        <div class="card">
            <div class="card-body">
                 
            </div>
        </div>
    </div>
</div>

 <!-- Standard modal content -->
 <div id="AddNewKPI" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Set KPI Target</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
          <form id="save_kpi_target">
            <input type="hidden" name="user_id" value="{{$user['id']}}">
            <div class="modal-body">
                 <div class="mb-2">
                     <label>KPI Heading </label>
                     <input type="text" class="form-control" name="kpi_heading">
                     <span class="text-danger" id="error_kpi_heading"></span>
                 </div>
                 <div class="mb-2">
                     <label>KPI Parameter</label>
                     <select class="form-control" name="kpi_perameter">
                         <option value="">Select KPI Parameter</option>
                         <option value="1">Sum of Added Interested Service Value</option>
                         <option value="2">Sum of Application Value</option>
                         <option value="3">Sum of Win Application Value</option>
                         <option value="4"> Sum of Lost Application Value</option>
                     </select>
                     <span class="text-danger" id="error_kpi_perameter"></span>
                 </div>
                 <div class="mb-2">
                     <label>KPI Frequency </label>
                     <select class="form-control kpi_frequency" name="kpi_frequency">
                         <option value="">Select KPI Frequency</option>
                         <option value="1">Certain Period</option>
                         <option value="2">Monthly</option> 
                     </select>
                     <span class="text-danger" id="error_kpi_frequency"></span>
                 </div>
            </div>
            <div class="main_class p-2 mt-2">
                    <label for="">Select Period Target</label>
                    <div class="row">
                        <div class="form-group col-md-6 mt-2">
                              <label for="">Form</label>
                              <input type="date" class="form-control" name="date_form[]">
                              <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>                          
                        </div>
                        <div class="form-group col-md-6 mt-2">
                              <label for="">To</label>
                              <input type="date" class="form-control" name="date_to[]">
                              <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>                          
                        </div>

                        <div class="form-group col-md-6 mt-2">
                              <label for="">Enter Monthly Target</label>
                              <select name="target_currency[]" id="" class="form-control">
                                <option value="">Select Target Currency</option>
                                @foreach($currency as $currencies)
                                    <option value="{{$currencies->currency_code}}">{{$currencies->currency_code}}</option>
                                @endforeach
                              </select>                         
                        </div>

                        <div class="form-group col-md-6" style="margin-top:4%">
                              <input type="number" class="form-control" placeholder="Enter target value for the period" name="target_value[]">                       
                        </div>
                        
                        <div class="add_data_show mt-2">

                        </div>
                        <div class="form-group text-end add_period_target" style="margin-top:4%">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addnewtax"> + Add New Period Target</button>                     
                        </div>
                        
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary set_kpi_target" >Save changes</button>
            </div>
          <form> 
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    $('.main_class').hide();
    $('.add_period_target').hide();

    $('.kpi_frequency').on('change',function(e){
         var kpi_currency=$(this).val();
         if(kpi_currency == 1)
         {
            $('.add_period_target').hide();
            $('.main_class').show();
         }
         if(kpi_currency == 2)
         {
            $('.main_class').show();
            $('.add_period_target').show();
         }  

    });

    $('.add_period_target').click(function(e){
        e.preventDefault();
        var currency=<?php echo json_encode($currency);?>;
       
        var i=0;
        var target_currency=' ';
        for(i=0; i<currency.length; i++)
        {
            target_currency += '<option value="'+currency[i].currency_code+'">'+currency[i].currency_code+'</option>'; 
        }
        //console.log(target_currency);
        $(".add_data_show").append('<div class="row"><div class="form-group col-md-6 mt-2"><label for="">Form</label><input type="date" class="form-control" name="date_form[]"><small>Date must be in YYYY-MM-DD (2012-12-22) format.</small></div><div class="form-group col-md-6 mt-2"><label for="">To</label><input type="date" class="form-control" name="date_to[]"><small>Date must be in YYYY-MM-DD (2012-12-22) format.</small></div><div class="form-group col-md-6 mt-2"><label for="">Enter Monthly Target</label><select name="target_currency[]" id="" class="form-control"><option value="">Select Target Currency</option>'+target_currency+'</select></div><div class="form-group col-md-6" style="margin-top:4%"><input name="target_value[]" type="number" class="form-control" placeholder="Enter target value for the period"></div><div class="col-md-2"><button class="btn btn-sm btn-outline-danger mt-2 removetr"><i class="mdi mdi-delete-outline mdi-10px"></i></button><div></div>');
    });

    $('body').delegate('.removetr', 'click', function() {
			$(this).parent().parent('div').remove();
    });

    $('.set_kpi_target').click(function(e){     
        e.preventDefault();
        var fromData = new FormData(document.getElementById("save_kpi_target"));
            $.ajax({
                url: "{{route('backend.save_kpi_target')}}",
                type: "POST",
                data: fromData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#AddNewKPI').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    //console.log(response);
                    $('#error_kpi_heading').text(response.responseJSON.errors.kpi_heading);
                    $('#error_kpi_perameter').text(response.responseJSON.errors.kpi_perameter);
                    $('#error_kpi_frequency').text(response.responseJSON.errors.kpi_frequency);
                }
            });
    });    
</script>
@endsection

@section('script')
<!-- Datatables init -->
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection