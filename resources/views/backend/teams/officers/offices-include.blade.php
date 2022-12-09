<div class="card">
    <div class="card-body"> 
        <div class="d-flex justify-content-end align-items-center"> 
            <h4 class="m-0"> Overview </h4>
            <p class="m-0 mx-2"> TOTAL USERS : </p>
            <h2 class="m-0 text-primary mx-2"> {{ @count($users) }} </h2>
            <p class="m-0 mx-2"> TOTAL CLIENTS : </p>
            <h2 class="m-0 text-primary mx-2"> {{ @count($clients) }} </h2>
        </div>
    </div>
</div>
<div class="card">
	<div class="card-body">  
        <h4>Office Information</h4>

        <h3> {{ $office->office_name }} <small class="badge bg-warning rounded-pill ">Active</small ></h3>
        
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-1">
                    <div class="col-6"><strong>Email:</strong></div>
                    <div class="col-6">{{ $office->email }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-6"><strong>Mobile:</strong></div>
                    <div class="col-6">{{ $office->mobile }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-6"><strong>Phone:</strong></div>
                    <div class="col-6">{{ $office->phone }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-6"><strong>Person to Contact :</strong></div>
                    <div class="col-6">{{ $office->contact_person }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row mb-1">
                    <div class="col-6"><strong>Street:</strong></div>
                    <div class="col-6">{{ $office->street }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-6"><strong>City:</strong></div>
                    <div class="col-6">{{ $office->city }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-6"><strong>State:</strong></div>
                    <div class="col-6">{{ $office->state }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-6"><strong>Zip/Post Code:</strong></div>
                    <div class="col-6">{{ $office->post_code }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-6"><strong>Country:</strong></div>
                    <div class="col-6">{{ $office->all_country->countryname }}</div>
                </div>
            </div>
        </div>
	</div>
</div>