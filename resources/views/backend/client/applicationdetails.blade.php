@extends('backend.layouts.app')
@section('css')
  <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />

  <style type="text/css">
      .acmenu{
        display: none;
      }
      #accordion .card-header h5:hover .acmenu{
        display: block;
      }
      #accordion .card-header h5 > a{
        line-height: 22px;
      }
  </style>
@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
    <a href="{{ url('/client') }}" class="btn btn-primary">  Client List </a>
</h4>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body"> 
                @include('backend.client.include.client-sidebar')
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body"> 
                @include('backend.client.include.client-header')
            </div>
        </div>  
        
       <div class="card">
            <div class="card-body">
               <div class="d-flex align-items-center justify-content-between mb-2">
                   <div class="text-primary"><i class="mdi mdi-record"></i> In Progress</div>
                   <div>
                       <button class="btn btn-primary btn-sm"><i class="mdi mdi-printer"></i></button>
                       <button class="btn btn-outline-danger btn-sm"><i class="mdi mdi-close"></i> Discontinue</button>
                       <button class="btn btn-outline-primary btn-sm"><i class="mdi mdi-chevron-left"></i> Back to Previous Stage</button>
                       <button class="btn btn-success btn-sm"> Proceed to Next Stage <i class="mdi mdi-chevron-right"></i></button>
                       
                   </div>
               </div>
               <div class="row mb-2">
                   <div class="col">
                       <div>Course:</div>
                       <div class="text-dark"><small>Bachelors in Software Concepts</small> </div>
                   </div>
                   <div class="col">
                       <div>University:</div>
                       <div class="text-dark"><small>University Of Sydney</small></div>
                   </div>
                   <div class="col">
                       <div>Branch:</div>
                       <div class="text-dark"><small>Head Office</small></div>
                   </div>
                   <div class="col">
                       <div>Workflow:</div>
                       <div class="text-dark"><small>Australian Education</small></div>
                   </div>
                   <div class="col">
                       <div>Current Stage:</div>
                       <div class="text-success"><small>COE</small></div>
                   </div>
               </div>
               <div class="row mb-2">
                   <div class="col">
                       <div>Application Id:</div>
                       <div class="text-dark"><small>1</small></div>
                   </div>
                   <div class="col">
                       <div>Partner's Client Id:</div>
                       <div class="text-dark"><small>-</small></div>
                   </div>
                   <div class="col">
                       <div>Started at:</div>
                       <div class="text-dark"><small>2022-08-31</small></div>
                   </div>
                   <div class="col">
                       <div>Last Updated:</div>
                       <div class="text-dark"><small>2022-09-07</small></div>
                   </div>
                   <div class="col">
                       <div class="text-dark">Overall Progress:</div>
                        <div class="text-success"><small>43 %</small></div>
                   </div>
               </div>
               <div>
                   <button class="btn btn-outline-primary" type="button"  data-bs-toggle="modal" data-bs-target="#viewotherdetails"> View Other Details</button>
               </div>
               <!-- details  -->

               <div class="row border-top border-mute mt-4">
                    <div class="col-md-8 pt-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a href="#Activities" data-bs-toggle="tab" aria-expanded="false" class="nav-link active rounded-pill">
                                    Activities
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#Documents" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-pill">
                                    Documents
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#Notes" data-bs-toggle="tab" aria-expanded="false" id="new_notes" class="nav-link rounded-pill">
                                    Notes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#Tasks" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-pill">
                                    Tasks
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#PaymentSchedule" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-pill">
                                    Payment Schedule
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="Activities"> 
                                <div id="accordion" class="mb-3">
                                     @foreach($lists as $list)
                                    <div class="card mb-1">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="m-0 d-flex align-items-center">
                                                <a class="text-dark" data-bs-toggle="collapse" href="#col_{{ $list['id'] }}" aria-expanded="true">
                                                  {{ $list['category_name'] }}
                                                </a>
                                                
                                                <div class="ms-auto acmenu">
                                                    <a href="javascript:;" class="addnote" applicaion_id="{{ $applications->id }}" client_id="{{ $client->id }}" collection_id="{{ $list['id'] }}" title="Add Note" ><i class="mdi mdi-file-document-outline mdi-18px"></i></a>
                                                    <a href="javascript:;" class="addDocuments" applicaion_id="{{ $applications->id }}" client_id="{{ $client->id }}" collection_id="{{ $list['id'] }}" title="Add Documents"><i class="mdi mdi-file-plus-outline mdi-18px"></i></a>
                                                    <a href="javascript:;" class="addAppointment" applicaion_id="{{ $applications->id }}" client_id="{{ $client->id }}" collection_id="{{ $list['id'] }}" title="Add Appointments"><i class="mdi mdi-calendar-outline  mdi-18px"></i></a>
                                                    <a href="javascript:;" class="newEmail" applicaion_id="{{ $applications->id }}" client_id="{{ $client->id }}" collection_id="{{ $list['id'] }}" title="Email"><i class="mdi mdi-email-outline  mdi-18px"></i></a> 
                                                </div>
                                            </h5>
                                        </div>
                            
                       
                                        <div id="col_{{ $list['id'] }}" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                
                                             @foreach($list['notes'] as $notes)
                                                <?php
                                                $note = json_decode($notes['info_value']);
                                                
                                                ?>
                                            
                                            <div class="d-flex mb-2">
                                                <div>
                                                   <i class="mdi mdi-file-document-outline mdi-18px text-primary"></i> <strong>Afiqur Rahman</strong><small> added a note</small>
                                                </div>
                                                <div class="ms-auto">
                                                    <small>
                                                        <!--08 Thu, Sep 2022 11:05 AM-->
                                                    
                                                     {{ date('h:i:sa d-m-Y', strtotime($notes['created_at'])) }}
                                                    </small>
                                                </div> 
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                       <h6>{{ $note->title }}</h6>
                                                       <p>{!! $note->description !!}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                            
                                              @foreach($list['documentations'] as $documentation)
                                                <?php
                                                 $values = json_decode($documentation['info_value']);
                                                  ?>
                                            <div class="d-flex mb-2">
                                                <div>
                                                   <i class="mdi mdi-file-document-outline mdi-18px text-primary"></i> <strong>Afiqur Rahman</strong><small> added a note</small>
                                                </div>
                                                <div class="ms-auto">
                                                    <small>
                                                      {{ date('h:i:sa d-m-Y', strtotime($documentation['created_at'])) }}
                                                    </small>
                                                </div> 
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                        <p><a href="{{ url('/') }}/{{ $values->file_path }}/{{ $values->file_name }}" download>{{ $values->file_name }}</a></p>
                                                </div>
                                            </div>  
                                                  
                                              @endforeach
                                            
                                            </div>
                                        </div>
                                        </div>
                                        @endforeach
                                 
                                </div> <!-- end #accordions-->
                                
                            </div>
                            <div class="tab-pane" id="Documents">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <table id="datatabledoc" class="table table-bordered dt-responsive  nowrap">
                                            <thead>
                                                <tr>      
                                                    <th> FILENAME / CHECKLIST </th>
                                                    <th> RELATED </th> 
                                                    <th> ADDED BY  </th>
                                                    <th> ADDED ON </th> 
                                                    <th> ACTION </th>
                                                </tr>
                                            </thead>  
                                            <tbody> 
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" id="Notes">
                                <div id="notesItems" class="row">
                                    
                            
                                
                                </div>
                            </div>
                            <div class="tab-pane" id="Tasks">
                                <div id="accordion" class="mb-3">
                                        @foreach($lists as $list)
                                    <div class="card mb-1">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="m-0 d-flex align-items-center">
                                                <a class="text-dark taskItems" type="{{ $list['id']}}" data-bs-toggle="collapse" href="#cols_{{ $list['id'] }}" aria-expanded="true">
                                                  {{ $list['category_name'] }} <span class="approve_task">0</span> / <span class="submited_task">0</span>
                                                </a>
                                                
                                                <div class="ms-auto acmenu">
                                                    <a href="javascript:;" title="Create New Task"  applicaion_id="{{ $applications->id }}" client_id="{{ $client->id }}" collection_id="{{ $list['id'] }}" class="CreateNewTask"  ><i class="mdi mdi-briefcase-variant-outline mdi-18px"></i></a>
                                                    
                                                </div>
                                            </h5>
                                        </div>
                            
                                        <div id="cols_{{ $list['id'] }}" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                            <div class="card-body table-responsive"> 
                                            <table id="datatabletask_{{ $list['id'] }}" class="table table-bordered dt-responsive  nowrap">
                                                <thead >
                                                    <tr> 
                                                        <th>Category</th>
                                                        <th>Comments</th>
                                                        <th>Attachments</th>
                                                        <th>Assignee</th>
                                                        <th>Priority</th>
                                                        <th>Due Date/Time</th>
                                                        <th>Status</th>  
                                                    </tr>
                                                </thead>  
                                                <tbody> 
                                                   
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                     @endforeach
                                 </div>
                            </div>
                            <div class="tab-pane" id="PaymentSchedule">
                                <div class="row ">
                                    <div class="col-md-6 border border-1 p-1">
                                        <div class="row">
                                            <div class="col">
                                                <div><small>Scheduled</small></div>
                                                <h5>0.00</h5>
                                            </div>
                                            <div class="col">
                                                <div><small>Invoiced</small></div>
                                                <h5>10.00</h5>
                                            </div>
                                            <div class="col">
                                                <div><small>Pending</small></div>
                                                <h5>0.00</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <button class="btn btn-primary me-1"  data-bs-toggle="modal" data-bs-target="#AddPaymentSchedule">+ Add Schedule</button>
                                        <select class="form-control">
                                            <option value="1"> Email Schedule</option>
                                            <option value="2">  Preview Schedule</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="mt-2 table-responsive">
                                                    
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap">
                                        <thead>
                                            <tr> 
                                                <th>id</th>
                                                <th>Installment</th>
                                                <th>Fee Type</th>
                                                <th>Fee</th>
                                                <th>Total Fees</th>
                                                <th>Discounts</th>
                                                <th>Invoicing</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>  
                                        <tbody>
                                            <tr>
                                                <td>3</td>
                                                <td>
                                                    <div class="text-primary">Semester 1</div>
                                                    <div>2022-09-10</div>
                                                    <div><span class="badge rounded-pill bg-info">Non-Claimable</span></div>
                                                </td>
                                                <td>Tuition Fee</td>
                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>2022-09-10</td>
                                                <td><span class="badge rounded-pill bg-primary">Invoiced</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-success">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-info">
                                                        <i class="mdi mdi-clipboard-text-outline"></i>
                                                    </a>
                                                    
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="mdi mdi-delete-outline"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 border-start border-mute pt-2">
                        <div class="mb-2">
                            <label  class="form-label ">Applied Intake</label>
                            <input type="" class="form-control basic-datepicker" name="" placeholder="Select Date..">
                            <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>
                        </div>
                        <div class="mb-2">
                            <label  class="form-label ">Start to End</label>
                            <input type="" placeholder="Select Date.." class="form-control basic-daterangepicker" name="">
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-outline-primary" type="button"  data-bs-toggle="modal" data-bs-target="#setuppaymentschedule"> + Setup Payment Schedule</button>
                        </div>
                        <hr/>
                        <h5 class="d-flex align-items-center">Product Fees <span class="badge rounded-pill bg-success">AUD</span> <a class="ms-auto" href="javascript:;" ><i class="mdi mdi-square-edit-outline mdi-18px" data-bs-toggle="modal" data-bs-target="#productfees"></i></a></h5>

                        <div class="d-flex">
                            <div class=""> Total Fee </div>
                            <div class="ms-auto"> 0.00 </div>
                        </div>
                        <div class="d-flex text-danger">
                            <div class=""> Discount</div>
                            <div class="ms-auto"> 0.00 </div>
                        </div>
                        <div class="d-flex text-primary">
                            <div class=""> Net Fee </div>
                            <div class="ms-auto"> 0.00 </div>
                        </div>

                        <hr/>
                        <h5 class="d-flex align-items-center">Sales Forecast<span class="badge rounded-pill bg-success">AUD</span> <a class="ms-auto" href="javascript:;" ><i class="mdi mdi-square-edit-outline mdi-18px" data-bs-toggle="modal" data-bs-target="#SalesForecast"></i></a></h5>

                        <div class="d-flex">
                            <div class=""> Partner Revenue </div>
                            <div class="ms-auto"> 0.00 </div>
                        </div>
                        <div class="d-flex">
                            <div class=""> Client Revenue </div>
                            <div class="ms-auto"> 0.00 </div>
                        </div>
                        <div class="d-flex text-danger">
                            <div class=""> Discount</div>
                            <div class="ms-auto"> 0.00 </div>
                        </div>
                        <div class="d-flex text-primary">
                            <div class=""> Net Revenue </div>
                            <div class="ms-auto"> 0.00 </div>
                        </div>
                        <hr/>
                        <h5>Expected Win Date:</h5>
                        <input type="text" class="form-control basic-datepicker" name="">
                        <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ApplicationOwnershipRatio">View Application Ownership Ratio</button>
                        <hr/>
                        <h5>Started By:</h5>
                        <div class="overflow-hidden mb-2">
                            <div class="float-start me-2">
                                <img src="{{ asset('assets/images/users/user-4.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
                            </div>
                            <div>
                                <div class="text-truncate">
                                     <small class="text-primary">
                                    Nikesh Demo Shrestha
                                    </small>
                                </div>
                                <div class="text-truncate">
                                    <small>nikesh.shrestha@mymail.com</small>
                                </div>
                            </div>
                        </div> 
                        <hr/>
                        <h5 class="d-flex align-items-center">Assignees: <button class="btn btn-light btn-sm ms-auto"> +Add </button> </h5>
                        <div class="overflow-hidden mb-2">
                            <div class="float-end"><i class="mdi mdi-close"></i></div>
                            <div class="float-start me-2">
                                <img src="{{ asset('assets/images/users/user-4.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
                            </div>
                            <div>
                                <div class="text-truncate">
                                     <small class="text-primary">
                                    Nikesh Demo Shrestha
                                    </small>
                                </div>
                                <div class="text-truncate">
                                    <small>nikesh.shrestha@mymail.com</small>
                                </div>
                            </div>
                        </div> 
                        <div class="overflow-hidden mb-2">
                            <div class="float-end"><i class="mdi mdi-close"></i></div>
                            <div class="float-start me-2">
                                <img src="{{ asset('assets/images/users/user-4.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
                            </div>
                            <div>
                                <div class="text-truncate">
                                     <small class="text-primary">
                                    Nikesh Demo Shrestha
                                    </small>
                                </div>
                                <div class="text-truncate">
                                    <small>nikesh.shrestha@mymail.com</small>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <h5 class="d-flex align-items-center">Super Agent: <button class="btn btn-light btn-sm ms-auto"> +Add </button> </h5> 
                        <div class="overflow-hidden mb-2">
                            <div class="float-end"><i class="mdi mdi-close"></i></div>
                            <div class="float-start me-2">
                                <img src="{{ asset('assets/images/users/user-4.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
                            </div>
                            <div>
                                <div class="text-truncate">
                                     <small class="text-primary">
                                    Nikesh Demo Shrestha
                                    </small>
                                </div>
                                <div class="text-truncate">
                                    <span class="badge bg-success rounded-pill">business</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5 class="d-flex align-items-center">Sub Agent: <button class="btn btn-light btn-sm ms-auto"> +Add </button> </h5> 
                        <div class="overflow-hidden mb-2">
                            <div class="float-end"><i class="mdi mdi-close"></i></div>
                            <div class="float-start me-2">
                                <img src="{{ asset('assets/images/users/user-4.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
                            </div>
                            <div>
                                <div class="text-truncate">
                                     <small class="text-primary">
                                   Saphire Migration
                                    </small>
                                </div>
                                <div class="text-truncate">
                                    <span class="badge bg-success rounded-pill">business</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> 
            </div>
       </div>
      
        
    </div>
</div>

<!-- Standard modal content -->
<div id="viewotherdetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Other Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="mdi mdi-file-document-outline mdi-48px"></i>
                    <h6>Looks like you haven't createdany records yet.</h6> 
                <a href="#">Create one.</a>
                </div>
            </div> 
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- setup payment schedule -->
<div id="setuppaymentschedule" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Payment Schedule Setup </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5">
                        <label>Installment Start Date </label>
                        <input type="text" class="form-control basic-datepicker" name="" placeholder="Select Date">
                        <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>
                    </div>
                    <div class="col-3">
                        <label>Installment</label>
                        <input type="Number" class="form-control" name="">
                    </div>
                    <div class="col-4">
                        <label>Interval </label>
                        <select class="form-control">
                            <option>Select interval</option>
                            <option value="1">Day</option>
                            <option value="2">Week</option>
                            <option value="3">Month</option>
                            <option value="4">Year</option>
                        </select>
                    </div>
                </div>
                <hr/>
                <h5>Setup Invoice Scheduling</h5>
                <div><small><i>Schedule your Invoices by selecting an Invoice date for this installment.</i></small></div>
                <div class="row">
                    <div class="col-6">
                        <label>First Invoice Date</label>
                        <input type="text" class="form-control basic-datepicker" placeholder="Select Date" name="">
                    </div>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Create Schedule</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Add Schedule -->
