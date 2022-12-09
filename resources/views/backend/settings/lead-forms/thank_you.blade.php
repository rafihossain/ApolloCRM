@extends('backend.layouts.app')
@section('css')
@endsection	
@section('content')

<div class="card card-body text-center col-md-6">
    <blockquote class="card-bodyquote mb-0">
        <h2>Thank you!</h2>
        <p>Your form has been submitted.</p>
         <a class="btn btn-primary" href="{{url('online-form',$slug)}}">New Form</a>
    </blockquote>
</div>
@endsection