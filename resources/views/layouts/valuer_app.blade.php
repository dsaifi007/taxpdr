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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom-file-input.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/after-login-style.css') }}" rel="stylesheet" type="text/css" >
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
      
body[style] {
  overflow-y:auto !important;
  padding-right: 0px !important;
}


    </style>
     @yield('style')
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

    <div id="common-proper-ty" class="modal fade" role="dialog">
    <div class="modal-dialog delete-proper-ty">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="popup_title_id" ></h4>
            </div>
            <div class="modal-body text-center">
                <p id="message_id"></p>
                <div class="tow-btn" id ="delete_saved_address">
                    
                </div>
            </div>
           
        </div>
    </div>
</div><!-- end popup div--->

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
 <script src="{{ asset('js/custom-file-input.js')}}"></script>
 <script src="{{ asset('js/lang/messages.js')}}"></script>

<!--   parsley validation js - - - - - -->
<!-- PARSLEY -->
<script type="text/javascript">
    window.ParsleyConfig = {
        errorsWrapper: '<div></div>',
        errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
        errorClass: 'has-error',
        successClass: 'has-success'
    };

  
equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

$(window).load(function() {
  equalheight('.height-equal');
});


$(window).resize(function(){
  equalheight('.height-equal');
});
</script>


<script src="{{ asset('js/parsley.js')}}"></script>

<script type="text/javascript">
 //base url for all jss files
var APP_URL = "{{ url('/')}}";
$(function () {
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
<script src="{{ asset('js/common.js') }}"></script>
  @yield('java-script')

<!--Google Map APi Key-->
<script src="https://maps.google.com/maps/api/js?key=AIzaSyBKS14AnP3HCIVlUpPKtGp7CbYuMtcXE2o"></script>
<script src="{{ asset('js/map-script.js') }}"></script>


<!--End Google Map APi-->
</body>
</html>
