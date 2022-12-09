@extends('backend.layouts.app')
@section('css')
 
@endsection	
@section('content') 
<div class="card">
	<div class="card-body"> 

		<ul class="nav nav-tabs nav-bordered border-0"> 
            <li class="nav-item">
                <a href="{{ route('backend.setting-subscription') }}" class="nav-link ">
                   Subscription
                </a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('backend.subscription-billing') }}" class="nav-link active">
                    Billing Details
                </a>
            </li> 
        </ul>

	</div>
</div>
<div class="card">
	<div class="card-body"> 
		<h4>Billing Details</h4> 
		<p>Your selected billing details will be your active payment details for subscription</p>
		<a href="#" class="btn btn-outline-primary"> + Add Card</a>
	</div>
</div>

@if(Session::has('success'))
<div class="alert alert-success">
	{{ Session::get('success') }}
</div>
@endif

<div class="card">
	<div class="card-body"> 
		<h4 class="mb-4">Billing History</h4> 
		<table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
			<thead>
				<tr> 
					<th>Invoice Number</th>
					<th>Payment Method</th>
					<th>Total Amount</th>
					<th>Payment Date</th>
					<th>Status</th>
					<th>Invoice</th>
				</tr>
			</thead>
			<tbody>
				@foreach($BillingHistories as $history)
				<tr>
					<td>{{ $history->id }}</td>
					<td>{{ $history->payment_method }}</td>
					<td>${{ $history->total_amount }}</td>
					<td>{{ $history->payment_date }}</td>
					<td>
						<span class="badge bg-success">{{ $history->status }}</span>
					</td>
					<td>
						<a href="#" class="btn btn-primary">Preview</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
 

@endsection

@section('script')
 <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection