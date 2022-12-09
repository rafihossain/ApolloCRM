@extends('backend.layouts.app')
@section('css')
<link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
@endsection	
@section('content')
	<div class="card">
		<div class="card-body">
			<ul class="nav nav-tabs nav-bordered border-0"> 
		        <li class="nav-item">
		          <a href="{{ route('backend.company-profile') }}" class="nav-link ">
		              Company Profile 
		          </a>
		        </li>
		        <li class="nav-item">
		          <a href="{{ route('backend.domain-information') }}" class="nav-link  ">
		             Domain Information
		          </a>
		        </li>
		        <li class="nav-item">
		          <a href="{{ route('backend.preference-legal') }}" class="nav-link active">
		             Legal
		          </a>
		        </li>
		    </ul>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<h4>Data Processing Agreement</h4>
			<p>The Data Processing Agreement for this account <strong> has not been accepted yet. </strong></p>
			<button type="button" class="btn btn-primary">Review Agreement</button> 
		</div>
	</div>
@endsection

@section('script')
<script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script> 
<script type="text/javascript">
	$(document).ready(function() { 
        $('.dropify').dropify();
        $('.countrypicker').countrypicker();
    });
</script>
@endsection