<div id="AddPaymentSchedule" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
               <form method="POST" action="{{ route('backend.application-add-note') }}" >
                @csrf
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Add Payment Schedule  </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              
                <div class="row">
                    <div class="mb-2 col-12"><small> <i class="mdi mdi-information-outline"></i> <em>You can add up to 10 fee items. </em></small> </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">Client Name</label>
                        <input type="text" class="form-control" value="Jeel Patel" name="" disabled="">
                    </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">Application</label>
                        <input type="text" class="form-control" value="Master of Business Administration (Global)" name="" disabled="">
                    </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">Installment Name</label>
                        <input type="text" class="form-control" value="" name="" >
                    </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">Installment Date</label>
                        <input type="text" class="form-control basic-datepicker" placeholder="Select Date" value="" name="" >
                        <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>
                    </div>
                    <div class="col-5">
                        <label>Installment Start Date </label>
                        <input type="text" class="form-control basic-datepicker" name="" placeholder="Select Date">
                        <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>
                    </div>
                    <div class="col-3">
                        <label>Installment</label>
                        <input type="Number" class="form-control" name="">
                    </div>
                    <div class="col-4">
                        <label>Interval </label>
                        <select class="form-control">
                            <option>Select interval</option>
                            <option value="1">Day</option>
                            <option value="2">Week</option>
                            <option value="3">Month</option>
                            <option value="4">Year</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-baseline">
                        <thead>
                            <tr>
                                <th>Fee Type</th>
                                <th>Fee Amount</th> 
                                <th>Commission %</th>
                            </tr>
                        </thead>
                       <tbody  id="wrapperfee">
                            <tr class="w-100">
                               <td>
                                   <button type="button" class="btn btn-sm btn-outline-primary addmorefee">+ Add  Fee</button>
                               </td>
                           </tr>
                           <tr class="morefeecol">
                               <td>
                                  <div class="mb-2 paymentfeetype">
                                    
                                    <select class="form-control selectfee2"   data-width="100%" placeholder="Choose Fee Type">
                                        
                                        <option value="1">  Accommodation Fee</option>
                                        <option value="2"> Administration Fee</option>
                                        <option value="3"> Airline Ticket</option>
                                        <option value="4"> Airport Transfer Fee
                                        </option>
                                        <option value="5">Application Fee</option>
                                        <option value="6">Bond</option>
                                        <option value="7">Exam Fee</option>
                                        <option value="8">Date Change Fee</option>
                                        <option value="9">Extension Fee</option>
                                        <option value="10">Extra Fee</option>
                                        <option value="11">FCE Exam Fee</option>
                                        <option value="12">Health Cover</option>
                                    </select>
                                </div>
                               </td>

                               <td>
                                    <div class="mb-2">
                                         
                                        <input type="number" class="form-control" name="" placeholder="00">
                                    </div>
                               </td>  
                            
                               <td>
                                   <div class="mb-2"> 
                                       <input type="number" name="" value="00" class="form-control">
                                   </div>
                               </td>
                               <td>
                                   <button class="btn btn-sm btn-outline-danger btnRemove">
                                       <i class="mdi mdi-delete-outline  "></i>
                                   </button>
                               </td>
                           </tr> 
                          
                          
                       </tbody>
                       <tfoot>
                         <tr>
                               <td>
                                    <div class="mb-2"> 
                                        <input type="text" class="form-control" name="" value="Discount" disabled="">
                                    </div>
                               </td>
                               <td>
                                    <div class="mb-2"> 
                                        <input type="number" class="form-control" name="" value="00" >
                                    </div>
                               </td>
                               <td>
                                    <div class="mb-2"> 
                                        <input type="number" class="form-control" name="" value="00" disabled="" >
                                    </div>
                               </td>
                               <td></td>
                           </tr>
                           <tr>
                               
                               <td></td>
                               <td><h4 class="text-primary">Total Fee (AUD) <br> 20.00</h4> </td>
                               <td>Net Fee<br> 10.00</td>
                               <td></td>
                               
                           </tr>
                       </tfoot>
                    </table> 
                </div>
                <hr/>
                <h5>Setup Invoice Scheduling</h5>
                <div><small><em><i class="mdi mdi-information-outline"></i> Schedule your Invoices by selecting an Invoice date for this installment.</em></small></div>
                
                <div class="row mb-2">
                    <div class="col-6">
                        <label class="form-label">Invoice Date</label>
                        <input type="text" class="form-control basic-datepicker" placeholder="Select Date" name="">
                        <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>
                    </div>
                </div>
                <div class="mb-2"> 
                     <div class="form-check">
                         <input type="checkbox" class="form-check-input"  name="" id="AutoInvoicing">
                         <label for="AutoInvoicing" class="form-check-label" >Auto Invoicing</label>
                        
                     </div>
                     <div><small><em><i class="mdi mdi-information-outline"></i> Enabling Auto Invoicing will automatically create unpaid invoices at above stated Invoice Date.</em></small></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label >Invoice Type</label>
                            <select class="form-control">
                                <option value="1"> Net Claim</option>
                                <option value="2">  Gross Claim </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--  product fees -->
