@include('backend.includes.header')
@include('backend.includes.sidebar')
  
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<div class="content-page">
  <div class="content">
    <!-- Start Content-->
    <div class="container-fluid"> 
		@yield('content')
	</div>
  </div>
</div>

@include('backend.includes.footer')
 
