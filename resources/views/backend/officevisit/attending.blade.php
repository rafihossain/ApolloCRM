@extends('backend.layouts.app')
@section('content')

<div class="card">
    <div class="card-body"> 
        <h4 class="m-0 header-title text-end float-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcontact">+ Add</button>
        </h4> 

        <ul class="nav nav-tabs nav-bordered border-0"> 
            <li class="nav-item">
                <a href="{{ route('backend.office-visit-waiting') }}" class="nav-link">
                    Waiting
                </a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('backend.office-visit-attending') }}" class="nav-link active">
                    Attending
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('backend.office-visit-completed') }}" class="nav-link">
                    Completed
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.office-visit-all') }}" class="nav-link">
                    All
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.office-visit-archived') }}" class="nav-link">
                    Archived
                </a>
            </li> 
             
        </ul>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-8"></div>
    <div class="col-md-4">
        <select class="form-control" data-toggle="select2" data-width="100%">
            <option value="1">All Branches</option>
            <option value="2"> Sydney - Head Office </option>
            <option value="3">Melbourne Branch </option>
            <option value="4">India Office </option>
            <option value="5">Nepal Office</option>
            <option value="6">Malaysia Office </option>
            <option value="7">China Office </option>
            <option value="8">Sri-Lanka Office </option>
            <option value="9">Pakistan Office </option>
            <option value="10">Bangladesh Office </option>
        </select>
    </div> 
</div>
<div class="card">
    <div class="card-body">  
        
        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
            <thead>
                <tr>              
                    <th>Id</th>
                    <th>Date</th>
                    <th>Start</th>
                    <th>Contact Name</th>
                    <th>Contact Type</th>
                    <th>Visit Purpose</th> 
                    <th>Check In Assignee</th>
                    <th>Attend Time </th>  
                </tr>
            </thead>  
            <tbody>
                <tr>
                    <td>#1</td>
                    <td>
                        <div class="text-primary">Wednesday</div>
                        <div>2022-08-24</div>
                    </td>
                    <td>
                        04:54 PM
                    </td>
                    <td>
                        <div class="overflow-hidden">
                            <div class="float-start me-2">
                                <img src="{{ asset('assets/images/users/user-4.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                            </div>
                            <div>
                                <div class="text-truncate">
                                     <a href="{{ url('/client/activitie') }}">
                                    Aadheya Chowdhury
                                    </a>
                                </div>
                                <div class="text-truncate">
                                    <a href="mailto:ananya.rosni@gmail.com">ananya.rosni@gmail.com</a>
                                </div>
                            </div>
                        </div> 
                    </td>
                    <td> Prospect </td>
                    <td> fdtt yt </td>
                    <td> - </td>
                    <td> 354h 52m 37s </td> 
                   
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Standard modal content -->
<div id="addcontact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add Application</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     
                    <div class="mb-2">
                        <label class="form-label">Search Contact:</label>
                        <select class="form-control" id="search_contact" data-width="100%"> </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">SVisit Purpose</label>
                        <textarea class="form-control"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Select CheckIn Assignee: </label>
                        <select class="form-control" id="CheckInAssignee" data-width="100%"> </select>
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
        $('[data-toggle="select2"]').select2(); 
       
        var data = [
          { id: 0, text: '' },
          { id: 1, text: '<div class="overflow-hidden"><div class="float-end"><div class="text-end"><span class="badge bg-primary rounded-pill">Lead</span></div><div><small> Bangladesh Office</small></div></div><div class="float-start me-2"> <img src="{{ asset("assets/images/users/user-1.jpg") }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md"> </div> <div> <div class="text-truncate"> Aadheya Chowdhury </div> <div class="text-truncate"><small>ab@findout.com</small> | <small title="+61412076345">+61412076345</small> </div> </div> </div>' },
          { id: 2, text: '<div class="overflow-hidden"><div class="float-end"><div class="text-end"><span class="badge bg-primary rounded-pill">Prospect</span></div><div><small> Bangladesh Office</small></div></div><div class="float-start me-2"> <img src="{{ asset("assets/images/users/user-2.jpg") }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md"> </div> <div> <div class="text-truncate"> Aadheya Chowdhury </div> <div class="text-truncate"><small>ab@findout.com</small> | <small title="+61412076345">+61412076345</small> </div> </div> </div>' },
          { id: 3, text: '<div class="overflow-hidden"><div class="float-end"><div class="text-end"><span class="badge bg-primary rounded-pill">Client</span></div><div><small> Bangladesh Office</small></div></div><div class="float-start me-2"> <img src="{{ asset("assets/images/users/user-3.jpg") }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md"> </div> <div> <div class="text-truncate"> Aadheya Chowdhury </div> <div class="text-truncate"><small>ab@findout.com</small> | <small title="+61412076345">+61412076345</small> </div> </div> </div>' },
           { id: 4, text: '<div class="overflow-hidden"><div class="float-end"><div class="text-end"><span class="badge bg-primary rounded-pill">Lead</span></div><div><small> Bangladesh Office</small></div></div><div class="float-start me-2"> <img src="{{ asset("assets/images/users/user-4.jpg") }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md"> </div> <div> <div class="text-truncate"> Aadheya Chowdhury </div> <div class="text-truncate"><small>ab@findout.com</small> | <small title="+61412076345">+61412076345</small> </div> </div> </div>' },
           { id: 5, text: '<div class="overflow-hidden"><div class="float-end"><div class="text-end"><span class="badge bg-primary rounded-pill">Lead</span></div><div><small> Bangladesh Office</small></div></div><div class="float-start me-2"> <img src="{{ asset("assets/images/users/user-5.jpg") }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md"> </div> <div> <div class="text-truncate"> Aadheya Chowdhury </div> <div class="text-truncate"><small>ab@findout.com</small> | <small title="+61412076345">+61412076345</small> </div> </div> </div>' },

        ];

        $("#search_contact").select2({
          dropdownParent: $('#addcontact'),
          data: data, 
          templateResult: function (d) { return $(d.text); },
          templateSelection: function (d) { return $(d.text); }, 
        });
        var datacheckin = [
          { id: 0, text: '' },
          { id: 1, text: '<div><div><strong> Ashraf Rocky</strong></div><small> ashraf@apollointl.com.au</small></div>' },
          { id: 2, text: '<div><div><strong> Kamrun Nahar</strong></div><small>  kamrun@apollointl.com.au</small></div>' },
          

        ];
        $('#CheckInAssignee').select2({ 
            dropdownParent: $('#addcontact'),
            data: datacheckin, 
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); }, 
        }); 
    });
</script>
@endsection