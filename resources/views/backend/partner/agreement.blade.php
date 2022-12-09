@extends('backend.layouts.app')
@section('css')
<link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/css/intlTelInput.css"/>
@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
	<a href="{{ route('backend.manage-partner') }}" class="btn btn-primary">  Partners List </a>
</h4>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body"> 
                @include('backend.partner.include.partner-sidebar') 
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body"> 
                @include('backend.partner.include.partner-header')
            </div>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success" style="text-align: center;">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">  
                <h4 class="header-title">Contract Information</h4> 
                <form method="POST" action="{{ route('backend.update-partner-agreement') }}">
                    @csrf
                    <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                    
                    <div class="row">
                        <div class="col-md-4 mb-2">
                           <label class="form-label"> Contract Expiry Date</label>
                            <input type="date" class="form-control" name="contract_expiry_date" value="{{ date('Y-m-d', strtotime(date('Y-m-d')) ) }}">
                            <p><small>Date must be in YYYY-MM-DD (2012-12-22) format.</small></p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label"> Representing Regions</label>
                            <select name="representing_regions" class="form-control">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->countryname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                           <label class="form-label"> Commission Percentage</label>
                            <input type="number" class="form-control" name="commission_percentage" value="90">
                        </div>

                        <div class="col-md-4 mb-2">
                           <label  class="form-label">Default Super Agent</label>
                            <select class="form-control" data-toggle="select2" data-width="100%" name="default_super_agent">
                                <option value="">Super Agent</option>
                                <option value="1">PFEC GLOBAL</option>
                                <option value="2">STUDYNET</option>
                                <option value="3">AUSTLINK</option>
                                <option value="4">LCI</option>
                                <option value="5">APPLYBOARD</option>  
                                <option value="6">AECC GLOBAL</option>  
                                <option value="7">IME Advisors</option>  
                                <option value="8">MI Education & Migration</option>  
                                <option value="9">ESI GLOBAL</option>  
                                <option value="10">Education Connect</option>  
                                <option value="11"> The Next</option>  
                                <option value="12">Optimus Education</option>  
                                <option value="13">ACIC</option>   
                            </select>
                            <p><small>Select super agent if you do not represent this partner directly</small></p>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"> Save Changes</button>
                </form> 
            </div>
        </div>
            

    </div>
</div>

@endsection

@section('script')
<!-- Datatables init --> 
<script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/intlTelInput.min.js"></script>

 <script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="select2"]').select2();
        $('.countrypicker').countrypicker();
    });
    //delete sweetalert
    $(document).on('click', '#partner-delete', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');

        swal({
                title: "Are you sure?",
                text: "You want to delete!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully deleted!", {
                        icon: "success",
                    });

                    window.location.href = Id;

                } else {
                    swal("safe!");
                }

            });
    });
    var countryData = window.intlTelInputGlobals.getCountryData(),
    input = document.querySelector("#phone");

    for (var i = 0; i < countryData.length; i++) {
      var country = countryData[i];
      country.name = country.name.replace(/.+\((.+)\)/,"$1");
    }

    window.intlTelInput(input, {
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/utils.min.js" // just for formatting/placeholders etc
    });
 </script>
@endsection