<div id="productfees" class="modal  fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Edit Fee Option</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Fee Option Name </label>
                        <input type="text" class="form-control" name="" placeholder="Default Fee"  disabled=""> 
                    </div>
                    <div class="col-md-4">
                        <label>Country of Residency </label>
                        <input type="text" class="form-control" name="" placeholder="All countries"  disabled=""> 
                    </div>
                    <div class="col-md-4">
                        <label>Installment Type</label>
                        <select class="form-control">
                            <option value="1">Full Fee</option>
                            <option value="2">Per Year</option>
                            <option value="3"> Per Month</option>
                            <option value="4">Per Term</option>
                            <option value="5">Per Trimester</option>
                            <option value="6">Per Semester</option>
                            <option value="7">Per Week</option>
                            <option value="8">Installment</option>
                        </select>
                    </div> 
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table align-baseline">
                            <thead>
                                <tr>
                                    <th>Fee Type</th>
                                    <th>Per Month Amount</th>
                                    <th>No. of Month</th>
                                    <th>Total Fee</th>
                                    <th>Claimable Month</th>
                                    <th>Commission %</th>
                                </tr>
                            </thead>
                           <tbody  id="wrapperfee">
                                <tr class="w-100">
                                   <td>
                                       <button type="button" class="btn btn-sm btn-outline-primary addmorefee">+ Add  Fee</button>
                                   </td>
                               </tr>
                               <tr class="morefeecol">
                                   <td>
                                      <div class="mb-2">
                                        
                                        <select class="form-control select2"   data-width="100%" placeholder="Choose Fee Type">
                                            
                                            <option value="1">  Accommodation Fee</option>
                                            <option value="2"> Administration Fee</option>
                                            <option value="3"> Airline Ticket</option>
                                            <option value="4"> Airport Transfer Fee
                                            </option>
                                            <option value="5">Application Fee</option>
                                            <option value="6">Bond</option>
                                            <option value="7">Exam Fee</option>
                                            <option value="8">Date Change Fee</option>
                                            <option value="9">Extension Fee</option>
                                            <option value="10">Extra Fee</option>
                                            <option value="11">FCE Exam Fee</option>
                                            <option value="12">Health Cover</option>
                                        </select>
                                    </div>
                                   </td>

                                   <td>
                                        <div class="mb-2">
                                             
                                            <input type="number" class="form-control" name="" placeholder="00">
                                        </div>
                                   </td>
                                   <td>
                                       <div class="mb-2">
                                            
                                            <input type="number" class="form-control" name="" value="1">
                                        </div>
                                   </td>
                                   <td>
                                        <div class="mb-2">
                                            
                                            <div>0.00</div>
                                        </div>
                                   </td>
                                   <td>
                                        <div class="mb-2"> 
                                        <input type="number" class="form-control" name="">
                                    </div>
                                   </td>
                                   <td>
                                       <div class="mb-2"> 
                                           <input type="number" name="" value="00" class="form-control">
                                       </div>
                                   </td>
                                   <td>
                                       <button class="btn btn-sm btn-outline-danger btnRemove">
                                           <i class="mdi mdi-delete-outline  "></i>
                                       </button>
                                   </td>
                               </tr> 
                              
                           </tbody>
                           <tfoot>
                               <tr>
                                   <td></td>
                                   <td></td>
                                   <td>Net Total</td>
                                   <td class="text-primary">231.00</td>
                                   <td></td>
                                   <td></td>
                               </tr>
                           </tfoot>
                        </table> 
                       </div>
                    </div>
                </div> 
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--  Sales Forecast -->
<div id="SalesForecast" class="modal  fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Sales Forecast</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Client Revenue</label>
                        <input type="number" class="form-control" name="" placeholder="00"   > 
                    </div>
                    <div class="col-md-4">
                        <label>Partner Revenue</label>
                        <input type="number" class="form-control" name="" placeholder="00"  > 
                    </div>
                    <div class="col-md-4">
                        <label>Discounts</label>
                        <input type="number" class="form-control" name="" placeholder="00"  >
                    </div> 
                    
                </div> 
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--  Application Ownership Ratio -->
<div id="ApplicationOwnershipRatio" class="modal  fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Application Ownership Ratio</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Navpreet Kour</label>
                        <input type="number" class="form-control" name="" placeholder="00" value="100"   > 
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Saleh Ahmed</label>
                        <input type="number" class="form-control" name="" placeholder="00"  value="0"> 
                    </div>                    
                    <div class="col-md-12">
                        <label class="form-label">Sanot Saha</label>
                        <input type="number" class="form-control" name="" placeholder="00"  value="0"> 
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Marzia Sultana</label>
                        <input type="number" class="form-control" name="" placeholder="00"  value="0"> 
                    </div>
                    
                    
                </div> 
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--  Add New Note -->
<div id="addnote" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('backend.application-add-note') }}" >
                @csrf
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Add New Note</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Title</label>
                        <input type="hidden" class="form-control applicaion_id" name="applicaion_id"> 
                        <input type="hidden" class="form-control client_id" name="client_id"> 
                        <input type="hidden" class="form-control collection_id" name="collection_id" > 
                        <input type="text" class="form-control" name="addnote_title" placeholder=""> 
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                       <textarea class="summereditor" name="addnote_description" rows="3"></textarea>
                    </div>   
                </div> 
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 
 <!-- Add documents -->
