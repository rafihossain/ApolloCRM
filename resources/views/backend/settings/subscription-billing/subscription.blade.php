@extends('backend.layouts.app')
@section('css')
 
@endsection	
@section('content') 
<div class="card">
	<div class="card-body"> 

		<ul class="nav nav-tabs nav-bordered border-0"> 
            <li class="nav-item">
                <a href="{{ route('backend.setting-subscription') }}" class="nav-link active">
                   Subscription
                </a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('backend.subscription-billing') }}" class="nav-link ">
                    Billing Details
                </a>
            </li> 
        </ul>
	</div>
</div>
<div class="card">
	<div class="card-body"> 
		<div class="d-flex gap-1 flex-wrap">
			<div class="mb2">  
				<h5>CURRENT PLAN</h5>
				<h4>Standard (Monthly)</h4>
			</div>
			<div class="ms-auto">
				<h5>BILLING DATE</h5>
				<h4>2022-09-20</h4> 
			</div>
			<div class="ms-auto">
				<h5>BILLING AMT</h5>
				<h4>USD 14.00</h4>
			</div>
			<div class="ms-auto">
				<a href="{{ route('backend.subscription-change') }}" class="btn btn-primary"> Upgrade Plan </a>
			</div>
		</div> 	 
	</div>
</div>
<h4 class="mb-3">SUBSCRIPTION USAGE DETAILS</h4>

<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<div>
						<h4>User</h4>
						@php
							if ($billing->total_user == 1) {
								$mode_total = $billing->mode_unit;
							} else {
								$mode_total = $billing->mode_total;
							}
						@endphp
						<p class="m-0">{{ $billing->total_user }} USER LIMITATION</p> 
					</div>
					<div class="text-end ms-auto">
						<h4><strong>USD {{$mode_total}}.00</strong></h4>
						<p class="m-0"><small>/ {{$billing->plan_name}}</small></p> 
					</div> 
				</div>
				<hr/>
				<p>{{@count($users)}}/{{$billing->total_user}}</p>
				<div class="progress mb-3">
					@if(count($users)==$billing->total_user)
                    	<div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					@else
                    	<div class="progress-bar bg-success" role="progressbar" style="width:{{@count($users)*100/$billing->total_user}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					@endif
				</div>
				<p><em>You have already reach your maximum User limitation.</em></p>
				<a href="{{ route('backend.subscription-change') }}">Manage Users</a>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<div>
						<h4>Storage</h4>
						<p class="m-0"> {{ $billing->storage_total*1024 }} MB LIMITATION</p> 
					</div>
					<div class="text-end ms-auto">
						<h4><strong>USD {{ $billing->storage_unit }}.00</strong></h4>
						<p class="m-0"><small>/ {{$billing->plan_name}}</small></p> 
					</div> 
				</div>
				<hr/>
				<p>2.08MB/{{$billing->storage_total*1024}}MB</p>
				<div class="progress mb-3">
                    @if(2.08==$billing->storage_total*1024)
                    	<div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					@else
                    	<div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					@endif
                </div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<div>
						<h4>Email Inbox</h4>
						<p class="m-0">{{ $billing->inbox_total }} LIMITATION</p> 
					</div>
					<div class="text-end ms-auto">
						<h4><strong>USD {{ $billing->inbox_unit }}.00</strong></h4>
						<p class="m-0"><small>/ {{$billing->plan_name}}</small></p> 
					</div> 
				</div>
				<hr/>
				<p>0/{{ $billing->inbox_total }}</p>
				<div class="progress mb-3">
                    @if($billing->inbox_total)
                    	<div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					@else
                    	<div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					@endif
                </div>  
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<div>
						<h4>Email Outbox</h4>
						<p class="m-0">{{ $billing->outbox_total }} LIMITATION</p> 
					</div>
					<div class="text-end ms-auto">
						<h4><strong>USD {{ $billing->outbox_unit }}.00</strong></h4>
						<p class="m-0"><small>/ {{$billing->plan_name}}</small></p> 
					</div> 
				</div>
				<hr/>
				<p>2/{{$billing->outbox_total}}</p>
				<div class="progress mb-3">
                    @if($billing->outbox_total)
                    	<div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					@else
                    	<div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					@endif
                </div>  
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
 
@endsection