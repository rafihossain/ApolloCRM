@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<div class="card">
  <div class="card-body">
     <ul class="nav nav-tabs nav-bordered border-0"> 
      <li class="nav-item">
          <a href="{{ route('backend.report_personaltask') }}" class="nav-link active">
              Personal Task Report 
          </a>
      </li>
      <li class="nav-item">
          <a href="{{ route('backend.report_personaltask') }}" class="nav-link ">
              Office Task Report
          </a>
      </li>
       
    </ul>
  </div>
</div>
<div class="card">
  <div class="card-body">  
    <table id="datatable_new" class="table table-bordered dt-responsive table-responsive nowrap">
        <thead>
            <tr>        
                <th>Category</th>
                <th>Task Title</th>
                <th>Contact</th>
                <th>Partner</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Status</th>
                <!-- <th>Task Added By</th> -->
                <th>Added Date</th>
                <th>Current Assignee</th>
                <th>Due Date</th>
                <th>Due Time</th>
                <th>Followers</th>
                <th>Related to</th> 
                <!-- <th>Completed Date</th> 
                <th>Completed In (Days)</th> 
                <th>Time Exceeded (Days) </th>  -->

            </tr>
        </thead>  
        <tbody>
             
        </tbody>
    </table>
  </div>
</div>

@endsection

@section('script')
<script>
      $( document ).ready(function() { 

    //    $('.dropify').dropify();
    //    $('.summereditor').summernote();

       var table=$('#datatable_new').DataTable( {
            processing: true,
            serverSide: true,
            // scrollX: true,
            ajax: {
                url: "{{route('backend.report_personaltask')}}",
                type: "get",
                dataType: 'JSON',
            },
            columns: [
                   { data:'task_category.task_name', name:'task_category.task_name'},
                   { data: 'title', name: 'title'},
                   { data: 'full_name', name: 'full_name'},
                   { data: 'partner_name', name: 'partner_name'},
                   { data: 'description', name: 'description'},
                   { data: 'priority', name: 'priority' },
                   { data: 'status', name: 'status'},
                   { data: 'created_at', name: 'created_at'},
                   { data: 'assign.name', name: 'assign.name'},
                   { data: 'due_date', name: 'due_date'},
                   { data: 'due_time', name: 'due_time'},
                   { data: 'follower_name', name: 'follower_name'},
                   { data: 'related', name: 'related' },
            //     { data: 'income_amount', name: 'income_amount'},
            //     { data: 'income_sharing', name: 'income_sharing'},
            //     { data: 'net_income', name: 'net_income'},
            //     { data: 'tax_received', name: 'tax_received'},
            //     { data: 'tax_paid', name: 'tax_paid' },
            //     { data: 'paid_amount', name: 'paid_amount'},
            //     { data: 'due_amount', name: 'due_amount'},
            //     { data: 'last_payment_date', name: 'last_payment_date'}
             ],
       });



    }); 
</script>
<!-- Datatables init --> 
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script> 
@endsection