<div id="AddDocuments" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('backend.application-add-documentation') }}" enctype="multipart/form-data">
                     @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Selected Documents</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <input type="hidden" class="form-control applicaion_id" name="applicaion_id"> 
                        <input type="hidden" class="form-control client_id" name="client_id"> 
                        <input type="hidden" class="form-control collection_id" name="collection_id" > 
                        <input type="file" class="dropify" name="application_file">
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
<!-- Add Appointment  modal -->
<div id="AddAppointment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
              <form method="POST" action="{{ route('backend.application-add-appointment') }}">
                  @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add Appointment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-2">
                                <label class="form-label">Related to:</label> 
                                <input type="hidden" class="form-control applicaion_id" name="applicaion_id"> 
                                <input type="hidden" class="form-control client_id" name="client_id"> 
                                <input type="hidden" class="form-control collection_id" name="collection_id" > 
                                <div class="d-flex">
                                    <div class="form-check me-2">

                                        <input type="radio" id="customRadio1" name="customRadio" value="client" class="form-check-input">
                                        <label class="form-check-label" for="customRadio1">Client</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" id="customRadio2" name="customRadio" value="patner" class="form-check-input">
                                        <label class="form-check-label" for="customRadio2">Partner</label>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Added by:</label>
                            <p class="mb-0">User name</p>
                        </div>
                    </div>
                     
                    <div class="mb-2">
                        <label class="form-label">Partner Name</label>
                        <input type="text" class="form-control" name="client_name">
                    </div>  
                    <div class="row">
                        <div class="col-7">
                            <div class="mb-2">
                                <label class="form-label">Date</label>
                                 <input type="text" id="basic-datepicker" name="date_time_date" class="form-control"  placeholder="Select Date ">
                                <p><small>Date must be in YYYY-MM-DD (2012-12-22) format.</small></p>
                            </div>  
                        </div>
                        <div class="col-5">
                            <div class="mb-2">
                                <label class="form-label">Time</label>
                                <input type="text" id="basic-timepicker" class="form-control" name="date_time_time"> 
                            </div> 
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Invitees</label>
                        <input type="text" class="form-control" name="invitees">
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
<!-- Add Appointment  modal -->
<div id="NewEmail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST" action="{{ route('backend.application-send-mail') }}" enctype="multipart/form-data">
               @csrf
               <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Compose Email</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> 
                    <div class="mb-2">
                        <label class="form-label">From</label>
                        <input type="hidden" class="form-control applicaion_id" name="applicaion_id"> 
                        <input type="hidden" class="form-control client_id" name="client_id"> 
                        <input type="hidden" class="form-control collection_id" name="collection_id" > 
                        <input type="email"  class="form-control" name="from_mail" >
                    </div>
                    <div class="mb-2">
                        <label class="form-label">To</label>
                        <select class="form-control" id="applicationto" multiple="multiple" name="to_mail[]" data-width="100%"></select>
                    </div> 
                    <div class="mb-2">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="send_individual_mail" id="SendIndividual">
                          <label class="form-check-label" for="SendIndividual">
                            Send Individual
                          </label>
                        </div>
                        <small>Placeholders will only work when send individual option is enabled.</small>
                    </div> 
                    <div class="mb-2">
                        <label class="form-label">CC</label>
                        <select class="form-control" id="applicationcc" name="cc_mail" multiple="multiple" data-width="100%"></select>
                    </div> 
                    <div class="mb-2">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" name="subject">
                    </div> 
                    <div class="mb-2">
                        <label class="form-label">Message</label>
                        <textarea class="summereditor" name="message" rows="4" cols="50"></textarea>
                    </div> 
                    <div class="mb-2">
                        <label class="form-label">Attachment</label>
                        <input type="file" name="attachment" class="dropify">
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
<!-- Create New Task modal -->
<div id="CreateNewTask" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
              <form id="taskFrom" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Create New Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <input type="hidden" class="form-control applicaion_id" name="applicaion_id"> 
                       <input type="hidden" class="form-control collection_id" name="collection_id" > 
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title">
                            <span class="text-danger" id="titleError"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-control" name="category_id">
                                <option value="">Choose Category</option>
                                @foreach($taskCategories as $taskCategory)
                                <option value="{{ $taskCategory->id }}">{{ $taskCategory->task_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="categoryError"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Assignee</label>
                            <select class="form-control" name="assigee_id">
                                <option value="">Choose Assignee</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{$user->first_name.' '.$user->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Priority</label>
                            <select class="form-control" name="priority_id">
                                <option value="">Choose Assignee</option>
                                @foreach($priorityCategories as $priorityCategory)
                                <option value="{{ $priorityCategory->id }}">{{ $priorityCategory->priority_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Due Date</label>
                            <input type="text" id="datetime-datepicker" class="form-control" placeholder="Date and Time" name="due_date">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="4" name="description"></textarea>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Attachments:</label>
                            <input type="file" class="dropify" name="attachment" data-height="90">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Followers</label>
                            <select class="form-control" name="follower_id">
                                <option value="">Choose Assignee</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{$user->first_name.' '.$user->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="">Choose Status</option>
                                <option value="1">To Do</option>
                                <option value="2">In Progress</option>
                                <option value="3">On Review</option>
                                <option value="4">Complete</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTask">Save</button>
                </div>
            </form>
            
           
            <!--<form>-->
            <!--    <div class="modal-header">-->
            <!--        <h4 class="modal-title" id="addcontact-modalLabel">Create New Task</h4>-->
            <!--        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
            <!--    </div>-->
            <!--    <div class="modal-body"> -->
            <!--        <div class="mb-2">-->
            <!--            <label class="form-label">Title</label>-->
            <!--            <input type="hidden" class="form-control applicaion_id" name="applicaion_id"> -->
            <!--            <input type="hidden" class="form-control client_id" name="client_id"> -->
            <!--            <input type="hidden" class="form-control collection_id" name="collection_id" > -->
            <!--            <input type="text" class="form-control" name=""  >-->
            <!--        </div>-->
            <!--        <div class="mb-2">-->
            <!--            <label class="form-label">Category</label>-->
            <!--            <select class="form-control">-->
            <!--                <option>Choose Category</option>-->
            <!--                <option value="1">Reminder</option>-->
            <!--                <option value="2">Call</option>-->
            <!--                <option value="3">Follow Up</option>-->
            <!--                <option value="4">Email</option>-->
            <!--                <option value="5">Meeting</option>-->
            <!--                <option value="6">Support</option>-->
            <!--                <option value="7">Others</option>-->
            <!--            </select>-->
            <!--        </div> -->
            <!--        <div class="mb-2">-->
            <!--            <label class="form-label">Assignee</label>-->
            <!--            <select class="form-control" id="taskAssignee" data-width="100%"></select>-->
            <!--        </div> -->
            <!--        <div class="mb-2">-->
            <!--            <label class="form-label">Priority</label>-->
            <!--            <select class="form-control">-->
            <!--                <option> Choose Priority </option>-->
            <!--                <option value="1">Low</option>-->
            <!--                <option value="2">Normal</option>-->
            <!--                <option value="3">High</option>-->
            <!--                <option value="4">Urgent</option> -->
            <!--            </select>-->
            <!--        </div>-->
               
                     
            <!--        <div class="mb-2">-->
            <!--            <label class="form-label">Due Date/Time</label>-->
            <!--            <input type="text" class="form-control basic-datetimepicker" name="">-->
            <!--            <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>-->
            <!--        </div> -->
            <!--        <div class="mb-2">-->
            <!--            <label class="form-label">Description</label>-->
            <!--            <div class="summereditor"></div>-->
            <!--        </div> -->
            <!--        <div class="mb-2" id="Followers">-->
            <!--            <label class="form-label">Followers</label>-->
            <!--            <select class="form-control" multiple="multiple" id="taskFollowers" data-width="100%"></select>-->
            <!--        </div>-->
            <!--         <div class="mb-2">-->
            <!--            <label class="form-label">Attachment</label>-->
            <!--            <input type="file" class="dropify" name="">-->
            <!--        </div> -->
                
            <!--    </div>-->
            <!--    <div class="modal-footer">-->
            <!--        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>-->
            <!--        <button type="submit" class="btn btn-primary">Create</button>-->
            <!--    </div>-->
            <!--</form>-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

AddSchedule

@endsection

@section('script')
<!-- Datatables init --> 
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.multifield.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#new_notes').on('click',function(){
          $.ajax({
               type:'GET',
               url:"{{ route('backend.application-notes',['aid'=> $applications->id,'client_id'=> $client->id ]) }}",
               dataType: "html",
               success:function(data) {
                   //console.log(data);
                $("#notesItems").html(data);
               }
            });   
        })
        
        $('.CreateNewTask').on('click',function(){
            var applicaion_id = $(this).attr('applicaion_id');
            var client_id = $(this).attr('client_id');
            var collection_id =  $(this).attr('collection_id');
            $('.applicaion_id').val(applicaion_id);
            $('.client_id').val(client_id);
            $('.collection_id').val(collection_id);
            $('#CreateNewTask').modal('show')
        })
        //
        $('.taskItems').on('click',function(){
            var id = $(this).attr('type');
            var aid = '{{ $applications->id }}';
            var client_id = '{{  $client->id }}';
            $('#datatabletask_'+id).dataTable().fnClearTable();
            $('#datatabletask_'+id).dataTable().fnDestroy();
            var ntable = $('#datatabletask_'+id).DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/') }}/admin/application-catewise-task/"+aid+"/"+client_id+"/"+id,
            columns: [
            {data: 'category', name: 'category'},
            {data: 'comments', name: 'comments'},
            {data: 'attachments', name: 'attachments'},
            {data: 'assignee', name: 'assignee'},
            {data: 'priority', name: 'priority'},
            {data: 'due-date', name: 'due-date'},
            {data: 'status', name: 'status'}
            ]
            });
           
        })
            
             $("#saveTask").click(function(e) {
            e.preventDefault();
            var fromData = new FormData(document.getElementById("taskFrom"));
            $.ajax({
                url: "{{ route('backend.application-addclient-task',['aid'=> $applications->id,'client_id'=> $client->id ]) }}",
                type: "POST",
                data: fromData,
                cache:false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    //$('#addTaskModal').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    // console.log(response);
                   $('#titleError').text(response.responseJSON.errors.title);
                    $('#categoryError').text(response.responseJSON.errors.category_id);
                }
            });

        });

        // $('.editTaskModel').on("click", function() {

        //     $('#updateTask').modal("show");
        //     var taskId = $(this).data('id');
        //     var clientId = $(this).data('client');
        //     // console.log(contactId);

        //     $.ajax({
        //         url: "{{ route('backend.editclient-task') }}",
        //         type: "POST",
        //         data: {
        //             task_id: taskId,
        //             client_id: clientId,
        //         },
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         dataType: 'json',
        //         success: function(response) {

        //             var users = '';
        //             for(var i = 0; i < response.users.length; i++){
        //                 if(response.task.assigee_id == response.users[i].id){
        //                     users += '<option value="'+response.users[i].id+'" selected>'+response.users[i].first_name+' '+response.users[i].last_name+'</option>';
        //                 }else{
        //                     users += '<option value="'+response.users[i].id+'">'+response.users[i].first_name+' '+response.users[i].last_name+'</option>';
        //                 }
        //             }
        //             var taskcategories = '';
        //             for(var i = 0; i < response.taskcategories.length; i++){
        //                 if(response.task.category_id == response.taskcategories[i].id){
        //                     taskcategories += '<option value="'+response.taskcategories[i].id+'" selected>'+response.taskcategories[i].task_name+'</option>';
        //                 }else{
        //                     taskcategories += '<option value="'+response.taskcategories[i].id+'">'+response.taskcategories[i].task_name+'</option>';
        //                 }
        //             }
        //             var priorities = '';
        //             for(var i = 0; i < response.priorities.length; i++){
        //                 if(response.task.priority_id == response.priorities[i].id){
        //                     priorities += '<option value="'+response.priorities[i].id+'" selected>'+response.priorities[i].priority_name+'</option>';
        //                 }else{
        //                     priorities += '<option value="'+response.priorities[i].id+'">'+response.priorities[i].priority_name+'</option>';
        //                 }
        //             }

        //             var url = '';
        //             var imagePath = '';
        //             if(response.task.attachment){
        //                 url = $('meta[name="base_url"]').attr('content');
        //                 imagePath = url+'/'+response.task.attachment;
        //             }

        //             var status = '';
        //             if(response.task.status == 1){
        //                 status = '<option value="">Choose Status</option><option value="1" selected>To Do</option><option value="2">In Progress</option><option value="3">On Review</option><option value="4">Complete</option>';
        //             }else if(response.task.status == 2){
        //                 status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2" selected>In Progress</option><option value="3">On Review</option><option value="4">Complete</option>';
        //             }else if(response.task.status == 3){
        //                 status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2">In Progress</option><option value="3" selected>On Review</option><option value="4">Complete</option>';
        //             }else if(response.task.status == 4){
        //                 status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2">In Progress</option><option value="3">On Review</option><option value="4" selected>Complete</option>';
        //             }else{
        //                 status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2">In Progress</option><option value="3">On Review</option><option value="4">Complete</option>';
        //             }

        //             var html = '';

        //             html += '<input type="hidden" name="task_id" value="'+response.task.id+'"><input type="hidden" name="client_id" value="'+ response.task.client_id+'"><div class="row"><div class="col-md-6 mb-2"><label class="form-label">Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" value="'+response.task.title+'"><span class="text-danger titleError"></span></div><div class="col-md-6 mb-2"><label class="form-label">Category <span class="text-danger">*</span></label><select class="form-control" name="category_id"><option value="">Choose Category</option>'+taskcategories+'</select><span class="text-danger categoryError"></span></div><div class="col-md-6 mb-2"><label class="form-label">Assignee</label><select class="form-control" name="assigee_id"><option value="">Choose Assignee</option>'+users+'</select></div><div class="col-md-6 mb-2"><label class="form-label">Priority</label><select class="form-control" name="priority_id"><option value="">Choose Assignee</option>'+priorities+'</select></div><div class="col-md-12 mb-2"><label class="form-label">Due Date</label><input type="text" class="form-control datetime-datepicker" placeholder="Date and Time" name="due_date" value="'+response.task.due_date+'"> </div><div class="col-md-12 mb-2"><label class="form-label">Description</label><textarea class="form-control" rows="4" name="description">'+response.task.description+'</textarea></div><div class="col-md-12 mb-2"><label class="form-label">Attachments:</label><input type="file" class="dropify" name="attachment" data-height="90" data-default-file="'+imagePath+'"></div><div class="col-md-12 mb-2"><label class="form-label">Followers</label><select class="form-control" name="follower_id"><option value="">Choose Assignee</option>'+users+'</select></div><div class="col-md-12 mb-2"><label class="form-label">Status</label><select class="form-control" name="status">'+status+'</select></div></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

        //             $('.updateTaskContent').html(html);

        //             $('.dropify').dropify();
        //             $(".datetime-datepicker").flatpickr({
        //                 enableTime: !0,
        //                 dateFormat: "Y-m-d H:i"
        //             });

        //         }
        //     });

        // });
  
            
        $('.addnote').on('click',function(){
            var applicaion_id = $(this).attr('applicaion_id');
            var client_id = $(this).attr('client_id');
            var collection_id =  $(this).attr('collection_id');
            $('.applicaion_id').val(applicaion_id);
            $('.client_id').val(client_id);
            $('.collection_id').val(collection_id);
            $('#addnote').modal('show')
        })
        $('.addDocuments').on('click',function(){
            var applicaion_id = $(this).attr('applicaion_id');
            var client_id = $(this).attr('client_id');
            var collection_id =  $(this).attr('collection_id');
            $('.applicaion_id').val(applicaion_id);
            $('.client_id').val(client_id);
            $('.collection_id').val(collection_id);
            $('#AddDocuments').modal('show')
        })   
        $('.addAppointment').on('click',function(){
            var applicaion_id = $(this).attr('applicaion_id');
            var client_id = $(this).attr('client_id');
            var collection_id =  $(this).attr('collection_id');
            $('.applicaion_id').val(applicaion_id);
            $('.client_id').val(client_id);
            $('.collection_id').val(collection_id);
            $('#AddAppointment').modal('show')
        })
        $('.newEmail').on('click',function(){
            var applicaion_id = $(this).attr('applicaion_id');
            var client_id = $(this).attr('client_id');
            var collection_id =  $(this).attr('collection_id');
            $('.applicaion_id').val(applicaion_id);
            $('.client_id').val(client_id);
            $('.collection_id').val(collection_id);
            $('#NewEmail').modal('show')
        })
 //applicaion_id="{{ $applications->id }}" client_id="{{ $client->id }}"

        var table = $('#datatabledoc').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('backend.application-docs',['aid'=> $applications->id,'client_id'=> $client->id ]) }}",
        columns: [
            {data: 'file_name', name: 'file_name'},
            {data: 'related', name: 'related'},
            {data: 'add_by', name: 'add_by'},
            {data: 'add_on', name: 'add_on'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
        });

        //$('.datatabletask').DataTable();
        $(".basic-datepicker").flatpickr();
        $(".basic-datetimepicker").flatpickr({enableTime: true,});
         
    $(".basic-daterangepicker").flatpickr({mode: "range"});
    $("#basic-datepicker").flatpickr();
    $("#basic-timepicker").flatpickr({
  	noCalendar: true,
    enableTime: true,
    dateFormat: 'h:i K'
  });
        
      //  
        
        $('[data-toggle="select2"]').select2({
            dropdownParent: $('#addcontact')
        });
        $('.dropify').dropify();
        $('.summereditor').summernote();
        $('.select2').select2({
            dropdownParent: $('#productfees')
        }); 
        $('.selectfee2').select2({
            dropdownParent: $('.paymentfeetype')
        }); 
        
