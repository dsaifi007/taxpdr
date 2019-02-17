<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <!--link href=" http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"-->
     <link href="css/revolution-slider.css" rel="stylesheet">
   
     @if(\Auth::check())
      <link href="{{ asset('css/after-login-style.css') }}" rel="stylesheet" type="text/css" >
                 
    @else   
          <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
    @endif
   
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/parsley.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/media.css')}}" rel="stylesheet" type="text/css">

    <link  rel="shortcut icon"  href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <link rel="icon"  href="{{ asset('images/favicon.png') }}" type="image/x-icon">
     <script src="{{ asset('js/jquery-3.1.1.js')}}"></script>
 <style>
            .owl-carousel .owl-item img {
            display: block;
            transform-style: preserve-3d;
            width: 100%;
            box-shadow: 0 0 15px -3px #ccc;
            }
        </style>
    
</head>
<body>
    <div class="page-wrapper" id="app">
         <!-- Preloader -->
    <div class="preloader"></div>
	     @if(\Auth::check())
			@if(\Auth::user()->role_category == "valuer")
				 @include('includes/valuer_header')
            @else
				 @include('includes/investor_header')
            @endif  				 
		 @else 	 
              @include('includes/header')
	     @endif
        @yield('content')
        @include('includes/footer')
    </div>

    <!-- Scripts -->
    

<script src="{{ asset('js/jquery.js') }}"></script> 
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/pagenav.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.js') }}"></script>
<script src="{{ asset('js/revolution.min.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox.pack.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox-media.js') }}"></script>
<script src="{{ asset('js/owl.js') }}"></script>
<script src="{{ asset('js/wow.js') }}"></script>
<script src="{{ asset('js/validate.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>

<!--   parsley validation js - - - - - -->
<!-- PARSLEY -->
<script>
    window.ParsleyConfig = {
        errorsWrapper: '<div></div>',
        errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
        errorClass: 'has-error',
        successClass: 'has-success'
    };
</script>


<script src="{{ asset('js/parsley.js') }}"></script>

<script src="{{ asset('js/common.js') }}"></script>
  @yield('java-script')

<!--Google Map APi Key-->
<script src="https://maps.google.com/maps/api/js?key=AIzaSyBKS14AnP3HCIVlUpPKtGp7CbYuMtcXE2o"></script>
<script src="{{ asset('js/map-script.js') }}"></script>
<!--script src="{{ asset('js/app.js') }}"></script-->

<!--End Google Map APi-->
</body>
</html>
