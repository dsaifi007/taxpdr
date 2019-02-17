@extends('layouts.app')

@section('content')
 <!--Page Title-->
    <section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg') }} );">
                        <div class="container"><h2>Policy</h2>
                            <ol class="breadcrumb">
                                <li>You are here: &nbsp;</li>
                                <li><a href="#" class="pathway">Policy</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!--Contact Section-->
    <section class="contact-section section-min-h">
    	<div class="auto-container">
        	
            
			<?php echo $pagecontent[0]->content; ?>
            
		</div>
    </section>
    <!--End Contact Section-->
@endsection
@section('java-script')

<script type="text/javascript" src="{{asset('js/contact_us.js')}}"></script>
@endsection
