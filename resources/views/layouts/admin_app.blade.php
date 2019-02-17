<!doctype html>
<html lang="en" class="fixed @if(\Auth::check()) @else accounts sign-in" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    @if(\Auth::check())
        <script src="{{asset('admin/vendor/pace/pace.min.js')}}"></script>
        <link href="{{asset('admin/vendor/pace/pace-theme-minimal.css')}}" rel="stylesheet" />
    @endif    
    <link rel="stylesheet" href="{{asset('admin/vendor/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendor/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendor/animate.css/animate.css')}}">
	<link href="{{ asset('css/parsley.css')}}" rel="stylesheet" type="text/css">
  <link  rel="shortcut icon"  href="http://localhost/taxpdr_backend/taxpdr/public/images/favicon.png" type="image/x-icon">
    @if(\Auth::check())
        <link rel="stylesheet" href="{{asset('admin/vendor/data-table/media/css/dataTables.bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin/stylesheets/css/custom-bootstrap-margin-padding.css')}}">
    @endif
    <link rel="stylesheet" href="{{asset('admin/stylesheets/css/style.css')}}">
   

      @yield('style')
</head>
<body>
   <div class="wrap">
         
         @if(\Auth::check())
            @include('includes/admin_header') 
         @endif
        @yield('content')
    </div>
    
 <!--BASIC scripts-->
<!-- ========================================================= -->
<script src="{{asset('admin/vendor/jquery/jquery-1.12.3.min.js')}}"></script>
<script src="{{asset('admin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/vendor/nano-scroller/nano-scroller.js')}}"></script>
<!--TEMPLATE scripts-->
<!-- ========================================================= -->
<script src="{{asset('admin/javascripts/template-script.min.js')}}"></script>
<script src="{{asset('admin/javascripts/template-init.min.js')}}"></script>
<!-- app url for js files -->
<script type="text/javascript">
   var APP_URL = "{{ url('/')}}";
</script>

<!--   parsley validation js - - - - - -->
<!-- PARSLEY -->
<script>
  var APP_URL = "{{ url('/')}}";
    window.ParsleyConfig = {
        errorsWrapper: '<div></div>',
        errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
        errorClass: 'has-error',
        successClass: 'has-success'
    };
</script>


<script src="{{ asset('js/parsley.js') }}"></script>

<script type="text/javascript">
 $(document).ready(function() {
if($("#lform").length > 0) {
  $('#lform').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
  })
  .on('form:submit', function() {
    return true; // Don't submit form for this demo
  });
}
  
});
</script>

 @if(\Auth::check())
<script src="{{asset('admin/vendor/data-table/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/vendor/data-table/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/javascripts/examples/tables/data-tables.js')}}"></script>
@endif


 @yield('java-script')

</body>
</html>
