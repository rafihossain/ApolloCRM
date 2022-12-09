@extends('backend.layouts.app')
@section('css')
 <style>
    .cover_image
    {
       height:200px;
       overflow: hidden;
       width: 100%; 
    }
    .header_image
    {
       height:200px;
       overflow: hidden;
       width: 100%; 
    }
 </style>
@endsection	
@section('content')
@php
    $lead_form_data=json_decode($lead_form_edit->system_fileds,true);
@endphp
<div class="cover_image">
        <img src="{{asset($lead_form_edit->cover_image)}}" alt="cover_image">
</div>
<div class="row mt-5">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <img class="avatar-xl" src="{{asset($lead_form_edit->header_image)}}" alt="header_image">
                <h4 class="ms-5">{{$lead_form_edit->header_title}}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <p class="text-end">{{$lead_form_edit->header_text}}</p>
        </div>
</div>
<form action="{{url('online-form',$lead_form_edit->save_form_as)}}" method="post" enctype="multipart/form-data">
    @csrf
<div class="row mt-5 border-line">
    <h2>Personal Details</h2>
    @if($lead_form_data['upload_profile_image'] == 1)
        <div class="col-md-3"> 
            <input type="file" class="dropify" name="personal_details_photo" data-default-file="">
            <p class="bg-primary mt-2 text-center">upload a photo</p>
        </div>
    @endif    
    <div class="col-md-4">
        <div class="form-group">
            <label for="">First Name *</label>
            <input type="text" class="form-control" name="first_name">
            @error('first_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div> 
        <div class="form-group">
            <label for="">Last Name *</label>
            <input type="text" class="form-control" name="last_name">
            @error('last_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
      @if($lead_form_data['date_of_birth'] == 1) 
        <div class="form-group">
            <label for="">Date of Birth *</label>
            <input type="date" class="form-control" name="date_of_birth">
        </div>
      @endif        
    </div>
</div>
 
<div class="row mt-5">
    <h2>Contact Details</h2>
  @if($lead_form_data['phone'] == 1)  
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Phone</label>
            <input type="text" class="form-control" name="contact_phone">
        </div>   
    </div>
  @endif   
    <div class="col-md-4">
       <div class="form-group">
            <label for="">Email *</label>
            <input type="text" class="form-control" name="contact_email">
            @error('contact_email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div> 
    </div>
  @if(($lead_form_data['secondary_email'] == 1) )    
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Secondary Email</label>
            <input type="text" class="form-control" name="contact_secondary_email">
        </div>
    </div>
  @endif 
  @if(($lead_form_data['contact_preference'] == 1) )   
    <div class="col-md-4 mt-2">
            <label for="">Contact Preference</label>
            <div class="form-group">
                <input type="radio" name="contact_preference" value="phone"> Phone
                <input type="radio" name="contact_preference" value="email"> Email
            </div>    
    </div>
  @endif    
</div>

<div class="row mt-4">
  @if(($lead_form_data['street'] == 1) || ($lead_form_data['city'] == 1) || ($lead_form_data['state'] == 1) || ($lead_form_data['postal_code'] == 1) || ($lead_form_data['country'] == 1))   
    <h2>Address Details</h2>
  @endif  
    <div class="row">
       @if(($lead_form_data['street'] == 1) ) 
         <div class="col-md-4 form-group">
            <label for="">Street</label>
            <input type="text" class="form-control" name="street">
         </div>
         @endif
        @if(($lead_form_data['city'] == 1) ) 
         <div class="col-md-4 form-group">
            <label for="">City</label>
            <input type="text" class="form-control" name="city">
         </div>
         @endif  
         @if(($lead_form_data['state'] == 1) ) 
         <div class="col-md-4 form-group">
            <label for="">State</label>
            <input type="text" class="form-control" name="state">
         </div>
         @endif 
         @if(($lead_form_data['postal_code'] == 1) )   
         <div class="col-md-4 form-group mt-2">
            <label for="">Zip / Postal Code</label>
            <input type="text" class="form-control" name="postal_code">
         </div>
         @endif
         @if(($lead_form_data['country'] == 1) )   
         <div class="col-md-4 form-group mt-2">
            <label for="">Country</label>
            <select name="country" id="" class="form-control">
                <option value="">---Select---</option>
                @foreach($Country as $countries)
                    <option value="{{$countries->countryname}}">{{$countries->countryname}}</option>
                @endforeach
            </select>
         </div>
         @endif    
    </div>
</div> 

<div class="row mt-4">
@if(($lead_form_data['visa_type'] == 1) || ($lead_form_data['visa_expiry_date'] == 1) || ($lead_form_data['country_of_passport'] == 1))   
    <h2>Current Visa Information</h2>
@endif    
   @if(($lead_form_data['visa_type'] == 1) )   
    <div class="col-md-4 form-group">
        <label for="">Visa Type</label>
        <input type="text" class="form-control" name="visa_type">
    </div>
   @endif
   @if(($lead_form_data['visa_expiry_date'] == 1) )    
    <div class="col-md-4 form-group">
        <label for="">Visa Expiry Date</label>
        <input type="date" class="form-control" name="visa_expire_date">
    </div>
   @endif
   @if(($lead_form_data['country_of_passport'] == 1) )  
    <div class="col-md-4 form-group">
        <label for="">Country of your Passport</label>
        <select name="country_passport" id="" class="form-control">
            <option value="">---Select---</option>
            @foreach($Country as $countries)
                <option value="{{$countries->countryname}}">{{$countries->countryname}}</option>
            @endforeach
        </select>
    </div>
   @endif 
</div>

@if(($lead_form_data['preferred_intake'] == 1) ) 
<div class="row mt-4">  
    <h2>Other Details</h2>
    <div class="col-md-4 form-group">
        <label for="">Preferred Intake</label>
        <input type="date" class="form-control" name="preferred_intake">
    </div>
</div>
@endif   

@if(($lead_form_data['australian_education'] == 1) || ($lead_form_data['us_education'] == 1) || ($lead_form_data['visa_service'] == 1) || ($lead_form_data['accomodation_service'] == 1) || ($lead_form_data['insurance_service'] == 1))   
<div class="row mt-4">
    <h2>Interested Services</h2>
    <div class="col-md-4 form-group">
     @if(($lead_form_data['australian_education'] == 1) )  
        <input type="checkbox" name="autralian_education" value="1"> Australian Education <br>
     @endif      
     @if(($lead_form_data['us_education'] == 1) )    
        <input type="checkbox" name="us_education" value="1"> Us Education F1 <br>
     @endif   
     @if(($lead_form_data['visa_service'] == 1) )    
        <input type="checkbox" name="visa_service" value="1"> VISA Service <br>
     @endif   
     @if(($lead_form_data['accomodation_service'] == 1) )    
        <input type="checkbox" name="accomodation_service" value="1"> Accomodation Service <br>
     @endif   
     @if(($lead_form_data['insurance_service'] == 1) )    
        <input type="checkbox" name="insurance_service" value="1"> Insurance Service <br>
    @endif   
    </div>
</div>
@endif

<div class="row mt-4">
    <h2>Education Background</h2>
 
    <div class="col-md-4 form-group">
        <label for="">Degree Title *</label>
        <input type="text" class="form-control" name="degree_title">
        @error('degree_title')
                <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 form-group">
        <label for="">Degree Level *</label>
        <select id="" class="form-control" name="degree_level">
            <option value="">Please select a Degree Level</option>
            @foreach($DegreeLevel as $DegreeLevels)
                    <option value="{{$DegreeLevels->id}}">{{$DegreeLevels->name}}</option>
            @endforeach
        </select>
        @error('degree_level')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
 
    <div class="col-md-4 form-group">
        <label for="">Institution *</label>
        <input type="text" class="form-control" name="institution">
        @error('institution')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    @if(($lead_form_data['course_start'] == 1) )  
    <div class="col-md-4 form-group">
        <label for="">Course Start</label>
        <input type="date" class="form-control" name="course_start">
    </div>
    @endif
    @if(($lead_form_data['course_end'] == 1) )  
    <div class="col-md-4 form-group">
        <label for="">Course End</label>
        <input type="date" class="form-control" name="course_end">
    </div>
    @endif
    @if(($lead_form_data['subject_area'] == 1) )  
    <div class="col-md-4 form-group">
        <label for="">Subject Area</label>
        <select name="subject_area" id="getSubject" class="form-control" data-toggle="select2" data-width="100%">
            <option value="">Please select subject area</option>
            @foreach($subjectareas as $subjectarea)
            <option value="{{ $subjectarea->id }}">{{ $subjectarea->name }}</option>
            @endforeach
        </select>
    </div>
    @endif
    @if(($lead_form_data['subject'] == 1) )  
    <div class="col-md-4 form-group">
        <label for="">Subject</label>
        <select name="subject" id="subjectinfo" class="form-control">
            
        </select>
    </div>
    @endif
    @if(($lead_form_data['academic_score'] == 1) )  
    <div class="col-md-4 form-group">
            <label for="">Academic Score</label>
            <input type="radio" name="academic_score" value="percentage">Percentage
            <input type="radio" name="academic_score" value="gpa">GPA           
    </div>
    <div class="col-md-2 form-group">
        <label for=""></label>
        <input type="number" class="form-control" name="academic_score_value">
    </div>
    @endif 
</div>

@if(($lead_form_data['tofel'] == 1) || ($lead_form_data['IELTS'] == 1) || ($lead_form_data['PTE'] == 1)) 
<div class="row mt-4">
    <h2>English Test Score</h2>
    @if(($lead_form_data['tofel'] == 1) ) 
    <div class="col-md-4 form-group">
        <label for="">TOEFL</label>
        <input type="number" class="form-control" name="tofel">
    </div>
    @endif 
    @if(($lead_form_data['IELTS'] == 1) ) 
    <div class="col-md-4 form-group">
        <label for="">IELTS</label>
        <input type="number" class="form-control" name="ielts">
    </div>
    @endif 
    @if(($lead_form_data['PTE'] == 1) ) 
    <div class="col-md-4 form-group">
        <label for="">PTE</label>
        <input type="number" class="form-control" name="pte">
    </div>
    @endif 
</div>
@endif 

@if(($lead_form_data['sat1'] == 1) || ($lead_form_data['sat2'] == 1) || ($lead_form_data['gre'] == 1) || ($lead_form_data['gmat'] == 1))
<div class="row mt-4">
    <h2>Other Test Score</h2>
    @if(($lead_form_data['sat1'] == 1) ) 
    <div class="col-md-4 form-group">
        <label for="">SAT I</label>
        <input type="number" class="form-control" name="sat1">
    </div>
    @endif 
    @if(($lead_form_data['sat2'] == 1) ) 
    <div class="col-md-4 form-group">
        <label for="">SAT II</label>
        <input type="number" class="form-control" name="sat2">
    </div>
    @endif 
    @if(($lead_form_data['gre'] == 1) ) 
    <div class="col-md-4 form-group">
        <label for="">GRE</label>
        <input type="number" class="form-control" name="gre">
    </div>
    @endif 
    @if(($lead_form_data['gmat'] == 1) ) 
    <div class="col-md-4 form-group">
        <label for="">GMAT</label>
        <input type="number" class="form-control" name="gmat">
    </div>
    @endif 
</div>
@endif

@if(($lead_form_data['upload_document'] == 1) ) 
<div class="row mt-4">
    <h2>Upload Documents</h2>
    <div class="col-md-12 form-group">
        <input type="file" class="dropify" name="upload_document">
    </div>
</div>
@endif

@if(($lead_form_data['comment'] == 1) ) 
<div class="row mt-4">
    <h2>Comments</h2>
    <div class="form-group">
       <textarea name="comments" id="" cols="100" rows="5" class="form-control">

       </textarea>
    </div>
</div>
@endif

@if(($lead_form_data['show_privacy_info'] == 1) ) 
<div class="row mt-4">
    <h2>Privacy Information</h2>
    <div class="col-md-12 form-group">
        <p>{{strip_tags($lead_form_data['privacy_info'])}}</p>
        <input type="checkbox" class="submit_button_enable" name="privacy_check" value="1"><p>{{strip_tags($lead_form_data['consent'])}}</p>
    </div>
</div>
@endif
<div class="col-md-12 text-center mt-4"> 
   <button class="btn btn-primary submit_button" disabled>Submit Form</button>
</div>  
</form>
<script>
    $('.dropify').dropify(); 
    $(".submit_button_enable").click(function(e){
        $(".submit_button").removeAttr('disabled');
    });
    $('#getSubject').on("change", function() {
            var subjectareaId = $(this).val();
            $('#subjectinfo').html('');
            $.ajax({
                url: "{{ route('backend.subject_info') }}",
                data: {
                    'subjectarea_id': subjectareaId
                },
                dataType: 'json',
                success: function(data) {
                    if (data != undefined && data != null) {
                        var optionValue = '<option value="">Please select subject</option>';
                        for (var i = 0; i < data.length; i++) {
                            optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#subjectinfo').append(optionValue);
                    }
                }
            });
        });
</script>
@endsection
