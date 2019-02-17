@extends('layouts.app')

@section('content')
  <!--Page Title-->
    <section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg') }} );">
                        <div class="container"><h2>Contact Us</h2>
                            <ol class="breadcrumb">
                                <li>You are here: &nbsp;</li>
                                <li><a href="#" class="pathway">Home</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
    
    <!--Contact Section-->
    <section class="my-request contact-section">
    	<div class="auto-container">
        	<div class="title-text">{{ $contactus->content }}</div>
            
            <div class="row clearfix">
            	
                <!--Map Column-->
                <div class="map-column col-md-5 col-sm-12 col-xs-12">
					<h2>Our Location</h2>
					<!--Map Outer-->
                    <div class="map-outer">
                       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6624.402947100777!2d151.20565487786465!3d-33.88446467260789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ae21f935bc5b%3A0x5017d681632cc90!2sSurry+Hills+NSW+2010%2C+Australia!5e0!3m2!1sen!2sin!4v1520430840028" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                
                <!--Form Column-->
                <div class="form-column col-md-7 col-sm-12 col-xs-12">
                	<div class="inner-column">
                        <h2>Contact Form</h2>
                        @if(Session::has('message'))
                               <h3 id="successMessage" style="color:#0fad00"> {{ Session::get('message') }} </h2>
                                    
                           @endif
                        <!--Contact Form-->
                        <div class="contact-form">
                            <form method="post" action="{{ route('save.Query')}}" id="lform" autocomplete="off">
							  {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" name="name" value=""  placeholder="First Name *" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="email" name="email" value="" placeholder="Email *" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" name="phone" value="" placeholder="Phone *" required data-parsley-minlength-message="This value is too short. It should have 10 characters" data-parsley-minlength="10"  data-parsley-pattern="^[0-9]{1,10}$" >
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" name="subject" value="" placeholder="Subject *" required>
                                    </div>
                                    
                                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                                        <textarea name="message" required placeholder="Message *"></textarea>
                                    </div>
                                    
                                    <div class="form-group col-md-12 col-md-12 col-xs-12 text-left">
                                        <button type="submit" class="theme-btn btn-style-one">Send Message</button>
                                    </div>
                                    
                                </div>
                                
                            </form>
                        </div>
                        <!--End Contact Form-->
                        
                    </div>
                </div>
            </div>

            
		</div>
    </section>
    <!--End Contact Section-->
@endsection
@section('java-script')

<script type="text/javascript" src="{{asset('js/contact_us.js')}}"></script>
@endsection
