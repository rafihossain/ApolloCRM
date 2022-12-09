<?php $months = ['January','February','March','April','May','June','July','August','September','October','November','December']; ?>

<div class="card">
    <div class="card-body"> 
        <div class="text-center">
            <div class="mb-2">
                <span class="badge bg-success rounded-pill">Auto sync</span>
            </div>
            <div>
                <img src="{{ asset('assets/images/users/user-2.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-xl">
            </div>
            <h4>{{ $product['name'] }}</h4>
            <div>
                <a href="{{ url('/') }}/admin/editproduct/{{ $product['id'] }}" class=" me-2 left-user-info">
                    <i class="mdi mdi-square-edit-outline mdi-18px"></i>
                </a> 
            </div>
        </div>
        <hr/>
        <h5>GENERAL INFORMATION:</h5>
        <div class="mb-2">
          <strong> Partner: </strong>  <a href="#">
            @isset($product['partner']['name'])
              {{ $product['partner']['name'] }}</a>
            @endisset
        </div>
        <div class="mb-2">
          <strong> Branches: </strong> <span class="badge rounded-pill bg-light text-dark me-2 mb-2">
            @isset($product['partner_branch']['name'])
              {{ $product['partner_branch']['name'] }}</a>
            @endisset
          </span> 
        </div>
        <div class="mb-2">
          <strong> Services: </strong>
            
            @isset($relatedWorkflow)
                @foreach($relatedWorkflow as $workflow)
                    <span class="badge bg-light text-dark me-2 mb-2">{{ $workflow->service_workflow }}</span>
                @endforeach
            @endisset

          </span>
        </div>
        <div class="mb-2">
          <strong>Duration: </strong>  
          @isset($product['duration'])
            {{ $product['duration'] }}
          @endisset
        </div>
        <div class="mb-2">
          <strong> Intake Month: </strong> 
          @isset($months[$product['intake_month']])
            {{ $months[$product['intake_month']] }}
          @endisset
        </div>
        <div class="mb-2">
          <strong>Fees: </strong> Default Fee : 
          @isset($defualtPrice->totals)
            {{ $defualtPrice->totals }}
          @endisset
        </div>
        <div class="mb-2">
          <strong>Revenue Type: </strong>  Revenue from client
          <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
        </div> 
        <div class="mb-2">
          <strong>Notes: </strong>
          @isset($product['note'])
            {!! $product['note'] !!}
          @endisset
        </div>
        <div class="mb-2">
          <strong>Description:   </strong> <p>
            @isset($product['description'])
              {!! $product['description'] !!}
            @endisset</p>
        </div>   
        
    </div>
</div>