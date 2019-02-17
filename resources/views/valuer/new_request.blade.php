@extends('layouts.valuer_app')
@section('content')
<section>
   <div class="row">
      <div class="col-sm-12 col-md-12">
         <div class="sp-column ">
            <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg') }} );">
               <div class="container">
                  <h2>My Jobs</h2>
                  <ol class="breadcrumb">
                     <li>You are here: &nbsp;</li>
                     <li><a href="#" class="pathway">New Jobs</a></li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="my-request my-report my-jobs section-min-h">
	
   <div class="auto-container">
   	 @if(Session::has('error_msg'))
                            <p class="{{ Session::has('error_msg') ? 'alert-danger parsley parsley-required danger-custom' : '' }}">
                                 <span class="">
                                        {{ Session::get('error_msg') }}
                                    </span></p>
                    @endif
                    
                    @if(Session::has('success'))
                        <div class="{{ Session::has('success') ? 'alert-success success-alert-custom' : '' }}">
                            <span class="">
                               {{ Session::get('success') }}
                            </span>
                        </div>
                    @endif
      <div class="panel with-nav-tabs panel-primary">
         <div class="panel-heading">
            <ul class="nav nav-tabs">
               <li ><a href="{{ route('valuer-dashboard') }}" >Accepted Jobs</a></li>
               <li class="active" ><a href="{{route('valuer.new.request')}}"  >New Jobs</a></li>
            </ul>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane new-jo-b fade in active" id="new-jobs-request">
               	@if(count($all_new_requests) > 0)
                  <ul class="card-property">
                  	@foreach($all_new_requests as $new_request)
                     <li style="background-image: url({{ asset('images/image'.rand(1,3).'.jpg') }});" class="height-equal">
                        <div class="over-lay"></div>
                        <ol>
                           <li>
                              <div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                              <div class="content">{{ convertIntoDateFormate( $new_request['created_at']) }}</div> <div class="tow-icon-btn" style="top:0;">
                            <!--a href="{{ url('/property-detail').'/'. $new_request['id']}}" title="View detail" ><i class="fa fa-eye"></i></a-->
                           
                        </div> 
                           </li>
                           <li>
                              <div class="icon"><i class="fa fa-home" aria-hidden="true"></i></div>
                             <div class="content ellipsis">{{ $new_request['property_address'] }}</div>
                           </li>
                           <li>
                              <div class="icon"><i class="fa fa-university" aria-hidden="true"></i></div>
                             <div class="content ellipsis">{{ $new_request['property_type_name']}}</div>
                           </li>
                        </ol>
                        <div class="tow-btn">
                           <a href="{{ url('valuer/accept-job').'/'.$new_request['id']}}" class="theme-btn btn-style-one">Accept</a>
                           <a href="#common-proper-ty" data-id="{{$new_request['id']}}" data-toggle="modal" class="theme-btn btn-style-one open_confirm_reject">Reject</a>
                        </div>
                     </li>
                     
                     @endforeach
                  </ul>
                @else
                    <div class="alert alert-info fade in">

                         {{ trans('messages.no_new_jobs') }}
                    </div>  
               @endif

               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
<!-- include page js script - - - -->
@section('java-script')
<script src="{{ asset('js/new-request.js') }}"></script>
<script>
	$(document.body).click(function() {
         $('.alert-danger').hide();
        $('.alert-success').hide();   
            
      });
	</script>
@endsection