//         $('#datetimepicker2').datetimepicker({
// 			format: 'DD-MM-YYYY'
// 		});
// 		$('#datetimepicker3').datetimepicker({
// 			format: 'LT'
// 		});
		
        $('#wrapperfee').multifield({
            section: '.morefeecol',
            btnAdd:'.addmorefee',
            btnRemove:'.btnRemove'

        });
        var data = [
      { id: 0, text: '' },
      { id: 1, text: '<div> MD Rafikul Islam Tanvir </div><div><small> sushan.me@mymail.com</small> <span class="badge bg-info float-end">Client</span></div>' },
      { id: 2, text: '<div> MD Rafikul Islam Tanvir </div><div><small> sushan.me@mymail.com</small> <span class="badge bg-success float-end"> Partner</span></div>' },
     

      ];

    $("#applicationto").select2({
      data: data,
      dropdownParent: $('#NewEmail'),
      templateResult: function (d) { return $(d.text); },
      templateSelection: function (d) { return $(d.text); },
      
    })
    var ccdata = [
      { id: 0, text: '' },
      { id: 1, text: '<div> MD Rafikul Islam Tanvir </div><div><small> sushan.me@mymail.com</small> <span class="badge bg-info float-end">Client</span></div>' },
      { id: 2, text: '<div> MD Rafikul Islam Tanvir </div><div><small> sushan.me@mymail.com</small> <span class="badge bg-success float-end"> Partner</span></div>' }, 

    ];
    $("#applicationcc").select2({
      data: ccdata,
      dropdownParent: $('#NewEmail'),
      templateResult: function (d) { return $(d.text); },
      templateSelection: function (d) { return $(d.text); },
      
    })
    var taskdata = [
      { id: 0, text: '' },
      { id: 1, text: '<div> MD Rafikul Islam Tanvir </div><div><small> sushan.me@mymail.com</small> <span class="badge bg-info float-end">Client</span></div>' },
      { id: 2, text: '<div> MD Rafikul Islam Tanvir </div><div><small> sushan.me@mymail.com</small> <span class="badge bg-success float-end"> Partner</span></div>' }, 

    ];
    $("#taskAssignee").select2({
      data: taskdata,
      dropdownParent: $('#CreateNewTask'),
      templateResult: function (d) { return $(d.text); },
      templateSelection: function (d) { return $(d.text); },
      
    });
    var followersdata = [
      { id: 0, text: '' },
      { id: 1, text: '<div> MD Rafikul Islam Tanvir </div><div><small> sushan.me@mymail.com</small> <span class="badge bg-info float-end">Bangladesh Office</span></div>' },
      { id: 2, text: '<div> MD Rafikul Islam Tanvir </div><div><small> sushan.me@mymail.com</small> <span class="badge bg-success float-end"> Melbourne Branch</span></div>' }, 

    ];
    $("#taskFollowers").select2({
      data: followersdata,
      dropdownParent: $('#Followers'),
      templateResult: function (d) { return $(d.text); },
      templateSelection: function (d) { return $(d.text); },
      
    })
    
    
    //archived sweetalert
    $(document).on('click', '#client-delete', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');

        swal({
                title: "Are you sure?",
                text: "You want to Archived!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully Archived!", {
                        icon: "success",
                    });

                    window.location.href = Id;

                } else {
                    swal("Archived not completed!");
                }

            });
    });

    //restore sweetalert
    $(document).on('click', '#client-restore', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');

        swal({
                title: "Are you sure?",
                text: "You want to restore this client!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully restore!", {
                        icon: "success",
                    });

                    window.location.href = Id;

                } else {
                    swal("Restore not completed!");
                }

            });
    });


    });
</script>
@endsection