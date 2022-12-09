<div class="text-center">
    <div>
        <img src="{{ url('/') }}/{{$client->client_image }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-xl">
    </div>
    <h4>{{$client->first_name }} {{$client->last_name }}</h4>
    <span class="badge bg-info mb-2 rounded-pill">In Progress</span>
    <div>
        <a href="#" class="me-2 left-user-info">
            <i class="mdi mdi-forum-outline mdi-18px"></i>
        </a>
        <a href="#" class="me-2 left-user-info">
            <i class="mdi mdi-email-outline mdi-18px"></i>
        </a>
        @if($client->client_status == 0 || $client->client_status == 1)
        <a href="{{ route('backend.edit-client', ['id' => $client->id]) }}" class="me-2 left-user-info">
            <i class="mdi mdi-square-edit-outline mdi-18px"></i>
        </a>
        @endif
        @if($client->client_status == 0 || $client->client_status == 1)
        <a href="{{ route('backend.delete-client', ['id' => $client->id]) }}" id="client-delete" class="me-2 left-user-info">
            <i class="mdi mdi-archive mdi-18px"></i>
        </a>
        @else
        <a href="{{ route('backend.restore-client', ['id' => $client->id]) }}" id="client-restore" class="me-2 btn btn-outline-danger w-100 mb-3">
            <i class="mdi mdi-history mdi-18px"></i> Archived
        </a>
        @endif
    </div>
</div>
<hr />
<h5> Application Sales Forecast </h5>
<div class="mb-2">
    0.00 AUD
</div>
<h5>Personal Details:</h5>
<div class="mb-2">
    <strong> Tag(s): </strong> 
    @isset($client->tag_info['name'])
        <span class="rounded-pill badge bg-dark">{{ $client->tag_info['name'] }}</span>
    @endisset
</div>
<div class="mb-2">
    <strong> Added From: </strong> - System
</div>
<div class="mb-2">
    <strong>Client Id: </strong> 
    @isset($client->client_id)
        {{ $client->client_id }}
    @endisset
</div>
<div class="mb-2">
    <strong>Internal Id: </strong>
    @isset($client->client_id)
        {{$client->client_id }}
    @endisset
</div>
<div class="mb-2">
    <strong>Date Of Birth: </strong> 
    @isset($client->client_dob)
        {{$client->client_dob }}
    @endisset
</div>
<div class="mb-2">
    <strong>Phone No: </strong> 
    @isset($client->phone)
        {{$client->phone }}
    @endisset
</div>
<div class="mb-2">
    <strong>Email: </strong> 
    @isset($client->email)
        {{$client->email }}
    @endisset
</div>
<div class="mb-2">
    <strong>Secondary Email: </strong> -
</div>
<div class="mb-2">
    <strong>Address: </strong> {{$client->city.' , '.$client->pass_country->countryname}}
</div>
<div class="mb-2">
    <strong>Country of Passport: </strong> 
    @isset($client->pass_country->countryname)
        {{ $client->pass_country->countryname }}
    @endisset
</div>
<div class="mb-2">
    <strong>Passport Number: </strong> 
    @isset($client->passport_number)
        {{ $client->passport_number }}
    @endisset
</div>
<div class="mb-2">
    <strong>Preferred Intake: </strong> 
    @isset($client->preferred_intake)
        {{ $client->preferred_intake }}
    @endisset
</div>
<div class="mb-2">
    <strong>Visa Expiry Date: </strong> 
    @isset($client->visa_expiry)
        {{ $client->visa_expiry }}
    @endisset
</div>
<div class="mb-2">
    <strong>Visa type: </strong> 
    @isset($client->visa_type)
        {{ $client->visa_type }}
    @endisset
</div>
<h5>Added By:</h5>
<div class="overflow-hidden mb-2">
    <div class="float-start me-2">
        <img src="{{ asset('assets/images/users/user-4.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
    </div>
    <div>
        <div class="text-truncate">
            <a href="{{route('backend.usersdetails', ['id'=>$client->user_info->id] )}}">
                <div><a href="">{{ $client->user_info->first_name.' '.$client->user_info->last_name }}</a></div>
            </a>
        </div>
        <div class="text-truncate">
            <a href="mailto:info@sydneymet.edu.au">{{ $client->user_info->email }}</a>
        </div>
    </div>
</div>
<h5>Assignee:</h5>
<div class="overflow-hidden">
    <div class="float-start me-2">
        <img src="{{ asset('assets/images/users/user-3.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
    </div>
    <div>
        <div class="text-truncate">
            <a href="{{route('backend.usersdetails', ['id'=>$client->user_info->id] )}}">
                <div><a href="">{{ $client->user_info->first_name.' '.$client->user_info->last_name }}</a></div>
            </a>
        </div>
        <div class="text-truncate">
            <a href="mailto:info@sydneymet.edu.au">{{ $client->user_info->email }}</a>
        </div>
    </div>
</div>