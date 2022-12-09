@extends('backend.layouts.app')
@section('css')
 
@endsection	
@section('content') 

@php

$lead_form=json_decode($lead_form_edit->system_fileds,true);

@endphp

<div class="card">
	<div class="card-body overflowhidden">
		<a class="btn btn-primary float-end ms-2" href="{{ route('backend.setting-lead-form') }}"> List Lead Form </a>
	</div>
</div>
<form action="{{route('backend.setting-leadform-update')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="lead_form_id" value="{{$lead_form_edit->id}}">
    <input type="hidden" name="old_cover_image" value="{{$lead_form_edit->cover_image}}">
    <input type="hidden" name="old_header_image" value="{{$lead_form_edit->header_image}}">
    <div class="card">
    	<div class="card-body">
    		<h4>Add New Lead Form</h4>
          
                <div class="mb-2">
                    <label class="form-label">Save form as </label>
                    <input type="text" class="form-control" name="save_form_as" value="{{$lead_form_edit->save_form_as}}">
                    @error('save_form_as')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-label">Add Cover Image</label>
                    <input type="file" class="dropify" name="cover_image" data-default-file="{{asset($lead_form_edit->cover_image)}}">
                </div>
            
    	</div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Form Header</h4> 
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Upload Logo / Image</label>
                    <input type="file" class="dropify" name="header_image" data-default-file="{{asset($lead_form_edit->header_image)}}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Form Title</label>
                    <input type="text" class="form-control" name="header_title" value="{{$lead_form_edit->header_title}}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Header Text </label>
                    <textarea class="form-control" placeholder="Header Text (e.g: Address / Contact Details)" name="header_text">{{$lead_form_edit->header_text}}</textarea>
                </div>
            </div>
            
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Choose Form Fields</h4> 
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#SystemFields" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                        System Fields
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#CustomFields" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                        Custom Fields
                    </a>
                </li> 
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="SystemFields">
                   
                    <div class="mb-2"> 
                        <h4 class="header-title mt-3 mb-3 clearfix">Team Members
                            <input type="checkbox" class="float-end" name="" id="team_member" @php if(($lead_form['upload_profile_image'] == '1') && ($lead_form['date_of_birth'] == '1')) echo 'checked' @endphp>
                        </h4>
                        <div class="row">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2">
                                    <input type="checkbox" class="float-end upload_profile_image" value="1" id="UploadProfileImage" name="upload_profile_image" {{$lead_form['upload_profile_image'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="UploadProfileImage">Upload Profile Image</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2 text-danger"> 
                                    <input type="checkbox" class="float-end" id="fname" checked="" disabled="">
                                    <label class="form-check-label" for="fname">First Name</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2 text-danger"> 
                                    <input type="checkbox" class="float-end" id="lname" disabled="" checked="">
                                    <label class="form-check-label" for="lname">Last Name</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end date_of_birth" id="DateOfBirth" name="date_of_birth" value="1" {{$lead_form['date_of_birth'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="DateOfBirth">Date Of Birth</label> 
                                </div>
                            </div>
                        </div>
                        <h4 class="header-title mt-3 mb-3 clearfix">Contact Details
                            <input type="checkbox" class="float-end contact_details" name="" @php if(($lead_form['phone'] == '1') && ($lead_form['secondary_email'] == '1') && ($lead_form['contact_preference'] == '1')) echo 'checked' @endphp>
                        </h4>
                         
                        <div class="row">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end contact_phone" id="uPhone" name="phone" value="1" {{$lead_form['phone'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uPhone">Phone</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2 text-danger"> 
                                    <input type="checkbox" class="float-end" id="fEmail" checked="" disabled="">
                                    <label class="form-check-label" for="fEmail">Email</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end secondary_email" id="SecondaryEmail" name="secondary_email" value="1" {{$lead_form['secondary_email'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="SecondaryEmail">Secondary Email</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end contact_preference" id="ContactPreference" name="contact_preference" value="1" {{$lead_form['contact_preference'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="ContactPreference">Contact Preference</label> 
                                </div>
                            </div>
                        </div>
                       <h4 class="header-title mt-3 mb-3 clearfix">Address Details
                            <input type="checkbox" class="float-end address_details" name="" @php if(($lead_form['street'] == '1') && ($lead_form['city'] == '1') && ($lead_form['state'] == '1') && ($lead_form['postal_code'] == '1') && ($lead_form['country'] == '1')) echo 'checked' @endphp>
                        </h4> 
                        <div class="row">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end address_street" id="uStreet" name="street" value="1" {{$lead_form['street'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uStreet">Street</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end address_city" id="fCity" name="city" value="1" {{$lead_form['city'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="fCity">City</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end address_State" id="uState" name="state" value="1" {{$lead_form['state'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uState">State</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end postal_code" id="uPostalCode" name="postal_code" value="1" {{$lead_form['postal_code'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uPostalCode">Postal Code</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end address_country" id="uCountry" name="country" value="1" {{$lead_form['country'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uCountry">Country</label> 
                                </div>
                            </div>
                        </div>
                        <h4 class="header-title mt-3 mb-3 clearfix">Current Visa Information
                            <input type="checkbox" class="float-end current_visa_info" name="" @php if(($lead_form['visa_type'] == '1') && ($lead_form['visa_expiry_date'] == '1') && ($lead_form['country_of_passport'] == '1')) echo 'checked' @endphp>
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end visa_type" id="uVisaType" name="visa_type" value="1" {{$lead_form['visa_type'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uVisaType">Visa Type</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end visa_expiry_date" id="uVisaExpiryDate" name="visa_expiry_date" value="1" {{$lead_form['visa_expiry_date'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uVisaExpiryDate">Visa Expiry Date</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end country_of_passport" id="uCountryOfPassport" name="country_of_passport" value="1" {{$lead_form['country_of_passport'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uCountryOfPassport">Country Of Passport</label> 
                                </div>
                            </div>  
                        </div>
                        <h4 class="header-title mt-3 mb-3 clearfix">Other Details    
                        </h4>
                       
                        <div class="row clearfix">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end" id="uPreferredIntake" name="preferred_intake" value="1" {{$lead_form['preferred_intake'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uPreferredIntake">Preferred Intake</label> 
                                </div>
                            </div> 
                        </div>
                        <h4 class="header-title mt-3 mb-3 clearfix">Interested Services   
                            <input type="checkbox" id="usWorkflow" name="">
                            <label for="usWorkflow">Workflow</label>
                            <input type="checkbox" id="usPartner" name="workflow" value="1">
                            <label for="usPartner">Partner</label>
                            <input type="checkbox" id="usProduct" name="partner" value="1">
                            <label for="usProduct">Product</label>
                            <input type="checkbox" class="float-end interested_service" name="" @php if(($lead_form['australian_education'] == '1') && ($lead_form['us_education'] == '1') && ($lead_form['visa_service'] == '1') && ($lead_form['accomodation_service'] == '1') && ($lead_form['insurance_service'] == '1')) echo 'checked' @endphp>
                        </h4>
                       
                        <div class="row">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end australian_education" id="uAustralianEducation" name="australian_education" value="1" {{$lead_form['australian_education'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uAustralianEducation">Australian Education</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end us_education" id="uUsEducationF1" name="us_education"  value="1" {{$lead_form['us_education'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uUsEducationF1">Us Education F1</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end visa_service" id="uVISAService" name="visa_service" value="1" {{$lead_form['visa_service'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uVISAService">VISA Service</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end accomodation_service" id="uAccomodationService" name="accomodation_service" value="1" {{$lead_form['accomodation_service'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uAccomodationService">Accomodation Service</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end insurance_service" id="uInsuranceService" name="insurance_service" value="1" {{$lead_form['insurance_service'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uInsuranceService">Insurance Service</label> 
                                </div>
                            </div> 
                        </div>
                        <h4 class="header-title mt-3 mb-3 clearfix">Education Background
                            <input type="checkbox" class="float-end education_background" name=""  @php if(($lead_form['subject_area'] == '1') && ($lead_form['subject'] == '1') && ($lead_form['course_start'] == '1') && ($lead_form['course_end'] == '1') && ($lead_form['academic_score'] == '1')) echo 'checked' @endphp>
                        </h4>
                       
                        <div class="row clearfix">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2 text-danger"> 
                                    <input type="checkbox" class="float-end degree_title" id="uDegreeTitle" name="degree_title" value="1" disabled>
                                    <label class="form-check-label" for="uDegreeTitle">Degree Title</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2 text-danger"> 
                                    <input type="checkbox" class="float-end degree_level" id="uDegreeLevel" name="degree_level" value="1" disabled>
                                    <label class="form-check-label" for="uDegreeLevel">Degree Level</label> 
                                </div>
                            </div> 
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2 text-danger"> 
                                    <input type="checkbox" class="float-end institution" id="uInstitution" name="institution" value="1" disabled>
                                    <label class="form-check-label" for="uInstitution">Institution</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end subject_area" id="uSubjectArea" name="subject_area" value="1" {{$lead_form['subject_area'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uSubjectArea">Subject Area</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end education_subject" id="uSubject" name="subject" value="1" {{$lead_form['subject'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uSubject">Subject</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end course_start" id="uCourseStart" name="course_start" value="1" {{$lead_form['course_start'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uCourseStart">Course Start</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end course_end" id="uCourseEnd" name="course_end" value="1" {{$lead_form['course_end'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uCourseEnd">Course End</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end academic_score" id="uAcademicScore" name="academic_score" value="1" {{$lead_form['academic_score'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uAcademicScore">Academic Score</label> 
                                </div>
                            </div> 
                        </div>
                        <h4 class="header-title mt-3 mb-3 clearfix">English Test Scores
                            <input type="checkbox" class="float-end english_test_score" name="" @php if(($lead_form['tofel'] == '1') && ($lead_form['IELTS'] == '1') && ($lead_form['PTE'] == '1')) echo 'checked' @endphp>
                        </h4>
                       
                        <div class="row clearfix">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end english_tofel" id="uTOEFL" name="tofel" value="1" {{$lead_form['tofel'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uTOEFL">TOEFL</label>  
                                    <div class="w-100 mt-2">
                                        <input type="checkbox" name="" id="individualfields" disabled>
                                        <label for="individualfields">Enable all individual fields</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end english_IELTS" id="uIELTS" name="IELTS" value="1" {{$lead_form['IELTS'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uIELTS">IELTS</label>  
                                    <div class="w-100 mt-2">
                                        <input type="checkbox" name="" id="individualfields2" disabled>
                                        <label for="individualfields2">Enable all individual fields</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end english_PTE" id="uPTE" value="1" name="PTE" {{$lead_form['PTE'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uPTE">PTE</label>  
                                    <div class="w-100  mt-2">
                                        <input type="checkbox" id="individualfields3" value="1" name="enable_all_individual_fields" disabled>
                                        <label for="individualfields3">Enable all individual fields</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="header-title mt-3 mb-3 clearfix">Other Test Scores
                            <input type="checkbox" class="float-end other_test_score" name="" @php if(($lead_form['sat1'] == '1') && ($lead_form['sat2'] == '1') && ($lead_form['gre'] == '1') && ($lead_form['gmat'] == '1')) echo 'checked' @endphp>
                        </h4>
                       
                        <div class="row clearfix">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end" id="uSATI" value="1" name="sat1" {{$lead_form['sat1'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uSATI">SAT I</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end" id="uSATII" value="1" name="sat2" {{$lead_form['sat2'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uSATII">SAT II</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end" id="uGRE" value="1" name="gre" {{$lead_form['gre'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uGRE">GRE</label> 
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end" id="uGMAT" value="1" name="gmat" {{$lead_form['gmat'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uGMAT">GMAT</label> 
                                </div>
                            </div>
                        </div>
                        <h4 class="header-title mt-3 mb-3 clearfix">Upload Documents
                         
                        </h4>
                       
                        <div class="row clearfix">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end" id="uUploadDocuments" name="upload_document" value="1" {{$lead_form['upload_document'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uUploadDocuments">Upload Documents</label> 
                                </div>
                            </div> 
                        </div>

                        <h4 class="header-title mt-3 mb-3 clearfix">Comments
                            
                        </h4>
                       
                        <div class="row clearfix">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="bg-light p-2"> 
                                    <input type="checkbox" class="float-end" id="uComments" value="1" name="comment" {{$lead_form['comment'] == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="uComments">Comments</label> 
                                </div>
                            </div> 
                        </div> 
                    </div>

                </div>
                <div class="tab-pane" id="CustomFields">
                   
                </div> 
            </div>

            
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>Form Properties</h4>

            <div class="row">
                <div class="col-md-4">
                    <label>Related Office</label>
                    <select class="form-control" name="related_office">
                        <option value="">---Select---</option>  
                        @foreach($Office as $Offices)
                            <option value="{{$Offices->id}}" {{($Offices->id == $lead_form['related_office']) ? 'selected' : ' '}}>{{$Offices->office_name}}</option>
                        @endforeach    
                    </select>
 
                </div>
                <div class="col-md-4">
                    <label>Source</label>
                    <select class="form-control"  name="source">
                        <option value="">---Select---</option>  
                        @foreach($SourceList as $SourceLists)
                            <option value="{{$SourceLists->id}}" {{($SourceLists->id == $lead_form['source']) ? 'selected' : ' '}} >{{$SourceLists->source_name}}</option>
                        @endforeach  
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Tag Name</label>
                    <select class="form-control"  name="tag_name">
                       <option value="">---Select---</option>  
                        @foreach($Tag as $Tags)
                            <option value="{{$Tags->id}}" {{($Tags->id == $lead_form['tag_name']) ? 'selected' : ' '}}>{{$Tags->name}}</option>
                        @endforeach  
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>FORM SHARING</h4>

            <div class="row">
                <div class="col-md-4">
                    <label>Lead form link</label>
                   <input type="text" class="form-control" name="lead_form_link" value={{$lead_form_edit->lead_form_link}}>
                </div>
                <div class="col-md-4">
                    <label>Source</label>
                    <textarea class="form-control" name="embed_code" id="" cols="30" rows="3">{{$lead_form_edit->embed_code}}</textarea>
                  
                </div>
                <div class="col-md-4">
                    <label>QR Code</label><br>
                    <img src="{{asset('images/lead_form/QRCode.png')}}" alt="" class="avatar-xl"><br>
                    <a  href="{{asset('images/lead_form/QRCode.png')}}"> <i class="mdi mdi-arrow-down-bold-circle mdi-18px"></i>Download</a>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h4>Legal & GDPR Compliance</h4>
            <input type="checkbox" name="show_privacy_info" value="1" {{$lead_form['show_privacy_info'] == '1' ? 'checked' : ''}}> <label>Show this information in lead form.</label>

            <div class="mb-2 mt-3">
                <label class="form-label">Privacy Information</label>
                <textarea class="summereditor" name="privacy_info">{{$lead_form['privacy_info']}}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label">Consent</label>
                <p><i class="mdi mdi-information-outline"></i> <small> This consent will appear as a checkbox and the checkbox will be disabled by default.</small></p>
                <textarea class="summereditor" name="consent">{{$lead_form['consent']}}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save </button>
        </div>
    </div>

</form>
@endsection

@section('script')
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
 <script type="text/javascript">
     $(document).ready(function() { 
        $('.dropify').dropify(); 
        $('.summereditor').summernote();

        $("#team_member").click(function(e){
            if($(this).is(':checked'))
            {  
                $(this).attr('checked',true);          
                $(".upload_profile_image").attr('checked',true);
                $(".date_of_birth").attr('checked',true);
            }
            else
            {
                $(this).attr('checked',false);
                $(".upload_profile_image").attr('checked',false);
                $(".date_of_birth").attr('checked',false);
            } 
        });

        $(".upload_profile_image").click(function(e){
            if(($(this).is(':checked')) && ($('.date_of_birth').is(':checked')))
            {

                $("#team_member").attr('checked',true);
            }
            else
            {
                $("#team_member").attr('checked',false);
            }
        });

        $(".date_of_birth").click(function(e){
            
            if(($(this).is(':checked')) && ($('.upload_profile_image').is(':checked')))
            {
                $("#team_member").attr('checked',true);
            }
            else
            {

                $("#team_member").attr('checked',false);
            }
        });

        //contact details------------------
        $(".contact_details").click(function(e){
            if($(this).is(':checked'))
            { 
                $(".contact_phone").attr('checked',true);
                $(".secondary_email").attr('checked',true);
                $(".contact_preference").attr('checked',true);
            }
            else
            {
                $(".contact_phone").attr('checked',false);
                $(".secondary_email").attr('checked',false);
                $(".contact_preference").attr('checked',false);
            }
        });

        $(".contact_phone").click(function(e){
            if(($(this).is(':checked')) && ($('.secondary_email').is(':checked')) && ($('.contact_preference').is(':checked')))
            {

                $(".contact_details").attr('checked',true);
            }
            else
            {
                $(".contact_details").attr('checked',false);
            }
        });

        $(".secondary_email").click(function(e){
            if(($(this).is(':checked')) && ($('.contact_phone').is(':checked')) && ($('.contact_preference').is(':checked')))
            {

                $(".contact_details").attr('checked',true);
            }
            else
            {
                $(".contact_details").attr('checked',false);
            }
        });

        $(".contact_preference").click(function(e){
            if(($(this).is(':checked')) && ($('.contact_phone').is(':checked')) && ($('.secondary_email').is(':checked')))
            {

                $(".contact_details").attr('checked',true);
            }
            else
            {
                $(".contact_details").attr('checked',false);
            }
        });

         //ADDRESS DETAILS------------------
         $(".address_details").click(function(e){
                if($(this).is(':checked'))
                { 
                    $(".address_street").attr('checked',true);
                    $(".address_city").attr('checked',true);
                    $(".address_State").attr('checked',true);
                    $(".postal_code").attr('checked',true);
                    $(".address_country").attr('checked',true);
                }
                else
                {
                    $(".address_street").attr('checked',false);
                    $(".address_city").attr('checked',false);
                    $(".address_State").attr('checked',false);
                    $(".postal_code").attr('checked',false);
                    $(".address_country").attr('checked',false);
                }
         });
         
         $(".address_street").click(function(e){
            if(($(this).is(':checked')) && ($('.address_city').is(':checked')) && ($('.address_State').is(':checked'))&&($('.postal_code').is(':checked')) && ($('.address_country').is(':checked')))
            {
                $(".address_details").attr('checked',true);
            }
            else
            {
                $(".address_details").attr('checked',false);
            }
        });

        $(".address_city").click(function(e){
            if(($(this).is(':checked')) && ($('.address_street').is(':checked')) && ($('.address_State').is(':checked'))&&($('.postal_code').is(':checked')) && ($('.address_country').is(':checked')))
            {
                $(".address_details").attr('checked',true);
            }
            else
            {
                $(".address_details").attr('checked',false);
            }
        });

        $(".address_State").click(function(e){
            if(($(this).is(':checked')) && ($('.address_street').is(':checked')) && ($('.address_city').is(':checked'))&&($('.postal_code').is(':checked')) && ($('.address_country').is(':checked')))
            {
                $(".address_details").attr('checked',true);
            }
            else
            {
                $(".address_details").attr('checked',false);
            }
        });

        $(".postal_code").click(function(e){
            if(($(this).is(':checked')) && ($('.address_street').is(':checked')) && ($('.address_city').is(':checked'))&&($('.address_State').is(':checked')) && ($('.address_country').is(':checked')))
            {

                $(".address_details").attr('checked',true);
            }
            else
            {
                $(".address_details").attr('checked',false);
            }
        });

        $(".address_country").click(function(e){
            if(($(this).is(':checked')) && ($('.address_street').is(':checked')) && ($('.address_city').is(':checked'))&&($('.address_State').is(':checked')) && ($('.postal_code').is(':checked')))
            {
                $(".address_details").attr('checked',true);
            }
            else
            {
                $(".address_details").attr('checked',false);
            }
        });

        //Current Visa Information--------------------
        $(".current_visa_info").click(function(e){
                if($(this).is(':checked'))
                { 
                    $(".visa_type").attr('checked',true);
                    $(".visa_expiry_date").attr('checked',true);
                    $(".country_of_passport").attr('checked',true);
                }
                else
                {
                    $(".visa_type").attr('checked',false);
                    $(".visa_expiry_date").attr('checked',false);
                    $(".country_of_passport").attr('checked',false);
                }
         });
         
         $(".visa_type").click(function(e){
            if(($(this).is(':checked')) && ($('.visa_expiry_date').is(':checked')) && ($('.country_of_passport').is(':checked')))
            {

                $(".current_visa_info").attr('checked',true);
            }
            else
            {
                $(".current_visa_info").attr('checked',false);
            }
        });

        $(".visa_expiry_date").click(function(e){
            if(($(this).is(':checked')) && ($('.visa_type').is(':checked')) && ($('.country_of_passport').is(':checked')))
            {

                $(".current_visa_info").attr('checked',true);
            }
            else
            {
                $(".current_visa_info").attr('checked',false);
            }
        });

        $(".country_of_passport").click(function(e){
            if(($(this).is(':checked')) && ($('.visa_type').is(':checked')) && ($('.visa_expiry_date').is(':checked')))
            {

                $(".current_visa_info").attr('checked',true);
            }
            else
            {
                $(".current_visa_info").attr('checked',false);
            }
        });

      //Interested Services------------
      $(".interested_service").click(function(e){
           if($(this).is(':checked'))
            { 
                $(".australian_education").attr('checked',true);
                $(".us_education").attr('checked',true);
                $(".visa_service").attr('checked',true);
                $(".accomodation_service").attr('checked',true);
                $(".insurance_service").attr('checked',true);
            }
            else
            {
                $(".australian_education").attr('checked',false);
                $(".us_education").attr('checked',false);
                $(".visa_service").attr('checked',false);
                $(".accomodation_service").attr('checked',false);
                $(".insurance_service").attr('checked',false);
            }
      })

      $(".australian_education").click(function(e){
            if(($(this).is(':checked')) && ($('.us_education').is(':checked')) && ($('.visa_service').is(':checked')) && ($('.accomodation_service').is(':checked')) && ($('.insurance_service').is(':checked')))
            {

                $(".interested_service").attr('checked',true);
            }
            else
            {
                $(".interested_service ").attr('checked',false);
            }
        });

        $(".us_education").click(function(e){
            if(($(this).is(':checked')) && ($('.australian_education').is(':checked')) && ($('.visa_service').is(':checked')) && ($('.accomodation_service').is(':checked')) && ($('.insurance_service').is(':checked')))
            {

                $(".interested_service").attr('checked',true);
            }
            else
            {
                $(".interested_service ").attr('checked',false);
            }
        });
        
        $(".visa_service").click(function(e){
            if(($(this).is(':checked')) && ($('.australian_education').is(':checked')) && ($('.us_education').is(':checked')) && ($('.accomodation_service').is(':checked')) && ($('.insurance_service').is(':checked')))
            {

                $(".interested_service").attr('checked',true);
            }
            else
            {
                $(".interested_service ").attr('checked',false);
            }
        });

        $(".accomodation_service").click(function(e){
            if(($(this).is(':checked')) && ($('.australian_education').is(':checked')) && ($('.us_education').is(':checked')) && ($('.visa_service').is(':checked')) && ($('.insurance_service').is(':checked')))
            {

                $(".interested_service").attr('checked',true);
            }
            else
            {
                $(".interested_service ").attr('checked',false);
            }
        });

        $(".insurance_service").click(function(e){
            if(($(this).is(':checked')) && ($('.australian_education').is(':checked')) && ($('.us_education').is(':checked')) && ($('.visa_service').is(':checked')) && ($('.accomodation_service').is(':checked')))
            {

                $(".interested_service").attr('checked',true);
            }
            else
            {
                $(".interested_service ").attr('checked',false);
            }
        });
      
        //Education Background-------------------------------
        $(".education_background").click(function(e){
            if($(this).is(':checked'))
            { 
                $(".subject_area").attr('checked',true);
                $(".education_subject").attr('checked',true);
                $(".course_start").attr('checked',true);
                $(".course_end").attr('checked',true);
                $(".academic_score").attr('checked',true);
            }
            else
            {
                $(".subject_area").attr('checked',false);
                $(".education_subject").attr('checked',false);
                $(".course_start").attr('checked',false);
                $(".course_end").attr('checked',false);
                $(".academic_score").attr('checked',false);
            }
        });


        $(".subject_area").click(function(e){
            if(($(this).is(':checked'))&& ($('.education_subject').is(':checked')) && ($('.course_start').is(':checked')) && ($('.course_end').is(':checked')) && ($('.academic_score').is(':checked')))
            {

                $(".education_background").attr('checked',true);
            }
            else
            {
                $(".education_background ").attr('checked',false);
            }
        });

        $(".education_subject").click(function(e){
            if(($(this).is(':checked')) && ($('.subject_area').is(':checked')) && ($('.course_start').is(':checked')) && ($('.course_end').is(':checked')) && ($('.academic_score').is(':checked')))
            {

                $(".education_background").attr('checked',true);
            }
            else
            {
                $(".education_background ").attr('checked',false);
            }
        });

        $(".course_start").click(function(e){
            if(($(this).is(':checked')) && ($('.subject_area').is(':checked')) && ($('.education_subject').is(':checked')) && ($('.course_end').is(':checked')) && ($('.academic_score').is(':checked')))
            {

                $(".education_background").attr('checked',true);
            }
            else
            {
                $(".education_background ").attr('checked',false);
            }
        });

        $(".course_end").click(function(e){
            if(($(this).is(':checked')) && ($('.subject_area').is(':checked')) && ($('.education_subject').is(':checked')) && ($('.course_start').is(':checked')) && ($('.academic_score').is(':checked')))
            {

                $(".education_background").attr('checked',true);
            }
            else
            {
                $(".education_background ").attr('checked',false);
            }
        });

        $(".academic_score").click(function(e){
            if(($(this).is(':checked')) && ($('.subject_area').is(':checked')) && ($('.education_subject').is(':checked')) && ($('.course_start').is(':checked')) && ($('.course_end').is(':checked')))
            {

                $(".education_background").attr('checked',true);
            }
            else
            {
                $(".education_background ").attr('checked',false);
            }
        });

        //ENGLISH TEST SCORES-----------------
        $(".english_test_score").click(function(e){
            if($(this).is(':checked'))
            { 
                $(".english_tofel").attr('checked',true);
                $(".english_IELTS").attr('checked',true);
                $(".english_PTE").attr('checked',true);

                $("#individualfields").removeAttr('disabled');
                $("#individualfields2").removeAttr('disabled');
                $("#individualfields3").removeAttr('disabled');
            }
            else
            {
                $(".english_tofel").attr('checked',false);
                $(".english_IELTS").attr('checked',false);
                $(".english_PTE").attr('checked',false);

                $("#individualfields").attr('disabled',true);
                $("#individualfields2").attr('disabled',true);
                $("#individualfields3").attr('disabled',true);
            }
        });

        //Other Test Scores----------------

        $(".other_test_score").click(function(e){
            if($(this).is(':checked'))
            { 
                $("#uSATI").attr('checked',true);
                $("#uSATII").attr('checked',true);
                $("#uGRE").attr('checked',true);
                $("#uGMAT").attr('checked',true);
            }
            else
            {
                $("#uSATI").attr('checked',false);
                $("#uSATII").attr('checked',false);
                $("#uGRE").attr('checked',false);
                $("#uGMAT").attr('checked',false);

            }
        });
    });
 </script>
 
@endsection